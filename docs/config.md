# Config

* Core
```
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
?>```

* Database
```
<?php
define('HOST', 'localhost');
define('ROOT', 'root');
define('ROOT_PW', 'C4CB6E4029E2E0B45F1CC62C38950F7C2308267569915DCC66AD1B2951F54EFF');
define('USER', 'admin');
define('PASSWORD', 'admin');
define('PORT', '2424');
define('DATABASE', 'dandelion');
define('ATTEMPT', 'default');
define('ALTER_CLASS', 'not');
define('TIMEOUT', 10);
define('DBTYPE','OrientDB')
?>```

* OrientDBCC
```
<?php
$map = array(
    'user' => '11',
    'notify' => '12',
    'sessions' => '13',
    'status' => '14',
    'comment' => '15',
    'activity' => '16',
    'actions' => '17',
    'friendship' => '18',
    'follow' => '19',
    'album' => '20',
    'photo' => '21',
    'information' => '22',
    'permission' => '23',
    'like' => '24',
    'group' => '25',
    'groupMember' => '26',
    'location' => '28',
    'tmp' => '29'
);
?>```

* ExtraConfig
```
<?php
class ExtraConfig
{

    static public function getId($className)
    {
        include CONFIG . "OrientDBCC.php";
        return $map[$className];
    }
}
?>```

* ModuleConfig

```
<?php
function ModulesConfig()
{
    $module = array();
    foreach (glob(MODULES."*/info.php") as $infoController)
    {
        require_once $infoController;
    }
    return $module;
}

function getViewPath(){
    $viewPath= array();
    foreach (glob(MODULES."*/info.php") as $infoController)
    {
        require_once $infoController;
    }
    return $viewPath;
}

?>```


* RouteConfig

```
<?php
class RouteConfig
{

    //Notice: Put controller contain function is first
    public $default = array(
        '_GET' => "HomeController,UserController",
        'signUp_POST' => "UserController",
        'login_POST' => "UserController",
        'logout_GET' => "UserController",
        'confirm_GET' => "UserController",
        'authentication_GET|POST' => "UserController",
        'confirmCode_POST' => "UserController",
        'forgotPassword_GET|POST' => "UserController",
        'resetPassword_POST' => "UserController",
        'confirmPassword_POST' => "UserController",
        'newPassword_POST' => "UserController",
        /* Route config for home page */
        'home_GET' => "HomeController,UserController",
        'listenPost_POST' => "HomeController",
        'notifications_POST' => "HomeController",
        'loadNotifications_POST' => "HomeController",
        'loadFriendRequests_POST' => "HomeController",
        'moreCommentHome_POST' => "HomeController",
        'loading_POST' => "HomeController",
        /* Route config for request friend */
        'sentFriendRequest_POST' => "FriendController",
        'acceptFriendship_POST' => "FriendController",
        'unAcceptFriendship_POST' => "FriendController",
        /* Route config for follow */
        'like_POST' => "LikeController",
        'unlike_POST' => "LikeController",
        /* Route config for follow */
        'follow_POST' => "FollowController",
        'unFollow_POST' => "FollowController",
        /* Route config for notification */
        'notify_POST' => "NotifyController,HomeController",
        'updateNotification_POST' => "NotifyController,HomeController",
        /* Route config for load suggest element */
        'pull_GET' => "HomeController",
        'loadSuggest_POST' => "HomeController",
        /* Route config for search */
        'search_POST|GET' => "HomeController",
        'moreSearch_GET' => "HomeController",
        /* Route config for about page */
        'about_GET' => "ProfileController",
        'loadBasicInfo_POST' => "UserController",
        'editBasicInfo_POST' => "UserController",
        'loadEduWork_POST' => "UserController",
        'addWork_POST' => "UserController",
        'editEduWork_POST' => "UserController",
        'searchWork_POST' => "UserController",
        /* Route config for friends page */
        'friends_GET' => "FriendController",
        'loadFriend_POST' => "FriendController",
        'searchFriend_POST' => "FriendController",
        /* Route config for ajax page */
        'photoBrowser_GET' => "ProfileController",
        'uploadCover_POST' => "UploadController",
        'uploadAvatar_POST' => "UploadController",
        'savePhoto_POST' => "UploadController",
        'remove_POST' => "UploadController",
        'changePhoto_POST' => "UploadController",
        'reposition_POST' => "UploadController",
        'cancel_POST' => "UploadController",
        'uploading_POST' => "UploadController",
        /* Route config for info profile */
        'work_POST|GET' => 'ProfileController',
        'college_POST|GET' => 'ProfileController',
        'school_POST|GET' => 'ProfileController',
        'currentCity_POST|GET' => 'ProfileController',
        'homeCity_POST|GET' => 'ProfileController',
        'contactPhone_POST|GET' => 'ProfileController',
        'birthday_POST|GET' => 'ProfileController',
        'gender_POST|GET' => 'ProfileController',
        'editname_POST|GET' => 'ProfileController',
        'editabout_POST|GET' => 'ProfileController',
        'searchLocation_POST|GET' => 'ProfileController',
        'searchInfoUser_GET' => 'ProfileController',
//        Comment
        'commentStatus_POST' => 'CommentController',
        'commentPhoto_POST' => 'CommentController',
    );
    public $modules = array(
        /* Route config for modules */
        'post_post' => "PostController",
        'group_group' => "GroupController",
        'photo_photo' => "PhotoController",
    );

}```



