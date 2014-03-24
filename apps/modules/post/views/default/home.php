<?php

$currentUserID = $currentUser->recordID;
if ($homeViews) {
    $status = $homeViews["actions"];
    $otherUserProfilePic = $homeViews['otherUser_profilePic'];
    $otherUserUserName = $homeViews['otherUser_username'];
    $actor = $homeViews["actor"];
    $statusID = $homeViews['statusID'];
    $comment = $homeViews['comment'];
    $activityID = $homeViews['activityID'];
    $key = $homeViews['key'];
    $numberComment = $homeViews['numberComments'];
    $likeStatus = $homeViews['likeStatus'];
    $statusFollow = $homeViews['statusFollow'];
    $userCommentProfilePic = $homeViews['userComment_profilePic'];
    $cm_username = $homeViews['userComment_username'];
    $rpStatusID = str_replace(":", "_", $statusID);
    $status_owner = $status->data->owner;
    $status_actor = $status->data->actor;
    $status_username = $status->data->actorName;
    $status_tagged = $status->data->tagged;
    $status_content = $status->data->content;
    $numberLikes = $status->data->numberLike;
    $numC = $status->data->numberComment;
    $numS = $status->data->numberShared;
    $status_contentShare = $status->data->contentShare;
    $status_published = $status->data->published;
    $status_mainStatus = str_replace(":", "_", $status->data->mainStatus);
    $avatar = $currentUser->data->profilePic;
    $linkProfile = '/content/myPost?username=' . $otherUserUserName;
    $records = $comment[$statusID];
    $numberOfComments = $numberComment;
    $otherUserName = ucfirst($otherUser->data->firstName) . " " . ucfirst($otherUser->data->lastName);
    $f3=require('_viewPost.php');
//    include '_viewPost.php';
}
?>