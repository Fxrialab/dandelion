<?php
require_once ('app_model.php');
class User extends AppModel
{
	public function __construct()
    {
		parent::__construct(10, 'user');
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}