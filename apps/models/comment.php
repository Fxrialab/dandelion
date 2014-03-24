<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/29/13 - 4:35 PM
 * Project: userwired Network - Version: 1.0
 */
require_once('app_model.php');
class Comment extends AppModel
{
    public function __construct()
    {
        parent::__construct(15, 'comment');
    }

    public function __destruct()
    {
        parent::__destruct();
    }
}