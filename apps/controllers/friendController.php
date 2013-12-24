<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/19/13 - 4:04 PM
 * Project: UserWired Network - Version: beta
 */

class FriendController extends AppController
{
    protected $uses     = array("Friendship", "Information", "Actions");
    protected $helpers  = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function sentFriendRequest()
    {
        if ($this->isLogin())
        {
            $getID  = $this->f3->get("POST.id");
            $userA  = $this->getCurrentUser()->recordID;
            $userB  = $this->User->getClusterID().':'.$getID;
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
            //After friend request is sent. The friendRequests action will be create
            $existFriendRequestAction   = $this->Actions->findOne("actionName = ?", array('Friend Requests'));
            if (!$existFriendRequestAction)
            {
                $actionRC       = array(
                    'actionName'    => 'Friend Requests',
                    'actionElement' => 'friendRequests',
                    'isSearch'      => 'no',
                    'isSuggest'     => 'yes',
                );
                $this->Actions->create($actionRC);
            }
        }
    }

    public function acceptFriendship()
    {
        if ($this->isLogin())
        {
            $getIdUserB = $this->f3->GET("POST.id");
            $userA      = $this->getCurrentUser()->recordID;
            $userB      = $this->User->getClusterID().':'.$getIdUserB;
            //update a record
            $updateRecord   = array(
                'relationship'  => 'friend',
                'status'        => 'ok'
            );
            $this->Friendship->updateByCondition($updateRecord, "userA = ? AND userB = ?", array($userB, $userA));
            //prepare data
            $relationship   = array(
                'userA'         => $userA,
                'relationship'  => 'friend',
                'status'        => 'ok',
                'userB'         => $userB,
                'published'     => time()
            );
            //save data
            $this->Friendship->createEdge('#'.$userA, '#'.$userB, $relationship);
            //After friend is accept. The peopleYouMayKnow action will be create
            $existPeopleYouMayKnowAction   = $this->Actions->findOne("actionName = ?", array('People You May Know'));
            if (!$existPeopleYouMayKnowAction)
            {
                $actionRC       = array(
                    'actionName'    => 'People You May Know',
                    'actionElement' => 'peopleYouMayKnow',
                    'isSearch'      => 'yes',
                    'isSuggest'     => 'yes',
                );
                $this->Actions->create($actionRC);
            }
        }
    }

    public function unAcceptFriendship()
    {
        if ($this->isLogin())
        {
            $getIdUserB = $this->f3->GET("POST.id");
            $userA      = $this->getCurrentUser()->recordID;
            $userB      = $this->User->getClusterID().':'.$getIdUserB;
            //update a record
            $updateRecord   = array(
                'status'  => 'later'
            );
            $this->Friendship->updateByCondition($updateRecord, "userA = ? AND userB = ?", array($userB, $userA));
        }
    }
}

?>