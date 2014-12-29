<?php

class UploadController extends AppController
{

    protected $helpers = array("String");

    //Uploading photo when choose us, it's not submit
    public function uploading()
    {
        if ($this->isLogin())
        {
            if (!file_exists(UPLOAD . 'images'))
                mkdir(UPLOAD . 'images', 0777);

            if (!file_exists(UPLOAD . "/thumbnail"))
                mkdir(UPLOAD . "/thumbnail", 0777); //The folder will display like gallery images on "Choose from my photos"
            $tempDir = UPLOAD . "images/";
            $thumbnailDir = UPLOAD . "/thumbnail";
            $data = array(
                'results' => array(),
                'success' => false,
                'error' => ''
            );

            if (!empty($_FILES["myfile"]))
            {
                $file = $_FILES["myfile"];
                $code = $this->StringHelper->generateRandomString(5);
                $newName = $code . time();
                $photo = $this->changeImageMultiple($file, 250, $thumbnailDir, $newName, 250, true, $tempDir); //upload to thumbnail folder
                $data['results'][] = array(
                    'id' => uniqid(),
                    'photoName' => $photo['name'],
                    'nameNotExt' => substr($photo['name'], 0, strpos($photo['name'], '.')),
                    'url' => UPLOAD_URL . "/thumbnail/" . $photo['name']
                );
                $data['success'] = true;
            } else
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
            if (!file_exists(UPLOAD . 'images'))
                mkdir(UPLOAD . 'images', 0777);

            if (!file_exists(UPLOAD . "/thumbnail"))
                mkdir(UPLOAD . "/thumbnail", 0777); //The folder will display like gallery images on "Choose from my photos"
            $tempDir = UPLOAD . "images/";
            $thumbnailDir = UPLOAD . "/thumbnail";

            if (isset($_FILES["myfile"]))
            {
                $file = $_FILES["myfile"];
                $code = $this->StringHelper->generateRandomString(5);
                $newName = $code . time();
                $image = $this->changeImageSingle($file, 250, $thumbnailDir, $newName, 250, true, $tempDir);
                $this->render('ajax/confirmPhoto', array('image' => $image, 'target' => 'uploadCover'));
            }
        }
    }

    public function uploadAvatar()
    {
        if ($this->isLogin())
        {
            if (!file_exists(UPLOAD . 'images'))
                mkdir(UPLOAD . 'images', 0777);

            if (!file_exists(UPLOAD . "/thumbnail"))
                mkdir(UPLOAD . "/thumbnail", 0777); //The folder will display like gallery images on "Choose from my photos"
            $tempDir = UPLOAD . "images/";
            $thumbnailDir = UPLOAD . "/thumbnail";

            if (isset($_FILES["myfile"]))
            {
                $file = $_FILES["myfile"];
                $code = $this->StringHelper->generateRandomString(5);
                $newName = $code . time();
                $image = $this->changeImageSingle($file, 160, $thumbnailDir, $newName, 160, true, $tempDir);
                $this->render('ajax/confirmAvatar', array('image' => $image, 'target' => 'uploadAvatar'));
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
                } else
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
            $currentUser = $this->getCurrentUser();

            $target = $_POST['target'];
            $file = $_POST['fileName'];
            $width = $_POST['width'];
            $height = $_POST['height'];
            $dragX = $_POST['dragX'];
            $dragY = $_POST['dragY'];
//                $pathFile = UPLOAD . 'tmp/' . $file;
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
                        } else
                        {
                            $updateUser = array(
                                'profilePic' => $photoID,
                            );
                        }
                    }
                    break;
                case 'uploadCover':
                    //resize image to thumbnail, cover folder and move image from tmp folder to images folder
//                        $this->resizeImageFile($pathFile, 150, $thumbnailDir . $file, 80);
//                        $this->resizeImageFile($pathFile, 170, $avatarDir . $file, 100);
//                        rename($pathFile, $imagesDir . $file);
                    //prepare data for save
                    $entry = array(
                        'owner' => $currentUser->recordID,
                        'albumID' => 'none',
                        'typeID' => 'none',
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
                        'published' => time()
                    );
                    $photoID = $this->facade->save('photo', $entry);
                    $updateUser = array(
                        'coverPhoto' => $photoID,
                    );
                    break;
                case 'uploadAvatar':
                    //resize image to thumbnail, cover folder and move image from tmp folder to images folder
//                        $this->resizeImageFile($pathFile, 150, $thumbnailDir . $file, 80);
//                        $this->resizeImageFile($pathFile, 750, $coverDir . $file, 100);
//                        rename($pathFile, $imagesDir . $file);
                    //prepare data for save
                    $entry = array(
                        'owner' => $currentUser->recordID,
                        'albumID' => 'none',
                        'typeID' => 'none',
                        'fileName' => $file,
                        'width' => $width,
                        'height' => $height,
                        'dragX' => $dragX,
                        'dragY' => $dragY,
                        'thumbnail_url' => '',
                        'description' => '',
                        'numberLike' => '0',
                        'numberComment' => '0',
                        'published' => time(),
                        'type' => 'avatar'
                    );
                    $photoID = $this->facade->save('photo', $entry);
                    $updateUser = array(
                        'profilePic' => $photoID,
                    );
                    break;
            }
            $this->facade->updateByAttributes('user', $updateUser, array('@rid' => '#' . $currentUser->recordID));
            $user = $this->facade->findByPk('user', $this->f3->get('SESSION.userID'));
            echo json_encode(array('username' => $user->data->username, 'avatar' => UPLOAD_URL . str_replace(':', '', $this->f3->get('SESSION.userID')) . '/thumbnail/' . $file));
        }
    }

//    Choose my photo
    public function changePhoto()
    {
        if ($this->isLogin())
        {
            $data = explode(';', $_POST['data']);
            $photo = $this->facade->findByPk('photo', $data[1]);
            $image = array('name' => $photo->data->fileName, 'width' => $photo->data->width, 'height' => $photo->data->height);
            if ($data[0] == 'avatar')
                $this->render('ajax/confirmAvatar', array('image' => $image, 'target' => 'choosePhoto'));
            else
                $this->render('ajax/confirmPhoto', array('image' => $image, 'target' => 'choosePhoto'));
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
                            'src' => UPLOAD_URL . "thumbnail/" . $photo->data->fileName,
                            'width' => $photo->data->width,
                            'height' => $photo->data->height,
                            'left' => $photo->data->dragX,
                            'top' => $photo->data->dragY,
                            'photoID' => $photo->recordID,
                        ));
                    } else
                    {
                        echo json_encode(array(
                            'username' => $user->data->username,
                            'src' => false
                        ));
                    }
                } elseif ($target == 'profilePic')
                {
                    if ($user->data->profilePic != 'none')
                    {
                        $photo = $this->facade->findByPk('photo', $user->data->profilePic);
                        echo json_encode(array(
                            'username' => $user->data->username,
                            'src' => UPLOAD_URL . "thumbnail/" . $photo->data->fileName,
                        ));
                    } else
                    {
                        echo json_encode(array(
                            'username' => $user->data->username,
                            'src' => UPLOAD_URL . "thumbnail/avatarMenDefault.png",
                        ));
                    }
                }
            }
        }
    }

}

?>
