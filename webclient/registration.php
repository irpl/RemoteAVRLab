<!DOCTYPE html>
<html>
<head>
	<link href='css/registration.css' rel='stylesheet' type='text/css'>
	<script src="js/registration.js"></script>
	<title></title>
</head>
<body>
	<div class="login-block">
	    <div class="logo"></div>
	    <div>
    	    <h1>Register</h1>
    	    <form name="signupform" id="signupform" onsubmit="return false;">
	    	    <input id="fname" type="text" value="" placeholder="First Name" /><br />
	    	    <input id="lname" type="text" value="" placeholder="Last Name" /><br />
	    	    <input id="email" type="text" value="" placeholder="Email" onfocus="emptyElement('status')" onkeyup="restrict('email')" maxlength="88"/><br />
	    	    <input id="idnumber" type="text" value="" placeholder="ID Number" onblur="checkidnumber()" onkeyup="restrict('idnumber')" maxlength="9"/><br />
	    	    <p id="idnumstatus"> </p><br />
	    	    <input id="pass1" type="password" value="" placeholder="Password" 			onfocus="emptyElement('status')" maxlength="16"/><br />
	    	    <input id="pass2" type="password" value="" placeholder="Confirm Password" 	onfocus="emptyElement('status')" maxlength="16"/><br />
	    	    <button id="signupbtn" onclick="signup()">Create Account</button>
	    	    <span id="status"></span>
	    	</form>
	    </div>
	</div>
</body>
</html>