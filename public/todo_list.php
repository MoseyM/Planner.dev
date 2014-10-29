<!DOCTYPE html>
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
	// Code for the email information
if(count($_FILES)> 0 && $_FILES['file1']['error'] == UPLOAD_ERR_OK) {
		if ($_FILES['file1']['type'] == 'text/plain') {
			$uploadDir = '/vagrant/sites/planner.dev/public/uploads/';
			// filename var is giving the file name with extension
			$filename = basename($_FILES['file1']['name']);
			$savedFilename = $uploadDir.$filename;
			//the file is saved temporarily so we are moving it from the temp location to a permanent location which file address and name with extension was creted with the $savedFilename var.
			move_uploaded_file($_FILES['file1']['tmp_name'], $savedFilename);		}
		else {
			echo "<p> Please attach a text file</p>";
		}
		
}
	// This checks if a file is present
	



	//-------------------------------------------------
if (isset($savedFilename) && filesize($savedFilename)) {
	$fileLocation = $savedFilename;
	} else {
		$fileLocation = "data/todo.txt";
	}
	$list = openFile($fileLocation);
	function updateList($list) {
			foreach ($list as $key => $listItem) { ?>
				<ul>
					<li><a href="?id=<?php echo $key; ?>">Complete</a>|<?php echo "$listItem"; ?> </li>
				</ul>
			<?php } 
		 }
//this will just open the file and allow you to read. For displaying the contents
	function openFile($fileLocation) {
	    //setting variable to the exact location of the file with user input for the actual file name	    
	    //this just gives the computer a location for the file
	    if (file_exists($fileLocation) && filesize($fileLocation)>0) {
			$handle = fopen($fileLocation, 'r');
		    $contents = trim(fread($handle, filesize($fileLocation)));
		    $newinfo = explode("\n", $contents);	    
		}
		else{
			$newinfo = [];
		}
	    fclose($handle);
	    return $newinfo;
}

//write information to a file
	function saveFile($array, $fileLocation) {
		$handle = fopen($fileLocation, 'w');
		foreach($array as $eachToDo) {
			fwrite($handle, $eachToDo . "\n");
		}
	    fclose($handle);
	}

?>


<!--beginning of content of the webpage-->	
	<div id="dynamicHeader">
		<h1> TODO List</h1>
	</div>
	<div class="lists">
	<!-- added the item submitted thru push to the to do list -->
	<?php 
	//only runs when one of the list items are selected (link has listIndex in url address for query string)
		if(isset($_GET['id'])) {
			$index = $_GET['id'];
			// This will delete the selected todo item
			unset($list[$index]);
			saveFile($list, $fileLocation);
		}
	//runs when "add" is selected in form
		if(isset($_POST['actToAdd'])) {
			$itemToAdd=$_POST['actToAdd'];
			array_push($list, $itemToAdd);
			saveFile($list, $fileLocation);
			// $items[]=$itemToAdd;
	}
	updateList($list);

		?>
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
			<?php
			// this makes sure a file was actually saved.
			if (isset($savedFilename)) {
				openFile($fileLocation = $savedFilename);
    // If we did, show a link to the uploaded file
    echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
} ?>
		</form>
	</div>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>
	</html>

