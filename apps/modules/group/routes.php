<?php

/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/6/13 - 5:10 PM
 * Project: joinShare Network - Version: 1.0
 */

$url = $_SERVER["REQUEST_URI"];
$params_full = explode('/', $url);
$lastParams = explode('?', $params_full[count($params_full) - 1]);
$param = $lastParams[0];
if (!empty($params_full))
{
    include MODULES . $params_full[2] . "/controllers/AjaxController.php";

    $routeModuleConfig = new RouteModuleConfig;

    $routes = $routeModuleConfig->route;

    foreach ($routes as $key => $value)
    {

        $params = substr($key, 0, strpos($key, '_'));
        $method = substr($key, strpos($key, '_') + 1);
        $controllers = explode(',', $value);

        $f3->route($method . " /content/group/" . $params, array(new $controllers[0], $params));
        $f3->route($method . " /content/group/ajax/" . $params, array(new $controllers[0], $params));
//            }
    }
}

class RouteModuleConfig
{

    public $route = array(
        'create_POST|GET' => "GroupController",
        'loading_POST' => "GroupController",
        'successGroup_POST' => "GroupController",
        'editDescription_POST' => "GroupController",
        'joinGroup_POST' => "GroupController",
        'groupSuccess_POST' => "GroupController",
        'saveCover_POST' => "GroupController",
        'cancelCover_POST' => "GroupController",
        'choosePhoto_POST|GET' => "GroupController",
        'uploadCover_POST' => "GroupController",
        'search_POST' => "GroupController",
        'leave_POST|GET' => "GroupController",
        'addFriend_POST|GET' => "AjaxController",
        'searchFriends_POST' => "AjaxController",
        'addMemberGroup_POST' => "AjaxController",
        'removeGroup_POST' => "AjaxController",
        'comfirmRemoveGrorup_POST' => "AjaxController",
        'rolegroup_POST' => "AjaxController",
        'removeAdmin_POST' => "AjaxController",
        'comfirmrole_POST' => "AjaxController",
        'comfirmcover_POST' => "AjaxController",
        'reposition_POST' => "GroupController",
        'remove_POST' => "GroupController",
        'photoBrowser_GET' => "AjaxController",
        'changePhoto_GET' => "AjaxController",
    );

}

?>