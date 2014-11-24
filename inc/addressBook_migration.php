<?php
	define('DB_HOST', '127.0.0.1');
	define('DB_NAME', 'addressBook');
	define('DB_USER','queen');
	define('DB_PASS','password');

	require 'db_connect.php';

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";
$dbc->exec("
	CREATE TABLE person(
		id INT NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(id),
		firstname VARCHAR(90) NOT NULL,
		lastname VARCHAR(90) NOT NULL,
		)
	");
?>