<?php

class Model
{
    public static function get($colName)
    {
        autolod(DBTYPE . "_Model");
        $impl = new DBTYPE . "_Model";
        $impl->setTarget($colName);
        return $impl;
    }
}