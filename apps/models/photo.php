<?php
require_once('app_model.php');

class Photo extends AppModel {
	public function __construct() {
		parent::__construct('14', 'photo');
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}