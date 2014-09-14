<?php
$path = 'photo/views/'.TEMPLATE.'/';
$pathElement = 'photo/views/elements';
// Info viewPath
$viewPath[] = array('type' => 'photo', 'viewPath' => $path);
// Info my Photo page
$module[] = array('func' => 'photo', 'controller' => 'PhotoController', 'viewPath' => $path, 'icon' => 'module_photo.png');
//$module[] = array('func' => 'myAlbum', 'controller' => 'PhotoController', 'viewPath' => $path, 'icon' => 'module_photo.png');
// Info view Album page
/* $module[]=array('func'=>'viewAlbum','controller'=>'PhotoController','viewPath'=>$path,'icon'=>'module_photo.png');
  // Info view Photo page
  $module[]=array('func'=>'viewPhoto','controller'=>'PhotoController','viewPath'=>$path,'icon'=>'module_photo.png'); */
?>