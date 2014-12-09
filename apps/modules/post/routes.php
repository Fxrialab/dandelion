<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/6/13 - 5:10 PM
 * Project: joinShare Network - Version: 1.0
 */
$url            = $_SERVER["REQUEST_URI"];
$params_full    = explode('/',$url);
$param          = explode('?',$params_full[count($params_full)-1]);

if ($params_full && count($params_full) > 3)
{
    $routeModuleConfigFile = MODULES.$params_full[2]."/RouteModuleConfig.php";
    if (file_exists($routeModuleConfigFile))
    {
        include $routeModuleConfigFile;
        // Call post module route
        $routeModuleConfig  = new RouteModuleConfig;
        $routes             = $routeModuleConfig->route;
        foreach ($routes as $key=>$value)
        {
            $params      = substr($key, 0, strpos($key, '_'));
            $method      = substr($key, strpos($key, '_') + 1);
            $controllers = explode(',', $value);

            if ($params == $param[0])
            {
                // Set route
                $function = $params;
                $f3->route($method." /content/post/".$params,
                    array(new $controllers[0], $function)
                );
            }
        }
    }
}

?>