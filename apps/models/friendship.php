<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/29/13 - 4:39 PM
 * Project: userwired Network - Version: 1.0
 */
require_once ('app_model.php');
class FriendShip extends AppModel
{
    public function __construct()
    {
        parent::__construct(17, 'friendship');
    }

    public function __destruct() {
        parent::__destruct();
    }
}