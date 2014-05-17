<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AjaxController extends AppController
{

    static public function findPhoto($id)
    {
        return Model::get('photo')->find($id);
    }

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
                        'url' => UPLOAD_URL . $fileName,
                        'thumbnail_url' => '',
                        'description' => '',
                        'numberLike' => '0',
                        'numberComment' => '0',
                        'statusUpload' => 'uploaded',
                        'published' => time(),
                        'type' => 'group'
                    );
                    $photoID = $this->facade->save('photo', $entry);
                    $photo = $this->facade->findByPk('photo', $photoID);
                    $this->f3->set('url', $photo->data->url);
                    $this->render('ajax/comfirmPhoto.php', 'ajax');
                }
            }
        }
    }

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
                    if ($width > 350)
                    {
                        $newwidth = 150;
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
                        'url' => UPLOAD_URL . $fileName,
                        'thumbnail_url' => '',
                        'description' => '',
                        'numberLike' => '0',
                        'numberComment' => '0',
                        'statusUpload' => 'uploaded',
                        'published' => time(),
                        'type' => 'group'
                    );
                    $photoID = $this->facade->save('photo', $entry);
                    $photo = $this->facade->findByPk('photo', $photoID);
                    $this->f3->set('url', $photo->data->url);
                    $this->render('ajax/comfirmAvatar.php', 'ajax');
                }
            }
        }
    }

    public function photobrowser()
    {
        $photos = $this->facade->findAllAttributes('photo', array('actor' => $this->f3->get('SESSION.userID')));
        $this->f3->set('photos', $photos);
        $this->f3->set('role', $_POST['role']);
        $this->render('ajax/photobrowser.php', 'ajax');
    }

    public function removecover()
    {
        if (!empty($_POST['role']))
        {
            $updateGroup = array(
                'urlCover' => ''
            );
            $update = $this->facade->updateByAttributes('user', $updateGroup, array('@rid' => '#' . $this->f3->get('SESSION.userID')));
            if ($update == 1)
            {
                $user = $this->facade->findByPk('user', $this->f3->get('SESSION.userID'));
                $this->f3->set('urlCover', $user->data->urlCover);
                $this->render('ajax/comfirmPhoto.php', 'ajax');
            }
        }
    }

    public function comfirmphoto()
    {
        if (!empty($_POST['avatar']))
        {
            $updateGroup = array(
                'profilePic' => $_POST['avatar']
            );
            $render = 'ajax/avatar.php';
            $theme = 'ajax';
        }
        else
        {
            $updateGroup = array(
                'urlCover' => $_POST['urlCover']
            );
            $render = 'elements/navTimeLine.php';
            $theme = 'elements';
        }
        $update = $this->facade->updateByAttributes('user', $updateGroup, array('@rid' => '#' . $this->f3->get('SESSION.userID')));
        if ($update == 1)
        {
            $user = $this->facade->findByPk('user', $this->f3->get('SESSION.userID'));
            $this->f3->set('username', $user->data->username);
            $this->f3->set('otherUser', $user);
            $this->render($render, $theme);
        }
    }

    public function choosephoto()
    {
        $photo = $this->facade->findByPk('photo', $_POST['id']);
        $this->f3->set('url', $photo->data->url);
        $this->f3->set('role', $_POST['role']);
        if ($_POST['role'] == 'avatar')
            $this->render('ajax/comfirmAvatar.php', 'ajax');
        else
            $this->render('ajax/comfirmPhoto.php', 'ajax');
    }

}

?>
