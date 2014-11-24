<?php
	define('DB_HOST', '127.0.0.1');
	define('DB_NAME', 'addressBook');
	define('DB_USER','queen');
	define('DB_PASS','password');

	require 'inc/db_connect.php';

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$dbc->exec("
	UPDATE TABLE addresses(
		email VARCHAR(50),
		phone INT(10),
		address VARCHAR(290),
		city VARCHAR(50),
		state CHAR(2),
		zip INT
		)
	");
?>