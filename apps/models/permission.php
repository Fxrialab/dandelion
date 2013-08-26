<?php
require_once('app_model.php');

class Permission extends AppModel {
    public function __construct() {
        parent::__construct('19', 'permission');
    }

    public function __destruct() {
        parent::__destruct();
    }
}