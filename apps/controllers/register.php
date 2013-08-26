<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 12/20/12
 * Project: UserWired Network - Version: beta
 */
require_once(CONFIG . 'moduleConfig.php');

class Register extends Base
{
    static private $modulesMap;
    static public function getAllModule(){
        if(Register::$modulesMap == null){
            Register::$modulesMap = array();

            //read from configModule.php
            $infoModule= ModulesConfig();

            foreach($infoModule as $module){
                Register::$modulesMap[] =array('func'=> $module['func'],'controller'=>$module['controller'],'viewPath'=>$module['viewPath']);
            }
        }
        return Register::$modulesMap;
    }

    static function getModule($type)
    {
        $infoModule= getViewPath();
        foreach($infoModule as $viewPath){
            if($viewPath['type']==$type)
            {
                Register::$modulesMap[] =array('viewPath'=>$viewPath['viewPath']);
            }
        }
        return Register::$modulesMap;
    }

    static function getPathModule($type)
    {
        $infoModule= getViewPath();

        foreach($infoModule as $viewPath){
            if($viewPath['type']==$type)
            {
                Register::$modulesMap =  $viewPath['viewPath'];
            }
        }

        return Register::$modulesMap;
    }

}
?>