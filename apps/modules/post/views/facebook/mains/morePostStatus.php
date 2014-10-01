<?php

$listStatus = $this->f3->get('listStatus');
foreach ($listStatus as $key => $status) {
    $statusID = $status->recordID;
    $rpStatusID = str_replace(":", "_", $statusID);
    $activity = $status->data;
    $user = OrientDBFind::user($status->data->actor);
    $username = $user->data->username;
    $avatar = $user->data->profilePic;
    $like = TRUE;
}
$f3 = require('viewPost.php');
?>