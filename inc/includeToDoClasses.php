<?php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'ToDo_List');
define('DB_USER','queen');
define('DB_PASS','password');

require 'db_connect.php';

class ToDoLister extends PDO{
	public $fileLocation = "";
	public $list = [];
	public function __construct($fileLocation) {
				$this->fileLocation = $fileLocation;
		}

	function readFile() {
		
	}

	function writeToFile() {
		$list = $this->list;
		$fileLocation = $this->fileLocation;
		$handle = fopen($fileLocation, 'w');
		
		// $list = $this->sanitize($list);
		foreach($list as $eachSet) {
			fputcsv($handle, $eachSet);
		}
		fclose($handle);
	}
	function sanitize($list){
		$list = $this->list;
		foreach($list as $key=> $value) {
			$list[$key] = htmlspecialchars(strip_tags($value));
		}
		return $list;
	}
}