<?php

/**
 * Route photo module
 */
class RouteModuleConfig
{

    public $route = array(
        'loading_POST' => "PostController",
        'postStatus_POST' => "PostController",
        'postComment_POST' => "PostController",
        'moreComment_POST' => "PostController",
        'share_GET' => "PostController",
        'insertStatus_POST' => "PostController",
        'deleteImage_POST' => "PostController",
        'detailStatus_GET' => "PostController",
        'delete_POST' => "PostController",
    );

}
