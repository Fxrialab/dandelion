<?php

/**
 * User: Hoc Nguyen
 * Date: 12/21/12
 */
// Info Path
$pathElement = 'group/views/elements';
$path = 'group/views/default/';
// Info viewPath
$viewPath[] = array('type' => 'Group', 'viewPath' => $path);
// Info Home page
$module[] = array('func' => 'group', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
// Info myPost page
$module[] = array('func' => 'groupdetail', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
$module[] = array('func' => 'members', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
//$module[] = array('func' => 'addGroup', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
//$module[] = array('func' => 'groupSuccess', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
//$module[] = array('func' => 'create', 'controller' => 'GroupController', 'viewPath' => $path, 'icon' => 'module_post.png');
?>

