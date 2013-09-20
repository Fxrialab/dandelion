<?php
class HomePost extends AppController{
    protected $uses = array ("User", "Follow", "Status", "Comment");

    public function __construct() {
        parent::__construct();
    }
    //has implement and fix logic
    public function postInHome($entry,$key)
    {
        if($entry)
        {
            $currentUser    = $this->getCurrentUser();
            $statusRC       = $this->Status->load($entry->data->object);
            $activityID     = $entry->recordID;
            if($statusRC)
            {
                $statusID   = $statusRC->recordID;
                if($currentUser->recordID != $statusRC->data->actor)
                    $userRC = $this->User->findOne("@rid = ?",array($statusRC->data->actor));
                else
                    $userRC = $this->User->findOne("@rid = ?",array($statusRC->data->owner));
                $commentOfStatusRC[$statusID]   = $this->Comment->findByCondition("post = ? LIMIT 4 ORDER BY published DESC", array($statusID));
                $numberCommentInStatusRC[$statusID] = $this->Comment->count("post = ?", array($statusID));
                $followRC[$statusID]            = $this->Follow->findOne("userA = ? AND userB = ? AND filterFollow = 'post' AND ID = ?", array($currentUser->recordID, $entry->data->actor, $statusID));
                //var_dump($followRC);
                $statusFollow[$statusID]        = ($followRC[$statusID]) ? $followRC[$statusID]->data->follow : 'null';

                if ($commentOfStatusRC[$statusID])
                {
                    $comments = $commentOfStatusRC[$statusID];
                    $pos = (count($comments) < 4 ? count($comments) : 4);
                    for($j = $pos - 1; $j >= 0; $j--)
                    {
                        $userComment[$comments[$j]->data->actor] = $this->User->load($comments[$j]->data->actor);
                    }
                }else {
                    $userComment = null;
                }
                //var_dump($userComment);
                $entry = array(
                    'type'          => 'post',
                    'key'           => $key,
                    'activityID'    => $activityID,
                    'comment'       => $commentOfStatusRC,
                    'numberComments'=> $numberCommentInStatusRC,
                    'statusFollow'  => $statusFollow,
                    'actions'       => $statusRC,
                    'actor'         => $statusRC->data->actor,
                    'statusID'      => $statusID,
                    'otherUser'     => $userRC,
                    'userComment'   => $userComment,
                    'path'          => Register::getPathModule('post'),
                );
            }
            return $entry;
        }
    }
    //has implement and fix logic
    public function moreInHome($entry,$key)
    {
        if($entry)
        {
            $currentUser    = $this->getCurrentUser();
            $activityID     = $entry->recordID;
            $statusRC       = $this->Status->load($entry->data->object);
            if($statusRC)
            {
                $statusID   = $statusRC->recordID;
                if($currentUser->recordID != $statusRC->data->actor)
                    $userRC = $this->User->findOne("@rid = ?",array($statusRC->data->actor));
                else
                    $userRC = $this->User->findOne("@rid = ?",array($statusRC->data->owner));
                $commentsOfStatus[$statusID] = $this->Comment->findByCondition("post = ? LIMIT 4 ORDER BY published DESC", array($statusID));
                $numberOfCommentsStatus[$statusID] = $this->Comment->count("post = ?", array($statusID));
                $getStatusFollow[$statusID]  = $this->Follow->findOne("userA = ? AND userB = ? AND filterFollow = 'post' AND ID = ?", array($currentUser->recordID, $entry->data->actor, $statusID));
                $statusFollow[$statusID]     = ($getStatusFollow[$statusID] == null) ? 'null' : $getStatusFollow[$statusID]->data->follow;
                if ($commentsOfStatus[$statusID])
                {
                    $comments = $commentsOfStatus[$statusID];
                    $pos = (count($comments) < 4 ? count($comments) : 4);
                    for($j = $pos - 1; $j >= 0; $j--)
                    {
                        $userComment[$comments[$j]->data->actor] = $this->User->load($comments[$j]->data->actor);
                    }
                }else {
                    $userComment = null;
                }
                $entry = array(
                    "type"          => 'post',
                    "key"           => $key,
                    "activityID"    => $activityID,
                    "comment"       => $commentsOfStatus,
                    "numberComments"=> $numberOfCommentsStatus,
                    "statusFollow"  => $statusFollow,
                    "actions"       => $statusRC,
                    "actor"         => $statusRC->data->actor,
                    "statusID"      => $statusID,
                    "otherUser"     => $userRC,
                    'userComment'   => $userComment,
                );
            }
            return $entry;
        }
    }
}
?>
