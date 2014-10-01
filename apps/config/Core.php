<?php
require_once('Structure.php');
require_once(MODELS.'Model.php');
$f3 = require(F3.'base.php');
//not cache for development environment
$f3->set('CACHE', FALSE);
// site name
$f3->set('site1', 'Dandelion');
$f3->set('site2', 'Welcome to Dandelion Network - Log In, Sign Up');
// debug level
$f3->set('DEBUG', 3);
// declare F3 structure
$f3->set('UI', UI);
//$f3->set('VIEWS', VIEWS);
$f3->set('WEBROOT', WEBROOT);
$f3->set('CSS', CSS);
$f3->set('JS', JS);
$f3->set('IMG', IMAGES);
$f3->set('STATIC_MOD',ROOT_MOD);
// other settings
$f3->set('ENCODING', 'utf-8');
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once('Routes.php');
$f3->run();
?>
