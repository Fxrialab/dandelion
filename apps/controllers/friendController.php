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
        $getID  = F3::get("POST.id");
        $userA  = $this->getCurrentUser()->recordID;
        $userB  = str_replace(substr($userA, 2), $getID, $userA);
        //prepare data
        $relationship   = array(
            'userA'         => $userA,
            'relationship'  => 'request',
            'status'        => 'new',
            'userB'         => $userB,
            'published'     => time()
        );
        //save data
        $this->Friendship->createEdge('#'.$userA, '#'.$userB, $relationship);
    }

    public function acceptFriendship()
    {
        $getIdUserB = F3::GET("POST.id");
        $userA      = $this->getCurrentUser()->recordID;
        $userB      = str_replace('_', ':', $getIdUserB);
        //update a record
        $updateRecord   = array(
            'relationship'  => 'friend',
            'status'        => 'ok'
        );
        $this->Friendship->updateByCondition($updateRecord, "userA = ? AND userB = ?", array($userB, $userA));
        /*//prepare data
        $relationship   = array(
            'userA'         => $userA,
            'relationship'  => 'friend',
            'status'        => 'ok',
            'userB'         => $userB,
            'published'     => time()
        );
        //save data
        $this->Friendship->createEdge('#'.$userA, '#'.$userB, $relationship);*/
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
    }
}

?>