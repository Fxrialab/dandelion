<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/5/13 - 10:06 AM
 * Project: UserWired Network - Version: beta
 */
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

?>
