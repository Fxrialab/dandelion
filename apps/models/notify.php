<?php
require_once('app_model.php');
class Notify extends AppModel
{
    public function __construct()
    {
        parent::__construct(12, 'notify');
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}

?>