<?php
/**
 * Route photo module
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
        'viewPhoto_POST'         => "PhotoController",
        'addDescription_POST'   => "PhotoController",
        'morePhotoComment_POST' => "PhotoController",
        'postComment_POST'      => "PhotoController",
        'sharePhoto_POST'       => "PhotoController"
    );
}