<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/27/13 - 2:46 PM
 * Project: userwired Network - Version: 1.0
 */
class LikeController extends AppController
{
    protected $uses     = array("Like", "Status");
    protected $helper   = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function like()
    {
        $getIDUser  = F3::GET("POST.id");
        $userA      = $this->getCurrentUser()->recordID;
        $userB      = $this->User->getClusterID().':'.$getIDUser;
        //filter follow status, qa, photo and all
        $statusID   = F3::GET("POST.statusID");
        $published  = time();

        $existStatusLikeRC = $this->Like->findOne("userA = ? AND ID = ?", array($userA, str_replace('_', ':', $statusID)));

        if ($statusID && $userB && !$existStatusLikeRC)
        {
            $statusID = str_replace('_', ':', $statusID);
            $data = array(
                'userA'         => $userA,
                'isLike'        => 'like',
                'filterFollow'  => 'post',
                'ID'            => $statusID,
                'userB'         => $userB,
                'published'     => $published
            );
            $this->Like->create($data);
            //update number follow to status
            $statusRC = $this->Status->findOne('@rid = ?',array('#'.$statusID));
            $updateNumFollow = array(
                'numberLike'  => $statusRC->data->numberLike + 1,
            );
            $this->Status->updateByCondition($updateNumFollow, "@rid = ?", array("#".$statusID));
        }
    }

    public function unlike()
    {
        $getIDUser  = F3::GET("POST.id");
        $userA      = $this->getCurrentUser()->recordID;
        $userB      = $this->User->getClusterID().':'.$getIDUser;
        $statusID   = F3::GET("POST.statusID");

        //find id of record then delete record
        if($statusID && $userB)
        {
            $statusID = str_replace('_', ':', $statusID);
            $this->Like->deleteByCondition("userA = ? AND userB = ? AND ID = ?", array($userA, $userB, $statusID));
            //update number follow to status
            $statusRC = $this->Status->findOne('@rid = ?',array('#'.$statusID));
            $updateNumFollow = array(
                'numberLike'  => $statusRC->data->numberLike - 1,
            );
            $this->Status->updateByCondition($updateNumFollow, "@rid = ?", array("#".$statusID));
        }
    }
}