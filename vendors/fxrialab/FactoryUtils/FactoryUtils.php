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

    static public function elementModule($element, $module)
    {
        $pathMod = Register::getModule($module);
        if (file_exists(MODULES  .$pathMod[0]['viewPath'].'elements/'. $element . '.php'))
        {
            $get = 'get' . $element;
            $elementController = 'Element'.ucfirst($module).'Controller';
            $element = new $elementController;
            return $element->$get();
        }else
            return false;
    }
}

?>
