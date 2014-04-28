<?php
$status     = $this->f3->get('status');
$activity   = $status->data;
$currentUser= $this->f3->get('currentUser');
$statusID   = str_replace(":", "_", $this->f3->get('statusID'));
$avatar     = $currentUser->data->profilePic;
$username   = $currentUser->data->username;
$like       = false;
$f3         = require('viewPost.php');
?>

