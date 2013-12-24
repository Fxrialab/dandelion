<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 10:02 AM
 * Project: UserWired Network - Version: beta
 */
class RouteConfig
{
    //Notice: Put controller contain function is first
    public $default = array(
        '_GET'                  => "homeController,userController",
        'signUp_POST'           => "userController",
        'login_POST'            => "userController",
        'logout_GET'            => "userController",
        'confirm_GET'           => "userController",
        'authentication_GET|POST'   => "userController",
        'confirmCode_POST'      => "userController",
        'forgotPassword_GET|POST'   => "userController",
        'resetPassword_POST'    => "userController",
        'confirmPassword_POST'  => "userController",
        'newPassword_POST'      => "userController",
        /* Route config for home page */
        'home_GET'              => "homeController,userController",
        'homeAMQ_POST'          => "homeController",
        'morePostHome_POST'     => "homeController",
        'moreCommentHome_POST'  => "homeController",
        /* Route config for request friend */
        'sentFriendRequest_POST'=> "friendController",
        'acceptFriendship_POST' => "friendController",
        'unAcceptFriendship_POST'   => "friendController",
        /* Route config for follow */
        'like_POST'             => "likeController",
        'unlike_POST'           => "likeController",
        /* Route config for follow */
        'follow_POST'           => "followController",
        'unFollow_POST'         => "followController",
        /* Route config for notification */
        'notify_POST'           => "notifyController,homeController",
        'updateNotification_POST'   => "notifyController,homeController",
        /* Route config for load suggest element */
        'pull_GET'              => "homeController",
        'loadSuggest_POST'      => "homeController",
        /* Route config for search*/
        'search_POST'           => "homeController",
        'moreSearch_GET'        => "homeController",
    );

    public $modules = array(
        /* Route config for modules */
        'myPost_post'           => "postController,homePost",
        'myQA_qanda'            => "qandaController,homeQA",
        'myPhoto_photo'         => "photoController,homePhoto",
    );
}

//'home|GET'  => "homeController,userController,friendController,followController,notifyController,elementController",