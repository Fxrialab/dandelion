<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/27/13 - 2:46 PM
 * Project: userwired Network - Version: 1.0
 */
class LikeController extends AppController
{
    protected $uses     = array("Like", "Status", "Photo");
    protected $helper   = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function like()
    {
        if ($this->isLogin())
        {
            $getIDUser  = F3::get("POST.id");
            $userA      = $this->getCurrentUser()->recordID;
            $userB      = $this->User->getClusterID().':'.$getIDUser;
            //filter follow status, qa, photo and all
            $statusID   = F3::get("POST.statusID");
            $photoID    = F3::get("POST.photoID");
            $published  = time();

            $existStatusLikeRC = $this->Like->findOne("userA = ? AND ID = ?", array($userA, str_replace('_', ':', $statusID)));

            if ($statusID && $userB && !$existStatusLikeRC)
            {
                $statusID = str_replace('_', ':', $statusID);
                $data = array(
                    'userA'         => $userA,
                    'isLike'        => 'like',
                    'filterLike'    => 'post',
                    'ID'            => $statusID,
                    'userB'         => $userB,
                    'published'     => $published
                );
                $this->Like->create($data);
                //update number like to status
                $statusRC = $this->Status->findOne('@rid = ?',array('#'.$statusID));
                $updateNumLike = array(
                    'numberLike'  => $statusRC->data->numberLike + 1,
                );
                $this->Status->updateByCondition($updateNumLike, "@rid = ?", array("#".$statusID));
            }
            if ($photoID && $userB && !$existStatusLikeRC)
            {
                $photoID = str_replace('_', ':', $photoID);
                $data = array(
                    'userA'         => $userA,
                    'isLike'        => 'like',
                    'filterLike'    => 'photo',
                    'ID'            => $photoID,
                    'userB'         => $userB,
                    'published'     => $published
                );
                $this->Like->create($data);
                //update number like to photo
                $photoRC = $this->Photo->findOne('@rid = ?',array('#'.$photoID));
                $updateNumLike = array(
                    'numberLike'  => $photoRC->data->numberLike + 1,
                );
                $this->Photo->updateByCondition($updateNumLike, "@rid = ?", array("#".$photoID));
            }
        }
    }

    public function unlike()
    {
        $getIDUser  = F3::GET("POST.id");
        $userA      = $this->getCurrentUser()->recordID;
        $userB      = $this->User->getClusterID().':'.$getIDUser;
        $statusID   = F3::GET("POST.statusID");
        $photoID    = F3::GET("POST.photoID");

        //find id of record then delete record
        if($statusID && $userB)
        {
            $statusID = str_replace('_', ':', $statusID);
            $this->Like->deleteByCondition("userA = ? AND userB = ? AND ID = ?", array($userA, $userB, $statusID));
            //update number like to status
            $statusRC = $this->Status->findOne('@rid = ?',array('#'.$statusID));
            $updateNumLike = array(
                'numberLike'  => $statusRC->data->numberLike - 1,
            );
            $this->Status->updateByCondition($updateNumLike, "@rid = ?", array("#".$statusID));
        }
        if($photoID && $userB)
        {
            $photoID = str_replace('_', ':', $photoID);
            $this->Like->deleteByCondition("userA = ? AND userB = ? AND ID = ?", array($userA, $userB, $photoID));
            //update number like to photo
            $photoRC = $this->Photo->findOne('@rid = ?',array('#'.$photoID));
            $updateNumLike = array(
                'numberLike'  => $photoRC->data->numberLike - 1,
            );
            $this->Photo->updateByCondition($updateNumLike, "@rid = ?", array("#".$photoID));
        }
    }
}