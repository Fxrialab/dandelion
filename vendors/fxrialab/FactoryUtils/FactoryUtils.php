<?php

class FactoryUtils
{

    public function element($param)
    {
        if (file_exists(ELEMENTS . $param . '.php'))
        {
            require_once(ELEMENTS . $param . '.php');
            $get = 'get' . $param;
            $element = new $param;
            return $element->$get();
        } else
            return false;
    }

    static public function elementModule($param, $module)
    {
        if (file_exists(MODULES . $module . '/elements/' . $param . '.php'))
        {
            require_once MODULES . $module . '/elements/' . $param . '.php';
            $get = 'get' . $param;
            $element = new $param;
            return $element->$get();
        } else
            return false;
    }

}

?>
