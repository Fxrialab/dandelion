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
        }else
            return false;
    }

    public function elementModule($elementPath, $module)
    {

    }
}

?>
