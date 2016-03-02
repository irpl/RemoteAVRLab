<?php
session_start();
// If user is logged in, header them away
if(isset($_SESSION["username"])){
	header("location: message.php?msg=NO to that weenis");
    exit();
}
?><?php
// Ajax calls this NAME CHECK code to execute
if(isset($_POST["idnumbercheck"])){
	include_once("db_conx.php");
	$idnumber = preg_replace('#[^0-9]#i', '', $_POST['idnumbercheck']);
	$sql = "SELECT id FROM users WHERE idnumber='$idnumber' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
    $idnum_check = mysqli_num_rows($query);
    if (strlen($idnumber) != 9) {
	    echo '<strong style="color:#F00;">ID Number should be 9 digits.</strong>';
	    exit();
    }
	// if (is_numeric($username[0])) {
	//     echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
	//     exit();
    //}
    if ($idnum_check < 1) {
	    echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
	    exit();
    } else {
	    echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
	    exit();
    }
}
?><?php
// Ajax calls this REGISTRATION code to execute
if(isset($_POST["f"])){
	// CONNECT TO THE DATABASE
	include_once("db_conx.php");
	// GATHER THE POSTED DATA INTO LOCAL VARIABLES
	$i = preg_replace('#[^0-9]#i', '', $_POST['i']);
	$f = $_POST['f'];
	$l = $_POST['l'];
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = $_POST['p'];
	$ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	// DUPLICATE DATA CHECKS FOR USERNAME AND EMAIL
	$sql = "SELECT id FROM users WHERE idnumber='$i' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$i_check = mysqli_num_rows($query);
	// -------------------------------------------
	$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$e_check = mysqli_num_rows($query);
	// FORM DATA ERROR HANDLING
	if($i == "" || $e == "" || $p == "" || $f == "" || $l == ""){
		echo "The form submission is missing values.";
        exit();
	} else if ($i_check > 0){ 
        echo "The ID Number you entered is alreay registered.";
        exit();
	} else if ($e_check > 0){ 
        echo "That email address is already in use in the system.";
        exit();
	} else if (strlen($i) != 9) {
        echo "ID Number must be 9 digits.";
        exit(); 
    } else {
	// END FORM DATA ERROR HANDLING
	    // Begin Insertion of data into the database
		// Hash the password and apply your own mysterious unique salt
		$p_hash = md5($p);
		
		// Create a randomly generated string for user activation
		include_once ("randStrGen.php");
		$a = randStrGen(20)."$p_hash".randStrGen(20);
		
		// Add user info into the database table for the main site table
		$sql = "INSERT INTO users (idnumber, fname, lname, email, password, signup, lastlogin, ip, activation)       
		        VALUES('$i','$f','$l','$e','$p_hash',now(),now(), '$ip', '$a')";
		$query = mysqli_query($db_conx, $sql); 
		$uid = mysqli_insert_id($db_conx);
		// Establish their row in the useroptions table
		//$sql = "INSERT INTO useroptions (id, username, background) VALUES ('$uid','$u','original')";
		//$query = mysqli_query($db_conx, $sql);
		// Create directory(folder) to hold each user's files(pics, MP3s, etc.)
		if (!file_exists("users/$i")) {
			mkdir("users/$i", 0755);
		}
		// Email the user their activation link
		require_once "Mail.php";
		$from = 'RemoteAVRLab <remoteavrlab@gmail.com>';
		$to = "<" . $e . ">";
		$subject = 'RemoteAVRLab Request Activation';
		$body = 'Hello '.$f.',

An account has been created for you at RemoteAVRLab with the following information:

UWI ID: '.$i.'
Name: '.$f.' '.$l.'
Email: '.$e.'

If the above information is correct, click the activation link below.

https://remoteavrlab-irpl.c9users.io/webclient/activation.php?a='.$a.'

By clicking the above link, you are requesting access to the RemoteAVRLab platform.

If you believe that you have received this email in error, please disregard it.

Thank you,
RemoteAVRLab';

		
		$headers = array(
		    'From' => $from,
		    'To' => $to,
		    'Subject' => $subject
		);
		
		$smtp = Mail::factory('smtp', array(
		        'host' => 'ssl://smtp.gmail.com',
		        'port' => '465',
		        'auth' => true,
		        'username' => 'remoteavrlab@gmail.com',
		        'password' => 'kickmonkeydoukeN1'
		    ));
		
		$mail = $smtp->send($to, $headers, $body);
		
		if (PEAR::isError($mail)) {
		    echo('Error notifying coordinator.');
		} else {
		    echo('signup_success');
		}
		exit();
	}
	exit();
}
?>