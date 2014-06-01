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

    public function element($element)
    {
        if (file_exists(UI . ELEMENTS . $element . '.php'))
        {
            if (method_exists($this->Elements, $element))
            {
                $this->Elements->$element();
            }
            require(UI . ELEMENTS . $element . '.php');
        }
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

    public function loadModules($modules)
    {
        if ($modules != '')
            require_once(MODULES . $modules);
    }

    static function elementModules($element, $modules)
    {
        include MODULES . $modules . '/info.php';
        if (file_exists(MODULES . $path . $element . '.php'))
        {
            foreach (glob(MODULES . $modules . '/controllers/' . $modules . 'controller.php') as $elementController)
            {
                if (file_exists($elementController))
                {
                    $elementControllers = $modules . 'Controller';
                    $newElement = new $elementControllers;
                    if (method_exists($newElement, $element))
                    {
                        $newElement->$element();
                    }
                }
            }
            require_once(MODULES . $path . $element . '.php');
        }
    }

    public function getFriendsStt($actor)
    {
        return $this->facade->findAllAttributes('friendship', array('userA' => $actor, 'relationship' => 'friend', 'status' => 'ok'));
    }

    public function getStatusFriendShip($userA, $userB)
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

        return $statusFriendShip;
    }

    // **********************************
    // Track activity
    // **********************************
    public function trackActivity($actor, $verb, $object, $type, $typeID, $published)
    {
        $checkActivity = $this->facade->findAllAttributes('activity', array('owner' => $actor->recordID, 'object' => $object));
        $findUserBOfFollow = $this->facade->findByPk('follow', $actor->recordID);
        $actorID = ($findUserBOfFollow) ? $findUserBOfFollow->data->userB : $actor->recordID;
        if (!$checkActivity)
        {
            // prepare activity data
            $activity = array(
                'owner' => $actor->recordID,
                'actor' => $actorID,
                'verb' => $verb,
                'object' => $object,
                'type' => $type,
                'typeID' => $typeID,
                'idObject' => $object,
                'published' => $published
            );
            // create activity for currentUser
            $this->facade->save('activity', $activity);
            $friends = $this->getFriendsStt($actor->recordID);

            // dupicate activities for followers
            if (!empty($friends) && !$checkActivity)
            {
                for ($i = 0; $i < count($friends); $i++)
                {
                    $checkActivityFriend = $this->facade->findAllAttributes('activity', array('owner' => $friends[$i]->data->userB, 'object' => $object));
                    //var_dump($checkActivityFriend);
                    //@todo handling follow after: HN
                    if ($findUserBOfFollow)
                    {
                        $checkFriends = $this->facade->findAllAttributes('friendship', array('userA' => $friends[$i]->data->userB, 'userB' => $findUserBOfFollow->data->userB, 'status' => 'ok'));
                        if ($checkFriends == null)
                        {
                            $activity = array(
                                'owner' => $actor->recordID,
                                'actor' => $findUserBOfFollow->data->userB,
                                'verb' => $verb,
                                'object' => $object,
                                'type' => 'post',
                                'idObject' => $object,
                                'published' => $published
                            );
                            $this->facade->save('activity', $activity);
                        }
                    }
                    // prepare activity for each followers
                    if (!$checkActivityFriend)
                    {
                        $activity = array(
                            'owner' => $friends[$i]->data->userB,
                            'actor' => $actor->recordID,
                            'verb' => $verb,
                            'object' => $object,
                            'type' => 'post',
                            'idObject' => $object,
                            'published' => $published
                        );
                        $this->facade->save('activity', $activity);
                    }
                }
            }
        }
    }

    public function trackComment($actor, $verb, $object, $statusID, $owner, $published)
    {
        $findUser = Model::get('comment')->findByCondition("post = '" . $statusID . "'");
        $checkActivity = Model::get('activity')->findByCondition("owner = '" . $actor->recordID . "' AND object = '" . $object . "'");

        $findUserBOfFollow = Model::get('follow')->findByPk($actor->recordID);
        $actorID = ($findUserBOfFollow) ? $findUserBOfFollow->data->userB : $actor->recordID;
        if (!$checkActivity)
        {
            /* Insert in to Activity for user posted this status. */
            if ($owner != $actor->recordID)
            {
                $userStatus = array(
                    'owner' => $owner,
                    'actor' => $actor->recordID,
                    'verb' => $verb,
                    'object' => $object,
                    'type' => 'comment',
                    'idObject' => $statusID,
                    'published' => $published
                );

                Model::get('activity')->create($userStatus);
            }

            $friends = $this->getFriendsStt($actor->recordID);
            /* dupicate activities for followers */
            if (!empty($friends) && !$checkActivity)
            {
                for ($i = 0; $i < count($friends); $i++)
                {
                    //@todo handling follow after: HN
                    if ($findUserBOfFollow)
                    {
                        $checkFriends = Model::get('friendship')->findByCondition("userA = '" . $friends[$i]->data->userB . "' AND status = 'ok' userB = '" . $findUserBOfFollow->data->userB . "'");
                        if ($checkFriends == null)
                        {
                            $activity = array(
                                'owner' => $actor->recordID,
                                'actor' => $findUserBOfFollow->data->userB,
                                'verb' => $verb,
                                'object' => $object,
                                'type' => 'comment',
                                'idObject' => $statusID,
                                'published' => $published
                            );
                            Model::get('activity')->create($activity);
                        }
                    }
                }
            }
            /* Insert Activity for user join comment in this status . */
            if ($findUser)
            {
                foreach ($findUser as $userCmt)
                {
                    if ($userCmt)
                    {
                        $checkActivityComment = Model::get('activity')->findByCondition("owner = '" . $userCmt->data->actor . "' AND object = '" . $object . "'");
                        if (!$checkActivityComment)
                        {
                            if ($userCmt->data->actor != $this->getCurrentUser()->recordID)
                            {
                                $userComment = array(
                                    'owner' => $userCmt->data->actor,
                                    'actor' => $this->getCurrentUser()->recordID,
                                    'verb' => $verb,
                                    'object' => $object,
                                    'type' => 'comment',
                                    'idObject' => $statusID,
                                    'published' => $published
                                );
                                Model::get('activity')->create($userComment);
                            }
                        }
                    }
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
     * @return array|bool
     */
    public function changeImage($file, $thumbSize = 0, $desImgFile, $newImgName, $quality, $returnInfo=false)
    {
        $fileName   = $file["name"];
        $tmpName    = $file['tmp_name'];
        $formats    = $file['type'];

        list($width, $height) = getimagesize($tmpName);
        /* The width and the height of the image also the getimagesize retrieve other information as well   */
        $imgRatio = $width / $height;

        if ($imgRatio > 1)
        {
            $newWidth = $thumbSize;
            $newHeight = (int)($thumbSize / $imgRatio);
        }
        else
        {
            $newHeight = $thumbSize;
            $newWidth = (int)($thumbSize * $imgRatio);
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
        imagejpeg($thumb, $desImgFile.'/' . $newImage, $quality);
        /*
          Out put of image
          if the $savePath is null then it will display the image in the browser
         */
        imagedestroy($thumb);
        /*
          Destroy the image
         */
        if (!empty($returnInfo))
            return array('name' => $newImage, 'width' => $newWidth, 'height' => $newHeight);
        else
            return false;
    }

    public function resizeImages($file, $size = 0, $dir, $newName)
    {
        $allowed_formats = array("jpg", "png", "gif", "bmp");
        $fileName = $file["name"];
        $tmpname = $file['tmp_name'];

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

        $thumbName = $newName . '.' . $ext;
        list($width, $height) = getimagesize($tmpname);
        $newwidth = $size;
        $newheight = ($height / $width) * $newwidth;
        $tmp = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        $image = $dir . $fileName;
        imagejpeg($tmp, $dir . $size . '/' . $thumbName, 100);
        /*
          Destroy the image
         */
    }

    public function move_uploaded_file($file, $dir, $newName)
    {
        $allowed_formats = array("jpg", "png", "gif", "bmp");
        $fileName = $file["name"];
        $tmpname = $file['tmp_name'];
        $size = $file['size'];
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
        if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $dir . $newName . '.' . $ext))
            return array('name' => $newName . '.' . $ext, 'width' => $width, 'height' => $height);
    }

}
