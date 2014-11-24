addressBook_seeder.php

<?php 
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'ToDo_List');
define('DB_USER','queen');
define('DB_PASS','password');

require 'inc/db_connect.php';

	$delQuery = "DELETE FROM ToDo_List";
	$numRows = $dbc->exec($delQuery);
	echo "Deleted $numRows rows\n";

// foreach($parks as $values) {
// 	$query = "INSERT INTO national_parks(name,location,date_established,area_in_acres, description) VALUES('{$values['name']}','{$values['location']}','{$values['date_established']}','{$values['area_in_acres']}','{$values['description']}')";
// 	$dbc->exec($query);
// 	echo "Inserted id: ".$dbc->lastInsertId().PHP_EOL;
// }

echo PHP_EOL.PHP_EOL;



?>