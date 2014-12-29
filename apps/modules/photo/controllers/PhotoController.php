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
            $currentUser = $this->getCurrentUser();
            $albumRC = $this->facade->findByAttributes('album', array('@rid' => '#' . $entry->data->object));

            if (!empty($albumRC))
            {
                $albumID = $albumRC->recordID;
                $userRC = $this->facade->findByPk("user", $albumRC->data->owner);

                $photos = $this->facade->findAllAttributes('photo', array('owner' => $albumRC->data->owner, 'albumID' => $albumID));
                $entry = array(
                    'type' => 'photo',
                    'key' => $key,
                    'like' => true,
                    'user' => $userRC,
                    'username' => $userRC->data->username,
                    'profilePic' => $userRC->data->profilePic,
                    'actions' => $photos,
                    'objectID' => $albumID,
                    'path' => Register::getPathModule('photo'),
                );
                return $entry;
            } else
            {
                return false;
            }
        } else
        {
            return false;
        }
    }

    public function photo()
    {
        if ($this->isLogin())
        {
            $this->layout = "other";
            $username = $this->f3->get('GET.user');
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
                } else
                {
                    $albumID = 'allPhoto'; //Untitled album
                }
                $model = $this->facade->findAllAttributes('photo', array('owner' => $currentProfileRC->recordID));
                $photo = array();
                if (!empty($model))
                {
                    foreach ($model as $value)
                    {
                        $user = $this->facade->findByPk('user', $value->data->owner);
                        $comment = $this->facade->findAllAttributes('comment', array('typeID' => $value->recordID));
                        $dataComment = array();
                        if (!empty($comment))
                        {
                            foreach ($comment as $val)
                            {
                                $userC = $this->facade->findByPk('user', $val->data->owner);
                                $like = $this->facade->findByAttributes('like', array('actor' => $this->f3->get('SESSION.userID'), 'objID' => $val->recordID));
                                $dataComment[] = array('comment' => $val, 'user' => $userC, 'like' => $like);
                            }
                        }
                        $like = $this->facade->findByAttributes('like', array('actor' => $this->f3->get('SESSION.userID'), 'objID' => $value->recordID));
                        $photo[] = array('photo' => $value, 'user' => $user, 'comment' => $dataComment, 'like' => $like);
                    }
                }
                $this->f3->set('userID', $currentProfileID);
                $this->renderModule("myPhoto", 'photo', array(
                    'currentUser' => $currentUser,
                    'otherUser' => $currentProfileRC,
                    'statusFriendShip' => $statusFriendShip,
                    'userID' => str_replace(':', '_', $currentProfileID),
                    'albumID' => $albumID,
                    'photo' => $photo
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
                $userID = str_replace('_', ':', $_POST['userID']);
                $obj = new ObjectHandler();
                $obj->owner = $userID;
                $obj->select = "ORDER BY published DESC offset " . $offset . " LIMIT " . $limit;

                if ($_POST['albumID'] != '')
                {
                    $albumID = str_replace('_', ':', $_POST['albumID']);
                    if ($albumID == 'allPhoto')//load all photos of all album
                    {
                        $model = $this->facade->findAll('photo', $obj);
                    } else
                    {//load all photos of determine an album
                        $obj->albumID = $albumID;
                        $model = $this->facade->findAll('photo', $obj);
                    }
                    $target = 'photos';
                } else
                {//this mean is load all album on myAlbum
                    $model = $this->facade->findAll('album', $obj);
                    $target = 'album';
                }
                $this->renderModule('dataPhoto', 'photo', array('model' => $model, 'target' => $target, 'userID' => $userID));
            }
        }
    }

    public function deletePhoto()
    {
        if ($this->isLogin())
        {

            $filename = explode('_', $_POST['data']);
            $link = UPLOAD . 'images/' . $filename[1];
            $thumb = UPLOAD . 'thumbnail/' . $filename[1];
            if (!empty($link))
            {
                unlink($link);
                unlink($thumb);
                echo $filename[0];
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
                $album = $this->facade->findAllAttributes('album', array('owner' => $currentProfileID));
                $this->renderModule("myAlbum", 'photo', array(
                    'currentUser' => $currentUser,
                    'otherUser' => $currentProfileRC,
                    'statusFriendShip' => $statusFriendShip,
                    'userID' => str_replace(':', '_', $currentProfileID),
                    'album' => $album
                ));
            }
        }
    }

    public function media()
    {
        $this->layout = "other";
        $album = $this->facade->findByPk('album', str_replace('_', ':', $_GET['id']));
        $photo = $this->facade->findAllAttributes('photo', array('album' => str_replace('_', ':', $_GET['id'])));
        $currentProfileRC = $this->facade->findByPk('user', $album->data->owner);
        $currentProfileID = $currentProfileRC->recordID;
        $currentProfileRC = $this->facade->load('user', $currentProfileID);
        $currentUser = $this->getCurrentUser();
        $this->renderModule('mains/media', 'photo', array(
            'otherUser' => $currentProfileRC,
            'currentUser' => $currentUser,
            'userID' => str_replace(':', '_', $currentProfileID),
            'album' => $album,
            'photo' => $photo
        ));
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
                        'owner' => $this->getCurrentUser()->recordID,
                        'name' => $albumTitle,
                        'description' => $albumDes,
                        'published' => $published
                    );
                    $albumID = $this->facade->save('album', $albumEntry);
                } else
                {
                    $albumID = 'none'; //of untitled album
                }
                $imagesName = $_POST['imgName'];
                $imagesDir = UPLOAD . "images/";
                foreach ($imagesName as $image)
                {
                    list($imageName, $name) = explode(",", $image);
                    $description = $_POST["description_" . $name];
                    //images are waiting in tmp folder
                    $file = UPLOAD . 'tmp/' . $imageName;
                    list($width, $height) = getimagesize($file);
                    //check IF size of images are larger than 960px then resize us ELSE move us from tmp folder to images folder
                    if ($width > 960 || $height > 960)
                        $this->resizeImageFile($file, 960, $imagesDir . $imageName, 100);
                    else
                        rename($file, $imagesDir . $imageName);
                    //save to DB
                    list($nWidth, $nHeight) = getimagesize(UPLOAD . 'images/' . $imageName);
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
                $this->renderModule('createAlbum', 'photo');
            }
        }
    }

    public function index()
    {
        if (!empty($_GET['type']) && $_GET['type'] == 1)
            $this->layout = 'popupphoto';

        if (!empty($_GET['uid']) && !empty($_GET['pid']))
        {
            $photo = $this->facade->findByPk('photo', $this->getRecordId($_GET['pid']));
            if ($_GET['sid'] != 0)
                $findAll = $this->facade->findAllAttributes('photo', array('typeID' => $this->getRecordId($_GET['sid']), 'owner' => $this->getRecordId($_GET['uid'])));
            else
                $findAll = $this->facade->findAllAttributes('photo', array('owner' => $this->getRecordId($_GET['uid'])));
            $k = $_GET['page'];
            $currentUser = $this->getCurrentUser();
            if ($k + 1 < count($findAll))
                $this->f3->set('idn', $findAll[$k + 1]->recordID);

            if ($k > 0)
                $this->f3->set('idp', $findAll[$k - 1]->recordID);

            $like = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $photo->recordID));
            $comment = $this->facade->findAllAttributes('comment', array('typeID' => $photo->recordID));
            $commentArray = array();
            if (!empty($comment))
            {
                foreach ($comment as $value)
                {
                    $like = $this->facade->findAllAttributes('like', array('actor' => $currentUser->recordID, 'objID' => $value->recordID));
                    $userComment = $this->facade->findByPk('user', $value->data->owner);
                    $commentArray[] = array('comment' => $value, 'like' => $like, 'user' => $userComment);
                }
            }
            $user = $this->facade->findByPk('user', $photo->data->owner);
            $avatar = $this->facade->findByPk('photo', $user->recordID);
            if (!empty($avatar))
                $photoAvatar = $avatar->data->fileName;
            else
                $photoAvatar = 'avatarMenDefault.png';

            if (!empty($_GET['set']))
            {
                $this->renderModule('photoDrap', 'photo', array('photo' => $photo));
            } else
            {
                $this->renderModule('popup', 'photo', array('photo' => $photo, 'tID' => $_GET['sid'], 'k' => $k, 'avatar' => $photoAvatar, 'user' => $user, 'like' => $like, 'comment' => $commentArray));
            }
        }
    }

    public function photoBrowsers()
    {
        if ($this->isLogin())
        {
            if (!empty($_GET['act']))
            {
                $album = $this->facade->findAllAttributes('album', array('owner' => $this->f3->get('SESSION.userID')));
                $this->renderModule('mains/albumBrowsers', 'photo', array('album' => $album, 'rid' => $_GET['rid'], 'type' => $_GET['type']));
            } else
            {
                if (!empty($_GET['aid']))
                {
                    $album = $this->facade->findByPk('album', $_GET['aid']);
                    if (!empty($album))
                    {
                        $albumName = $album->data->name;
                        $photos = $this->facade->findAllAttributes('photo', array('album' => $album->recordID));
                    } else
                    {
                        $albumName = '';
                    }
                } else
                {
                    $photos = $this->facade->findAllAttributes('photo', array('owner' => $this->f3->get('SESSION.userID')));
                    $albumName = 'Recent Uploads';
                }
                $this->f3->set('albumName', $albumName);
                $this->f3->set('photos', $photos);
                $this->f3->set('rid', $_GET['id']);
                $this->f3->set('type', 'group');
                $this->renderModule('mains/photoBrowsers', 'photo');
            }
        }
    }

    public function crop()
    {
        $targ_w = $targ_h = 160;
        $jpeg_quality = 90;

        $src = UPLOAD . 'images/5444dc8d99702.jpg';
        $newfilename = UPLOAD . 'images/thumbnail/';
        $img_r = imagecreatefromjpeg($src);
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);
        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x1'], $_POST['y1'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);
        header('Content-type: image/jpeg');
        //imagejpeg($dst_r,null,$jpeg_quality);
        imagejpeg($dst_r, $newfilename . '/' . time() . '.jpg', 150);
    }

}
