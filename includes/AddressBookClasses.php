<?php
class AddressDataStore extends Filestore 
{
	public $addresses;
	public function __construct($filename){
		parent::__construct(strtolower($filename));
	}

	function validityOfEntry() 
	{
		$addresses = $this->addresses;
		$keysChecked = 0;
		if (!empty($_POST)) {
			foreach ($_POST as $key => $value) {
				if ($value == false && $key !='phone') {
					echo "<p>Please enter your $key<p>";
				} else {
					++$keysChecked;
				}
			}
			if($keysChecked >= 5) {
				$addresses[]=$_POST;
			}
			return $addresses;
		}
	}

	function uploadFile() 
	{
		if ($_FILES['file1']['type'] == 'text/csv') {
			$uploadDir = '/vagrant/sites/planner.dev/public/uploads/';
			// filename var is giving the file name with extension
			$filename = basename($_FILES['file1']['name']);
			$savedFilename = $uploadDir.$filename;
			//the file is saved temporarily so we are moving it from the temp location to a permanent location which file address and name with extension was creted with the $savedFilename var.
			move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);
			//need to create a new object for the new filename. File hasn't been converted to an array yet.
			$addresses2 = new Filestore("uploads/".$filename);
			//converts info to an array.
			$addresses2->addresses = $addresses2->readLines();
			$userAddresses->addresses = array_merge($userAddresses->addresses, $addresses2->addresses);
			$userAddresses->writeLines();
		}
		else {
			echo "<p> Please attach a csv file</p>";
		}	
	}
}
