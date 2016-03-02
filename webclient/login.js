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
function emptyElement(x){
    _(x).innerHTML = "";
}
function login(){ 
    var i = _("idnumber").value;
    var p = _("password").value;
    if(i == "" || p == ""){ 
        _("status").innerHTML = "Fill out all of the form data";
    } else { 
        _("loginbtn").style.display = "none"; 
        _("status").innerHTML = 'please wait ...'; 
        var ajax = ajaxObj("POST", "login.php"); 
        ajax.onreadystatechange = function() { 
            if(ajaxReturn(ajax) == true) { 
                if(ajax.responseText == "login_failed"){ 
                    _("status").innerHTML = "Login unsuccessful, please try again."; 
                    _("loginbtn").style.display = "block"; 
                    
                } else { 
                    window.location = "user.php?i="+ajax.responseText; 
                } 
            } 
        } 
        ajax.send("i="+i+"&p="+p); 
    } 
}