<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 9/12/13 - 3:09 PM
 * Project: userwired Network - Version: 1.0
 */
require_once ('app_model.php');
class Actions extends AppModel
{
    public function __construct()
    {
        parent::__construct(19, 'actions');
    }

    public function __destruct() {
        parent::__destruct();
    }
}
?>