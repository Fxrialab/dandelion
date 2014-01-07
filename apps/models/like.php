<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/27/13 - 10:29 AM
 * Project: userwired Network - Version: 1.0
 */
require_once('app_model.php');

class Like extends AppModel {
    public function __construct() {
        parent::__construct('21','like');
    }

    public function __destruct() {
        parent::__destruct();
    }
}

?>