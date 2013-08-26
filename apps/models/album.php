<?php
require_once('app_model.php');

class Album extends AppModel {
	public function __construct() {
		parent::__construct('13', 'album');
	}
	
	public function __destruct() {
		parent::__destruct();
	}
}