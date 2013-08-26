<?php
require_once('app_model.php');

class Group extends AppModel
{
    public function __construct()
    {
        parent::__construct('22','group');
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
?>