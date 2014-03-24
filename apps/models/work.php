<?php
require_once('app_model.php');
class Work extends AppModel
{
    public function __construct()
    {
        parent::__construct(25, 'work');
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}