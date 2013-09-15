<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/29/13 - 3:39 PM
 * Project: userwired Network - Version: 1.0
 */
require_once ('app_model.php');
class Notify extends AppModel
{
    public function __construct()
    {
        parent::__construct(11, 'notify');
    }

    public function __destruct() {
        parent::__destruct();
    }
}