<?php
require_once("app_model.php");

class Status extends AppModel {	

	public function __construct() {
		parent::__construct(9, "status");
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}
?>