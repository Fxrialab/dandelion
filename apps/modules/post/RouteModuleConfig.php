<?php
/**
 * Route photo module
 */
class RouteModuleConfig {

    public $route = array(
        'postStatus_POST' => "PostController",
        'postComment_POST' => "PostController",
        'morePostStatus_POST' => "PostController",
        'morePostComment_POST' => "PostController",
        'shareStatus_POST' => "PostController",
        'insertStatus_POST' => "PostController",
        'detailStatus_GET' => "PostController",
        'delete_POST' => "PostController",
        'postWrap_POST' => "ElementController",
    );

}