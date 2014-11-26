<?php 
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'ToDo_List');
define('DB_USER','queen');
define('DB_PASS','password');

require '../includes/db_connect.php';
//this will return the information from our todo database into an array.
function get_Data($dbc) {
	$query = "SELECT * FROM ToDo_List ORDER BY todo LIMIT 10";
	$stmt = $dbc->query($query);
	return $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
function send_Data($array, $dbc) {
		$query = "INSERT INTO ToDo_List(todo, due_date, priority) VALUES({$array['todo']},{$array['due_date']},{$array['priority']})";
		$dbc->exec($query);
		}

function changeDate($string) {
	$newTime = strtotime($string);
	return $newTime;
}
//-----------------------------
$todoList = get_Data($dbc);
	if(!empty($_POST)) {
		if (strlen($_POST['todo']) > 240 || empty($_POST['todo'])) {
			throw new Exception('Please provide a Todo Item less than 256 characters.');	
		}
		if(!empty($_POST['due_date'])) {
			$_POST['due_date'] = changeDate($_POST['due_date']);
		}
		
		send_Data($_POST, $dbc);		
	}
?>
<!DOCTYPE html>
<html>
	<head> 
		<title>TODO List</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="/todo_list.css">
	</head>
	<body id="bodyPadding">		
<!--beginning of content of the webpage-->	
	<div id="dynamicHeader">
		<h1> TODO List</h1>
	</div>
	<div class="lists">
		<table class="table table-striped">
		 	<tr>
		 		<th> The Task </th>
		 		<th> Date </th>
		 		<th> Priority </th>
		 		<th> Task Done? </th>
		 	</tr>
		 	<tr>
				 <?php
				foreach ($todoList as $key => $value) {
					foreach ($value as $col => $detail) {
						if ($col == 'id') {
							continue;
						}
						if ($col == 'due_date') {
						$detail = changeDate($detail);
					}
						echo "<td> $detail</td>";
					}
					echo "<td><a href=\"?idx=$key\"> &#88; </a></td>";
					echo "</tr>";
				}
				?>
		</table>
	</div>
	<div class="form" id="fDesign">
	<form class="form" method="POST" action="todo_list.php">
		<div class="form-group">
		<h2>Add to the TODO List</h2>
			</div>
		<div class="form-group">
			<label for="todo">List your next TODO:</label>
			<input type="text" id="todo" name="todo" value=<?= isset($_POST['todo']) ? $_POST['todo']: '' ?>>
			</div>
		<div class="form-group">
			<label for="priority">Set Priority</label>
			<select id="priority" name="priority">
				<option value="4" selected="selected">Very Important</option>
		        <option VALUE="3"> Important</option>
		        <option VALUE="2"> Need to Do But Not Soon</option>
		        <option VALUE="1"> Optional Task</option> 
		    </select> 
		    </div>
		<div class="form-group">
		    <label for="due_date">Due Date for Task</label>
		    <!-- sets date but will keep as is if something is selected -->
			<input type="date" id="due_date" name="due_date" value=				<?= isset($_POST['due_date']) ? $_POST['due_date']: '' ?>>
		</div>
		<div class="form-group">
		<button type="submit" class="btn btn-primary">Primary</button>
		</div>
	</form>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="moment.js"></script>
	</body>
</html>