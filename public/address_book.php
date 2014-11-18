<?php require_once '../includes/filestore.php' ;
require_once '../includes/AddressBookClasses.php'; 
$userAddresses = new AddressDataStore("../data/addressBookStore.csv");
// uploadFile() will only run when a file is uploaded through the browser
if(count($_FILES)> 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
	$userAddresses->uploadFile();
}
$userAddresses->addresses = $userAddresses->read();
if(!empty($_POST)){	
	$userAddresses->addresses = $userAddresses->validityOfEntry();
	$userAddresses->write($userAddresses->addresses); 
	$userAddresses->read();
}
//change to make it a jquery function. Should not use GET to change data
if(!empty($_GET['idx'])){
	$index = $_GET['idx'];
	unset($userAddresses->addresses[$index]);
	$userAddresses->write($userAddresses->addresses);
}?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="address_book.css">
		<title> Address Book </title>
		<?php 
			
		?>
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
			if (!empty($userAddresses->addresses)) {
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
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="moment.js"></script>
	</body>

</html>