<?php
require_once("app_model.php");

class Answer extends AppModel {

    public function __construct() {
        parent::__construct(16, "answer");
    }

    public function __destruct() {
        parent::__destruct();
    }
}
?>