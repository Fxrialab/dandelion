<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 7/30/13 - 8:58 AM
 * Project: UserWired Network - Version: beta
 */
require_once (CONTROLLERS . "appController.php");
require_once (CONTROLLERS . "elementController.php");

/*F3::route('GET /min',
    function() {
        Web::minify($_GET['base'],explode(',',$_GET['files']));
    },
    CACHE_TIME
);*/

$url            = $_SERVER["REQUEST_URI"];
$params_full    = explode('/',$url);
//var_dump($params_full);
$lastParams     = explode('?',$params_full[count($params_full)-1]);
$param          = $lastParams[0];

if ($params_full)
{
    $routeConfigFile = CONFIG.'routeConfig.php';
    if (file_exists($routeConfigFile))
    {
        include $routeConfigFile;
        $routeConfig    = new RouteConfig;
        $routes         = $routeConfig->default;
        if ($param == '')
        {
            echo 'index page <br />';
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
                    F3::route($method." /".$params,
                        array(new $controllers[0], $function)
                    );
                }
            }
        }else{
            if (count($params_full) > 1 && $params_full[1] == 'content')
            {
                //echo 'modules route <br />';
                $modules = $routeConfig->modules;
                $registerFile   = CONTROLLERS.'register.php';
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
                                $moduleFile = CONTROLLERS.'moduleController.php';
                                $function = 'content';
                                if (file_exists($moduleFile))
                                {
                                    require_once $moduleFile;
                                    F3::route('GET|POST /content/*',
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
                            // load all modules in home page
                            if ($controller == 'homeController')
                            {
                                foreach (glob(MODULES."*/controllers/*.php") as $modulesControllerFile){
                                    require_once $modulesControllerFile;
                                    //echo $modulesControllerFile."<br />";
                                }
                                $registerFile   = CONTROLLERS.'register.php';
                                if (file_exists($registerFile))
                                    require_once $registerFile;
                            }
                        }
                        // Set route
                        $function = $params;
                        F3::route($method." /".$params,
                            array(new $controllers[0], $function)
                        );
                    }
                }
            }

        }
    }
}else {
    //add notify error HTTP 404
}

?>