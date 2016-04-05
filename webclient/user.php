<?php
// include_once("php/check_login_status.php");
include_once("php/isAdmin.php");
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
    header("location: index");
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
<!--<link rel="stylesheet" href="css/stylesheet.css">-->


<script src="CodeMirror/lib/codemirror.js"></script>
<script src="CodeMirror/mode/clike/clike.js"></script>
<script src="CodeMirror/keymap/sublime.js"></script>
<script src="CodeMirror/addon/edit/matchbrackets.js"></script>
<script src="CodeMirror/addon/edit/closebrackets.js"></script>
<script src="CodeMirror/addon/display/fullscreen.js"></script>
<link href="css/user.css" rel="stylesheet" type="text/css">



<!--booking-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery.ptTimeSelect.js"></script>
    <!--<link rel="stylesheet" href="/resources/demos/style.css">  -->
    <link rel="stylesheet" href="css/jquery.ptTimeSelect.css">
    
    <script>
        $(function() {
            $( "#datepicker" ).datepicker();
        });
        $(document).ready(function(){
            // find the input fields and apply the time select to them.
            $("#timepicker").ptTimeSelect({timeFormat: "H:i"});
        });
    </script>
<!---->

<!--fullcalendar-->
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.js"></script>
<!---->

<script src="js/ajax.js"></script>
<script src="js/users.js"></script>
<script src="js/upload.js"></script>
<script src="js/timer.js"></script>

