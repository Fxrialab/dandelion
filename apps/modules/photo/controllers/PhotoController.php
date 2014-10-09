<?php

class PhotoController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Binding photo data from album
     *
     * @param $entry
     * @param $key
     * @return array|bool
     */
    public function bindingData($entry, $key)
    {
        if (!empty($entry))
        {
            $currentUser= $this->getCurrentUser();
            $albumRC   = $this->facade->findByAttributes('album', array('@rid'=>'#'.$entry->data->object));

            if (!empty($albumRC))
            {
                $albumID = $albumRC->recordID;
                $userRC = $this->facade->findByPk("user", $albumRC->data->owner);

                $photos = $this->facade->findAllAttributes('photo', array('owner' => $albumRC->data->owner,'albumID'=>$albumID));
                $entry = array(
                    'type'      => 'photo',
                    'key'       => $key,
                    'like'      => true,
                    'user'      => $userRC,
                    'username'  => $userRC->data->username,
                    'profilePic'=> $userRC->data->profilePic,
                    'actions'   => $photos,
                    'objectID'  => $albumID,
                    'path'      => Register::getPathModule('photo'),
                );
                return $entry;
            }else{
                return false;
            }
        }else {
            return false;
        }
    }

    public function photo($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = "other";
            $username = $this->f3->get('GET.user');
            $album = $this->f3->get('GET.album');
            //echo $username;
            if (!empty($username))
            {
                $currentProfileRC = $this->facade->findByAttributes('user', array('username' => $username));
                $currentProfileID = $currentProfileRC->recordID;
                $this->f3->set('SESSION.userProfileID', $currentProfileID);
                $currentProfileRC = $this->facade->load('user', $currentProfileID);
                $currentUser = $this->getCurrentUser();
                //get status friendship
                $statusFriendShip = $this->getStatusFriendShip($currentUser->recordID, $currentProfileRC->recordID);
                if (!empty($album))
                {
                    $albumID = $album;
                }
                else
                {
                    $albumID = 'allPhoto';//Untitled album
                }
                $this->f3->set('userID', $currentProfileID);
                $this->render($viewPath . "mains/myPhoto.php", 'modules', array(
                    'currentUser'   => $currentUser,
                    'otherUser'     => $currentProfileRC,
                    'statusFriendShip'  => $statusFriendShip,
                    'userID'        => str_replace(':','_',$currentProfileID),
                    'albumID'       => $albumID
                ));
            }

        }
    }

    /**
     *  This is loading only photo or album on photo module
     */
    public function loading()
    {
        if ($this->isLogin())
        {
            $offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
            $limit = is_numeric($_POST['number']) ? $_POST['number'] : die();

            if (!empty($_POST['userID']))
            {
                $userID = str_replace('_',':',$_POST['userID']);
                $obj = new ObjectHandler();
                $obj->owner = $userID;
                $obj->select = "ORDER BY published DESC offset " . $offset . " LIMIT " . $limit;

                if ($_POST['albumID'] != '')
                {
                    $albumID = str_replace('_',':',$_POST['albumID']);
                    if ($albumID == 'allPhoto')//load all photos of all album
                    {
                        $model = $this->facade->findAll('photo', $obj);
                    }else {//load all photos of determine an album
                        $obj->albumID = $albumID;
                        $model = $this->facade->findAll('photo', $obj);
                    }
                    $target = 'photos';
                }else {//this mean is load all album on myAlbum
                    $model = $this->facade->findAll('album', $obj);
                    $target = 'album';
                }
                $this->renderModule('mains/dataPhoto', 'photo', array('model'=>$model, 'target'=>$target, 'userID'=>$userID));
            }
        }
    }

    public function comment()
    {
        if (!empty($_POST['comment']))
        {
            $data = array(
                "userID" => $this->f3->get('SESSION.userID'),
                "content" => $_POST['comment'],
                "typeID" => str_replace('_', ':', $_POST['photoID']),
                "published" => time(),
            );
            $commentID = $this->facade->save('comment', $data);
            if (!empty($commentID))
            {
                $commentRC = $this->facade->findByPk('comment', $commentID);
                $count = $this->facade->count('comment', array('typeID' => str_replace('_', ':', $_POST['photoID'])));
                $height = $count * 40 + 50;
                $user = $this->facade->findByPk('user', $commentRC->data->userID);
                echo json_encode(array(
                    'id' => str_replace(':', '_', $commentID),
                    'photoID' => str_replace(':', '_', $_POST['photoID']),
                    'count' => $count,
                    'height' => $height,
                    'content' => $commentRC->data->content,
                    'name' => $user->data->fullName,
                    'userID' => $user->recordID,
                    'time' => $commentRC->data->published
                ));
            }
        }
    }

    public function deletePhoto()
    {
        if ($this->isLogin())
        {

            $filename = $_POST['name'];
            $link = UPLOAD_URL . $filename;
            if (!empty($link))
            {
                unlink($link);
                echo $_POST['id'];
            }
        }
    }

    public function album()
    {
        if ($this->isLogin())
        {
            $this->layout = "other";
            $username = $this->f3->get('GET.user');
            if (!empty($username))
            {
                $currentProfileRC = $this->facade->findByAttributes('user', array('username' => $username));
                $currentProfileID = $currentProfileRC->recordID;
                $currentProfileRC = $this->facade->load('user', $currentProfileID);
                $currentUser = $this->getCurrentUser();
                //get status friendship
                $statusFriendShip = $this->getStatusFriendShip($currentUser->recordID, $currentProfileRC->recordID);
                $this->render(Register::getPathModule('photo')."mains/myAlbum.php", 'modules', array(
                    'currentUser'   => $currentUser,
                    'otherUser'     => $currentProfileRC,
                    'statusFriendShip'  => $statusFriendShip,
                    'userID'        => str_replace(':','_',$currentProfileID)
                ));
            }

        }
    }

    public function createAlbum()
    {
        if ($this->isLogin())
        {
            $currentUser = $this->getCurrentUser();
            //if existed photo for create album
            if (!empty($_POST['imgName']))
            {
                $albumTitle = $this->f3->get("POST.albumTitle");
                $albumDes = $this->f3->get("POST.albumDescription");
                $published = time();
                //get album id
                if (!empty($albumTitle))
                {
                    $albumEntry = array(
                        'owner'     => $this->getCurrentUser()->recordID,
                        'name'      => $albumTitle,
                        'description' => $albumDes,
                        'published' => $published
                    );
                    $albumID = $this->facade->save('album', $albumEntry);
                }else {
                    $albumID = 'none';//of untitled album
                }
                $imagesName = $_POST['imgName'];
                $imagesDir = UPLOAD . "images/";
                foreach ($imagesName as $image)
                {
                    list($imageName, $name) = explode(",", $image);
                    $description = $_POST["description_" . $name];
                    //images are waiting in tmp folder
                    $file = UPLOAD.'tmp/'.$imageName;
                    list($width, $height) = getimagesize($file);
                    //check IF size of images are larger than 960px then resize us ELSE move us from tmp folder to images folder
                    if ($width > 960 || $height > 960)
                        $this->resizeImageFile($file, 960, $imagesDir.$imageName, 100);
                    else
                        rename($file, $imagesDir.$imageName);
                    //save to DB
                    list($nWidth, $nHeight) = getimagesize(UPLOAD.'images/'.$imageName);
                    $photoEntry = array(
                        'owner' => $this->f3->get('SESSION.userID'),
                        'albumID' => $albumID,
                        'fileName' => $imageName,
                        'width' => $nWidth,
                        'height' => $nHeight,
                        'dragX' => '0',
                        'dragY' => '0',
                        'thumbnail_url' => '',
                        'description' => $description,
                        'numberLike' => '0',
                        'numberComment' => '0',
                        'statusUpload' => 'uploaded',
                        'published' => time(),
                        'type' => 'none'
                    );
                    $this->facade->save('photo', $photoEntry);
                }
                // track activity to home page
                $this->trackActivity($currentUser, 'Photo', $albumID, 'photo', false, $published);
                echo BASE_URL . "content/photo?user=" . $this->f3->get('SESSION.username') . "&album=" . str_replace(':', '_', $albumID);
            }
            else
            {
                $this->renderModule('mains/createAlbum', 'photo');
            }
        }
    }

    public function detail()
    {
        if ($this->isLogin())
        {
            if (!empty($_GET['id']))
            {
                $id = str_replace('_', ':', $_GET['id']);
                $k = str_replace('_', ':', $_GET['p']);
                $kc = $k + 1;
                $kt = $k - 1;
                if (!empty($_GET['typeID']))
                {
                    $array = $this->facade->findAllAttributes('photo', array('actor' => F3::get('SESSION.userID'), 'typeID' => str_replace('_', ':', $_GET['typeID'])));
                    if ($k >= 0 && $k < count($array) - 1)
                        $idn = str_replace(':', '_', $array[$kc]->recordID);
                    else
                        $idn = str_replace(':', '_', $array[$k]->recordID);
                    if ($k == 0)
                        $idp = 0;
                    else
                        $idp = str_replace(':', '_', $array[$kt]->recordID);
                    $next = '/content/photo/detail?typeID=' . str_replace(':', '_', $_GET['typeID']) . '&id=' . $idn . '&p=' . $kc;
                    $prev = '/content/photo/detail?typeID=' . str_replace(':', '_', $_GET['typeID']) . '&id=' . $idp . '&p=' . $kt;
                }
                else
                {
                    $array = $this->facade->findAllAttributes('photo', array('owner' => F3::get('SESSION.userID')));
                    if ($k >= 0 && $k < count($array) - 1)
                        $idn = str_replace(':', '_', $array[$kc]->recordID);
                    else
                        $idn = str_replace(':', '_', $array[$k]->recordID);
                    if ($k == 0)
                        $idp = 0;
                    else
                        $idp = str_replace(':', '_', $array[$kt]->recordID);
                    $next = '/content/photo/detail?id=' . $idn . '&p=' . $kc;
                    $prev = '/content/photo/detail?id=' . $idp . '&p=' . $kt;
                }
                $currentUser = $this->getCurrentUser();
                $photo = $this->facade->findByPk('photo', $id);
                $this->renderModule('mains/detail', 'photo', array(
                    'photo' => $photo,
                    'next'  => $next,
                    'prev'  => $prev,
                    'p'     => $k,
                    'count'  => count($array) - 1,
                    'currentUser'  => $currentUser,
                ));
            }
        }
    }

}
