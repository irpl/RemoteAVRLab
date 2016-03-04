<?php
include_once("check_login_status.php");
//check if signed in
if($log_idnumber == ""){
	echo "You must be logged in to continue.";
	exit();
}
//check if the signed in user has admin rights
$sql = "SELECT * FROM users WHERE idnumber='$log_idnumber' AND password='$log_password' AND admin='1' LIMIT 1";
$query = mysqli_query($db_conx, $sql);
if($query == false){
	echo "An admin user has not been assigned.";
	exit();
}
$numrows = mysqli_num_rows($query);
// check to see if user is an admin
if($numrows < 1){
	echo "You are not an admin user.";
	exit();
}
?>