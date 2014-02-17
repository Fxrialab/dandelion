<?php
/**
 * Created by JetBrains PhpStorm.
 * User: King
 * Date: 9/4/13
 * Time: 9:45 AM
 * To change this template use File | Settings | File Templates.
 */
require_once ('app_model.php');
class Permission extends AppModel {
    public function __construct() {
        parent::__construct(23, 'permission');
    }

    public function __destruct() {
        parent::__destruct();
    }
}

?>