<?php
if (isset($_GET['a'])) {
	include_once("db_conx.php");
	$a = preg_replace('#[^a-z0-9\$]#i', '', $_GET['a']);
	
	if($a == "" || strlen($a) != 72) {
		header("location: message.php?msg=This activation link is invalid.
		".$a."");
    	exit();
	}
	
	$sql = "SELECT id, idnumber, email, password, fname, lname FROM users WHERE activation='$a' AND activated='0' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
	if($numrows == 0){
		// Log this potential hack attempt to text file and email details to yourself
		header("location: message.php?msg=Your credentials are not matching anything in our system");
    	exit();
	}
	$row = mysqli_fetch_row($query);
	$email_id = $row[0];
	$email_i = $row[1];
	$email_e = $row[2];
	$email_p = $row[3];
	$email_f = $row[4];
	$email_l = $row[5];
	
	// Email the user their activation link
		require_once "Mail.php";
		$from = 'RemoteAVRLab <remoteavrlab@gmail.com>';
		$to = "<philo3194@gmail.com>";
		$subject = 'RemoteAVRLab Account Activation';
		$body = 'Greetings,
		
Below is the registration information of a student that would like access to the RemoteAVRLab platform.

UWI ID: '.$email_i.'
Name: '.$email_f.' '.$email_l.'
Email: '.$email_e.'

Review the information and click the link below to activate the account when ready:

https://remoteavrlab-irpl.c9users.io/webclient/activation.php?id='.$email_id.'&i='.$email_i.'&e='.$email_e.'&p='.$email_p.'

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
		    echo('<p>' . $mail->getMessage() . '</p>');
		} else {
		    echo('<h2>Activation Pending</h2> A request for activation has been sent to the course coordinator.');
		}
        
    	exit();
	
}

if (isset($_POST['id']) && isset($_POST['i']) && isset($_POST['e'])) {
																// && isset($_GET['p'])
	//echo $_POST['id'] ." ". $_POST['i'] ." ".$_POST['e'];
	//exit();
																
	// Connect to database and sanitize incoming $_GET variables
    include_once("db_conx.php");
    $id = preg_replace('#[^0-9]#i', '', $_POST['id']); 
	$i = preg_replace('#[^0-9]#i', '', $_POST['i']);
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = mysqli_real_escape_string($db_conx, $_POST['p']);
	// Evaluate the lengths of the incoming $_GET variable
	if($id == "" || strlen($i) != 9 || strlen($e) < 5 ){
													//|| strlen($p) == ""
		// Log this issue into a text file and email details to yourself
		header("location: message.php?msg=activation_string_length_issues");
    	exit(); 
	}
	// Check their credentials against the database
	$sql = "SELECT * FROM users WHERE id='$id' AND idnumber='$i' AND email='$e' AND activated='0' LIMIT 1";
																				//AND password='$p'
    $query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
	// Evaluate for a match in the system (0 = no match, 1 = match)
	if($numrows == 0){
		// Log this potential hack attempt to text file and email details to yourself
		header("location: message.php?msg=Your credentials are not matching anything in our system or account may already be activated");
    	exit();
	}
	// Match was found, you can activate them
	$sql = "UPDATE users SET activated='1' WHERE id='$id' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
	// Optional double check to see if activated in fact now = 1
	$sql = "SELECT * FROM users WHERE id='$id' AND activated='1' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
	// Evaluate the double check
    if($numrows == 0){
		// Log this issue of no switch of activation field to 1
        header("location: message.php?msg=activation_failure");
    	exit();
    } else if($numrows == 1) {
		// Great everything went fine with activation!
        header("location: message.php?msg=activation_success");
        
        // Email the user their activation link
		require_once "Mail.php";
		$from = 'RemoteAVRLab <remoteavrlab@gmail.com>';
		$to = "<" . $e .">";
		$subject = 'RemoteAVRLab Access Granted';
		$body = 'Hello again,
		
You have been granted access to the RemoteAVRLab platform. 
You may now login at 
https://remoteavrlab-irpl.c9users.io/webclient/login.html
with ID number: '.$i.'.		

			
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
		    echo('<p>' . $mail->getMessage() . '</p>');
		} else {
		    echo('signup_success');
		}
        
    	exit();
    }
} else {
	// Log this issue of missing initial $_GET variables
	header("location: message.php?msg=missing_GET_variables");
    exit(); 
}
?>