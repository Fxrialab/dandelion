<?php

/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 2:47 PM
 * Project: UserWired Network - Version: beta
 */
require_once("Controller.php");

class AppController extends Controller
{

    protected $helpers = array();
    protected $layout = '';

    //protected $elements = null;

    public function __construct()
    {
        parent::__construct();
        $this->Elements = new ElementController();
    }

    public function beforeRoute()
    {
        //Add some condition later. Set if timeout > 3600 -> disable record session
    }

    /**
     *
     * Some helpful function for controller
     *
     */
    public function isLogin()
    {
        $session = $this->f3->get("SESSION");
        if (isset($session["loggedUser"]))
        {
            return true;
        }
        //session ok
        if (isset($_COOKIE['email']) && isset($_COOKIE['password']))
        {
            $user = $this->User->findOne('email = ?', array($_COOKIE['email']));
            $this->f3->clear('SESSION');
            $this->f3->set('SESSION.loggedUser', $user);
            return true;
        }
        //cookie ok
        return false;
    }

    /* public function getCurrentUser()
      {
      return F3::get("SESSION.loggedUser");
      } */

    public function getCurrentUserName()
    {
        return ucfirst($this->getCurrentUser()->data->firstName) . " " . ucfirst($this->getCurrentUser()->data->lastName);
    }

    public function getMacAddress()
    {
        ob_start(); // Turn on output buffering
        system('ipconfig /all'); //Execute external program to display output
        $getContents = ob_get_contents(); // Capture the output into a variable
        ob_clean(); // Clean (erase) the output buffer
        $findString = "Physical";
        $macPos = strpos($getContents, $findString); // Find the position of Physical text
        $mac = substr($getContents, ($macPos + 36), 17); // Get Physical Address
        return $mac;
    }

    public function getIPAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //to check ip is pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
            $ip = $_SERVER['REMOTE_ADDR'];

