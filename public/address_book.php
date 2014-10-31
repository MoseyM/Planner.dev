<!-- NEED TO DO THE FOLLOWING: 1. FIX SYNTAX ON IF/ELSE(CHK) 2. GET ARRAY TO COMBINE AND PRINT OUT ON SCREEN 3. ADD DELETE KEY TO ADDRESS BOOK 4. UPDATE VARIABLES SO ADDRESSES IS USED APPROPRIATELY.-->

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<title> Address Book </title>
		<?php 
		// Use a CSV file to save to your list after each valid entry	
		$addresses = read();
		function read() {
			$fileLocation = './csv/addressBook.csv';
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

		function saveAddress($addresses) {
			$handle=fopen('/vagrant/sites/planner.dev/public/csv/addressBook.csv', 'w');
			
			foreach ($addresses as $addressArray => $value) {
				if(is_array($value)) {
					//writes to the file
					fputcsv($handle, $value);
				}
			}
			fclose($handle);
		}

			//check for a valid entry here...if/else
		function validityOfEntry() {
			$keysChecked = 0;
			if (!empty($_POST)) {
				foreach ($_POST as $key => $value) {
					if($key =='phone'){
					}
					elseif ((bool)$_POST[$key] == false) {
						echo "<p>Please enter your $key<p>";
					}
					else {
						++$keysChecked;
					}
				}
			if($keysChecked >= 5) {
				return $_POST;
			}
		}
	}

		//we are starting with what was saved in addressBook.csv, each time we reload.
		
		if (isset($_GET['id'])) {
					$index = $_GET['id'];
					unset($addresses[$index]);
					saveAddress($addresses);
		}

		//$newAddress is the new entry we collected by selecting "CompleteAddress" so we will only append to $addresses if pass validityOfEntry function.
		$newAddress = validityOfEntry();
		if ($newAddress == $_POST) {
			$addresses[] = $newAddress;
			saveAddress($addresses);
			
		}
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
				foreach ($addresses as $key => $address) {
					if(is_array($address) && !false && !null) {
						echo "<tr>";
							foreach ($address as $key2 => $value) {
								echo "<td> $value </td>";
							}
							//To add an X at the end of each row to delete the row
							echo "<td><a href=\"?id=$key\"> &#88; </a></td>";
						echo "</tr>";
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