</head>
<body>

    
    <!--<h1><?php echo $i; ?></h1>-->
    <!--<button id="logout" onclick="location.href='php/logout.php';"  >Log Out</button>-->
    <!--<p>Is the viewer the page owner, logged in and verified? <b><?php echo $isOwner; ?></b></p>-->
    <!--<p>ID Number: <?php echo $profile_idnumber; ?></p>-->
    <!--<p>Name: <?php echo $profile_fname . ' ' . $profile_lname; ?></p>-->
    <!--<p>Email: <?php echo $profile_email; ?></p>-->
    <!--<p>Join Date: <?php echo $joindate; ?></p>-->
    <!--<p>Last Session: <?php echo $lastsession; ?></p>-->
    
    
    <div id="top">
        <a href=""><img src="img/logo-nosha.png" id="logo"></img></a>
        <span class="lab_top_text" id="lab_number">Choose a lab</span>
        <button id="logout" onclick="location.href='php/logout';">Logout</button>
        <?php
            if($isAdmin){
                ?>
                <button onclick="location.href='admin';" style="float: right; margin-top:9px; margin-right:30px;">Admin</button>
                <?php
            }
        ?>
        <span class="lab_top_text" id="fname"><?php echo $profile_fname ?></span>
    </div>
    <div id="side">
        <div id="upload_buttons">
        	<form id="upload_form" enctype="multipart/form-data" method="post">
        	  	<input type="file" name="file1" id="file1" accept=".c, .asm, .hex">
        	  	<label for="file1">Browse...</label><br>
        	  	<input type="button" value="Upload" onclick="uploadFile()">
        	 	<progress id="progressBar" value="0" max="100" style="width:100px;"></progress>
        		<span id="status"></span>
        	 	<p id="loaded_n_total"></p>
        	</form>
        </div>
    </div>
    
   <div id="pageMiddle">
       <?php
            date_default_timezone_set("America/Jamaica");
            $now = new DateTime(date("Y-m-d H:i:s"));
            $result0 = $now->format('Y-m-d H:i:s');
            
            $sql = "SELECT * FROM labs WHERE idnumber='$profile_idnumber'";
            $query = mysqli_query($db_conx, $sql);
            $numrows = mysqli_num_rows($query);
            if ($numrows > 0){
                while($row=mysqli_fetch_row($query)){
                    $booked_lab1 = $row[1];
                    $booked_lab2 = $row[2];
                    $booked_lab3 = $row[3];
                    $start_time = new DateTime($row[5]);
                    $result1 = $start_time->format('Y-m-d H:i:s');
                    
                    $end_time = new DateTime($row[6]);
                    $result2 = $end_time->format('Y-m-d H:i:s');
    
                }
                
                if($booked_lab1 == 1){
                    if($now < $start_time){ //too early
                        $button1_html = "<button id='lab1'>too early</button>";
                    } else if(($now > $start_time) && ($now < $end_time)) { // time started ans not yet finished
                        $button1_html = "<button id='lab1' onclick='loadLab(1)' >Start Lab 1</button>";
                    } else if ($now > $end_time) {
                        $button1_html = "<button id='lab1' onclick='chooseTime(this)' >Book Me</button>";
                    }
                } else {
                    $button1_html = "<button id='lab1' onclick='chooseTime(this)' >Book Me</button>";
                }
                
                if($booked_lab2 == 1){
                    if($now < $start_time){ //too early
                        $button2_html = "<button id='lab2'>too early</button>";
                    } else if(($now > $start_time) && ($now < $end_time)) { // time started ans not yet finished
                        $button2_html = "<button id='lab2' onclick='loadLab(2)' >Start Lab 2</button>";
                    } else if ($now > $end_time) {
                        $button2_html = "<button id='lab2' onclick='chooseTime(this)' >Book Me</button>";
                    }
                } else {
                    $button2_html = "<button id='lab2' onclick='chooseTime(this)' >Book Me </button>";
                }
                
                if($booked_lab3 == 1){
                    if($now < $start_time){ //too early
                        $button3_html = "<button id='lab3'>Too Early</button>";
                    } else if(($now > $start_time) && ($now < $end_time)) { // time started ans not yet finished
                        $button3_html = "<button id='lab3' onclick='loadLab(3)' >Start Lab 3</button>";
                    } else if ($now > $end_time) {
                        $button3_html = "<button id='labs' onclick='chooseTime(this)' >Book Me</button>";
                    }
                } else {
                    $button3_html = "<button id='lab3' onclick='chooseTime(this)' >Book Me</button>";
                }
            } else {
                $button1_html = "<button id='lab1' onclick='chooseTime(this)' >Book Me</button>";
                $button2_html = "<button id='lab2' onclick='chooseTime(this)' >Book Me</button>";
                $button3_html = "<button id='lab3' onclick='chooseTime(this)' >Book Me</button>";
            }
       ?>
        <table id=lab_defn>
            <tr>
                <td>
                    <h1>Lab 1</h1>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt justo ut augue ultricies ultricies. Pellentesque sit amet velit non justo convallis tristique. Mauris convallis orci in urna fermentum, non auctor turpis fermentum. Donec quis metus in massa volutpat vestibulum. Curabitur ornare, metus id faucibus euismod, risus lorem ultrices arcu, non ornare est urna sit amet libero. In eget sagittis felis. In sit amet enim tellus. Nullam rutrum iaculis tristique. Aliquam ut sodales nulla. Suspendisse rutrum lorem a arcu faucibus dictum eget posuere neque.
                    </p>
                    <?php echo $button1_html;?>
                </td>
                <td>
                    <h1>Lab 2</h1>
                    <p>
                        Nam tristique vitae nulla id placerat. Morbi eu blandit eros. Suspendisse eu laoreet dolor. Cras nec ante vel nunc gravida volutpat eget lacinia sapien. In finibus euismod imperdiet. Nullam efficitur malesuada imperdiet. Integer id libero et orci facilisis pellentesque sit amet eu mi.
                    </p>
                    <?php echo $button2_html;?>
                </td>
                <td>
                    <h1>Lab 3</h1>
                    <p>
                        Integer dignissim ultrices purus sit amet tempus. Phasellus varius, est a iaculis dictum, felis nisl hendrerit metus, ac suscipit quam urna et mi. Fusce libero est, sagittis vel diam non, convallis mollis sem. Aliquam ornare blandit ipsum, id consequat libero fringilla ac. Cras et ullamcorper turpis, et dapibus nisi. Duis varius ipsum et cursus porta. Ut fringilla massa lacus, vel venenatis nisi dictum sit amet. Sed ut dolor id arcu imperdiet dictum sed at turpis. Cras porttitor rutrum tristique. Sed venenatis augue ut odio gravida, id interdum augue scelerisque. Pellentesque egestas dignissim odio sit amet varius. Proin facilisis viverra metus nec euismod.
                    </p>
                    <?php echo $button3_html;?>
                </td>
            </tr>
        </table>
        
        <!--<div id="booking_form" style="display:none;">-->
        <!--    <form onsubmit="return false;">-->
        <!--        <div>Date: <input id="datepicker" type="text"/></div>-->
        <!--        <div>Time: <input id="timepicker" type="text"/></div>-->
        <!--        <button id="booklab" onclick="bookLab(<?php //echo $profile_idnumber ?>)" >Book Lab</button>-->
        <!--    </form>-->
        <!--</div>-->
        <div id="user_id" style="display:none;"><?php echo $profile_idnumber ?></div>
        <div id="calendar" style="display:none;"></div>
        
        <!--<div id="smn_" style="position:absolute; top:200px; left:190px;"></div>-->
    
        <?php
            if ($isOwner == "no"){
                ?>
                    <script type="text/javascript">
                        _("lab_defn").style.display="none";
                        _("upload_buttons").style.display="none";
                        _("lab_number").innerHTML = "Lab Outline";
                        _("fname").innerHTML = "";
                        _("logout").style.display = "none";
                    </script>
                <?php
            }
        ?>
        
        <div id="loading">
            <span>Hi there<br/>Your lab is coming right up</span><br/>
            <img src="img/loading.gif"></img>
        </div>
        
        
        <div id="lab">
            <!--<div id="top">-->
            <!--    <a href=""><img src="img/logo-nosha.png" id="logo"></img></a>-->
            <!--    <button id="logout">Logout</button>-->
            <!--</div>-->
            <!--<div id="side"></div>-->
            <div id="squares">
                <!--code editor-->
                <div class="sq" id="r1c1">
                    <div id="control_buttons" >
                	    <span id="save"></span>
                	    <input id="compile" type="button" value="Compile" onclick="program(<?php echo $log_idnumber; ?>,'c')">
                		<input id="program" type="button" value="Program" onclick="program(<?php echo $log_idnumber; ?>,'p')">
                	</div>
                    <script> 
                        var code = document.getElementById("r1c1");
                        
                        <?php date_default_timezone_set("America/Jamaica"); ?>
                        
                        var startingCode = '/*\nAuthor: <?php echo $profile_fname." ".$profile_lname;?>\nID Number: <?php echo $profile_idnumber;?>\nDate: <?php echo date('D M j, Y');?>\nTitle:\n*/\n\n//include libraries\n\nint main(void)\n{\n  while(1)\n  {\n    //Insert code here\n  }\n  return 0;\n}'
                        // var code = document.body;
                    	var editor = CodeMirror(code, {
                    		mode: "text/x-csrc",
                    	  	lineNumbers: true,
                    	  	// theme: "monokai",
                    	  	keyMap: "sublime",
                            value: startingCode,
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
                
                <!--video window-->
                <div class="sq" id="r1c2">
                    <!--<img src="2.jpg" alt="Smiley face" height="100%" width="100%">-->
                    <div id="live">
            	        <!--<iframe width="660" height="400" src="https://www.youtube.com/embed/_z84FvCSlaw" scrolling="no" frameborder="0">-->
            	        <!--<iframe height="100%" width="100%" src="http://72.252.157.203:8081" frameborder="0" allowfullscreen style="display:block"></iframe>-->
            	        <img height="100%" width="100%" src="http://72.252.157.203:8081" style="display:block"></img>
            		        <!--<p>Your browser does not support iframes.</p>-->
            	        </iframe>
                    </div>
                </div>
                
                <!--console output-->
                <div class="sq" id="r2c1">
                    <span id="console_label">console@RemoteAVRLab:~$</span>
                    <textarea id="output" rows="100" cols="105" readonly>&#13;&#10;&#13;&#10;</textarea>
                </div>
                
                <!--pdf-->
                <div class="sq" id="r2c2">
                    <!--<img src="4.jpg" alt="Smiley face" height="100%" width="100%">-->
                    <!--<div height="100%">-->
                        <iframe id="lab_iframe" src="" height="100%" width="100%" style="display:block;"></iframe>
                        
                    <!--</div>-->
                </div>
            </div>
        </div>
    </div>
</body>
</html>