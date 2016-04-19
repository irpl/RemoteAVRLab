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
<script src="js/ajax.js"></script>
<script src="js/users.js"></script>
<script src="js/upload.js"></script>
<script src="js/timer.js"></script>
<!--<link rel="stylesheet" href="style/style.css">-->
<!--<script src="js/main.js"></script>-->
<!--<script src="js/ajax.js"></script>-->
</head>
<body>
<div id="pageMiddle">
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
        <span class="lab_top_text" id="fname"><?php echo $profile_fname ?></span>
    </div>
    <div id="side" style="display:none;">
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
    
    <!--<div class="lab_text" id="lab_buttons">-->
    <!--    <button id="lab1" onclick="loadLab(1)" >Lab 1</button>-->
    <!--    <button id="lab2" onclick="loadLab(2)" >Lab 2</button>-->
    <!--    <button id="lab3" onclick="loadLab(3)" >Lab 3</button>-->
    <!--</div>-->
    
    <div id=lab_defn>
        <h3>Lab 1</h3>
        <p>
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin tincidunt justo ut augue ultricies ultricies. Pellentesque sit amet velit non justo convallis tristique. Mauris convallis orci in urna fermentum, non auctor turpis fermentum. Donec quis metus in massa volutpat vestibulum. Curabitur ornare, metus id faucibus euismod, risus lorem ultrices arcu, non ornare est urna sit amet libero. In eget sagittis felis. In sit amet enim tellus. Nullam rutrum iaculis tristique. Aliquam ut sodales nulla. Suspendisse rutrum lorem a arcu faucibus dictum eget posuere neque.
</p>
        <p>
        Nullam et semper nibh. Vivamus enim orci, venenatis quis dictum tincidunt, molestie ac augue. Mauris vitae nisl et tellus aliquet finibus nec blandit nisi. Vestibulum pharetra, elit sit amet ornare egestas, nisl augue volutpat felis, et venenatis est ligula ut arcu. Maecenas enim nulla, finibus quis quam quis, eleifend commodo dui. Vestibulum nec erat vitae neque sollicitudin viverra. Donec nisi augue, lobortis eget lorem eget, faucibus volutpat arcu. Cras gravida suscipit purus, in ullamcorper nibh tristique ut. Integer et tincidunt mauris. Donec convallis varius vehicula. Donec pulvinar tellus nunc, sit amet aliquam purus varius nec. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Mauris facilisis euismod interdum.
</p>
        <p>
        Praesent rutrum lectus eu finibus eleifend. Morbi diam urna, commodo sed sodales vitae, porttitor id est. In a tortor vel lorem bibendum hendrerit. Quisque sem risus, elementum et convallis id, gravida quis dui. Mauris ac bibendum tortor. Vestibulum aliquam consectetur quam vitae suscipit. Sed ut justo id ante finibus fringilla. In laoreet ac orci non malesuada. Praesent a leo bibendum, efficitur turpis ut, volutpat tellus. Maecenas a semper turpis. Integer vel rutrum est, consequat ullamcorper nulla.
</p>
        <button id="lab1" onclick="loadLab(2)" >Lab 1</button>
        
        <h3>Lab 2</h3>
        <p>
        Nam tristique vitae nulla id placerat. Morbi eu blandit eros. Suspendisse eu laoreet dolor. Cras nec ante vel nunc gravida volutpat eget lacinia sapien. In finibus euismod imperdiet. Nullam efficitur malesuada imperdiet. Integer id libero et orci facilisis pellentesque sit amet eu mi.
</p>
        <p>
        Vestibulum a orci vitae enim vehicula fringilla sed tincidunt sapien. Duis felis mi, mollis sed felis vel, ullamcorper finibus odio. Curabitur vitae ligula tristique, dignissim augue non, pretium tortor. Sed consequat, neque sit amet congue dignissim, nisl ligula commodo elit, vel posuere nunc nisl non leo. Cras tristique vel magna consectetur efficitur. Vivamus vel bibendum felis, sed rhoncus velit. Duis iaculis eu ante ac tristique. Nunc faucibus ac nibh at porttitor. Nullam scelerisque lacus in orci fermentum tempor. Interdum et malesuada fames ac ante ipsum primis in faucibus.
</p>
        <p>
        Vivamus et varius velit, quis tempus nibh. Donec ultricies magna quis erat dapibus tincidunt. Mauris hendrerit, est sit amet efficitur scelerisque, sem felis suscipit enim, in rutrum justo diam ut turpis. Donec elementum sit amet ante vitae dignissim. Cras iaculis elit at neque suscipit blandit. Sed a sapien nec lectus suscipit mattis et in elit. Etiam commodo suscipit rhoncus.
