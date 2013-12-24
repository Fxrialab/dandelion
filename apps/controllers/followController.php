<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/20/13 - 4:50 PM
 * Project: UserWired Network - Version: beta
 */

class FollowController extends AppController
{
    protected $uses     = array("Follow", "Status");
    protected $helpers  = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function follow()
    {
        if ($this->isLogin())
        {
            $getIDUser  = $this->f3->GET("POST.id");
            $userA      = $this->getCurrentUser()->recordID;
            $userB      = $this->User->getClusterID().':'.$getIDUser;
            //filter follow status, qa, photo and all
            $statusID   = $this->f3->GET("POST.statusID");
            $qaID       = $this->f3->GET("POST.qaID");
            $photoID    = $this->f3->GET("POST.photoID");
            $userID     = $userB;
            $published  = time();

            $existStatusFollowingRC = $this->Follow->findOne("userA = ? AND ID = ?", array($userA, str_replace('_', ':', $statusID)));
            //prepare data
            if ($statusID && $userID && !$existStatusFollowingRC)
            {
                $statusID = str_replace('_', ':', $statusID);
                $data = array(
                    'userA'         => $userA,
                    'follow'        => 'following',
                    'filterFollow'  => 'post',
                    'ID'            => $statusID,
                    'userB'         => $userB,
                    'published'     => $published
                );
                $this->Follow->create($data);
                //update number follow to status
                $statusRC = $this->Status->findOne('@rid = ?',array('#'.$statusID));
                $updateNumFollow = array(
                    'numberFollow'  => $statusRC->data->numberFollow + 1,
                );
                $this->Status->updateByCondition($updateNumFollow, "@rid = ?", array("#".$statusID));
                //track activity
                $this->trackActivity($this->getCurrentUser(), 'HomePost', str_replace('_', ':', $statusID), $published);
            }
            if($qaID && $userID)
            {
                $data = array(
                    'userA'         => $userA,
                    'follow'        => 'following',
                    'filterFollow'  => 'qanda',
                    'ID'            => str_replace('_', ':', $qaID),
                    'userB'         => $userB,
                    'published'     => $published
                );
                $this->Follow->create($data);
                //track activity
                $this->trackActivity($this->getCurrentUser(), 'HomeQuestion', str_replace('_', ':', $qaID), $published);
            }
            if($photoID && $userID)
            {
                $data = array(
                    'userA'         => $userA,
                    'follow'        => 'following',
                    'filterFollow'  => 'photo',
                    'ID'            => str_replace('_', ':', $photoID),
                    'userB'         => $userB,
                    'published'     => $published
                );
                $this->Follow->create($data);
                //track activity
                $this->trackActivity($this->getCurrentUser(), 'HomePhoto', str_replace('_', ':', $photoID), $published);
            }
            if($userID && empty($statusID) && empty($qaID) && empty($photoID) )
            {
                $data = array(
                    'userA'         => $userA,
                    'follow'        => 'following',
                    'filterFollow'  => 'all',
                    'ID'            => $userID,
                    'userB'         => $userB,
                    'published'     => $published
                );
                $this->Follow->create($data);
            }
        }

    }

    public function unFollow()
    {
        if ($this->isLogin())
        {
            $getIDUser  = $this->f3->GET("POST.id");
            $userA      = $this->getCurrentUser()->recordID;
            $userB      = $this->User->getClusterID().':'.$getIDUser;
            //filter follow status, qa, photo and all
            $statusID   = $this->f3->GET("POST.statusID");
            $qaID       = $this->f3->GET("POST.qaID");
            $photoID    = $this->f3->GET("POST.photoID");
            $userID     = $userB;
            //find id of record then delete record
            if($statusID && $userID)
            {
                $statusID = str_replace('_', ':', $statusID);
                $this->Follow->deleteByCondition("userA = ? AND userB = ? AND ID = ?", array($userA, $userB, $statusID));
                //update number follow in status
                $statusRC = $this->Status->findOne('@rid = ?',array('#'.$statusID));
                $updateNumFollow = array(
                    'numberFollow'  => $statusRC->data->numberFollow - 1,
                );
                $this->Status->updateByCondition($updateNumFollow, "@rid = ?", array("#".$statusID));
            }
            if($qaID && $userID) {
                $this->Follow->deleteByCondition("userA = ? AND userB = ? AND ID = ?", array($userA, $userB, str_replace('_', ':', $qaID)));
            }
            if($photoID && $userID) {
                $this->Follow->deleteByCondition("userA = ? AND userB = ? AND ID = ?", array($userA, $userB, str_replace('_', ':', $photoID)));
            }
            if($userID && empty($statusID) && empty($qaID) && empty($photoID)) {
                $this->Follow->deleteByCondition("userA = ? AND userB = ? AND ID = ?", array($userA, $userB, str_replace('_', ':', $userID)));
            }
        }
    }
}

?>