<?php
/**
 * Created by JetBrains PhpStorm.
 * User: King
 * Date: 10/09/2013
 * Time: 03:11
 * To change this template use File | Settings | File Templates.
 */
class RouteModuleConfig
{
    public $route = array(
        'uploadPhoto_POST'      => "PhotoController",
        'deletePhoto_POST'      => "PhotoController",
        'createAlbum_POST'      => "PhotoController",
        'myAlbum_GET'           => "PhotoController",
        'viewAlbum_GET'         => "PhotoController",
        'viewPhoto_GET'         => "PhotoController",
        'commentPhoto_POST'     => "PhotoController",
        'addDescription_POST'   => "PhotoController",
        'morePhotoComment_POST' => "PhotoController",
    );
}