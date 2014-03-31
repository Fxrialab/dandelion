<?php

class ExtraConfig
{

    static public function getId($className)
    {
        include CONFIG . "OrientDBCC.php";
        return $map[$className];
    }
}