<?php
class AddressDataStore {
	public $filename = '';
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
    public function writeAddressBook($addresses) {
         // Code to write $addressesArray to file $this->filename
     	$handle=fopen($this->filename, 'w');
		if($addresses){
		foreach ($addresses as $addressArray => $value) {
			if(is_array($value)) {
				//writes to the file
				fputcsv($handle, $value);
			}
		}
	}
		fclose($handle);
    }
}
