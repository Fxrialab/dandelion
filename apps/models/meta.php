<?php
require_once('app_model.php');

class Meta extends AppModel {
	public function __construct() {
		// @todo: complete model, add cluster id for meta here 
		parent::__construct('', 'meta');
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}