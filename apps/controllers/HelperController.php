<?php

/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 3:23 PM
 * Project: UserWired Network - Version: beta
 */
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

    static public function findRs($id)
    {
        $facade = new DataFacade;
        $model = $facade->findByPk('reposition', $id);
        return $model;
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
        $fullName = ucfirst($model->data->firstName).' '.ucfirst($model->data->lastName);
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
}