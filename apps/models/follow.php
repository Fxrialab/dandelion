<?php
require_once('app_model.php');

class Follow extends AppModel {
    public function __construct() {
        parent::__construct('19','follow');
    }

    public function __destruct() {
        parent::__destruct();
    }
}

?>