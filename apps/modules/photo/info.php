<?php
/**
 * Created by JetBrains PhpStorm.
 * User: King
 * Date: 10/09/2013
 * Time: 03:11
 * To change this template use File | Settings | File Templates.
 */
$path='photo/views/default/';
// Info viewPath
$viewPath[]= array('type'=>'photo','viewPath'=>$path);
// Info my Photo page
$module[]=array('func'=>'myPhoto','controller'=>'PhotoController','viewPath'=>$path,'icon'=>'module_photo.png');
// Info view Album page
/*$module[]=array('func'=>'viewAlbum','controller'=>'PhotoController','viewPath'=>$path,'icon'=>'module_photo.png');
// Info view Photo page
$module[]=array('func'=>'viewPhoto','controller'=>'PhotoController','viewPath'=>$path,'icon'=>'module_photo.png');*/
?>