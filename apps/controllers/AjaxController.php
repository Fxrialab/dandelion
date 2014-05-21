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
    public function uploadphoto()
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

                    $thumbName = time() . '.' . $ext;
                    if ($width > 350)
                    {
//                        imges width 350px
                        $newwidth = 350;
                        $newheight = ($height / $width) * $newwidth;
                        $tmp = imagecreatetruecolor($newwidth, $newheight);
                        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                        $image = $outPutDir . $fileName;
                        imagejpeg($tmp, $outPutDir . '350/' . $thumbName, 100);

                        //                        imges width 150px
                        $newwidth150 = 150;
                        $newheight150 = ($height / $width) * $newwidth150;
                        $tmp = imagecreatetruecolor($newwidth150, $newheight150);
                        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth150, $newheight150, $width, $height);
                        $image = $outPutDir . $fileName;
                        imagejpeg($tmp, $outPutDir . '150/' . $thumbName, 100);
                    }
                    move_uploaded_file($_FILES["myfile"]["tmp_name"], $outPutDir . $thumbName);
                    $entry = array(
                        'actor' => $currentUser->recordID,
                        'album' => '',
                        'fileName' => $thumbName,
                        'width' => $width,
                        'height' => $height,
                        'drapx' => 0,
                        'drapy' => 0,
                        'thumbnail_url' => '',
                        'description' => '',
                        'numberLike' => '0',
                        'numberComment' => '0',
                        'statusUpload' => 'uploaded',
                        'published' => time(),
                        'type' => 'cover'
                    );
                    $photoID = $this->facade->save('photo', $entry);
                    $photo = $this->facade->findByPk('photo', $photoID);
                    $this->f3->set('photo', $photo);
                    $this->render('ajax/comfirmPhoto.php', 'ajax');
                }
            }
        }
    }

//Upload image cover Avatar
    public function uploadavatar()
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
                    $thumbName = time() . '.' . $ext;
                    if ($width > 350)
                    {
                        //                        imges width 350px
                        $newwidth = 350;
                        $newheight = ($height / $width) * $newwidth;
                        $tmp = imagecreatetruecolor($newwidth, $newheight);
                        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                        $image = $outPutDir . $fileName;
                        imagejpeg($tmp, $outPutDir . '350/' . $thumbName, 100);

                        //                        imges width 150px
                        $newwidth150 = 150;
                        $newheight150 = ($height / $width) * $newwidth150;
                        $tmp = imagecreatetruecolor($newwidth150, $newheight150);
                        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth150, $newheight150, $width, $height);
                        $image = $outPutDir . $fileName;
                        imagejpeg($tmp, $outPutDir . '150/' . $thumbName, 100);
                    }
                    move_uploaded_file($_FILES["myfile"]["tmp_name"], $outPutDir . $thumbName);
                    $entry = array(
                        'actor' => $currentUser->recordID,
                        'album' => '',
                        'fileName' => $fileName,
                        'width' => $width,
                        'height' => $height,
                        'drapx' => 0,
                        'drapy' => 0,
                        'description' => '',
                        'numberLike' => '0',
                        'numberComment' => '0',
                        'statusUpload' => 'uploaded',
                        'published' => time(),
                        'type' => 'group'
                    );
                    $photoID = $this->facade->save('photo', $entry);
                    $photo = $this->facade->findByPk('photo', $photoID);
                    $this->f3->set('fileName', $thumbName);
                    $this->render('ajax/comfirmAvatar.php', 'ajax');
                }
            }
        }
    }

//Choose imgaes in browser photo of user
    public function photobrowser()
    {
        $photos = $this->facade->findAllAttributes('photo', array('actor' => $this->f3->get('SESSION.userID')));
        $this->f3->set('photos', $photos);
        $this->f3->set('role', $_POST['role']);
        $this->render('ajax/photobrowser.php', 'ajax');
    }

//    Remove image avatar and cover
    public function remove()
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
                    'cover' => '0',
                    'drapx' => '0',
                    'drapy' => '0'
                );
            }
            $update = $this->facade->updateByAttributes('user', $updateUser, array('@rid' => '#' . $this->f3->get('SESSION.userID')));
            if ($update == 1)
            {
                echo json_encode(array('role' => $_POST['role'], 'url' => IMAGES));
            }
        }
    }

//    Update image cove and avatar in user
    public function comfirmphoto()
    {
        if (!empty($_POST['avatar']))
        {
            $updateUser = array(
                'profilePic' => $_POST['avatar']
            );
        }
        else
        {
            $updateUser = array(
                'cover' => $_POST['cover'],
                'drapx' => $_POST['drapx'],
                'drapy' => $_POST['drapy'],
            );
        }
        $update = $this->facade->updateByAttributes('user', $updateUser, array('@rid' => '#' . $this->f3->get('SESSION.userID')));
        if ($update == 1)
        {
            $user = $this->facade->findByPk('user', $this->f3->get('SESSION.userID'));
            $this->f3->set('username', $user->data->username);
            $this->f3->set('otherUser', $user);
            $this->f3->set('message', 1);
            echo json_encode(array('username' => $user->data->username, 'avatar' => UPLOAD_URL . '150/' . $user->data->profilePic));
        }
    }

//    Choose my photo
    public function choosephoto()
    {
        $photo = $this->facade->findByPk('photo', $_POST['id']);
        $this->f3->set('fileName', $photo->data->fileName);
        $this->f3->set('photo', $photo);
        $this->f3->set('role', $_POST['role']);
        if ($_POST['role'] == 'avatar')
            $this->render('ajax/comfirmAvatar.php', 'ajax');
        else
            $this->render('ajax/comfirmPhoto.php', 'ajax');
    }

//    Reposition photo
    public function reposition()
    {
        $photo = $this->facade->findByPk('photo', $_POST['id']);
        $user = $this->facade->findByAttributes('user', array('cover' => $_POST['id']));
        $this->f3->set('photoID', $photo->recordID);
        $this->f3->set('fileName', $photo->data->fileName);
        $this->f3->set('width', $photo->data->width);
        $this->f3->set('height', $photo->data->height);
        $this->f3->set('drapx', $photo->data->drapx);
        $this->f3->set('drapy', $photo->data->drapy);
        $this->render('ajax/reposition.php', 'ajax');
    }

//    Cancel 
    public function cancel()
    {
        $user = $this->facade->findByPk('user', $this->f3->get('SESSION.userID'));
        $photo = $this->facade->findByPk('photo', $user->data->cover);
        echo json_encode(array(
            'username' => $user->data->username,
            'src' => UPLOAD_URL . $photo->data->fileName,
            'width' => $photo->data->width,
            'height' => $photo->data->height,
            'left' => $user->data->drapx,
            'top' => $user->data->drapy,
            'photoID' => $photo->recordID,
        ));
    }

}

?>
