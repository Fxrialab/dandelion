<?php
require_once("app_model.php");

class Question extends AppModel {

    public function __construct() {
        parent::__construct(15, "question");
    }

    public function __destruct() {
        parent::__destruct();
    }
}
?>