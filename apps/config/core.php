<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 8:39 AM
 * Project: UserWired Network - Version: beta
 */
require_once('structure.php');
require(F3.'base.php');

define('CACHE_TIME', 3600);
//not cache for development environment
F3::set('CACHE', FALSE);
// site name
F3::set('SITE', 'joinShare Network');
// debug level
F3::set('DEBUG', 3);
// declare F3 structure
F3::set('UI', UI);
F3::set('STATIC', WEBROOT);
F3::set('VIEWS', VIEWS);
F3::set('STATIC_MOD',ROOT_MOD);
// other settings
F3::set('ENCODING', 'utf-8');
date_default_timezone_set('Asia/Ho_Chi_Minh');

require_once('routes.php');

F3::run();

?>