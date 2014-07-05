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
        $comment = $facade->findAllAttributes('comment', array('post' => $photoID));
        return $comment;
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
        return $facade->count('comment', array('post' => $id));
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
                $userID = $this->facade->findByAttributes('user', array('username' => $username));
                if (!empty($albumID))
                {
                    $album = $this->facade->findByAttributes('album', array('owner' => $userID->recordID, '@rid' => str_replace('_', ':', $albumID)));
                    $array = explode(",", $album->data->photo);
                    foreach ($array as $value)
                    {
                        $model = $this->facade->findByPk('photo', $value);
                        $photos[] = array('recordID' => $model->recordID, 'userID' => $model->data->actor, 'fileName' => $model->data->fileName);
                    }
                }
                else
                {
                    $array = $this->facade->findAllAttributes('photo', array('actor' => $userID->recordID));
                    foreach ($array as $value)
                    {
                        $photos[] = array('recordID' => $value->recordID, 'userID' => $value->data->actor, 'fileName' => $value->data->fileName);
                    }
                }
                $this->f3->set('photos', $photos);
            }
            $this->render($viewPath . "myPhoto.php", 'modules');
        }
    }

    public function comment()
    {
        if (!empty($_POST['comment']))
        {
            $data = array(
                "actor" => $this->f3->get('SESSION.userID'),
                "content" => $_POST['comment'],
                "post" => $_POST['photoID'],
                "published" => time(),
            );
            $commentID = $this->facade->save('comment', $data);
            if (!empty($commentID))
            {
                $commentRC = $this->facade->findByPk('comment', $commentID);
                $count = $this->facade->count('comment', array('post' => $_POST['photoID']));
                $height = $count * 40 + 50;
                $user = $this->facade->findByPk('user', $commentRC->data->actor);
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

    public function removePhoto()
    {
        if ($this->isLogin())
        {
            $photoID = $this->f3->get('POST.photoID');

            if ($photoID && !is_array($photoID))
            {
                $this->Photo->deleteByCondition("@rid = ?", array('#' . str_replace('_', ':', $photoID)));
                //@todo: remove file in out put dir
            }
            else
            {
                foreach ($photoID as $id)
                {
                    $this->Photo->deleteByCondition("@rid = ?", array('#' . str_replace('_', ':', $id)));
                }
            }
        }
    }

    public function createAlbum()
    {
        if ($this->isLogin())
        {
            $title = $this->f3->get("POST.title");
            $des = $this->f3->get("POST.description");
            $published = time();
            if (!empty($_POST['imgID']))
            {
                foreach ($_POST['imgID'] as $value)
                {
                    list($id, $name, $width, $height) = explode(",", $value);
                    $description = $_POST["description_" . $id];
                    $entry = array(
                        'actor' => $this->f3->get('SESSION.userID'),
                        'fileName' => $name,
                        'width' => $width,
                        'height' => $height,
                        'dragX' => 0,
                        'dragY' => 0,
                        'thumbnail_url' => '',
                        'description' => $description,
                        'numberLike' => '0',
                        'numberComment' => '0',
                        'statusUpload' => 'uploaded',
                        'published' => time(),
                        'type' => 'album'
                    );
                    $photoID[] = $this->facade->save('photo', $entry);
                }
                $photo = implode(',', $photoID);
                $data = array(
                    'owner' => $this->getCurrentUser()->recordID,
                    'name' => $title,
                    'description' => $des,
                    'photo' => $photo,
                    'published' => $published
                );
                $album = $this->facade->save('album', $data);
                header("Location: /content/photo?user=" . $this->f3->get('SESSION.username') . "&album=" . $album);
            }
            else
            {
                $this->renderModule('createAlbum', 'photo');
            }
        }
    }

   

    public function addDescription()
    {
        if ($this->isLogin())
        {
            $description = F3::get('POST.description');
            $getPhotoID = F3::get('POST.photoID');
            $photoID = str_replace('_', ':', $getPhotoID);

            $updateDescription = array('description' => $description);
            $this->Photo->updateByCondition($updateDescription, "@rid = ?", array("#" . $photoID));
        }
    }

    public function postComment()
    {
        if ($this->isLogin())
        {
            $currentUser = $this->getCurrentUser();
            $photoID = str_replace("_", ":", $this->f3->get('POST.postPhotoID'));
            $textComment = $this->f3->get('POST.comment');
            $actorName = $this->getCurrentUserName();
            $published = time();
            $existCommentRC = $this->Comment->findByCondition("actor = ? AND post = ?", array($currentUser->recordID, $photoID));
            if ($existCommentRC)
            {
                $commentEntryCase1 = array(
                    "actor" => $currentUser->recordID,
                    "actor_name" => $actorName,
                    "content" => $textComment,
                    "post" => $photoID,
                    "status_post" => "later",
                    "published" => $published,
                    "tagged" => "none"
                );
                $comment1 = $this->Comment->create($commentEntryCase1);
                $commentID = $comment1;
            }
            else
            {
                $commentEntryCase2 = array(
                    "actor" => $this->getCurrentUser()->recordID,
                    "actor_name" => $actorName,
                    "content" => $textComment,
                    "post" => $photoID,
                    "status_post" => "first",
                    "published" => $published,
                    "tagged" => "none"
                );

                $comment = $this->Comment->create($commentEntryCase2);
                $commentID = $comment;
            }
            /* Update number comment */
            $status_update = $this->Photo->findOne('@rid = ?', array('#' . $photoID));
            $dataCountNumberComment = array('numberComment' => $status_update->data->numberComment + 1);
            $this->Photo->updateByCondition($dataCountNumberComment, "@rid = ?", array("#" . $photoID));
            // track activity
            $userPostID = $this->Photo->findOne("@rid = ?", array($photoID));
            $this->trackComment($currentUser, "photo" . $commentID, $commentID, $photoID, $userPostID->data->actor, $published);

            $this->f3->set('actorName', $actorName);
            $this->f3->set('published', $published);
            $this->f3->set('content', $textComment);
            $this->f3->set('currentUser', $currentUser);
            $this->renderModule('comment', 'photo');
        }
    }

    /* Load comment for Insert in Activity */

    //@todo Check again with album and photo.
    public function LoadComment($object, $actor, $activityID)
    {
        if ($this->isLogin())
        {
            $findStatus = $this->Comment->findByCondition("@rid = ?", array('#' . $object));
            if ($findStatus)
            {
                $findContentStt = $this->Photo->findByCondition("@rid = ?", array('#' . $findStatus[0]->data->post));
                $profileCommentActor[$actor] = $this->User->load($actor);
                $entry = array(
                    'activityID' => $activityID,
                    'name' => $findStatus[0]->data->actor_name,
                    'content' => '<img src=\'' . $findContentStt[0]->data->thumbnail_url . '\' width=\'45px\' height=\'35px\' >',
                    'numberComment' => $findContentStt[0]->data->numberComment,
                    'pfCommentActor' => $profileCommentActor,
                    'published' => $findStatus[0]->data->published,
                    'text' => 'has comment ',
                    'actor' => $actor,
                    'commentID' => $object,
                    'owner' => $findContentStt[0]->data->owner,
                    'link' => 'detailStatus?id=' . $findStatus[0]->data->post,
                    'type' => 'photo'
                );
                return $entry;
            }
        }
    }

    public function deletePhoto()
    {
        if ($this->isLogin())
        {
            $id_photo = str_replace('_', ':', F3::get('POST.id_photo'));
            if ($id_photo)
            {
                $this->Photo->deleteByCondition('@rid = ? ', array('#' . $id_photo));
                $this->Activity->deleteByCondition('idObject = ? ', array($id_photo));
            }
        }
    }

    public function morePhotoComment()
    {
        if ($this->isLogin())
        {
            $published = $this->f3->get('POST.published');
            $photoID = str_replace("_", ":", $this->f3->get('POST.photoID'));

            $comments = $this->Comment->findByCondition("post = ? and published < ? LIMIT 50 ORDER BY published DESC", array($photoID, $published));
            if ($comments)
            {
                $pos = (count($comments) < 50 ? count($comments) : 50);
                for ($j = $pos - 1; $j >= 0; $j--)
                {
                    $commentActor[$comments[$j]->data->actor] = $this->User->load($comments[$j]->data->actor);
                }
            }
            else
            {
                $commentActor = null;
            }
            $this->f3->set("commentActor", $commentActor);
            $this->f3->set("comments", $comments);
            $this->renderModule('morePhotoComment', 'photo');
        }
    }

    public function sharePhoto()
    {
        if ($this->isLogin())
        {
            $photoID = F3::get('POST.photoID');
            $content_stt = $this->Photo->findOne("@rid = ?", array($photoID));
            $getAvatar = $this->User->findOne(" @rid = ? ", array($content_stt->data->actor));
            F3::set('content_stt', $content_stt);
            F3::set('getAvatar', $getAvatar);
            $this->renderModule('sharePhoto', 'photo');
        }
    }

}
