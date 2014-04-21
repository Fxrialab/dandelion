<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ElementPhotoController extends AppController
{

    static public function postWrap()
    {
        return array('3' => 'ba', '4' => 'bon');
    }

}
