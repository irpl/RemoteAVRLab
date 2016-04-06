<?php
// include_once("php/check_login_status.php");
include_once("php/isAdmin.php");
if(!$isAdmin){
	echo "you are not an admin";
	exit();
}
?>

<?php
if (isset($_POST['d']) && isset($_POST['i']) && isset($_POST['e']) ){
	$id = preg_replace('#[^0-9]#i', '', $_POST['d']);
	$i = preg_replace('#[^0-9]#i', '', $_POST['i']);
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	
	$sql = "DELETE FROM users WHERE id='$id' AND idnumber='$i' AND email='$e' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	
	// Check their credentials against the database
	$sql = "SELECT * FROM users WHERE id='$id' AND idnumber='$i' AND email='$e' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
	// Evaluate for a match in the system (0 = no match, 1 = match)
	if($numrows == 0){
		echo("delete_success");
	}
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="js/admin.js"></script>
	<script src="js/ajax.js"></script>
	<link href="css/admin.css" rel="stylesheet" type="text/css"/>
	<link href="css/user.css" rel="stylesheet" type="text/css"/>
	</head>
<body>

<div id="top">
    <a href=""><img src="img/logo-nosha.png" id="logo"></img></a>
    <span class="lab_top_text" id="lab_number">Admin Control</span>
    <button id="logout" onclick="location.href='php/logout';">Logout</button>
    <form ><input type="text" id="search" placeholder="Search User"/></form>
    <!--<span class="lab_top_text" id="fname"><?php echo $profile_fname ?></span>-->
</div>
<div id="side">
    <div id="admin_buttons">
    	<button class="admin_button" id="table_btn" onclick="showTab('table')">Users</button>
    	<button class="admin_button" id="stats_btn" onclick="showTab('stats')">User Stats</button>
    	<button class="admin_button" id="submission_btn" onclick="showTab('submission')">User Submission</button>
    	<button class="admin_button" id="booking_btn" onclick="showTab('booking')">Lab Bookings</button>
    </div>
</div>
<div id="tabs">
	<div class="tab" id="table">
		<form>
		<table id="admin_table" class="striped">
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
			    echo "<td><button type='button' onclick='activate(".$i.", 0)'>Activate</button></td>";
			} else {
			    echo "<td><button type='button' onclick='activate(".$i.", 1)'>Deactivate</button></td>";
			}
			echo "<td><button type='button' onclick='del(".$i.")'>Delete</button></td>";
			echo "</tr>";
		}
		?>
		</table>
		</form>
		<div id="status"></div>
	</div>
	<div class="tab" id="stats" style="display:none;">
		stats table
		<table>
			
		</table>
	</div>
	<div class="tab" id="submission" style="display:none;">submission</div>
	<div class="tab" id="booking" style="display:none;">booking</div>
</div>
</body>
</html>