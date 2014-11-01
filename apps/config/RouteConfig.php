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
        '_GET' => "HomeController,UserController",
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
        'listenPost_POST' => "HomeController",
        'notifications_POST' => "HomeController",
        'loadNotifications_POST' => "HomeController",
        'loadFriendRequests_POST' => "HomeController",
        'moreCommentHome_POST' => "HomeController",
        'loading_POST' => "HomeController",
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
        'search_POST|GET' => "HomeController",
        'moreSearch_GET' => "HomeController",
        /* Route config for about page */
        'about_GET' => "ProfileController",
        'loadBasicInfo_POST' => "UserController",
        'editBasicInfo_POST' => "UserController",
        'loadEduWork_POST' => "UserController",
        'addWork_POST' => "UserController",
        'editEduWork_POST' => "UserController",
        'searchWork_POST' => "UserController",
        /* Route config for friends page */
        'friends_GET' => "FriendController",
        'loadFriend_POST' => "FriendController",
        'searchFriend_POST' => "FriendController",
        /* Route config for ajax page */
        'photoBrowser_GET' => "ProfileController",
        'uploadCover_POST' => "UploadController",
        'uploadAvatar_POST' => "UploadController",
        'savePhoto_POST' => "UploadController",
        'remove_POST' => "UploadController",
        'choosePhoto_POST' => "UploadController",
        'reposition_POST' => "UploadController",
        'cancel_POST' => "UploadController",
        'uploading_POST' => "UploadController",
        /* Route config for info profile */
        'work_POST|GET' => 'ProfileController',
        'college_POST|GET' => 'ProfileController',
        'school_POST|GET' => 'ProfileController',
        'currentCity_POST|GET' => 'ProfileController',
        'homeCity_POST|GET' => 'ProfileController',
        'contactPhone_POST|GET' => 'ProfileController',
        'birthday_POST|GET' => 'ProfileController',
        'gender_POST|GET' => 'ProfileController',
        'editname_POST|GET' => 'ProfileController',
        'editabout_POST|GET' => 'ProfileController',
        'searchLocation_POST|GET' => 'ProfileController',
        'searchInfoUser_GET' => 'ProfileController'
    );
    public $modules = array(
        /* Route config for modules */
        'post_post' => "PostController",
        'group_group' => "GroupController",
        'photo_photo' => "PhotoController",
    );

}
