<!DOCTYPE html>
<? require_once 'includes/includeAddressBookClasses.php'; ?>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="address_book.css">
		<title> Address Book </title>
		<?php 
		if(count($_FILES)> 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
			if ($_FILES['file1']['type'] == 'text/csv') {
				$uploadDir = '/vagrant/sites/planner.dev/public/uploads/';
				// filename var is giving the file name with extension
				$filename = basename($_FILES['file1']['name']);
				$savedFilename = $uploadDir.$filename;
				//the file is saved temporarily so we are moving it from the temp location to a permanent location which file address and name with extension was creted with the $savedFilename var.
				move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);
				//need to create a new object for the new filename. File hasn't been converted to an array yet.
				$addresses2 = new AddressDataStore("uploads/".$filename);
				//converts info to an array.
				$addresses2->addresses = $addresses2->readAddressBook();
				$userAddresses->addresses = array_merge($userAddresses->addresses, $addresses2->addresses);
				$userAddresses->writeAddressBook();
			}
			else {
				echo "<p> Please attach a csv file</p>";
			}	
		}

		$userAddresses = new AddressDataStore('csv/addressBook.csv');
		$userAddresses->addresses = $userAddresses->readAddressBook();
		if(!empty($_POST)){	
			$userAddresses->addresses[] = $_POST;
			$userAddresses->writeAddressBook(); 
		}
		if(isset($_GET['idx'])){
			$index = $_GET['idx'];
			unset($userAddresses->addresses[$index]);
			$userAddresses->writeAddressBook();
		}
		?>
	</head>
	<body class="container-fluid">
	<h1 id="header">Address Book</h1>
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
			if (isset($userAddresses->addresses) && !empty($userAddresses->addresses)) {
				foreach ($userAddresses->addresses as $key => $address) {
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
		<div id="formDesign">
		<form class="form" method="POST" action="address_book.php">
			<div class="form-group">
				<label for="name">Name: </label>
				<input id="name" class="form-control inputWidth" name="name" type="text">
			</div>

			<div class="form-group">			
				<label for="address">Address: </label>
				<input id="address" class="form-control inputWidth" name="address" type="text">
			</div>

			<div class="form-group">
				<label for="city">City: </label>
				<input id="city" class="form-control inputWidth" name="city" type="text">
			</div>

			<div class="form-group">
				<label for="state">State: </label>
				<input id="state" class="form-control inputWidth"  name="state" type="text">
			</div>

			<div class="form-group">
				<label for="zip">Zip: </label>
				<input id="zip" class="form-control inputWidth" name="zip" type="text">
			</div>

			<div class="form-group">
				<label for="phone">Phone: </label>
				<input id="phone" class="form-control inputWidth"  name="phone" type="text">
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">CompleteAddress</button>
			</div>
		</form>
	</div>
	<div>
		<form method="POST" enctype="multipart/form-data" action="todo_list.php">
			<input type="file" class="fileKeys" id="file1" name="file1">
			<input type="submit" class="fileKeys" value="SendFile">
		</form>
	</div>
</div> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="moment.js"></script>
	</body>

</html>