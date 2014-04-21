<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FactoryUtils
{

    var $params = array();


    static function element($element, $params = array())
    {
        if (!empty($params))
        {
            foreach ($params as $key => $value)
            {
                include MODULES . $value . '/info.php';
                if (file_exists(MODULES . $value . '/views/elements/' . $element . '.php'))
                {
                    if (file_exists(MODULES . $value . '/controllers/Element' . $value . 'Controller.php'))
                    {
                        require_once MODULES . $value . '/controllers/Element' . $value . 'Controller.php';
                    }
                    require_once MODULES . $value . '/views/elements/' . $element . '.php';
                }
            }
        }
        else
        {
            if (file_exists(UI . ELEMENTS . $element . '.php'))
            {
                require(UI . ELEMENTS . $element . '.php');
            }
        }
    }

}

?>
