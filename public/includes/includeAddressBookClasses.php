<?php
class AddressDataStore {
	public $filename = '';
	public $addresses = [];

	public function __construct($filename) {
		$this->filename = $filename;
	}
    public function readAddressBook() {
     	$fileLocation = $this->filename;
		$handle = fopen($fileLocation, 'r');
		$addressBook = [];
		while(!feof($handle)) {
		    $row = fgetcsv($handle);
		    if (!empty($row)) {
		        $addressBook[] = $row;
		    }
		}
		fclose($handle);
		return $addressBook;
    }
    public function writeAddressBook() {
         // Code to write $addressesArray to file $this->filename
    	$addresses = $this->addresses;
     	$handle=fopen($this->filename, 'w');
     	$this->validityOfEntry();
		foreach ($addresses as $addressArray => $value) {
			if(is_array($value)) {
				//writes to the file
				fputcsv($handle, $value);
		}
	}
		fclose($handle);
    }
    //this will handle reading and writing to the data file.
	function validityOfEntry() {
		$addresses = $this->addresses;
		$keysChecked = 0;
		if (!empty($_POST)) {
			foreach ($_POST as $key => $value) {
				if($key =='phone') {
					}
				elseif ($value == false) {
					echo "<p>Please enter your $key<p>";
				}
				else {
					++$keysChecked;
				}
			}
			if($keysChecked >= 5) {
				$addresses[]=$_POST;
			}
			return $addresses;
		}
	}
}
