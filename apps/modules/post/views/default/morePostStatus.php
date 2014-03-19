<?php

$rand = rand(100, 100000);
//$currentUser = $this->f3->get('currentUser');
//$userProfileInfo = $this->f3->get('userProfileInfo');
//$likeStatus = $this->f3->get('likeStatus');
//$listStatus = $this->f3->get('listStatus');
//$comments = $this->f3->get('comments');
//$numberOfComments = $this->f3->get('numberOfComments');
//$statusFollow = $this->f3->get('statusFollow');
//$postActor = $this->f3->get('postActor');
//$commentActor = $this->f3->get('commentActor');
//$currentUserID = $currentUser->recordID;
//$userProfileID = $userProfileInfo->recordID;
//$userNameProfile = ucfirst($userProfileInfo->data->firstName) . " " . ucfirst($userProfileInfo->data->lastName);
//$otherUserID = $otherUser->recordID;
$listStatus = $this->f3->get('listStatus');
$comments = $this->f3->get('comments');
$numberOfComments = $this->f3->get('numberOfComments');
$currentUser = $this->f3->get('currentUser');
$otherUser = $this->f3->get('otherUser');
$likeStatus = $this->f3->get('likeStatus');
$statusFollow = $this->f3->get('statusFollow');
$statusFriendship = $this->f3->get('statusFriendShip');
$postActor = $this->f3->get('postActor');
$commentActor = $this->f3->get('commentActor');
$currentProfileID = $this->f3->get('currentProfileID');
$currentUserID = $currentUser->recordID;
$otherUserID = $otherUser->recordID;

if ($listStatus) {
    for ($i = 0; $i < count($listStatus); $i++) {
        $lastStatus = $listStatus[$i]->recordID;
        $postID = str_replace(":", "_", $listStatus[$i]->recordID);
        $actorProfile = $postActor[$listStatus[$i]->data->actor];
        $f3 = require('_viewPost.php');
    }
}
?>