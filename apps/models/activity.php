<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/29/13 - 4:31 PM
 * Project: userwired Network - Version: 1.0
 */
require_once ('app_model.php');
class Activity extends AppModel
{
    public function __construct()
    {
        parent::__construct(14, 'activity');
    }

    public function __destruct() {
        parent::__destruct();
    }
}