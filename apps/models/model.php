<?php
require_once CONFIG."database.php";
require_once MODEL_UTILS."impl/".DBTYPE."_Model.php";

class Model
{
    public static function get($colName)
    {
        $dbModel = DBTYPE.'_Model';
        $impl = new $dbModel;
        $impl->setTarget($colName);
        return $impl;
    }
}