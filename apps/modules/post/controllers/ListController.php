<?php

class ListController extends AppController {

    protected $uses = array("User", "Follow", "Status", "Comment", "Like");

    public function __construct() {
        parent::__construct();
    }

    //has implement and fix logic
    public function viewPost($entry, $key) {
        if (!empty($entry)) {
            $facade = new OrientDBFacade();
            $currentUser = $this->getCurrentUser();
            $statusRC = Model::get('status')->load($entry->data->object);
            $activityID = $entry->recordID;
            $userID = $this->f3->get('SESSION.userID');

            if (!empty($statusRC)) {
                $statusID = $statusRC->recordID;
                if ($currentUser->recordID != $statusRC->data->actor)
                    $userRC = $facade->findByPk("user", $statusRC->data->actor);
                else
                    $userRC = $facade->findByPk("user", $statusRC->data->owner);
                $like = $facade->findByAttributes('like', array('owner' => $statusRC->data->owner,'ID'=>$statusID));
                $entry = array(
                    'type' => 'post',
                    'key' => $key,
                    'like' => $like,
                    'username' => $userRC->data->username,
                    'avatar' => $userRC->data->profilePic,
                    'actions' => $statusRC,
                    'statusID' => $statusID,
                    'path' => Register::getPathModule('post'),
                );
            }
            return $entry;
        }
    }

    //has implement and fix logic
    public function moreInHome($entry, $key) {
        if ($entry) {
            $facade = new OrientDBFacade();
            $currentUser = $this->getCurrentUser();
            $activityID = $entry->recordID;
            $statusRC = Model::get('status')->load($entry->data->object);
            if ($statusRC) {
                $statusID = $statusRC->recordID;
                if ($currentUser->recordID != $statusRC->data->actor)
                    $userRC = $facade->findByPk("user", $statusRC->data->actor);
                else
                    $userRC = $facade->findByPk("user", $statusRC->data->owner);
                $commentsOfStatus[$statusID] = $facade->findAll('comment', array("post" => $statusID));
                $numberOfCommentsStatus[$statusID] = $facade->count("comment", $statusID);

                $likeStatus[$statusID] = $this->getLikeStatus($statusID, $currentUser->recordID);
                $statusFollow[$statusID] = $this->getFollowStatus($statusID, $currentUser->recordID);

                if ($commentsOfStatus[$statusID]) {
                    $comments = $commentsOfStatus[$statusID];
                    $pos = (count($comments) < 4 ? count($comments) : 4);
                    for ($j = $pos - 1; $j >= 0; $j--) {
                        $userComment[$comments[$j]->data->actor] = Model::get('user')->load($comments[$j]->data->actor);
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
