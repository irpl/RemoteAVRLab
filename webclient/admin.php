<?php
include_once("db_conx.php"); 
?>

<?php
if (isset($_POST['d'])){}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="admin.js"></script>
</head>
<body>

<form>
<table id="admin_table">
<tr>
	<th>Database ID</th>
	<th>Select All<input type="checkbox" id='check0' onchange='select_all()'></th>
	<th>ID Number</th>
	<th>Name</th>
	<th>Email</th>
	<th></th>
	<th></th>
</tr>
<?php
$sql = "SELECT id, idnumber, fname, lname, email, activated FROM users";
$query = mysqli_query($db_conx, $sql);

$i=0;
while ($row=mysqli_fetch_row($query)) {
    $i++;
	echo "<tr>";
	echo "<td>".$row[0]."</td>";
	echo "<td><input type='checkbox' id='check".$i."' ></td>";
	echo "<td>".$row[1]."</td>";
	echo "<td>".$row[2]." ".$row[3]."</td>";
	echo "<td>".$row[4]."</td>";
	
	if ($row[5] == "0") {
	    echo "<td><button type='button' onclick='activate(".$i.")'>Activate</button></td>";
	} else {
	    echo "<td><button type='button' onclick='activate(".$i.")' disabled>Activate</button></td>";
	}
	echo "<td><button type='button' onclick='del(".$i.")'>Delete</button></td>";
	echo "</tr>";
}
?>
</table>
</form>
<div id="status"></div>

</body>
</html>