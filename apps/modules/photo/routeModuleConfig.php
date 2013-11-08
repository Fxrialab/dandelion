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
        'loadingPhoto_POST'     => "PhotoController",
        'uploadPhoto_POST'      => "PhotoController",
        'removePhoto_POST'      => "PhotoController",
        'deletePhoto_POST'      => "PhotoController",
        'createAlbum_POST'      => "PhotoController",
        'myAlbum_GET'           => "PhotoController",
        'viewAlbum_GET'         => "PhotoController",
        'viewPhoto_GET'         => "PhotoController",
        'addDescription_POST'   => "PhotoController",
        'morePhotoComment_POST' => "PhotoController",
        'postComment_POST'      => "PhotoController",
        'sharePhoto_POST'       => "PhotoController"
    );
}