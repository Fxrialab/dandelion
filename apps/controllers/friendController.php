<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/19/13 - 4:04 PM
 * Project: UserWired Network - Version: beta
 */

class FriendController extends AppController
{
    protected $uses     = array("Friendship", "Information");
    protected $helpers  = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function sentFriendRequest()
    {
        $userB  = F3::get("POST.id");
        $userA  = $this->getCurrentUser()->recordID;
        //prepare data
        $relationship   = array(
            'userA'         => $userA,
            'relationship'  => 'request',
            'status'        => 'new',
            'userB'         => str_replace(substr($userA, 2), $userB, $userA),
            'published'     => time()
        );
        //save data
        $this->Friendship->create($relationship);
        $this->Information->createLink(" friends","LINKSET","friendship.userA", "information.userID");
    }

    public function acceptFriendship()
    {
        $getIdUserB = F3::GET("POST.id");
        $userA      = $this->getCurrentUser()->recordID;
        $userB      = str_replace(substr($userA, 2), $getIdUserB, $userA);
        //update a record
        $updateRecord   = array(
            'relationship'  => 'friend',
            'status'        => 'ok'
        );
        $this->Friendship->updateByCondition($updateRecord, "userA = ? AND userB = ?", array($userB, $userA));
        $this->Information->createLink(" friends","LINKSET","friendship.userA", "information.userID");
        //prepare data
        $relationship   = array(
            'userA'         => $userA,
            'relationship'  => 'friend',
            'status'        => 'ok',
            'userB'         => $userB,
            'published'     => time()
        );
        //save data
        $this->Friendship->create($relationship);
        $this->Information->createLink(" friends","LINKSET", "friendship.userA", "information.userID");
    }

    public function unAcceptFriendship()
    {
        $getIdUserB = F3::GET("POST.id");
        $userA      = $this->getCurrentUser()->recordID;
        $userB      = str_replace(substr($userA, 2), $getIdUserB, $userA);
        //update a record
        $updateRecord   = array(
            'status'  => 'later'
        );
        $this->Friendship->updateByCondition($updateRecord, "userA = ? AND userB = ?", array($userB, $userA));
        $this->Information->createLink(" friends","LINKSET","friendship.userA", "information.userID");
    }
}

?>