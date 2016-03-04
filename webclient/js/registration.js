function _(x){
	return document.getElementById(x);
}
function ajaxObj( meth, url ) {
	var x = new XMLHttpRequest();
	x.open( meth, url, true );
	x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	return x;
}
function ajaxReturn(x){
	if(x.readyState == 4 && x.status == 200){
	    return true;	
	}
}
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "idnumber"){
		rx = /[^0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
	_(x).innerHTML = "";
}
function checkidnumber(){
	var i = _("idnumber").value;
	if(i != ""){
		_("idnumstatus").innerHTML = 'checking ...';
		var ajax = ajaxObj("POST", "php/signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            _("idnumstatus").innerHTML = ajax.responseText;
	        }
        }
        ajax.send("idnumbercheck="+i);
	}
}
function signup(){
	var f = _("fname").value;
	var l = _("lname").value;
	var i = _("idnumber").value;
	var e = _("email").value;
	var p1 = _("pass1").value;
	var p2 = _("pass2").value;
	var status = _("status");
	if(f == "" || l == "" || i == "" || e == "" || p1 == "" || p2 == ""){
		status.innerHTML = "Fill out all of the form data";
	} else if(p1 != p2){
		status.innerHTML = "Your password fields do not match";
	} else {
		_("signupbtn").style.display = "none";
		status.innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "php/signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText != "signup_success"){
					status.innerHTML = ajax.responseText;
					_("signupbtn").style.display = "block";
				} else {
					window.scrollTo(0,0);
					_("signupform").innerHTML = "</br></br>OK "+f+", you will receive an email at <u>"+e+"</u> that will contain a request link to the course coordinator. Your account must be activated by the course coordinator. You will not be able to do anything on the site until your account is successfully activated.</br></br></br></br></br>";
				}
	        }
        }
        ajax.send("f="+f+"&l="+l+"&i="+i+"&e="+e+"&p="+p1);
	}
}