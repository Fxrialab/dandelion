<?php
// orientdb-php don't have prepare statement features, so I decide to implement a simple helper 
// to deal with sql injection
class SecurityHelper {
	public function __construct() {

	}
	
	public function postOut($str) {
		$str = str_replace("&#39;", "'", $str);
		$str = str_replace("&#34;", '"', $str);
		return $str;
	}
	
	public function postIn($str) {
		$str = str_replace("'", "&#39;", $str);
		$str = str_replace('"', "&#34;", $str);
		$str = $this->mysslashes($str);
		$str = $this->mutate($str);
		return $str;
	}

	protected function mysslashes($text) {
		$text = str_replace("\\\"", "\"", $text);
		$text = str_replace("\\\\", "\\", $text);
		$text = str_replace("\\'", "'", $text);
		$text = str_replace("\t", "", $text);
		return $text;
	}

	protected function mutate($text) {
		$text = htmlspecialchars($this->mysslashes($text));
		return $text;
	}

}
?>