</p>
        <button id="lab2" onclick="loadLab(2)" >Lab 2</button>
        
        <h3>Lab 3</h3>
        <p>
        Integer dignissim ultrices purus sit amet tempus. Phasellus varius, est a iaculis dictum, felis nisl hendrerit metus, ac suscipit quam urna et mi. Fusce libero est, sagittis vel diam non, convallis mollis sem. Aliquam ornare blandit ipsum, id consequat libero fringilla ac. Cras et ullamcorper turpis, et dapibus nisi. Duis varius ipsum et cursus porta. Ut fringilla massa lacus, vel venenatis nisi dictum sit amet. Sed ut dolor id arcu imperdiet dictum sed at turpis. Cras porttitor rutrum tristique. Sed venenatis augue ut odio gravida, id interdum augue scelerisque. Pellentesque egestas dignissim odio sit amet varius. Proin facilisis viverra metus nec euismod.
</p>
        <p>
        Suspendisse nunc ex, lacinia vitae nibh vel, mattis posuere lacus. Morbi facilisis ante sed laoreet fringilla. Integer metus nisl, condimentum ut fringilla vitae, venenatis nec sem. Nullam vel elit nibh. Duis lobortis tristique lacinia. Suspendisse dignissim convallis ultrices. Nunc ornare egestas dui quis dapibus. Mauris at dapibus lectus. Vestibulum eget molestie est. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Mauris hendrerit blandit vestibulum. Fusce non aliquet massa. Donec eu lectus non nisi semper tincidunt in a urna. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum at aliquam mi. Maecenas ornare sit amet nisi ut luctus.
</p>
        <p>
        Curabitur at facilisis nisi. Nulla eu eros nulla. Quisque tristique dui ac quam tincidunt cursus. Sed placerat ante quam, non viverra nulla pharetra quis. Vestibulum feugiat, mauris in volutpat vestibulum, nisi eros convallis magna, ut vestibulum velit diam non tellus. Suspendisse nisl massa, rutrum vel hendrerit sit amet, ullamcorper non nisi. Proin lobortis facilisis elit at eleifend. Ut dapibus tempor urna eget mollis. Maecenas imperdiet arcu malesuada massa suscipit, vitae scelerisque justo dictum. Sed laoreet enim molestie nunc ullamcorper fermentum. Donec eleifend lorem non augue tincidunt, sed vulputate lectus blandit.
</p>
        <button id="lab3" onclick="loadLab(3)" >Lab 3</button>
    </div>
    
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
            
            <!--pdf-->
            <div class="sq" id="r2c2">
                <iframe id="lab_iframe" src="" height="100%" width="100%" style="display:block;"></iframe>
            </div>
            
            <!--code editor-->
            <div class="sq" id="r1c1">
                <div id="control_buttons" >
            	    <span id="save"></span>
            	    <input id="compile" type="button" value="Compile" onclick="program(<?php echo $log_idnumber; ?>,'c')">
            		<input id="program" type="button" value="Program" onclick="program(<?php echo $log_idnumber; ?>,'p')">
            	</div>
                <script> 
                    var code = document.getElementById("r1c1");
                    
                    <?php date_default_timezone_set("America/Jamaica");?>
                    
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
            
            <!--console output-->
            <div class="sq" id="r2c1">
                <span id="console_label">console@RemoteAVRLab:~$</span>
                <textarea id="output" rows="100" cols="105" readonly>&#13;&#10;&#13;&#10;</textarea>
            </div>
            
            <!--video window-->
            <div class="sq" id="r1c2">
                <!--<img src="2.jpg" alt="Smiley face" height="100%" width="100%">-->
                <div id="live">
        	        <!--<iframe width="660" height="400" src="https://www.youtube.com/embed/_z84FvCSlaw" scrolling="no" frameborder="0">-->
        	        <!--<iframe height="100%" width="100%" src="http://72.252.157.203:8081" frameborder="0" allowfullscreen style="display:block"></iframe>-->
        	        <img height="100%" width="100%" src="http://philliplogan.com:8081" style="display:block"></img>
        		        <!--<p>Your browser does not support iframes.</p>-->
        	        </iframe>
                </div>
            </div>
            
        </div>
    </div>
    
</div>
</body>
</html>