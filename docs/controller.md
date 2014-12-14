# Controller

#### Controller

```
class Controller
{
    Methods inherited from Controller...
}```

##### Method Detail

**__construct()** ```
public```

Contructor.

Nó sẽ định nghĩa một Contructor

 ```
public function __construct()
    {
        $f3 = Base::instance();
        $facade = new DataFacade();
        $amq = new AMQFacade();

        $this->f3 = $f3;
        $this->facade = $facade;
        $this->service = $amq;
        $this->_mergeVars(array("uses", "helpers"));
        $this->loadHelpers();
        //$this->loadModels();
    }```

**loadHelpers()** ```
protected```

 ```
protected function loadHelpers()
    {
        foreach ($this->helpers as $helper)
        {
            // get file name
            $helperFile = lcfirst($helper);
            $helper = $helper . 'Helper';

            if (file_exists(HELPERS . $helperFile . '_helper.php'))
            {
                require_once(HELPERS . $helperFile . '_helper.php');
                $this->$helper = new $helper;
            }
        }
    }```

**render** ```
public```

 How to use this render for get variables on view:
 - If existed layout when render, need $this->f3->get('...') on view for get variables
 - If not exist layout, only direct echo $variables on view for get variables. It always using when load ajax or return a part data

```
    public function render($path, $set = array())
    {
        $page = VIEWS . $path . '.php';
        foreach ($set as $k => $value)
            $this->f3->set($k, $value);
        if ($this->layout != '')
            require_once(VIEWS . LAYOUTS . $this->layout . '.php');
        else
            require_once $page;
    }```


```
    public function renderModule($action, $type, $set = array())
    {
        foreach ($set as $k => $value)
            $this->f3->set($k, $value);
        $page = MODULES . $type . '/views/' . $action . '.php';
        if (!empty($this->layout))
            require_once(VIEWS . LAYOUTS . $this->layout . '.php');
        else
            require_once $page;
    }```

**inc()** ```
public```

Include view:

$this->inc('layout',array()).

```
    public function inc($param, $type, $array = array())
    {
        foreach ($array as $k => $value)
        {
            $this->f3->set($k, $value);
        }
        if (file_exists(MODULES . $type . '/views/' . $param . '.php'))
            require MODULES . $type . '/views/' . $param . '.php';
        else if (file_exists(VIEWS . $param . '.php'))
            require VIEWS . $param . '.php';
        else
            throw New Exception('File is not existed !');
    }```

**including()** ```
public```

$this->including('layout include');

```
public function including($file)
    {
        if (file_exists(VIEWS . 'includes/' . $file . '.php'))
            require_once (VIEWS . 'includes/' . $file . '.php');
        else
            throw New Exception('File is not existed !');

```

**loadContent()** ```
public```


```
    public function loadContent($path)
    {
        if (file_exists($path))
            require_once $path;
        else
            echo View::instance()->render($path);
    }```

#### AppController

```
class AppController extends Controoler
{

}```

