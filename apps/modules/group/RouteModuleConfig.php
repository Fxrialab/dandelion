<?php

/**
 * Route group module
 */
class RouteModuleConfig
{

    public $route = array(
        'create_POST'       => "GroupController",
        'loading_POST'       => "GroupController",
        'successGroup_POST' => "GroupController",
        'editDescription_POST' => "GroupController",
        'joinGroup_POST'    => "GroupController",
        'groupSuccess_POST' => "GroupController",
        'photoBrowsers_POST'    => "GroupController",
        'saveCover_POST'    => "GroupController",
        'cancelCover_POST'  => "GroupController",
        'choosePhoto_POST'  => "GroupController",
        'uploadCover_POST'  => "GroupController",
        'search_POST'       => "GroupController",
        'leave_POST'        => "GroupController",
        'addFriend_POST'    => "AjaxController",
        'searchFriends_POST'    => "AjaxController",
        'addMemberGroup_POST'   => "AjaxController",
        'removeGroup_POST'  => "AjaxController",
        'comfirmRemoveGrorup_POST'  => "AjaxController",
        'rolegroup_POST'    => "AjaxController",
        'removeAdmin_POST'  => "AjaxController",
        'comfirmrole_POST'  => "AjaxController",
        'comfirmcover_POST' => "AjaxController",
        'reposition_POST'   => "GroupController",
        'remove_POST'       => "GroupController",
    );

}