<?php
include_once("php/check_login_status.php");
if ($log_idnumber != ""){
	header("location: user.php?i=".$log_idnumber);
}
?>
<!DOCTYPE html>
<html>
<head>
	<link href='css/login.css' rel='stylesheet' type='text/css'>
	<script src="js/ajax.js"></script>
	<script src="js/login.js"></script>
	<title></title>
</head>
<body>
	<!--<div class="logo"></div>-->
	<div class="login-block">
	    <div class="logo"></div>
	    <div>
    	    <h1>Login</h1>
    	    <form id="loginform" onsubmit="return false;">
    	    	<input id="idnumber" type="text" value="" placeholder="ID Number" onfocus="emptyElement('status')"/><br />
    	    	<input id="password" type="password" value="" placeholder="Password" onfocus="emptyElement('status')"/><br />
    	    </form>
    	    <p id="status"></p>
    	    <div id="rem-reg">
    	        <label><input type="checkbox" name="remember" value="remember" id="remember" /><span id="remember-text">Remember me</span></label>
        	    <span id="not-reg"><a href="registration.html">Not yet registered?</a></span>
    	    </div>
    	    <button id="loginbtn" onclick="login()" >Login</button>
	    </div>
	</div>
</body>
</html>