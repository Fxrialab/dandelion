<?php

class ListController extends AppController
{

    public function __construct() {
        parent::__construct();
    }

    //has implement and fix logic
    public function viewPost($entry, $key)
    {
        if (!empty($entry))
        {
            $currentUser= $this->getCurrentUser();
            $statusRC   = $this->facade->findByAttributes('status', array('@rid'=>'#'.$entry->data->object, 'active'=>1));

            $activityID = $entry->recordID;
            $userID = $this->f3->get('SESSION.userID');

            if (!empty($statusRC))
            {
                $statusID = $statusRC->recordID;
                if ($currentUser->recordID != $statusRC->data->actor)
                    $userRC = $this->facade->findByPk("user", $statusRC->data->actor);
                else
                    $userRC = $this->facade->findByPk("user", $statusRC->data->owner);
                $like = $this->facade->findAllAttributes('like', array('actor' => $statusRC->data->owner,'objID'=>$statusID));

                $entry = array(
                    'type'      => 'post',
                    'key'       => $key,
                    'like'      => $like,
                    'username'  => $userRC->data->username,
                    'avatar'    => $userRC->data->profilePic,
                    /*'currentUser'   => $userRC,*/
                    'actions'   => $statusRC,
                    'statusID'  => $statusID,
                    'path'      => Register::getPathModule('post'),
                );
                return $entry;
            }else{
                return false;
            }

        }
    }

    //has implement and fix logic
    public function moreInHome($entry, $key) {
        if ($entry) {
            $currentUser = $this->getCurrentUser();
            $activityID = $entry->recordID;
            $statusRC = Model::get('status')->load($entry->data->object);
            if ($statusRC) {
                $statusID = $statusRC->recordID;
                if ($currentUser->recordID != $statusRC->data->actor)
                    $userRC = $this->facade->findByPk("user", $statusRC->data->actor);
                else
                    $userRC = $this->facade->findByPk("user", $statusRC->data->owner);
                $commentsOfStatus[$statusID] = $this->facade->findAllAttributes('comment', array("post" => $statusID));
                $numberOfCommentsStatus[$statusID] = $this->facade->count("comment", array('post'=>$statusID));

                $likeStatus[$statusID] = $this->getLikeStatus($statusID, $currentUser->recordID);
                $statusFollow[$statusID] = $this->getFollowStatus($statusID, $currentUser->recordID);

                if ($commentsOfStatus[$statusID]) {
                    $comments = $commentsOfStatus[$statusID];
                    $pos = (count($comments) < 4 ? count($comments) : 4);
                    for ($j = $pos - 1; $j >= 0; $j--) {
                        $userComment[$comments[$j]->data->actor] = $this->facade->load('user', $comments[$j]->data->actor);
                    }
                } else {
                    $userComment = null;
                }
                $entry = array(
                    "type" => 'post',
                    "key" => $key,
                    "activityID" => $activityID,
                    "comment" => $commentsOfStatus,
                    "numberComments" => $numberOfCommentsStatus,
                    "statusFollow" => $statusFollow,
                    'likeStatus' => $likeStatus,
                    "actions" => $statusRC,
                    "actor" => $statusRC->data->actor,
                    "statusID" => $statusID,
                    "otherUser" => $userRC,
                    'userComment' => $userComment,
                );
            }
            return $entry;
        }
    }

}

?>
