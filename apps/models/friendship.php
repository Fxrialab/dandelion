<?php
require_once('app_model.php');

class Friendship extends AppModel {
	public function __construct() {
		parent::__construct('11', 'friendship');
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}