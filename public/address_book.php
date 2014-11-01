<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<title> Address Book </title>
		<?php 
		//this will handle reading and writing to the data file.
		class AddressDataStore {
			public $filename = '';
			public function __construct($filename) {
				$this->filename = $filename;
			}

		    public function readAddressBook() {
		     	$fileLocation = $this->filename;
				$handle = fopen($fileLocation, 'r');
				$addressBook = [];
				//feof will put our pointer at the end of the file. so this condition checks to make sure we are not at the end.
				while (!feof($handle)) {
					//setting a variable equal to each line of the csv file
					$row = fgetcsv($handle);
					//below we are chking to make sure the row is not empty. and if not we are adding it $row to the array declared above $addressBook
					$addressBook[] = $row;
					if (is_null($row)) {
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

		$userAddresses = new AddressDataStore('csv/addressBook.csv');
		$addresses = $userAddresses->readAddressBook();
		//will delete once link is pressed.
		if(isset($_GET['id'])) {
			$index = $_GET['id'];
				// This will delete the selected todo item
				unset($addresses[$index]);
				$userAddresses->writeAddressBook($addresses); 
			}

		//check for a valid entry here...if/else
		function validityOfEntry($addresses) {
			$keysChecked = 0;
			if (!empty($_POST)) {
				foreach ($_POST as $key => $value) {
					if($key =='phone'){
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
		$addresses = validityOfEntry($addresses);
		$userAddresses->writeAddressBook($addresses); 

		
		

		//$newAddress is the new entry we collected by selecting "CompleteAddress" so we will only append to $addresses if pass validityOfEntry function.
		
		?>
	</head>
	<body class="container-fluid">

	<!-- Created table to output the information submitted through the form for the address book -->
		<table class="table table-striped">
			<tr>
				<th>Name</th>
				<th>Address</th>
				<th>City</th>
				<th>State</th>
				<th>Zip</th>
				<th>Phone</th>
				<th>Delete?</th>
			</tr>

			<?php
			if (isset($addresses) && !empty($addresses)) {
				foreach ($addresses as $key => $address) {
					if(is_array($address) && !false && !null) {
						echo "<tr>";
							foreach ($address as $key2 => $value) {
								echo "<td> $value </td>";
							}
							//To add an X at the end of each row to delete the row
							// <a href=\"?id=$key\"> &#88; </a>
							echo "<td><a href=\"?id=$key\"> &#88; </a></td>";
						echo "</tr>";
					}
				}
			}	
			?>
		</table>
	
		<!-- Create a form that will ask for name, address, city, state, zip, and phone. -->
		<form class="form" method="POST" action="address_book.php">
			<div class="form-group">
				<label for="name">Name: </label>
				<input id="name" class="form-control" name="name" type="text">
			</div>

			<div class="form-group">			
				<label for="address">Address: </label>
				<input id="address" class="form-control" name="address" type="text">
			</div>

			<div class="form-group">
				<label for="city">City: </label>
				<input id="city" class="form-control" name="city" type="text">
			</div>

			<div class="form-group">
				<label for="state">State: </label>
				<input id="state" class="form-control"  name="state" type="text">
			</div>

			<div class="form-group">
				<label for="zip">Zip: </label>
				<input id="zip" class="form-control" name="zip" type="text">
			</div>

			<div class="form-group">
				<label for="phone">Phone: </label>
				<input id="phone" class="form-control"  name="phone" type="text">
			</div>

			<div class="form-group">
				<input type="submit" value="CompleteAddress">
			</div>
		</form>
	</div> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>

</html>