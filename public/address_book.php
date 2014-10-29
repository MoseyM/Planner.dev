<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="/address_book.css">
		<title> Address Book </title>
		<? 
		// Use a CSV file to save to your list after each valid entry.
		$addresses = [
		    ['The White House', '1600 Pennsylvania Avenue NW', 'Washington', 'DC', '20500'],
		    ['Marvel Comics', 'P.O. Box 1527', 'Long Island City', 'NY', '11101'],
		    ['LucasArts', 'P.O. Box 29901', 'San Francisco', 'CA', '94129-0901']
		];		
		function saveAddress($addresses) {
			$handle=fopen('/vagrant/sites/planner.dev/public/csv/addressBook.csv', 'w');
			foreach ($addresses as $addressArray => $value) {
				fputcsv($handle, $value);
			}
			fclose($handle);
		}

			//check for a valid entry here...if/else
		function validityOfEntry() {
			if (isset($_POST)) {
				$inputIncluded = 0;
				foreach ($_POST as $key => $value) {
					if(!empty($_POST[$key]) && isset($_POST[$key])) {
						$inputIncluded++;
					}
				}
					if ($inputIncluded = 5) {
						return $_POST;
					}
					else {
						echo "Missing Information. Please enter all required information";
					}
			}
		}
		
		//function to update the table with new adresses
		// function updateAddressList($addresses) {
		// 	foreach ($addresses as $key => $value) {
		// 		foreach ($value as $word) {
		// 			echo $word;
		// 		}
		// 	}
		// }

		$addresses[] = validityOfEntry();
		saveAddress($addresses);	
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
			</tr>

			<tr>

				<? foreach ($addresses as $key => $address): ?>
					<tr>
					<!-- once we move forward can remove this and just have the nested foreach -->
						<? if(is_array($address)):
							foreach ($address as $value): ?>
								<td> <?= $value; ?> </td>
						<? endforeach 
						;
						else: ?>
							<td> <?= $address; ?> </td>
							<? endif; ?>
					</tr>
				<? endforeach ?>
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

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>

</html>