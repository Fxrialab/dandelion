<?php

class PhotoController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    static function getFindComment($photoID)
    {
        $facade = new DataFacade();
        $comment = $facade->findAllAttributes('comment', array('typeID' => $photoID));
        return $comment;
    }

    public static function like($typeID)
    {
        $facade = new DataFacade();
        $model = $facade->findByAttributes('like', array('actor' => F3::get('SESSION.userID'), 'objID' => $typeID));
        if (!empty($model))
            return TRUE;
        else
            return FALSE;
    }

    static function getPhoto($id)
    {
        $facade = new DataFacade();
        return $facade->findByPk('photo', $id);
    }

    static function getUser($id)
    {
        $facade = new DataFacade();
        return $facade->findByPk('user', $id);
    }

    public static function countComment($id)
    {
        $facade = new DataFacade();
        return $facade->count('comment', array('typeID' => $id));
    }

    //Upload image Post and Comment
    public function upload()
    {
        if ($this->isLogin())
        {
            $outPutDir = UPLOAD;
            $data = array(
                'results' => array(),
                'success' => false,
                'error' => ''
            );
            if (!empty($_FILES["myfile"]))
            {
                $fileName = $_FILES["myfile"]["name"][0];
                $tmpname = $_FILES["myfile"]['tmp_name'][0];
                $size = $_FILES["myfile"]['size'][0];
                list($name, $ext) = explode(".", $fileName);
                $newName = uniqid();
                list($width, $height) = getimagesize($tmpname);
                if (move_uploaded_file($_FILES["myfile"]["tmp_name"][0], $outPutDir . $newName . '.' . $ext))
                    $data['results'][] = array('imgID' => $newName, 'url' => UPLOAD_URL . $newName . '.' . $ext, 'name' => $newName . '.' . $ext, 'width' => $width, 'height' => $height);
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode((object) $data);
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

    // @todo: ask client for album page
    public function photo($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = "timeline";
            $username = $this->f3->get('GET.user');
            $albumID = $this->f3->get('GET.album');
            if (!empty($username))
            {
                $photos = array();
                $userID = $this->facade->findByAttributes('user', array('username' => $username));
                if (!empty($albumID))
                {
                    $this->f3->set('albumID', $albumID);
//                    $album = $this->facade->findByAttributes('album', array('owner' => $userID->recordID, '@rid' => str_replace('_', ':', $albumID)));
//                    $array = explode(",", $album->data->photo);
//                    foreach ($array as $value)
//                    {
//                        $model = $this->facade->findByPk('photo', $value);
//                        $photos[] = array('recordID' => $model->recordID, 'userID' => $model->data->actor, 'fileName' => $model->data->fileName, 'numberLike' => $model->data->numberLike);
//                    }
                }
                else
                {
                    $this->f3->set('albumID', '0');
//                    $array = $this->facade->findAllAttributes('photo', array('actor' => $userID->recordID));
//                    if (!empty($array))
//                        foreach ($array as $value)
//                            $photos[] = array('recordID' => $value->recordID, 'userID' => $value->data->actor, 'fileName' => $value->data->fileName, 'numberLike' => $value->data->numberLike);
                }
                $this->f3->set('userID', $userID->recordID);
            }
            $this->render($viewPath . "myPhoto.php", 'modules');
        }
    }

    public function success()
    {
        if ($this->isLogin())
        {
            $offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die();
            $limit = is_numeric($_POST['number']) ? $_POST['number'] : die();
            $obj = new ObjectHandler();
            $obj->actor = $_POST['userID'];
            $obj->select = 'and published > 1399543903 LIMIT ' . $limit . ' ORDER BY published DESC offset ' . $offset;
            if ($_POST['albumID'] == 0)
            {
                $model = $this->facade->findAll('photo', $obj);
                if (!empty($model))
                {
                    foreach ($model as $value)
                    {
                        $photos[] = array('recordID' => $value->recordID, 'userID' => $value->data->actor, 'fileName' => $value->data->fileName, 'numberLike' => $value->data->numberLike);
                    }
                    $set = $photos;
                }
                else
                {
                    $set = 'null';
                }
            }
            else
            {
                $album = $this->facade->findByAttributes('album', array('owner' => $userID->recordID, '@rid' => $_POST['albumID']));
                if (!empty($album))
                {
                    $array = explode(",", $album->data->photo);
                    foreach ($array as $value)
                    {
                        $model = $this->facade->findByPk('photo', $value);
                        $photos[] = array('recordID' => $model->recordID, 'userID' => $model->data->actor, 'fileName' => $model->data->fileName, 'numberLike' => $model->data->numberLike);
                    }
                    $set = $photos;
                }
                else
                {
                    $set = 'null';
                }
            }
            $this->f3->set('photos', $set);
            $this->renderModule('dataPhoto', 'photo');
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

    public function myPhoto($viewPath)
    {
        if ($this->isLogin())
        {
            $this->layout = "timeline";
            $username = $this->f3->get('GET.username');
            if (!empty($username))
            {
                $userID = $this->facade->findByAttributes('user', array('username' => $username));
                $photos = $this->facade->findAll('photo', array('actor' => $userID->recordID));
                $this->f3->set('photos', $photos);
            }
            $this->render($viewPath . "myPhoto.php", 'modules');
        }
    }

    public function myAlbum()
    {
        if ($this->isLogin())
        {
            $this->layout = "timeline";
            $username = $this->f3->get('GET.user');
            if (!empty($username))
            {
                $userID = $this->facade->findByAttributes('user', array('username' => $username));
                $album = $this->facade->findAllAttributes('album', array('owner' => $userID->recordID));
                $this->f3->set('album', $album);
            }
            $this->render(Register::getPathModule('photo') . "myAlbum.php", 'modules');
        }
    }

    public function loadingPhoto()
    {
        if ($this->isLogin())
        {
            $outPutDir = UPLOAD;
            $data = array(
                'results' => array(),
                'success' => false,
                'error' => ''
            );

            if (isset($_FILES["myfile"]))
            {
                $currentUser = $this->getCurrentUser();
                $allowed_formats = array("jpg", "png", "gif", "bmp");
                $data['success'] = true;
                $data['error'] = $_FILES["myfile"]["error"];

                if (!is_array($_FILES["myfile"]['name'])) //single file
                {
                    $allowed_formats = array("jpg", "png", "gif", "bmp");
                    $fileName = $_FILES["myfile"]["name"];
                    $tmpname = $_FILES['myfile']['tmp_name'];
                    $size = $_FILES['myfile']['size'];
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
                    if ($width > 750)
                    {
                        $newwidth = 750;
                        $newheight = ($height / $width) * $newwidth;
                        $tmp = imagecreatetruecolor($newwidth, $newheight);
                        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                        $image = $outPutDir . $fileName;
                        imagejpeg($tmp, $outPutDir . $fileName, 100);
                        move_uploaded_file($image, $outPutDir . $fileName);
                    }
                    else
                    {
                        move_uploaded_file($_FILES["myfile"]["tmp_name"], $outPutDir . $fileName);
                    }


                    $entry = array(
                        'actor' => $currentUser->recordID,
                        'album' => '',
                        'fileName' => $fileName,
                        'drapx' => 0,
                        'drapy' => 0,
                        'thumbnail_url' => '',
                        'description' => '',
                        'numberLike' => '0',
                        'numberComment' => '0',
                        'statusUpload' => 'uploaded',
                        'published' => ''
                    );

                    $photoID = $this->facade->save('photo', $entry);

                    $infoPhotoRC = $this->facade->findByPk('photo', $photoID);

                    $data['results'][] = array(
                        'photoID' => str_replace(':', '_', $infoPhotoRC->recordID),
                        'fileName' => $infoPhotoRC->data->fileName,
                        'url' => UPLOAD_URL . $infoPhotoRC->data->fileName
                    );
                }
                else
                {
                    $fileCount = count($_FILES["myfile"]['name']);
                    for ($i = 0; $i < $fileCount; $i++)
                    {
                        $fileName = $_FILES["myfile"]["name"][$i];
                        $tmpname = $_FILES["myfile"]['tmp_name'][$i];
                        $size = $_FILES["myfile"]['size'][$i];
                        list($name, $ext) = explode(".", $fileName);
                        $newName = time();
                        list($width, $height) = getimagesize($tmpname);
                        if (move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $outPutDir . $newName . '.' . $ext))
                            $data['results'][] = array('url' => UPLOAD_URL . $newName . '.' . $ext, 'name' => $newName . '.' . $ext, 'width' => $width, 'height' => $height);
                    }
                }
                header("Content-Type: application/json; charset=UTF-8");
                $jsonData = json_encode((object) $data);
                echo $jsonData;
            }
        }
    }

    public function uploadPhoto()
    {
        if ($this->isLogin())
        {
            $outPutDir = UPLOAD . "test/";
            $qualityCB = $this->f3->get('POST.stage');
            $data = $this->f3->get('POST.data');
            $albumID = $this->f3->get('POST.albumID');
            $albumID = ($albumID == 'none') ? $albumID : str_replace('_', ':', $albumID);
            $published = time();
            if ($qualityCB == 'checked')
            {
                if ($data)
                {
                    foreach ($data as $photo)
                    {
                        $photoID = str_replace('_', ':', $photo['photoID']);
                        $description = $photo['description'];
                        $updateEntry = array(
                            'album' => $albumID,
                            'description' => $description,
                            'published' => $published
                        );
                        $this->Photo->updateByCondition($updateEntry, "@rid = ?", array('#' . $photoID));
                        $photoRC = $this->Photo->findOne("@rid = ?", array('#' . $photoID));
                        $filePath = $outPutDir . $photoRC->data->fileName;
                        //check size of image
                        list($width, $height) = getimagesize($filePath);
                        if ($width > 960 || $height > 960)
                            $this->resizeImage($filePath, 960, $filePath);
                    }
                }
            }else
            {
                if ($data)
                {
                    foreach ($data as $photo)
                    {
                        $photoID = str_replace('_', ':', $photo['photoID']);
                        $description = $photo['description'];
                        $updateEntry = array(
                            'album' => $albumID,
                            'description' => $description,
                            'published' => $published
                        );
                        $this->Photo->updateByCondition($updateEntry, "@rid = ?", array('#' . $photoID));
                        $photoRC = $this->Photo->findOne("@rid = ?", array('#' . $photoID));
                        $filePath = $outPutDir . $photoRC->data->fileName;
                        //check size of image
                        list($width, $height) = getimagesize($filePath);
                        if ($width > 960 || $height > 960)
                            $this->resizeImage($filePath, 960, $filePath);
                        $this->compressImage($filePath, $filePath, 80);
                    }
                }
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
                        'actor' => $this->f3->get('SESSION.userID'),
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
                $this->trackActivity($currentUser, 'Photo', false, 'photo', $albumID, $published);
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
                    $array = $this->facade->findAllAttributes('photo', array('actor' => F3::get('SESSION.userID')));
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

                $photo = $this->facade->findByPk('photo', $id);
                $this->f3->set('photo', $photo);
                $this->f3->set('next', $next);
                $this->f3->set('prev', $prev);
                $this->f3->set('p', $k);
                $this->f3->set('count', count($array) - 1);
                $this->renderModule('detail', 'photo');
            }
        }
    }

}
