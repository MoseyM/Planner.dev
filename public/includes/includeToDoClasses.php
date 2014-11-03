<?php

class ToDoLister {
	public $fileLocation = "";
	public $list = [];
	public function __construct($fileLocation) {
				$this->fileLocation = $fileLocation;
			}
	function openFile() {
		$fileLocation = $this->fileLocation;
	    $handle = fopen($fileLocation, 'r');
	   	//checking to make sure a file is present before reading it and saving to an array.
	   	$newinfo = [];
	    if (file_exists($fileLocation) && filesize($fileLocation)>0) {
		    while (!feof($handle)) {
					//setting a variable equal to each line of the csv file
					$row = fgetcsv($handle);
					//below we are chking to make sure the row is not empty. and if not we are adding it $row to the array declared above $addressBook
					if ($row) {
						$newinfo[] = $row; 
					}  
			}
		}
	    fclose($handle);
	    return $newinfo;
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