<?php

class ExtraConfig
{
    static public function getId($className)
    {
        require_once CONFIG."orientDBCC.php";

        return $map[$className];
    }
}