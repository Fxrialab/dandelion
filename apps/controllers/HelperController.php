<?php

class HelperController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

//    find Member of group
    static public function groupMember()
    {
        $facade = new DataFacade;
        $model = $facade->findAllAttributes('groupMember', array('member' => F3::get('SESSION.userID')));
        return $model;
    }

    static public function findGroup($id)
    {

        $facade = new DataFacade;
        $model = $facade->findByPk('group', $id);
        return $model;
    }

    static public function findPhoto($id)
    {
        $facade = new DataFacade;
        $model = $facade->findByPk('photo', $id);
        return $model;
    }

    static public function findGender($id)
    {
        $facade = new DataFacade;
        $model = $facade->findByAttributes('information', array('user' => $id));
        return $model->data->gender;
    }

    static public function findLocation($id)
    {
        $facade = new DataFacade;
        $model = $facade->findByPk('location', $id);
        return $model->data->city . ', ' . $model->data->country;
    }

    static public function findUser($id)
    {
        $facade = new DataFacade;
        $model = $facade->findByPk('user', $id);
        return $model;
    }

    static public function getFullNameUser($id)
    {
        $facade = new DataFacade;
        $model = $facade->findByPk('user', $id);
        $fullName = ucfirst($model->data->firstName) . ' ' . ucfirst($model->data->lastName);
        return $fullName;
    }

    static function getFindPhotoByPhotoName($name)
    {
        $facade = new DataFacade();
        $photo = $facade->findByAttributes('photo', array('fileName' => $name));
        return $photo;
    }

    public static function countComment($id)
    {
        $facade = new DataFacade();
        return $facade->count('comment', array('typeID' => $id));
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

    static public function findPhotosByAlbum($id)
    {
        $facade = new DataFacade;
        $model = $facade->findAllAttributes('photo', array('albumID' => $id));
        return $model;
    }

    static public function getAvatar($user)
    {
        if ($user->data->profilePic != 'none')
        {
            $photo = HelperController::findPhoto($user->data->profilePic);
            $avatar = UPLOAD_URL . 'avatar/170px/' . $photo->data->fileName;
        }
        else
        {
            $gender = HelperController::findGender($user->recordID);
            if ($gender == 'male')
                $avatar = UPLOAD_URL . 'avatar/170px/avatarMenDefault.png';
            else
                $avatar = UPLOAD_URL . 'avatar/170px/avatarWomenDefault.png';
        }
        return $avatar;
    }

    static public function findAlbum($id)
    {
        $facade = new DataFacade;
        $model = $facade->findByPk('album', $id);
        return $model;
    }
    
     public static function countGroup()
    {
        $facade = new DataFacade();
        return $facade->count('groupMember', array('member' => F3::get('SESSION.userID')));
    }

}