* Routers

```
<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 8:58 AM
 * Project: UserWired Network - Version: beta
 */
require_once (CONTROLLERS . "AppController.php");
//require_once (CONTROLLERS . "HelperController.php");
$url            = $_SERVER["REQUEST_URI"];
$params_full    = explode('/',$url);
$lastParams     = explode('?',$params_full[count($params_full)-1]);
$param          = $lastParams[0];

if ($params_full)
{
    $routeConfigFile = CONFIG.'RouteConfig.php';
    if (file_exists($routeConfigFile))
    {
        include $routeConfigFile;
        $routeConfig    = new RouteConfig;
        $routes         = $routeConfig->default;
        if ($param == '')
        {
            //echo 'index page <br />';
            foreach($routes as $key=>$value)
            {
                $params     = substr($key, 0, strpos($key, '_'));
                $method     = substr($key, strpos($key, '_') + 1);
                $controllers = explode(',', $value);

                if ($params == '')
                {
                    foreach ($controllers as $controller)
                    {
                        $controllerFiles = CONTROLLERS.$controller.'.php';
                          if (file_exists($controllerFiles))
                            include($controllerFiles);
                    }
                    $function = 'index';
                    $f3->route($method." /".$params,
                        array(new $controllers[0], $function)
                    );
                }
            }
        }else{
            if (count($params_full) > 1 && $params_full[1] == 'content')
            {
                //echo 'modules route <br />';
                $modules = $routeConfig->modules;
                $registerFile   = CONTROLLERS.'Register.php';
                if (file_exists($registerFile))
                {
                    require_once $registerFile;

                    foreach($modules as $key=>$value)
                    {
                        $params      = substr($key, 0, strpos($key, '_'));
                        $mod         = substr($key, strpos($key, '_') + 1);
                        $controllers = explode(',', $value);
                        if ($mod)
                        {
                            if ($param == $params || $params_full[2] == $mod)
                            {
                               // echo "param: ".$param." params: ".$params." param2: ".$params_full[2]." mod: ".$mod."<br />";
                                // Load all controllers for each module
                                foreach ($controllers as $controller)
                                {
                                    $modControllerFiles = MODULES.$mod."/controllers/".$controller.".php";
                                    if (file_exists($modControllerFiles))
                                    {
                                        //echo $modControllerFiles."<br />";
                                        include($modControllerFiles);
                                    }

                                }
                                // Set route for modules
                                $moduleFile = CONTROLLERS.'ModuleController.php';
                                $function = 'content';
                                if (file_exists($moduleFile))
                                {
                                    require_once $moduleFile;
                                    $f3->route('GET|POST /content/*',
                                        array(new ModuleController, $function)
                                    );
                                }
                                // Load routes file of module
                                if ($params_full[2] == $mod)
                                {
                                    $routeFile  = MODULES.$mod."/routes.php";
                                    if (file_exists($routeFile))
                                        require_once $routeFile;
                                }
                            }
                        }/*else {
                            //@TODO: check if example pass URL just /content in here
                            echo "here";
                            $homeFile   = CONTROLLERS.'homeController.php';
                            $function   = 'index';
                            if (file_exists($homeFile))
                            {
                                require_once $homeFile;
                                F3::route('GET /',
                                    array(new HomeController, $function)
                                );
                            }
                        }*/
                    }
                }
            }elseif (count($params_full) > 1 && $params_full[1] == 'user') {
                $userControllerFile = CONTROLLERS.'UserController.php';
                $registerFile   = CONTROLLERS.'Register.php';
                if (file_exists($userControllerFile) && file_exists($registerFile))
                {
                    require_once $userControllerFile;
                    require_once $registerFile;
                    $f3->route('GET /user/*',
                        array(new UserController, 'user')
                    );
                }
            }else {
                //echo "default route <br />";
                foreach($routes as $key=>$value)
                {
                    $params      = substr($key, 0, strpos($key, '_'));
                    $method      = substr($key, strpos($key, '_') + 1);
                    $controllers = explode(',', $value);

                    if ($params == $param)
                    {
                        foreach ($controllers as $controller)
                        {
                            $controllerFiles = CONTROLLERS.$controller.'.php';
                            if (file_exists($controllerFiles))
                                include($controllerFiles);
                            else
                                $f3->reroute('/');
                            // load all modules in home page
                            if ($controller == 'HomeController')
                            {
                                foreach (glob(MODULES."*/controllers/*.php") as $modulesControllerFile){
                                    require_once $modulesControllerFile;
                                    //echo $modulesControllerFile."<br />";
                                }
                                $registerFile   = CONTROLLERS.'Register.php';
                                if (file_exists($registerFile))
                                    require_once $registerFile;
                            }
                        }
                        // Set route
                        $function = $params;
                        $f3->route($method." /".$params,
                            array(new $controllers[0], $function)
                        );
                        break;
                    }
                }
            }

        }
    }
}

?>```


