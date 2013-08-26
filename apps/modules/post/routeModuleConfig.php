<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/6/13 - 5:16 PM
 * Project: joinShare Network - Version: 1.0
 */
class RouteModuleConfig
{
    public $route = array(
        'postStatus_POST'       => "PostController",
        'postComment_POST'      => "PostController",
        'morePostStatus_POST'   => "PostController",
        'morePostComment_POST'  => "PostController",
        'shareStatus_POST'      => "PostController",
        'insertStatus_POST'     => "PostController",
        'detailStatus_GET'     => "PostController",
    );
}