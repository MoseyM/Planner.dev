<?php require_once '../includes/filestore.php'; 
	require_once '../includes/todoClass.php';
	$toDos = new todoClass('../data/todoClasses.txt');
	$toDos->todoList = $toDos->read();
	if(!empty($_POST)) {
		$toDos->CheckForLength();
		$toDos->todoList[] = $_POST['actToAdd'];
		$toDos->write($toDos->todoList);		
	} 
	if(count($_FILES)> 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
		$toDos->testType();	
	}

	if(isset($_GET['id'])) {
		$index = $_GET['id'];
		unset($toDos->todoList[$index]);
		$toDos->write($toDos->todoList);
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
		 		<th> Task Done? </th>
		 	</tr>
		 	<tr>
				 <?php
				foreach ($toDos->todoList as $key => $value) {
					echo "<td> $value </td>";
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
			<label for="actToAdd">List your next TODO:</label>
			<input type="text" id="actToAdd" name="actToAdd" value="">
		</div>
		<div class="form-group">
		<button type="submit" class="btn btn-primary">Primary</button>
		</div>
	</form>
	</div>
	<div class="fileUpload">
		<form method="POST" enctype="multipart/form-data" action="todo_list.php">
			<input type="file" class="fileKeys" id="file1" name="file1">
			<input type="submit" class="fileKeys" value="SendFile">
		</form>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="moment.js"></script>
	</body>
	</html>

