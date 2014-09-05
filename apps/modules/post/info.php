<?php
// Info Path
$pathElement = 'post/views/elements/';
$path='post/views/'.TEMPLATE.'/';
// Info viewPath
$viewPath[]= array('type'=>'post','viewPath'=>$path);
// Info Home page
//$module[]=array('func'=>'postWap','controller'=>'PostController','viewPath'=>$pathElement,'icon'=>'module_post.png');
// Info myPost page
$module[]=array('func'=>'post','controller'=>'PostController','viewPath'=>$path,'icon'=>'module_post.png');
//$module[]=array('func'=>'detailStatus','controller'=>'PostController','viewPath'=>$path,'icon'=>'module_post.png');

?>

