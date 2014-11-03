<!DOCTYPE html>
<? require_once 'includes/includeToDoClasses.php'; ?>
<html>
	<head>
		<title>TODO List</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="/todo_list.css">
	</head>
	<body>
<?php	
//code to check if we are starting with a new file or a saved/uploaded file
	$lister = new ToDoLister('csv/todo.csv');
	$list = $lister-> openFile();
// Code for the email information when a file is uploaded
	if(count($_FILES)> 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
			if ($_FILES['file1']['type'] == 'text/csv') {
				$uploadDir = '/vagrant/sites/planner.dev/public/uploads/';
				// filename var is giving the file name with extension
				$filename = basename($_FILES['file1']['name']);
				$savedFilename = $uploadDir.$filename;
				//the file is saved temporarily so we are moving it from the temp location to a permanent location which file address and name with extension was creted with the $savedFilename var.
				move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);		}
			else {
				echo "<p> Please attach a csv file</p>";
			}	
	}
//only runs when one of the list items are selected (link has listIndex in url address for query string)
	

//runs when "add" is selected in form
		if(isset($_POST) && !empty($_POST)) {
			$list[] = $_POST;
			$lister->writeToFile($list);
		}
//-------------------------------------------------

	
//to display the array on the browser.
?>
<!--beginning of content of the webpage-->	
	<div id="dynamicHeader">
		<h1> TODO List</h1>
	</div>
	<div class="lists">
		<table class="table table-striped">
		 	<tr>
		 		<th> The Task </th>
		 		<th> Due Date </th>
		 		<th> Priority </th>
		 		<th> Task Done? </th>
		 	</tr>
		 	<tr>
				 <?php
				foreach ($list as $key => $value) {
						foreach ($value as $listTitle => $listValue){
				 	 		echo "<td> $listValue </td>";
						}
						echo "<td><a href=\"?id=$key\"> &#88 </td>";
						echo "</tr>";
					} if(isset($_GET['id'])) {
		$index = $_GET['id'];
		unset($list[$index]);
		$lister->writeToFile($list);
	}?>
		</table>
	</div>
	<div id="formContainer" class="form">
	<form method="POST" action="todo_list.php">
		<h2 class="form-heading">Add to the TODO List</h2>
		<p>
			<label for="actToAdd">List your next TODO:</label>
			<input type="text" id="actToAdd" name="actToAdd" value="">
			</p>
			<p>
			<label for="dueDate">Due Date: </label>
			<input type="date" name="dueDate" id="dueDate">
		</p>
		<p>
			<label for="priorityLevel">Rate Priority: </label>
			<select id="priorityLevel" name="priorityLevel">
				<option value="4">Very Important</option>
				<option value="3">Important</option>
				<option value="2">Neutral</option>
				<option value="1">Not Important/Optional</option>
			</select>
		</p>
		<input type="submit" value="Add">
	</form>
	</div>
	<div class="fileUpload">
		<form method="POST" enctype="multipart/form-data" action="todo_list.php">
			<input type="file" class="fileKeys" id="file1" name="file1">
			<input type="submit" class="fileKeys" value="SendFile">
		</form>
	</div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>
	</html>

