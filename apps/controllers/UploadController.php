<?php

class UploadController extends AppController
{

    protected $helpers = array("String");

    //Uploading photo when choose us, it's not submit
    public function uploading()
    {
        if ($this->isLogin())
        {
            $tempDir = UPLOAD . "tmp/";
            $thumbnailDir = UPLOAD . "thumbnails/150px"; //The folder will display like gallery images on "Choose from my photos"
            $data = array(
                'results' => array(),
                'success' => false,
                'error' => ''
            );

            if (isset($_FILES["myfile"]))
            {
                //var_dump($_FILES["myfile"]['name']);
                if (!is_array($_FILES["myfile"]['name'])) //single file
                {
                    echo 'single file';
                }
                else
                {//multiple files
                    $file = $_FILES["myfile"];
                    $code = $this->StringHelper->generateRandomString(5);
                    $newName = $code . time();
                    $photo = $this->changeImage($file, 150, $thumbnailDir, $newName, 80, true, $tempDir); //upload to thumbnail folder
                    $data['results'][] = array(
                        'photoName' => $photo['name'],
                        'nameNotExt' => substr($photo['name'], 0, strpos($photo['name'], '.')),
                        'url' => UPLOAD_URL . 'thumbnails/150px/' . $photo['name']
                    );
                    $data['success'] = true;
                }
            }
            else
            {
                $data['error'] = "Upload is failed, pls try again !";
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode((object) $data);
        }
    }

    //Upload image cover User
    public function uploadCover()
    {
        if ($this->isLogin())
        {
            $tempDir = UPLOAD . "tmp/";
            $coverDir = UPLOAD . "cover/750px";

            if (isset($_FILES["myfile"]))
            {
                if (!is_array($_FILES["myfile"]['name'])) //single file
                {
                    $file = $_FILES["myfile"];
                    $code = $this->StringHelper->generateRandomString(5);
                    $newName = $code . time();
                    $image = $this->changeImage($file, 750, $coverDir, $newName, 100, true, $tempDir);
                    $this->render('ajax/confirmPhoto', array('image' => $image, 'target' => 'uploadCover'));
                }
            }
        }
    }

    //Upload image cover Avatar
    public function uploadAvatar()
    {
        if ($this->isLogin())
        {
            $tempDir = UPLOAD . "tmp/";
            $avatarDir = UPLOAD . "avatar/170px";

            if (isset($_FILES["myfile"]))
            {
                if (!is_array($_FILES["myfile"]['name'])) //single file
                {
                    $file = $_FILES["myfile"];
                    $code = $this->StringHelper->generateRandomString(5);
                    $newName = $code . time();
                    $image = $this->changeImage($file, 170, $avatarDir, $newName, 100, true, $tempDir);
                    $this->render('ajax/confirmAvatar', array('image' => $image, 'target' => 'uploadAvatar'));
                }
            }
        }
    }

    //Choose images in browser photo of user
    public function photoBrowser()
    {
        if ($this->isLogin())
        {
            $photos = $this->facade->findAllAttributes('photo', array('owner' => $this->f3->get('SESSION.userID')));
            $this->f3->set('photos', $photos);
            $this->f3->set('role', $_GET['r']);
            $this->render('ajax/photoGalleriesajax');
        }
    }

//    Remove image avatar and cover
    public function remove()
    {
        if ($this->isLogin())
        {
            if (!empty($_POST['role']))
            {
                if ($_POST['role'] == 'avatar')
                {
                    $updateUser = array(
                        'profilePic' => 'none',
                    );
                }
                else
                {
                    $updateUser = array(
                        'coverPhoto' => 'none',
                    );
                }
                $update = $this->facade->updateByAttributes('user', $updateUser, array('@rid' => '#' . $this->f3->get('SESSION.userID')));
                if (!empty($update))
                {
                    echo json_encode(array('role' => $_POST['role'], 'url' => IMAGES));
                }
            }
        }
    }

//    Update image cove and avatar in user
    public function savePhoto()
    {
        if ($this->isLogin())
        {
            $avatarDir = UPLOAD . "avatar/170px/";
            $thumbnailDir = UPLOAD . "thumbnails/150px/"; //The folder will display like gallery images on "Choose from my photos"
            $coverDir = UPLOAD . "cover/750px/";
            $imagesDir = UPLOAD . "images/";

            $currentUser = $this->getCurrentUser();
            if (!empty($_POST['avatar']))
            {
                $updateUser = array(
                    'profilePic' => $_POST['avatar']
                );
            }
            else
            {
                $target = $_POST['target'];
                $file = $_POST['fileName'];
                $width = $_POST['width'];
                $height = $_POST['height'];
                $dragX = $_POST['dragX'];
                $dragY = $_POST['dragY'];
                $pathFile = UPLOAD . 'tmp/' . $file;
                switch ($target)
                {
                    case 'isReposition':
                        $photoID = $file;
                        $entry = array(
                            'dragX' => $dragX,
                            'dragY' => $dragY,
                            'type' => 'cover'
                        );
                        $this->facade->updateByAttributes('photo', $entry, array('@rid' => '#' . $photoID));
                        $updateUser = array(
                            'coverPhoto' => $photoID,
                        );
                        break;
                    case 'choosePhoto':
                        if ($_POST['chooseBy'])
                        {
                            $type = $_POST['chooseBy'];
                            $photo = $this->facade->findByAttributes('photo', array('fileName' => $file));
                            $photoID = $photo->recordID;
                            $entry = array(
                                'dragX' => $dragX,
                                'dragY' => $dragY
                            );
                            $this->facade->updateByAttributes('photo', $entry, array('@rid' => '#' . $photoID));
                            if ($type == 'cover')
                            {
                                $updateUser = array(
                                    'coverPhoto' => $photoID,
                                );
                            }
                            else
                            {
                                $updateUser = array(
                                    'profilePic' => $photoID,
                                );
                            }
                        }
                        break;
                    case 'uploadCover':
                        //resize image to thumbnail, cover folder and move image from tmp folder to images folder
                        $this->resizeImageFile($pathFile, 150, $thumbnailDir . $file, 80);
                        $this->resizeImageFile($pathFile, 170, $avatarDir . $file, 100);
                        rename($pathFile, $imagesDir . $file);
                        //prepare data for save
                        $entry = array(
                            'owner' => $currentUser->recordID,
                            'albumID' => 'none',
                            'fileName' => $file,
                            'width' => $width,
                            'height' => $height,
                            'dragX' => $dragX,
                            'dragY' => $dragY,
                            'thumbnail_url' => '',
                            'description' => '',
                            'numberLike' => '0',
                            'numberComment' => '0',
                            'statusUpload' => 'uploaded',
                            'published' => time(),
                            'type' => 'cover'
                        );
                        $photoID = $this->facade->save('photo', $entry);
                        $updateUser = array(
                            'coverPhoto' => $photoID,
                        );
                        break;
                    case 'uploadAvatar':
                        //resize image to thumbnail, cover folder and move image from tmp folder to images folder
                        $this->resizeImageFile($pathFile, 150, $thumbnailDir . $file, 80);
                        $this->resizeImageFile($pathFile, 750, $coverDir . $file, 100);
                        rename($pathFile, $imagesDir . $file);
                        //prepare data for save
                        $entry = array(
                            'owner' => $currentUser->recordID,
                            'albumID' => 'none',
                            'fileName' => $file,
                            'width' => $width,
                            'height' => $height,
                            'dragX' => $dragX,
                            'dragY' => $dragY,
                            'thumbnail_url' => '',
                            'description' => '',
                            'numberLike' => '0',
                            'numberComment' => '0',
                            'statusUpload' => 'uploaded',
                            'published' => time(),
                            'type' => 'avatar'
                        );
                        $photoID = $this->facade->save('photo', $entry);
                        $updateUser = array(
                            'profilePic' => $photoID,
                        );
                        break;
                }
            }
            $this->facade->updateByAttributes('user', $updateUser, array('@rid' => '#' . $currentUser->recordID));
            $user = $this->facade->findByPk('user', $this->f3->get('SESSION.userID'));
            echo json_encode(array('username' => $user->data->username, 'avatar' => UPLOAD_URL . 'avatar/170px/' . $file));
        }
    }

//    Choose my photo
    public function changePhoto()
    {
        if ($this->isLogin())
        {
            $imagesDir = UPLOAD . "images/";
            $avatarDir = UPLOAD . "avatar/170px/";
            $coverDir = UPLOAD . "cover/750px/";
            $data = explode(';', $_POST['data']);
            $photoID = $data[1];
            $photo = $this->facade->findByPk('photo', $photoID);
            $image = array('name' => $photo->data->fileName, 'width' => $photo->data->width, 'height' => $photo->data->height);
            $this->f3->set('image', $image);
            $this->f3->set('target', 'choosePhoto');
            $pathFile = $imagesDir . $photo->data->fileName;
            if ($data[0] == 'avatar')
            {
                if (!file_exists($avatarDir . $photo->data->fileName))
                    $this->resizeImageFile($pathFile, 170, $avatarDir . $photo->data->fileName, 100);
                $this->render('ajax/confirmAvatar');
            }
            else
            {//when role such as cover
                if (!file_exists($coverDir . $photo->data->fileName))
                    $this->resizeImageFile($pathFile, 750, $coverDir . $photo->data->fileName, 100);
                $this->render('ajax/confirmPhoto');
            }
        }
    }

//    Reposition photo
    public function reposition()
    {
        if ($this->isLogin())
        {
            $photo = $this->facade->findByPk('photo', $_POST['id']);
            $this->f3->set('photo', $photo);
            $this->render('ajax/reposition');
        }
    }

//    Cancel
    public function cancel()
    {
        if ($this->isLogin())
        {
            $user = $this->facade->findByPk('user', $this->f3->get('SESSION.userID'));
            $target = $_POST['target'];
            if (!empty($target))
            {
                if ($target == 'coverPhoto')
                {
                    if ($user->data->coverPhoto != 'none')
                    {
                        $photo = $this->facade->findByPk('photo', $user->data->coverPhoto);
                        echo json_encode(array(
                            'username' => $user->data->username,
                            'src' => UPLOAD_URL . "cover/750px/" . $photo->data->fileName,
                            'width' => $photo->data->width,
                            'height' => $photo->data->height,
                            'left' => $photo->data->dragX,
                            'top' => $photo->data->dragY,
                            'photoID' => $photo->recordID,
                        ));
                    }
                    else
                    {
                        echo json_encode(array(
                            'username' => $user->data->username,
                            'src' => false
                        ));
                    }
                }
                elseif ($target == 'profilePic')
                {
                    if ($user->data->profilePic != 'none')
                    {
                        $photo = $this->facade->findByPk('photo', $user->data->profilePic);
                        echo json_encode(array(
                            'username' => $user->data->username,
                            'src' => UPLOAD_URL . "avatar/170px/" . $photo->data->fileName,
                        ));
                    }
                    else
                    {
                        echo json_encode(array(
                            'username' => $user->data->username,
                            'src' => UPLOAD_URL . "avatar/170px/avatarMenDefault.png",
                        ));
                    }
                }
            }
        }
    }

}

?>
