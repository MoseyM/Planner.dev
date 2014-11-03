<!DOCTYPE html>
<? require_once 'includes/includeAddressBookClasses.php'; ?>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<title> Address Book </title>
		<?php 
		//this will handle reading and writing to the data file.
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
		$userAddresses = new AddressDataStore('csv/addressBook.csv');
		$addresses = $userAddresses->readAddressBook();
		if(!empty($_POST)){	
			$addresses = validityOfEntry($addresses);
			$userAddresses->writeAddressBook($addresses); 
		}
		if(isset($_GET['idx'])){
			$index = $_GET['idx'];
			unset($addresses[$index]);
			$userAddresses->writeAddressBook($addresses);
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
			if (isset($addresses) && !empty($addresses)) {
				foreach ($addresses as $key => $address) {
					echo "<tr>";
						foreach ($address as $key2 => $value) {
							echo "<td> $value </td>";
						}
					echo "<td><a href=\"?idx=$key\"> &#88; </a></td>";
					echo "</tr>";
					}
			}?>
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