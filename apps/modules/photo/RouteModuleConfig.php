<?php

/**
 * Route photo module
 */
class RouteModuleConfig
{


    public $route = array(
        'loadingPhoto_POST' => "PhotoController",
        'loading_POST' => "PhotoController",
        'upload_POST' => "PhotoController",
        'removePhoto_POST' => "PhotoController",
        'deletePhoto_POST' => "PhotoController",
        'createAlbum_POST' => "PhotoController",
        'album_GET' => "PhotoController",
        'myPhoto_GET' => "PhotoController",
        'viewAlbum_GET' => "PhotoController",
        'viewPhoto_POST' => "PhotoController",
        'addDescription_POST' => "PhotoController",
        'morePhotoComment_POST' => "PhotoController",
        'postComment_POST' => "PhotoController",
        'sharePhoto_POST' => "PhotoController",
        'comment_POST' => "PhotoController",
        'detail_GET' => "PhotoController",
        'popupPhoto_GET' => "PhotoController",
        'media_GET' => "PhotoController"
    );

}