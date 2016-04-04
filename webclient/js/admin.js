function table() {
    return _('admin_table');
}

function refreshTable() {
    var content = table().innerHTML;
    table.innerHTML= "";
}

function getDataFromRow(row) {
    var cells = table().rows.item(row).cells;
    var id = cells.item(0).innerHTML;
    var idnumber = cells.item(2).innerHTML;
    var fname = cells.item(3).innerHTML.split(" ")[0];
    var email = cells.item(4).innerHTML;
    var user = [id, idnumber, email, fname];
    return user;
}

function activate(row, what) {
    var user = getDataFromRow(row);
    var status =_("status"); 
    if (what != 1 && what != 0){
        alert("Something went wrong");
        return;
    }
    if (what) {
        var word = "deactivate";
    } else {
        var word = "activate";
    }
    if (confirm("You are about to "+word+" user "+user[3]+".\nAre you sure?")) {
        var ajax = ajaxObj("POST", "php/activation.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText != "activation_success"){
	                status.innerHTML = ajax.responseText;
					//setTimeout(function () { window.location.reload(); }, 10);
					console.log(ajax.responseText);
					//_("signupbtn").style.display = "block";
				} else {
					status.innerHTML = ajax.responseText;
					//setTimeout(function () { window.location.reload(); }, 10);
					//window.scrollTo(0,0);
					//_("signupform").innerHTML = "</br></br>OK "+f+", you will receive an email at <u>"+e+"</u> that will contain a request link to the course coordinator. Your account must be activated by the course coordinator. You will not be able to do anything on the site until your account is successfully activated.</br></br></br></br></br>";
				}
	        }
        }
        ajax.send("id="+user[0]+"&i="+user[1]+"&e="+user[2]+"&w="+what);
        //while (status.innerHTML == ""){}
        //refreshTable();
    }
}

function del(row) {
    var user = getDataFromRow(row);
    if (confirm("You are about to delete user "+user[3]+".\nAre you sure?")) {
        //alert(user);
        var ajax = ajaxObj("POST", "admin.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText != "delete_success"){
	               // _("status").innerHTML = ajax.responseText;
	               _("status").innerHTML = ajax.responseText;
					//setTimeout(function () { window.location.reload(); }, 10);
				} else {
					//_("status").innerHTML = "done";
					setTimeout(function () { window.location.reload(); }, 10);
				}
	        }
        }
        ajax.send("d="+user[0]+"&i="+user[1]+"&e="+user[2]);
        //refreshTable();
    }
}

function select_all() {
    var num_rows = table().rows.length;
    for(var i = 1; i < num_rows; i++) {
        document.getElementById("check"+i).checked = document.getElementById("check0").checked;
    }
}

function showTab(thing) {
    $("#"+thing).siblings().hide();
    $("#"+thing).show();
}