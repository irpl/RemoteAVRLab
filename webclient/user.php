<?php
include_once("php/check_login_status.php");
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
    header("location: index.php");
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
<meta charset="utf-8"/>

<link rel=stylesheet href="CodeMirror/doc/docs.css">
<link rel="stylesheet" href="CodeMirror/lib/codemirror.css">
<link rel="stylesheet" href="CodeMirror/addon/display/fullscreen.css">
<link rel="stylesheet" href="css/stylesheet.css">


<script src="CodeMirror/lib/codemirror.js"></script>
<script src="CodeMirror/mode/clike/clike.js"></script>
<script src="CodeMirror/keymap/sublime.js"></script>
<script src="CodeMirror/addon/edit/matchbrackets.js"></script>
<script src="CodeMirror/addon/edit/closebrackets.js"></script>
<script src="CodeMirror/addon/display/fullscreen.js"></script>
<link href='css/user.css' rel='stylesheet' type='text/css'>
<script src="js/ajax.js"></script>
<script src="js/users.js"></script>
<script src="js/upload.js"></script>
<!--<link rel="stylesheet" href="style/style.css">-->
<!--<script src="js/main.js"></script>-->
<!--<script src="js/ajax.js"></script>-->
</head>
<body>
<div id="pageMiddle">
    <h1><?php echo $i; ?></h1>
    <button id="logout" onclick="location.href='php/logout.php';"  >Log Out</button>
    <p>Is the viewer the page owner, logged in and verified? <b><?php echo $isOwner; ?></b></p>
    <p>ID Number: <?php echo $profile_idnumber; ?></p>
    <p>Name: <?php echo $profile_fname . ' ' . $profile_lname; ?></p>
    <p>Email: <?php echo $profile_email; ?></p>
    <!--<p>Join Date: <?php echo $joindate; ?></p>-->
    <!--<p>Last Session: <?php echo $lastsession; ?></p>-->
    
    <div id="lab_buttons">
        <button id="lab1" onclick="loadLab(1)" >Lab 1</button>
        <button id="lab2" onclick="loadLab(2)" >Lab 2</button>
        <button id="lab3" onclick="loadLab(3)" >Lab 3</button>
    </div>

    <?php
        if ($isOwner == "no"){
            ?>
                <script type="text/javascript">
                    _("lab_buttons").style.display="none";
                </script>
            <?php
        }
    ?>

    <div id="lab">
        <h1>Remote AVR Lab</h1>
        <p>Lab 1</p>
        
        <div id="bod">
        
        <div>
        	<form id="upload_form" enctype="multipart/form-data" method="post">
        	  	<input type="file" name="file1" id="file1" accept=".c, .asm, .hex"><br>
        	  	<input type="button" value="Upload File" onclick="uploadFile()">
        	 	<progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
        		<h3 id="status"></h3>
        	 	<p id="loaded_n_total"></p>
        	</form>
        </div>
        
        
        
        <div id="text">
        	<div>
        	    <input id="compile" type="button" value="Compile" onclick="save()">
        		<input id="program" type="button" value="Program" onclick="program()">
        		<span id="save"></span>
        	</div>
        <textarea id="code" name="code"  rows="14" >/* Attint2313 blink program */
int main(void)
{
    DDRD |= (1 << PD6);  // make PD6 an output

    while(1)
    {
        PORTD ^= (1 << PD6);  // toggle PD6
        _delay_ms(1000);  // delay for a second
    }
    return 0;  // the program executed successfully
}</textarea>
<div id="error"></div>
        </div>
        
        <div id="live">
        	<iframe width="660" height="500" src="http://72.252.157.203:8081" scrolling="no" frameborder="0">
        		<p>Your browser does not support iframes.</p>
        	</iframe>
        </div>
        
        <script> 
        	//dawg(_("code"));
        	var code = document.getElementById("code");
        	var editor = CodeMirror.fromTextArea(code, {
        		mode: "text/x-csrc",
        	  	lineNumbers: true,
        	  	keymap: "sublime",
        		//height: 100px,
        		minHeight: "200px",
        		autoCloseBrackets: true,
        		matchBrackets: true,
        		extraKeys: {
        			"F11": function(cm) {
        		  		cm.setOption("fullScreen", !cm.getOption("fullScreen"));
        			},
        			"Esc": function(cm) {
        				if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
        			}
        	    }
        	});
        	editor.on("change", function(editor) {
                _("save").innerHTML = "Saving...";
                save();
            });
        </script>
        
        </div>
    </div>
    
</div>
</body>
</html>