        return $ip;
    }

    public function including($file)
    {
        if (file_exists(UI . 'includes/' . $file . '.php'))
            require_once (UI . 'includes/' . $file . '.php');
        else
            throw New Exception('File is not existed !');
    }

    public function loadModules($modules)
    {
        if ($modules != '')
            require_once(MODULES . $modules);
    }

    public function element($param)
    {
        $element = new FactoryUtils();
        return $element->element($param);
    }

    public function getFriendsStt($actor)
    {
        return $this->facade->findAllAttributes('friendship', array('userA' => $actor, 'relationship' => 'friend', 'status' => 'ok'));
    }

    public function getStatusFriendShip($userA, $userB)
    {
        if ($userA != $userB)
        {
            $friendShipAtoB = $this->facade->findByAttributes('friendship', array('userA' => $userA, 'userB' => $userB));
            $friendShipBtoA = $this->facade->findByAttributes('friendship', array('userA' => $userB, 'userB' => $userA));
            if (!empty($friendShipAtoB) && !empty($friendShipBtoA))
            {
                $statusFriendShip = $friendShipBtoA->data->relationship;
            }
            else
            {
                if (!empty($friendShipAtoB) && !$friendShipBtoA)
                {
                    $statusFriendShip = 'request';
                }
                elseif (!$friendShipAtoB && !empty($friendShipBtoA))
                {
                    $statusFriendShip = 'respondRequest';
                }
                else
                {
                    $statusFriendShip = 'addFriend';
                }
            }
        }
        else
        {
            $statusFriendShip = 'updateInfo';
        }

        return $statusFriendShip;
    }

    // **********************************
    // Track activity
    // **********************************
    public function trackActivity($actor, $verb, $object, $type, $typeID, $published)
    {
        $existActivity = $this->facade->findAllAttributes('activity', array('owner' => $actor->recordID, 'object' => $object));

        if (!$existActivity)
        {
            // prepare activity data
            $data = array(
                'owner' => $actor->recordID,
                'actor' => $actor->recordID,
                'verb' => $verb,
                'object' => $object,
                'type' => $type,
                'typeID' => $typeID,
                'published' => $published
            );
            // create activity for currentUser
            $activities = $this->facade->save('activity', $data);
            // check all friends of current user
            $friends = $this->facade->findAllAttributes('friendship', array('userA' => $actor->recordID, 'relationship' => 'friend', 'status' => 'ok'));

            // duplicate activities for friends
            if (!empty($friends))
            {
                for ($i = 0; $i < count($friends); $i++)
                {
                    $checkActivityFriend = $this->facade->findAllAttributes('activity', array('owner' => $friends[$i]->data->userB, 'object' => $object));
                    // prepare activity for each followers
                    if (!$checkActivityFriend)
                    {
                        $data = array(
                            'owner' => $friends[$i]->data->userB,
                            'actor' => $actor->recordID,
                            'verb' => $verb,
                            'object' => $object,
                            'type' => $type,
                            'typeID' => $typeID,
                            'published' => $published
                        );
                        $this->facade->save('activity', $data);
                    }
                    $yourFriends = str_replace(':', '_', $friends[$i]->data->userB);
                    $this->service->exchange('dandelion', 'topic')->routingKey('newsFeed.post.'.$yourFriends)->dispatch('post', $activities);
                }

            }
        }
    }

    public function randomKeys($array, $for)
    {
        $result = array();
        $length = count($array);
        switch ($for)
        {
            case 'randomSuggestElement':
                $result = ($array && $length > 2) ? array_rand($array, 2) : array_keys($array);
                break;
            case 'randomFriendID':
                $result = ($length >= 3) ? array_rand($array, mt_rand(2, $length)) : array_keys($array);
                break;
        }
        return $result;
    }

    public function peopleYouMayKnow()
    {
        $current = array();
        $loggedUser = $this->getCurrentUser()->recordID;
        $findSuggestFriends = Model::get('user')->callGremlin("current.out.both", array('@rid' => '#' . $loggedUser));
        if (!empty($findSuggestFriends))
        {
            $groupFriend = array_keys(array_count_values($findSuggestFriends));
            array_push($current, $loggedUser);
            $yourFriends = array_diff($groupFriend, $current);
            $neighborCurrentUser = Model::get('user')->callGremlin("current.in", array('@rid' => '#' . $loggedUser));
            $yourFriendArrays = array();
            if (current($yourFriends) != '')
            {
                foreach ($yourFriends as $yourFriend)
                {
                    $relationShipAtoB[$yourFriend] = $this->facade->findAllAttributes('friendship', array('userA' => $loggedUser, 'userB' => $yourFriend));
                    $relationShipBtoA[$yourFriend] = $this->facade->findAllAttributes('friendship', array('userA' => $yourFriend, 'userB' => $loggedUser));
                    if (!$relationShipAtoB[$yourFriend] && !$relationShipBtoA[$yourFriend])
                    {
                        array_push($yourFriendArrays, $yourFriend);
                    }
                }

                $randomKeys = $this->randomKeys($yourFriendArrays, 'randomFriendID');
                if ($randomKeys)
                {
                    foreach ($randomKeys as $key)
                    {
                        $randYourFriend = $yourFriendArrays[$key];
                        $infoYourFriend[$randYourFriend] = Model::get('user')->callGremlin("current.map", array('@rid' => '#' . $randYourFriend));
                        $neighborFriends[$randYourFriend] = Model::get('user')->callGremlin("current.in", array('@rid' => '#' . $randYourFriend));

                        if (current($neighborCurrentUser) != '')
                        {
                            $mutualFriends[$randYourFriend] = array_intersect($neighborCurrentUser, $neighborFriends[$randYourFriend]);
                            $this->f3->set('numMutualFriends', $mutualFriends);
                            if ($mutualFriends[$randYourFriend])
                            {
                                foreach ($mutualFriends[$randYourFriend] as $mutualFriend)
                                {
                                    $infoMutualFriend[$mutualFriend] = Model::get('user')->callGremlin("current.map", array('@rid' => '#' . $mutualFriend));
                                }
                                $this->f3->set('infoMutualFriend', $infoMutualFriend);
                            }
                        }
                        $this->f3->set('infoYourFriend', $infoYourFriend);
                    }
                }
                $this->f3->set('yourFriendArrays', $yourFriendArrays);
                $this->f3->set('randomKeys', $randomKeys);
                $this->f3->set('yourFriends', $yourFriends);
                $this->render("elements/peopleYouMayKnowElement.php", 'default');
            }
        }
    }

    public function friendRequest()
    {
        $loggedUser = $this->getCurrentUser()->recordID;
        $neighborCurrentUser = Model::get('user')->callGremlin("current.in", array('@rid' => '#' . $loggedUser));
        if ($neighborCurrentUser)
        {
            $requestUserArrays = array();
            //var_dump($neighborCurrentUser);
            if (current($neighborCurrentUser) != '')
            {
                foreach ($neighborCurrentUser as $neighbor)
                {
                    $requestRelationShip[$neighbor] = $this->facade->findAllAttributes('friendship', array('userA' => $neighbor, 'userB' => $loggedUser, 'relationship' => 'request'));

                    if ($requestRelationShip[$neighbor])
                    {
                        array_push($requestUserArrays, $neighbor);
                    }
                }
                $randomKeys = $this->randomKeys($requestUserArrays, 'randomFriendID');
                foreach ($randomKeys as $key)
                {
                    $randYourFriend = $requestUserArrays[$key];
                    $infoRequestUser[$randYourFriend] = Model::get('user')->callGremlin("current.map", array('@rid' => '#' . $randYourFriend));
                    $neighborRequestUser[$randYourFriend] = Model::get('user')->callGremlin("current.in", array('@rid' => '#' . $randYourFriend));
                    if (!empty($neighborRequestUser[$randYourFriend]))
                    {
                        $mutualFriends[$randYourFriend] = array_intersect($neighborCurrentUser, $neighborRequestUser[$randYourFriend]);
                        $this->f3->set('numMutualFriends', $mutualFriends);
                        if ($mutualFriends[$randYourFriend])
                        {
                            foreach ($mutualFriends[$randYourFriend] as $mutualFriend)
                            {
                                $infoMutualFriend[$mutualFriend] = Model::get('user')->callGremlin("current.map", array('@rid' => '#' . $mutualFriend));
                            }

                            $this->f3->set('infoMutualFriend', $infoMutualFriend);
                        }
                    }

                    $this->f3->set('infoRequestUser', $infoRequestUser);
                }
                $this->f3->set('requestUserArrays', $requestUserArrays);
                $this->f3->set('randomKeys', $randomKeys);
                $this->f3->set('neighborCurrentUser', $neighborCurrentUser);

                $this->render("elements/friendRequestElement.php", 'default');
            }
        }
    }

    public function suggest($for)
    {
        switch ($for)
        {
            case 'peopleYouMayKnow':
                $this->peopleYouMayKnow();
                break;
            case 'friendRequests':
                $this->friendRequest();
                break;
            case 'suggestedGroups':
                break;
            case 'findPreferences':
                break;
        }
    }

    public function getSearchCommand($properties, $searchText)
    {
        $command = "current.or(";
        for ($i = 0; $i < count($properties); $i++)
        {
            $command = $command . "_().filter{it.getProperty('" . $properties[$i] . "').contains('" . strtolower($searchText) . "')},";
        }
        $command = $command . ")";
        return $command;
    }

    public function compressImage($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source_url);

        //save it
        imagejpeg($image, $destination_url, $quality);

        //return destination file url
        return $destination_url;
    }

    /**
     * This function will resize, compress and return image info
     *
     * @param $file
     * @param int $thumbSize
     * @param $desImgFile
     * @param $newImgName
     * @param $quality
     * @param bool $returnInfo
     * @param bool $moveDefaultFileTo
     * @return array|bool
     */
    public function changeImage($file, $thumbSize = 0, $desImgFile, $newImgName, $quality, $returnInfo = false, $moveDefaultFileTo = false)
    {
        if (!is_array($file["name"]))//single file
        {
            $fileName = $file["name"];
            $tmpName = $file['tmp_name'];
            $formats = $file['type'];

            list($width, $height) = getimagesize($tmpName);
            /* The width and the height of the image also the getimagesize retrieve other information as well   */
            $imgRatio = $width / $height;

            if ($imgRatio > 1)
            {
                $newWidth = $thumbSize;
                $newHeight = (int) ($thumbSize / $imgRatio);
            }
            else
            {
                $newHeight = $thumbSize;
                $newWidth = (int) ($thumbSize * $imgRatio);
            }
            list($name, $ext) = explode(".", $fileName);

            if ($formats == 'image/jpeg')// Now it will create a new image from the source
                $source = imagecreatefromjpeg($tmpName);
            elseif ($formats == 'image/gif')
                $source = imagecreatefromgif($tmpName);
            elseif ($formats == 'image/png')
                $source = imagecreatefrompng($tmpName);

            $thumb = imagecreatetruecolor($newWidth, $newHeight); // Making a new true color image
            $newImage = $newImgName . '.' . $ext;
            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height); // Copy and resize the image
            imagejpeg($thumb, $desImgFile . '/' . $newImage, $quality);
            /*
              Out put of image
              if the $savePath is null then it will display the image in the browser
             */
            imagedestroy($thumb);
            /*
              Destroy the image
             */
            if (!empty($moveDefaultFileTo))
            {
                move_uploaded_file($tmpName, $moveDefaultFileTo.$newImage);
            }
            if (!empty($returnInfo))
                return array('name' => $newImage, 'width' => $newWidth, 'height' => $newHeight);
            else
                return false;
        }else {//multiple files
            $fileCount = count($file["name"]);
            for ($i = 0; $i < $fileCount; $i++)
            {
                $fileName = $file["name"][$i];
                $tmpName = $file['tmp_name'][$i];
                $formats = $file['type'][$i];

                list($width, $height) = getimagesize($tmpName);
                /* The width and the height of the image also the getimagesize retrieve other information as well   */
                $imgRatio = $width / $height;

                if ($imgRatio > 1)
                {
                    $newWidth = $thumbSize;
                    $newHeight = (int) ($thumbSize / $imgRatio);
                }
                else
                {
                    $newHeight = $thumbSize;
                    $newWidth = (int) ($thumbSize * $imgRatio);
                }
                list($name, $ext) = explode(".", $fileName);

                if ($formats == 'image/jpeg')// Now it will create a new image from the source
                    $source = imagecreatefromjpeg($tmpName);
                elseif ($formats == 'image/gif')
                    $source = imagecreatefromgif($tmpName);
                elseif ($formats == 'image/png')
                    $source = imagecreatefrompng($tmpName);

                $thumb = imagecreatetruecolor($newWidth, $newHeight); // Making a new true color image
                $newImage = $newImgName . '.' . $ext;
                imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height); // Copy and resize the image
                imagejpeg($thumb, $desImgFile . '/' . $newImage, $quality);
                /*
                  Out put of image
                  if the $savePath is null then it will display the image in the browser
                 */
                imagedestroy($thumb);
                /*
                  Destroy the image
                 */
                if (!empty($moveDefaultFileTo))
                {
                    move_uploaded_file($tmpName, $moveDefaultFileTo.$newImage);
                }
                if (!empty($returnInfo))
                    return array('name' => $newImage, 'width' => $newWidth, 'height' => $newHeight);
                else
                    return false;

            }
        }
    }

    public function resizeImageFile($imgFile="",$thumbSize=0,$savePath=NULL,$quality)
    {
        list($width,$height)=getimagesize($imgFile);
        /* The width and the height of the image also the getimagesize retrieve other information as well   */

        $imgRatio=$width/$height;
        /*
        To compress the image we will calculate the ration
        For eg. if the image width=700 and the height = 921 then the ration is 0.77...
        if means the image must be compression from its height and the width is based on its height
        so the newheight = thumbsize and the newwidth is thumbsize*0.77...
        */
        if($imgRatio>1)
        {
            $newWidth   = $thumbSize;
            $newHeight  = $thumbSize/$imgRatio;
        } else {
            $newHeight  = $thumbSize;
            $newWidth   = $thumbSize*$imgRatio;
        }

        $thumb=imagecreatetruecolor($newWidth,$newHeight); // Making a new true color image
        $source=imagecreatefromjpeg($imgFile); // Now it will create a new image from the source
        imagecopyresampled($thumb,$source,0,0,0,0,$newWidth,$newHeight,$width,$height);  // Copy and resize the image
        imagejpeg($thumb,$savePath,$quality);
        /*
        Out put of image
        if the $savePath is null then it will display the image in the browser
        */
        imagedestroy($thumb);
        /*
            Destroy the image
        */
    }

    public function move_uploaded_file($file, $i, $dir, $newName)
    {
        if (!empty($i))
            $i = $i;
        else
            $i = 0;
        $allowed_formats = array("jpg", "png", "gif", "bmp");
        $fileName = $file["name"][$i];
        $tmpname = $file['tmp_name'][$i];
        $size = $file['size'][$i];
        list($name, $ext) = explode(".", $fileName);
        if (!in_array($ext, $allowed_formats))
        {
            $err = "<strong>Oh snap!</strong>Invalid file formats only use jpg,png,gif";
            return false;
        }
        if ($ext == "jpg" || $ext == "jpeg")
            $src = imagecreatefromjpeg($tmpname);
        else if ($ext == "png")
            $src = imagecreatefrompng($tmpname);
        else
            $src = imagecreatefromgif($tmpname);

        list($width, $height) = getimagesize($tmpname);
        if (move_uploaded_file($tempname, $dir . $newName . '.' . $ext))
            return array('name' => $newName . '.' . $ext, 'width' => $width, 'height' => $height);
    }

}
