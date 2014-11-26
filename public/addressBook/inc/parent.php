<?php

abstract class Parent {
	function __construct($dbc, $id) {
		$this->dbc = $dbc;
		$this->id = $id;
	}

	protected abstract function insert(); 
	protected abstract function delete();




























	// function sortDetails() {
	// foreach ($_POST as $key => $i) {
	// 	if(!empty($i)) {
	// 		if ($_POST[$key] == 'firstname' || $_POST[$key] == 'lastname') {
	// 			continue;
	// 		}
	// 		$i = $i;
	// 	} else {
	// 		$i = null;
	// 	}
	// }
	// $person = array_slice($_POST, 0, 2);
	// $address = array_slice($_POST, 2);
	// add($person, $address);
	// }

	// function add($p, $a) {
	// 	$query = $dbc->prepare("INSERT INTO person(firstname, lastname)
	// 	VALUES (:firstname, :lastname");
	// 	$dbc->bindvalue(':firstname', $p[0], PDO::PARAM_STR);
	// 	$dbc->bindvalue(':lastname', $p[1], PDO::PARAM_STR);
	// 	$dbc->exec($query);
	// 	$id = $dbc->lastInsertId();

	// 	addressId = PDO::fetchColumn($id);
	// 	$queri = $dbc->prepare("INSERT INTO addresses('address','city','state','zip', 'email', 'phone') VALUES (:address, :city, :state, :zip, :email, :phone)";
	// 	$dbc->bindvalue(':address', $a[0], PDO::PARAM_STR);
	// 	$dbc->bindvalue(':city', $a[1], PDO::PARAM_STR);
	// 	$dbc->bindvalue(':state', $a[2], PDO::PARAM_STR);
	// 	$dbc->bindvalue(':zip', $a[3], PDO::PARAM_STR);
	// 	$dbc->bindvalue(':email', $a[4], PDO::PARAM_STR);
	// 	$dbc->bindvalue(':phone', $a[5], PDO::PARAM_STR);
		
	// 	}

?>