```
    public function __construct()
    {
        parent::__construct();
    }

    public function beforeRoute()
    {
        //Add some condition later. Set if timeout > 3600 -> disable record session
    }```

 /**

**isLogin()** ```
public```

Some helpful function for controller

   ```
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
```
**element()** ```
public```

```
    public function element($param)
    {
        $element = new FactoryUtils();
        return $element->element($param);
    }```

getCurrentUserName() ```
public```

```
public function getCurrentUserName()
    {
        return 'Session fullName';
    }```

**getAvatar** ```
public```

```
    public function getAvatar($param)
    {
        return $param;
    }```

example:
```
    public function getAvatar($id)
    {

            $avatar = $this->facade->findByPk('photo', $id);
            return UPLOAD_URL . 'thumbnail/' . $avatar->data->fileName;
    }```


**getImg** ```
public```

```
    public function getImg($param)
    {
        return $param;
    }```

example:

```
 public function getImg($id)
    {
        $photo = $this->facade->findByPk('photo', $id);
        return UPLOAD_URL . 'images/' . $photo->data->fileName;
    }```


**getMacAddress()** ```
public```

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

**getIPAddress()** ```
public```

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

**getFriendStt()** ```
public```


    public function getFriendsStt($actor)
    {
        return $this->facade->findAllAttributes('friendship', array('userA' => $actor, 'relationship' => 'friend', 'status' => 'ok'));
    }

**getStatusFriendShip()** ```
public```

    public function getStatusFriendShip($userA, $userB)
    {
        if ($userA != $userB)
        {
            $friendShipAtoB = $this->facade->findByAttributes('friendship', array('userA' => $userA, 'userB' => $userB));
            $friendShipBtoA = $this->facade->findByAttributes('friendship', array('userA' => $userB, 'userB' => $userA));
            if (!empty($friendShipAtoB) && !empty($friendShipBtoA))
            {
                $statusFriendShip = $friendShipBtoA->data->relationship;
            } else
            {
                if (!empty($friendShipAtoB) && !$friendShipBtoA)
                {
                    $statusFriendShip = 'request';
                } elseif (!$friendShipAtoB && !empty($friendShipBtoA))
                {
                    $statusFriendShip = 'respondRequest';
                } else
                {
                    $statusFriendShip = 'addFriend';
                }
            }
        } else
        {
            $statusFriendShip = 'updateInfo';
        }

        return $statusFriendShip;
    }

**trackActivity()** ```
public```


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
                    $this->service->exchange('dandelion', 'topic')->routingKey('newsFeed.post.' . $yourFriends)->dispatch('post', $activities);
                }
            }
        }
    }

**randomKeys()** ```
public```

  ```
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
    }```

**peopleYouMayKnow()** ```
public```


   ```
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
```
**friendRequest()** ```
public```


```
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
    }```



**suggest()** ```
public```



   ```
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
    }```

**getSearchCommand()** ```
public```


   ```
 public function getSearchCommand($properties, $searchText)
    {
        $command = "current.or(";
        for ($i = 0; $i < count($properties); $i++)
        {
            $command = $command . "_().filter{it.getProperty('" . $properties[$i] . "').contains('" . strtolower($searchText) . "')},";
        }
        $command = $command . ")";
        return $command;
    }```

**compressImage()** ```
public```


   ```
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
    }```

**changeImageSingle()** ```
public```


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
    public function changeImageSingle($file, $thumbSize = 0, $desImgFile, $newImgName, $quality, $returnInfo = false, $moveDefaultFileTo = false)
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
        } else
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
            move_uploaded_file($tmpName, $moveDefaultFileTo . $newImage);

        if (!empty($returnInfo))
            return array('name' => $newImage, 'width' => $newWidth, 'height' => $newHeight);
        else
            return false;
    }

**changeImageMultiple()** ```
public```


    public function changeImageMultiple($file, $thumbSize = 0, $desImgFile, $newImgName, $quality, $returnInfo = false, $moveDefaultFileTo = false)
    {
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
            } else
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
                move_uploaded_file($tmpName, $moveDefaultFileTo . $newImage);
            }
            if (!empty($returnInfo))
                return array('name' => $newImage, 'minWidth' => $newWidth, 'minHeight' => $newHeight, 'width' => $width, 'height' => $height);
            else
                return false;
        }
    }

**resizeImageFile()** ```
public```


    public function resizeImageFile($imgFile = "", $thumbSize = 0, $savePath = NULL, $quality)
    {
        list($width, $height) = getimagesize($imgFile);
        /* The width and the height of the image also the getimagesize retrieve other information as well   */

        $imgRatio = $width / $height;
        /*
          To compress the image we will calculate the ration
          For eg. if the image width=700 and the height = 921 then the ration is 0.77...
          if means the image must be compression from its height and the width is based on its height
          so the newheight = thumbsize and the newwidth is thumbsize*0.77...
         */
        if ($imgRatio > 1)
        {
            $newWidth = $thumbSize;
            $newHeight = $thumbSize / $imgRatio;
        } else
        {
            $newHeight = $thumbSize;
            $newWidth = $thumbSize * $imgRatio;
        }

        $thumb = imagecreatetruecolor($newWidth, $newHeight); // Making a new true color image
        $source = imagecreatefromjpeg($imgFile); // Now it will create a new image from the source
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);  // Copy and resize the image
        imagejpeg($thumb, $savePath, $quality);
        /*
          Out put of image
          if the $savePath is null then it will display the image in the browser
         */
        imagedestroy($thumb);
        /*
          Destroy the image
         */
    }

**move_uploaded_file()** ```
public```

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

