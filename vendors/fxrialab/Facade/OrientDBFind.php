<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class OrientDBFind {

    static public function group($id) {
        $model = Model::get('group')->findByPk($id);
        return $model;
    }
    
    static public function user($id){
        $model = Model::get('user')->findByPk($id);
        return $model;
    }

}

?>