* Structure

```
<?php

// source code structure
// base
$dir = dirname(__FILE__);
$dirSource = substr($dir, 0, strpos($dir, 'apps') - 1);

define('DS', '/');
define('BASE_URL', 'http://dandelion.local/');
define('DOCUMENT_ROOT', $dirSource . DS);
define('F3', DOCUMENT_ROOT . 'lib' . DS);
define('CONFIG', DOCUMENT_ROOT . 'apps' . DS . 'config' . DS);

// framework
define('CONTROLLERS', DOCUMENT_ROOT . 'apps' . DS . 'controllers' . DS);
define('HELPERS', DOCUMENT_ROOT . 'apps' . DS . 'helpers' . DS);
define('MODELS', DOCUMENT_ROOT . 'apps' . DS . 'models' . DS);
define('VIEWS', DOCUMENT_ROOT . 'apps' . DS . 'views' . DS);
define('ELEMENTS', DOCUMENT_ROOT . 'apps' . DS . 'elements' . DS);
define('TEMPLATE', 'facebook');
define('UI', VIEWS . TEMPLATE . DS);

// inside view
//define('ELEMENTS', 'elements' . DS);
define('LAYOUTS', 'layouts' . DS);
define('EMAILS', 'emails' . DS);

// static
define('WEBROOT', BASE_URL . 'apps' . DS . 'views' . DS .'webroot' . DS);
define('IMAGES', WEBROOT . 'images' . DS);
define('JS', WEBROOT . 'js' . DS);
define('CSS', WEBROOT . 'css' . DS);
define('UPLOAD', DOCUMENT_ROOT . 'apps' . DS . 'upload' . DS);
define('UPLOAD_URL', BASE_URL . 'apps' . DS . 'upload' . DS);


// vendors
define('VENDORS', DOCUMENT_ROOT . 'vendors' . DS);
define('MODEL_UTILS', VENDORS . 'fxrialab' . DS . 'ModelUtils' . DS);
define('FACTORY_UTILS', VENDORS . 'fxrialab' . DS . 'FactoryUtils' . DS);
define('SERVICE_UTILS', VENDORS . 'fxrialab' . DS . 'ServiceUtils' . DS);
define('FACADE', VENDORS . 'fxrialab' . DS . 'Facade' . DS);
define('ORIENTDB', VENDORS . 'OrientDB' . DS);
define('AMQP', VENDORS . 'Amqp' . DS);
define('SYMFONY_LOADER', VENDORS . "Symfony/Component/ClassLoader" . DS);
//define ('AMQCONFIG', DOCUMENT_ROOT. 'vendors' . DS . 'php-amqplib' . DS. 'vendor'.DS);
// modules
define('MODULES', DOCUMENT_ROOT . 'apps' . DS . 'modules' . DS);
define('ROOT_MOD', BASE_URL . 'apps' . DS . 'modules' . DS);

define('CACHE_TIME', 3600);
?>```


