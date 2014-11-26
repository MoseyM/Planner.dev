<?php

require_once 'parent.php';
$address = [];

class Person extends Parent {
	function insert() {
		$query = $dbc->prepare("INSERT INTO person ('email', 'phone', 'address', 'city', 'state', 'zip') VALUES (:email, :phone, :address, :city, :state, :zip)");
		foreach ($address as $key => $value) {
			if ($key == 'email') {
				$email = $value;
			} elseif ($key == 'phone') {
				$phone = $value;	
			} elseif ($key == 'address') {
				$address = $value;
			} elseif ($key == 'city') {
				$city = $value;
			} elseif ($key == 'state') {
				$state = $value;
			} elseif ($key == 'zip') {
				$zip = $value;
			}
		}
		$dbc->bindValue(':email', $email, PDO::PARAM_STR);
		$dbc->bindValue(':phone', $phone, PDO::PARAM_STR);
		$dbc->bindValue(':address', $address, PDO::PARAM_STR);
		$dbc->bindValue(':city', $city, PDO::PARAM_STR);
		$dbc->bindValue(':state', $state, PDO::PARAM_STR);
		$dbc->bindValue(':zip', $zip, PDO::PARAM_STR);
		$dbc->execute();
	}

}