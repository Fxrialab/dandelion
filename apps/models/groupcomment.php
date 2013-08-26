<?php
require_once('app_model.php');

class GroupComment extends AppModel
{
    public function __construct()
    {
        parent::__construct('25','groupcomment');
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
?>