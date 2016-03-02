<?php
include_once("check_login_status.php");
// Initialize any variables that the page might echo
$i = "";
$e = "";
//$sex = "Male";
//$userlevel = "";
//$country = "";
$joindate = "";
$lastsession = "";
// Make sure the _GET username is set, and sanitize it
if(isset($_GET["i"])){
	$i = preg_replace('#[^0-9]#i', '', $_GET['i']);
	$e = mysqli_real_escape_string($db_conx, $_GET['e']);;
} else {
    header("location: login.html");
    exit();	
}
// Select the member from the users table
$sql = "SELECT * FROM users WHERE idnumber='$i' AND activated='1' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = mysqli_num_rows($user_query);
if($numrows < 1){
	echo "That user does not exist or is not yet activated, press back";
    exit();	
}
// Check to see if the viewer is the account owner
$isOwner = "no";
if($i == $log_idnumber && $user_ok == true){
	$isOwner = "yes";
}
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
	$profile_id = $row["id"];
	$profile_idnumber = $row["idnumber"];
    $profile_fname = $row["fname"];
    $profile_lname = $row["lname"];
    $profile_email = $row["email"];
	//$gender = $row["gender"];
	//$country = $row["country"];
	//$userlevel = $row["userlevel"];
	//$signup = $row["signup"];
	//$lastlogin = $row["lastlogin"];
	//$joindate = strftime("%b %d, %Y", strtotime($signup));
	//$lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
// 	if($gender == "f"){
// 		$sex = "Female";
// 	}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $i; ?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<!--<link rel="stylesheet" href="style/style.css">-->
<!--<script src="js/main.js"></script>-->
<!--<script src="js/ajax.js"></script>-->
</head>
<body>
<?php //include_once("template_pageTop.php"); ?>
<div id="pageMiddle">
  <h3><?php echo $i; ?></h3>
  <p>Is the viewer the page owner, logged in and verified? <b><?php echo $isOwner; ?></b></p>
  <p>ID Number: <?php echo $profile_idnumber; ?></p>
  <p>Name: <?php echo $profile_fname . ' ' . $profile_lname; ?></p>
  <p>Email: <?php echo $profile_email; ?></p>
  <!--<p>Join Date: <?php echo $joindate; ?></p>-->
  <!--<p>Last Session: <?php echo $lastsession; ?></p>-->
</div>
<?php //include_once("template_pageBottom.php"); ?>
</body>
</html>