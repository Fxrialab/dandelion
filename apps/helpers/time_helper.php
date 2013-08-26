<?php
class TimeHelper {
	public function __construct() {}
	
	public function getTommorrow() {
		return mktime(0, 0, 0, date("m") , date("d")+1, date("Y"));
	}
}