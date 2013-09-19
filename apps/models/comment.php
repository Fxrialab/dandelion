<?php
require_once('app_model.php');

class Comment extends AppModel {
	public function __construct() {
		parent::__construct('17', 'comment');
	}

	public function __destruct() {
		parent::__destruct();
	}
}