<?php
/**
 * Route group module
 */
class RouteModuleConfig
{

    public $route = array(
        'create_POST' => "GroupController",
        'successGroup_POST' => "GroupController",
        'addmember_POST' => "GroupController",
        'editDescription_POST' => "GroupController",
        'addMemberGroup_POST' => "GroupController",
        'joinGroup_POST' => "GroupController",
        'groupSuccess_POST' => "GroupController",
        'makeAdmin_POST' => "GroupController",
        'removeGroup_POST' => "GroupController",
    );

}