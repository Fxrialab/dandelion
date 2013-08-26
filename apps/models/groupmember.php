<?php
require_once('app_model.php');

class GroupMember extends AppModel
{
    public function __construct()
    {
        parent::__construct('23','groupmember');
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}
?>