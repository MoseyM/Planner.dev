<?php
	define('DB_HOST', '127.0.0.1');
	define('DB_NAME', 'ToDo_List');
	define('DB_USER','queen');
	define('DB_PASS','password');

	require 'db_connect.php';

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";
$dbc->exec("
	CREATE TABLE ToDo_List(
		id INT NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(id),
		todo VARCHAR(90),
		due_date DATE,
		priority INT
		)
	");
?>