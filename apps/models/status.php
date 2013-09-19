<?php
require_once("app_model.php");

class Status extends AppModel {	

	public function __construct() {
		parent::__construct(11, "status");
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}
?>