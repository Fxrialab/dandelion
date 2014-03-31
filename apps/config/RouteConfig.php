<?php

/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 10:02 AM
 * Project: UserWired Network - Version: beta
 */
class RouteConfig {

    //Notice: Put controller contain function is first
    public $default = array(
        '_GET' => "HomeController,UserController",
        'install_GET' => "installController",
        'installDB_POST' => "installController",
        'signUp_POST' => "UserController",
        'login_POST' => "UserController",
        'logout_GET' => "UserController",
        'confirm_GET' => "UserController",
        'authentication_GET|POST' => "UserController",
        'confirmCode_POST' => "UserController",
        'forgotPassword_GET|POST' => "UserController",
        'resetPassword_POST' => "UserController",
        'confirmPassword_POST' => "UserController",
        'newPassword_POST' => "UserController",
        /* Route config for home page */
        'home_GET' => "HomeController,UserController",
        'homeAMQ_POST' => "HomeController",
        'morePostHome_POST' => "HomeController",
        'moreCommentHome_POST' => "HomeController",
        /* Route config for request friend */
        'sentFriendRequest_POST' => "FriendController",
        'acceptFriendship_POST' => "FriendController",
        'unAcceptFriendship_POST' => "FriendController",
        /* Route config for follow */
        'like_POST' => "LikeController",
        'unlike_POST' => "LikeController",
        /* Route config for follow */
        'follow_POST' => "FollowController",
        'unFollow_POST' => "FollowController",
        /* Route config for notification */
        'notify_POST' => "NotifyController,HomeController",
        'updateNotification_POST' => "NotifyController,HomeController",
        /* Route config for load suggest element */
        'pull_GET' => "HomeController",
        'loadSuggest_POST' => "HomeController",
        /* Route config for search */
        'search_POST' => "HomeController",
        'moreSearch_GET' => "HomeController",
        /* Route config for about page */
        'about_GET' => "UserController",
        'loadBasicInfo_POST' => "UserController",
        'editBasicInfo_POST' => "UserController",
        'loadEduWork_POST'      => "UserController",
        'addWork_POST'          => "UserController",
        'editEduWork_POST'      => "UserController",
        'searchWork_POST'       => "UserController",
    );

    public $components = array(

    );
    public $modules = array(
        /* Route config for modules */
        'myPost_post' => "PostController,homePost",
     
        'myQA_qanda' => "qandaController,homeQA",
        'myPhoto_photo' => "photoController,homePhoto",
    );

}
