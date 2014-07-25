<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FactoryUtils
{

    var $params = array();

    static function element($element)
    {
        if (file_exists(UI . LAYOUTS . ELEMENTS . $element . '.php'))
        {
            require(UI . LAYOUTS . ELEMENTS . $element . '.php');
        }
    }

}

?>
