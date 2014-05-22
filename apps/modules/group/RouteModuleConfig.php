<?php

/**
 * Route group module
 */
class RouteModuleConfig
{

    public $route = array(
        'create_POST' => "GroupController",
        'successGroup_POST' => "GroupController",
        'editDescription_POST' => "GroupController",
        'joinGroup_POST' => "GroupController",
        'groupSuccess_POST' => "GroupController",
        'myphotos_POST' => "GroupController",
        'cover_POST' => "GroupController",
        'uploadphoto_POST' => "GroupController",
        'search_POST' => "GroupController",
        'leave_POST' => "GroupController",
        'crop_GET' => "GroupController",
        'addFriend_POST' => "AjaxController",
        'searchFriends_POST' => "AjaxController",
        'addMemberGroup_POST' => "AjaxController",
        'removeGroup_POST' => "AjaxController",
        'comfirmRemoveGrorup_POST' => "AjaxController",
        'rolegroup_POST' => "AjaxController",
        'removeAdmin_POST' => "AjaxController",
        'comfirmrole_POST' => "AjaxController",
        'comfirmcover_POST' => "AjaxController",
        'reposition_POST' => "AjaxController",
        'remove_POST' => "AjaxController",
    );

}