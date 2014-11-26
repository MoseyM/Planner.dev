<?php

require_once 'parent.php';
$person = [];

class Person extends Parent {
	function insert() {
		$query = $dbc->prepare("INSERT INTO person ('firstname','lastname') VALUES (:firstname, :lastname)");
		foreach ($this->person as $key => $value) {
			if ($key == 'firstname') {
				$firstname = $value;
			} else {
				$lastname = value;
			}
		}
		$dbc->bindValue(':firstname', $firstname, PDO::PARAM_STR);
		$dbc->bindValue(':lastname', $lastname, PDO::PARAM_STR);
		$dbc->execute();
	}

	function delete() {
		
}