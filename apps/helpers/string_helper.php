<?php
class StringHelper {
	public function __construct() {
	}

	function generateRandomString($len) {
		// get count of all required minimum special chars
		$base = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz123456789';
		$max = strlen($base) - 1;

		$random_str = '';
		mt_srand((double)microtime() * 1000000);
		
		while (strlen($random_str) < $len + 1)
			$random_str .= $base{mt_rand(0, $max)};

		return $random_str;
	}
	
	function replaceFirst($find, $replace, $subject) {
		// stolen from the comments at PHP.net/str_replace
		// Splits $subject into an array of 2 items by $find,
		// and then joins the array with $replace
		return implode($replace, explode($find, $subject, 2));
	}

}
