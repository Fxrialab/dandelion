<?php

/**
 * Route group module
 */
class RouteModuleConfig
{

    public $route = array(
        'create_POST|GET' => "GroupController",
        'loading_POST' => "GroupController",
        'successGroup_POST' => "GroupController",
        'editDescription_POST' => "GroupController",
        'joinGroup_POST' => "GroupController",
        'groupSuccess_POST' => "GroupController",
        'saveCover_POST' => "GroupController",
        'cancelCover_POST' => "GroupController",
        'choosePhoto_POST|GET' => "GroupController",
        'uploadCover_POST' => "GroupController",
        'search_POST' => "GroupController",
        'leave_POST|GET' => "GroupController",
        'addFriend_POST|GET' => "AjaxController",
        'searchFriends_POST' => "AjaxController",
        'addMemberGroup_POST' => "AjaxController",
        'removeGroup_POST' => "AjaxController",
        'comfirmRemoveGrorup_POST' => "AjaxController",
        'rolegroup_POST' => "AjaxController",
        'removeAdmin_POST' => "AjaxController",
        'comfirmrole_POST' => "AjaxController",
        'comfirmcover_POST' => "AjaxController",
        'reposition_POST' => "GroupController",
        'remove_POST' => "GroupController",
        'photoBrowser_GET' => "AjaxController",
        'changePhoto_GET' => "AjaxController",
    );

}