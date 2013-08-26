<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/5/13 - 10:01 AM
 * Project: UserWired Network - Version: beta
 */
class ModuleController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function content()
    {
        $url            = $_SERVER["REQUEST_URI"];
        $params_full    = explode('/',$url);
        $lastParams     = explode('?',$params_full[count($params_full)-1]);
        $param          = $lastParams[0];
        $mod            = null;
        $modules        = Register::getAllModule();

        foreach($modules as $module)
        {
            if($module['func'] == $param)
            {
                $mod = $module;
                break;
            }
        }
        if($mod != null)
        {
            $controllerClass = $mod['controller'];
            //$autoloader = new ClassAutoloader();
            $modController = new $controllerClass;
            if(method_exists($modController,$mod['func']))
            {
                $viewPath =$mod['viewPath'];
                $modController->$mod['func']($viewPath);
            }
        }
    }
}

?>