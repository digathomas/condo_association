<?php
include('config.php'); 
session_start();
?>


<html>

<head>
<style>

table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

th, td {
  padding: 5px;
}

th {
  text-align: left;
}

</style>
</head>


<body>

Create group: 
<br>
<br>

<?php

if(isset($_POST['create_group'])) {	//handle create group button press
	
	//ensure form is not null, and not empty
	$valid = true;
	if( !isset($_POST['name']) || empty($_POST['name']) ) $valid = false;
	if( !isset($_POST['desc']) || empty($_POST['desc']) ) $valid = false;
	
	if($valid) {
		
		//assign variables to fields for ease of insertion int sql string
		$name = $_POST['name']; $description = $_POST['desc'];
		$owner = $_SESSION['ID'];
		
		//add group row to database
		$sql = "INSERT INTO groups (name, description, owner) VALUES ('$name', '$description', $owner)";
		if (mysqli_query($db, $sql)) echo "new group created"."<br><br>";
		else echo mysqli_error($db)."<br><br>";
		
		//reload page to prevent form resubmission
		header("Location: " . $_SERVER['PHP_SELF']);
	
	} else echo "please fill out all input fields to create a group<br><br>";
	
} else if(isset($_POST['delete_group'])) {

	$sql = "DELETE FROM groups WHERE groupID=".$_POST['groupToDelete']."";
	if (mysqli_query($db, $sql)) echo "group deleted"."<br><br>";
	else echo mysqli_error($db)."<br><br>";

}



?>

<form action="manage_groups.php" method="post">
		<label for="name">Name:</label>
		<br>
		<input type="text" name="name">
		<br>
		<label for="desc:">description:</label>
		<br>
		<textarea name="desc" rows="4" cols="100"></textarea>
		<br>
		<br>
		<input type="submit" name="create_group" value="submit">
</form>

<form action="../admin_page.html" method="post">
		<input type="submit" name="back" value="back">
</form>
	
<table style = "width:100%">
	<tr>
		<th></th>
		<th> name </th>
		<th> description </th>
		<th> Owner </th>
	</tr>
	
	
<?php

	//list all groups from database
  $group_query = mysqli_query($db, "SELECT groups.name, groups.description, groups.groupID, Users.name as owner_name FROM groups,Users WHERE groups.owner=Users.userID;");
  while($group = mysqli_fetch_array($group_query)){
  		echo "<tr>";
  		echo '<td><form action="edit_group.php" method="post">';		//goto edit_group.php on manage group button press 
  		echo '<input type="hidden" id="groupID" name="groupID" value="'.$group['groupID'].'">';	//send group id as well
  		echo '<input type="submit" name="manage" value="manage">';
  		echo "</form></td>";
      echo "<td>".$group['name']."</td>";
      echo "<td>".$group['description']."</td>";
      echo "<td>".$group['owner_name']."</td>";
      echo "</tr>";
  }
	
?>
</table>

</body>
</html>
