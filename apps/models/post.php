<?php
/**
 * Created by fxrialab team
 * Author: Uchiha
 * Date: 8/29/13 - 4:07 PM
 * Project: userwired Network - Version: 1.0
 */
require_once ('app_model.php');
class Post extends AppModel
{
    public function __construct()
    {
        parent::__construct(12, 'post');
    }

    public function __destruct() {
        parent::__destruct();
    }
}