<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FactoryUtils
{

    public function element($param)
    {
        if (file_exists(ELEMENTS . $param . '.php'))
        {
            require_once(ELEMENTS . $param . '.php');
            $get = 'get' . $param;
            $element = new $param;
            $element->$get();
        }
    }

}

class ViewHtml
{
    static function render($param, $array = array())
    {
        if (file_exists(UI . LAYOUTS . $param . '.php'))
        {
            foreach ($array as $k => $value)
            {
                F3::set($k, $value);
            }
            require(UI . LAYOUTS . $param . '.php');
        }
    }

}

?>
