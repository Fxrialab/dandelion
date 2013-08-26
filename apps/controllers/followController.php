<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/20/13 - 4:50 PM
 * Project: UserWired Network - Version: beta
 */

class FollowController extends AppController
{
    protected $uses     = array("Follow");
    protected $helpers  = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function sentFollowing()
    {
        $getIDUser  = F3::GET("POST.id");
        $userA      = $this->getCurrentUser()->recordID;
        $userB      = str_replace(substr($userA, 2), $getIDUser, $userA);
        //filter follow status, qa, photo and all
        $statusID   = F3::GET("POST.statusID");
        $qaID       = F3::GET("POST.qaID");
        $photoID    = F3::GET("POST.photoID");
        $userID     = $userB;
        $published  = time();
        //prepare data
        if ($statusID && $userID)
        {
            $data = array(
                'userA'         => $userA,
                'follow'        => 'following',
                'filterFollow'  => 'post',
                'ID'            => str_replace('_', ':', $statusID),
                'userB'         => $userB,
                'published'     => $published
            );
            $this->Follow->create($data);
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

    public function unFollow()
    {
        $getIDUser  = F3::GET("POST.id");
        $userA      = $this->getCurrentUser()->recordID;
        $userB      = str_replace(substr($userA, 2), $getIDUser, $userA);
        //filter follow status, qa, photo and all
        $statusID   = F3::GET("POST.statusID");
        $qaID       = F3::GET("POST.qaID");
        $photoID    = F3::GET("POST.photoID");
        $userID     = $userB;
        //find id of record then delete record
        if($statusID && $userID) {
            $this->Follow->deleteByCondition("userA = ? AND userB = ? AND ID = ?", array($userA, $userB, str_replace('_', ':', $statusID)));
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

?>