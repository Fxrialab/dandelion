<?php
// Info Path
$pathElement = 'group/views/elements';
$path = 'group/views/'.TEMPLATE.'/';
// Info viewPath
$viewPath[] = array('type' => 'group', 'viewPath' => $path);
// Info Home page
$module[] = array('mod'=> 'group', 'func' => 'group', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
// Info myPost page
$module[] = array('mod'=> 'group', 'func' => 'groupdetail', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
$module[] = array('mod'=> 'group', 'func' => 'members', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
//$module[] = array('func' => 'addGroup', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
//$module[] = array('func' => 'groupSuccess', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
//$module[] = array('func' => 'create', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
?>

