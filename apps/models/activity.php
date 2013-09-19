<?php
require_once('app_model.php');

class Activity extends AppModel {
	public function __construct() {
		parent::__construct('18', 'activity');
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}