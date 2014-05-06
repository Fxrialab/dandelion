<?php
require_once CONFIG."Database.php";
require_once MODEL_UTILS . "impl/" . DBTYPE . "Model.php";

class Model
{
    public static function get($colName)
    {
        $dbModel = DBTYPE.'Model';
        $impl = new $dbModel;
        $impl->setTarget($colName);
        return $impl;
    }
}