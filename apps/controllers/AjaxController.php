<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AjaxController extends AppController
{

//    Find Photo
    static public function findPhoto($id)
    {
        return Model::get('photo')->find($id);
    }

    //Upload image cover User
    public function uploadCover()
    {
        if ($this->isLogin())
        {
            $coverDir   = UPLOAD . "cover/750px";
            $avatarDir  = UPLOAD . "avatar/170px";
            $thumbnailDir   = UPLOAD. "thumbnails/150px";//The folder will display like gallery images on "Choose from my photos"

            if (isset($_FILES["myfile"]))
            {
                if (!is_array($_FILES["myfile"]['name'])) //single file
                {
                    $file   = $_FILES["myfile"];
                    $newName= time();
                    $this->changeImage($file, 150, $thumbnailDir, $newName, 80, false);
                    $this->changeImage($file, 170, $avatarDir, $newName, 100, false);
                    $image  = $this->changeImage($file, 750, $coverDir, $newName, 100, true);

                    $this->f3->set('image', $image);
                    $this->f3->set('target', 'uploadCover');
                    $this->render('ajax/confirmPhoto.php', 'default');
                }
            }
        }
    }

//Upload image cover Avatar
    public function uploadAvatar()
    {
        if ($this->isLogin())
        {
            $coverDir   = UPLOAD . "cover/750px";
            $avatarDir  = UPLOAD . "avatar/170px";
            $thumbnailDir   = UPLOAD. "thumbnails/150px";//The folder will display like gallery images on "Choose from my photos"

            if (isset($_FILES["myfile"]))
            {
                if (!is_array($_FILES["myfile"]['name'])) //single file
                {
                    $file   = $_FILES["myfile"];
                    $newName= time();
                    $this->changeImage($file, 150, $thumbnailDir, $newName, 80, false);
                    $this->changeImage($file, 750, $coverDir, $newName, 100, false);
                    $image  = $this->changeImage($file, 170, $avatarDir, $newName, 100, true);

                    $this->f3->set('image', $image);
                    $this->f3->set('target', 'uploadAvatar');
                    $this->render('ajax/confirmAvatar.php', 'default');
                }
            }
        }
    }

//Choose imgaes in browser photo of user
    public function photoBrowser()
    {
        if ($this->isLogin())
        {
            $photos = $this->facade->findAllAttributes('photo', array('actor' => $this->f3->get('SESSION.userID')));
            $this->f3->set('photos', $photos);
            $this->f3->set('role', $_POST['role']);
            $this->render('ajax/photoGalleries.php', 'ajax');
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
                }else {
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
            if (!empty($_POST['avatar']))
            {
                $updateUser = array(
                    'profilePic' => $_POST['avatar']
                );
            }else {
                $target     = $_POST['target'];
                $file       = $_POST['coverFile'];
                $width      = $_POST['width'];
                $height     = $_POST['height'];
                $dragX      = $_POST['dragX'];
                $dragY      = $_POST['dragY'];
                switch ($target)
                {
                    case 'isReposition':
                        $photoID= $file;
                        $entry  = array(
                            'dragX'     => $dragX,
                            'dragY'     => $dragY,
                            'type'      => 'cover'
                        );
                        $this->facade->updateByAttributes('photo', $entry, array('@rid'=>'#'.$photoID));
                        $updateUser = array(
                            'coverPhoto' => $photoID,
                        );
                        break;
                    case 'choosePhoto':
                        if ($_POST['chooseBy'])
                        {
                            $type = $_POST['chooseBy'];
                            $photo = $this->facade->findByAttributes('photo', array('fileName'=>$file));
                            $photoID= $photo->recordID;
                            $entry  = array(
                                'dragX'     => $dragX,
                                'dragY'     => $dragY
                            );
                            $this->facade->updateByAttributes('photo', $entry, array('@rid'=>'#'.$photoID));
                            if ($type == 'cover')
                            {
                                $updateUser = array(
                                    'coverPhoto' => $photoID,
                                );
                            }else {
                                $updateUser = array(
                                    'profilePic' => $photoID,
                                );
                            }
                        }
                        break;
                    case 'uploadCover':
                        $entry = array(
                            'actor'     => $currentUser->recordID,
                            'album'     => '',
                            'fileName'  => $file,
                            'width'     => $width,
                            'height'    => $height,
                            'dragX'     => $dragX,
                            'dragY'     => $dragY,
                            'thumbnail_url' => '',
                            'description'   => '',
                            'numberLike'    => '0',
                            'numberComment' => '0',
                            'statusUpload'  => 'uploaded',
                            'published'     => time(),
                            'type'          => 'cover'
                        );
                        $photoID = $this->facade->save('photo', $entry);
                        $updateUser = array(
                            'coverPhoto' => $photoID,
                        );
                        break;
                    case 'uploadAvatar':
                        $entry = array(
                            'actor'     => $currentUser->recordID,
                            'album'     => '',
                            'fileName'  => $file,
                            'width'     => $width,
                            'height'    => $height,
                            'dragX'     => $dragX,
                            'dragY'     => $dragY,
                            'thumbnail_url' => '',
                            'description'   => '',
                            'numberLike'    => '0',
                            'numberComment' => '0',
                            'statusUpload'  => 'uploaded',
                            'published'     => time(),
                            'type'          => 'avatar'
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
    public function choosePhoto()
    {
        if ($this->isLogin())
        {
            $photoID    = $_POST['id'];
            $photo = $this->facade->findByPk('photo', $photoID);
            $image = array('name'=>$photo->data->fileName, 'width'=>$photo->data->width, 'height'=>$photo->data->height);
            $this->f3->set('image', $image);
            $this->f3->set('target', 'choosePhoto');
            if ($_POST['role'] == 'avatar')
            {
                $this->render('ajax/confirmAvatar.php', 'ajax');
            }else{//when role such as cover
                $this->render('ajax/confirmPhoto.php', 'ajax');
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
            $this->render('ajax/reposition.php', 'ajax');
        }
    }

    //    Cancel
    public function cancel()
    {
        if ($this->isLogin())
        {
            $user   = $this->facade->findByPk('user', $this->f3->get('SESSION.userID'));
            $target = $_POST['target'];
            if (!empty($target))
            {
                if ($target == 'coverPhoto')
                {
                    if ($user->data->coverPhoto != 'none')
                    {
                        $photo  = $this->facade->findByPk('photo', $user->data->coverPhoto);
                        echo json_encode(array(
                            'username'  => $user->data->username,
                            'src'       => UPLOAD_URL ."cover/750px/". $photo->data->fileName,
                            'width'     => $photo->data->width,
                            'height'    => $photo->data->height,
                            'left'      => $photo->data->dragX,
                            'top'       => $photo->data->dragY,
                            'photoID'   => $photo->recordID,
                        ));
                    }else {
                        echo json_encode(array(
                            'username'  => $user->data->username,
                            'src'       => false
                        ));
                    }
                }elseif ($target == 'profilePic') {
                    if ($user->data->profilePic != 'none')
                    {
                        $photo  = $this->facade->findByPk('photo', $user->data->profilePic);
                        echo json_encode(array(
                            'username'  => $user->data->username,
                            'src'       => UPLOAD_URL ."avatar/170px/". $photo->data->fileName,
                        ));
                    }else {
                        echo json_encode(array(
                            'username'  => $user->data->username,
                            'src'       => UPLOAD_URL ."avatar/170px/avatarMenDefault.png",
                        ));
                    }
                }
            }

        }
    }

}

?>
