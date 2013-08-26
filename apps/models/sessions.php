<?php
require_once ('app_model.php');
class Sessions extends AppModel {
    public function __construct() {
        parent::__construct(20, 'sessions');
    }

    public function __destruct() {
        parent::__destruct();
    }
}

?>