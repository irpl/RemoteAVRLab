var lab_number;
var title;

function loadLab(lab){
    lab_number = lab;
    _("loading").style.display="block";
    // _("lab_buttons").style.display="none";
    _("lab_defn").style.display="none";
    _("lab_number").innerHTML = "Lab "+lab;
    _("lab_iframe").src = "labs/lab"+lab+"/lab.php";
    var ajax = ajaxObj("POST", "php/program.php"); 
        ajax.onreadystatechange = function() { 
            if(ajaxReturn(ajax) == true) { 
                if(ajax.responseText == "loaded_lab"+lab){ 
                	//alert("ready");
                // 	_("lab").innerHTML = loaded;
                    //_("lab_title").innerHTML = "Lab "+lab+title;
                    
                	_("lab").style.display="block";
                	_("upload_buttons").style.display="block";
                	
                	if (lab == 1){
                        title = " DELAY LOOPS & DIGITAL INPUT/OUTPUT";
                    } else if(lab == 2){
                        title = " Dice";
                    } else if(lab == 3){
                        title = " Arm";
                    }
                	console.log(ajax.responseText);
                	editor.refresh();
                	console.log(title);
                    save();
                	_("loading").style.display="none";
                } else { 
                    alert("not ready"); 
                } 
            } 
        } 
        ajax.send("y="+lab); 
    // startTimer(60*5);
}
function program(idnumber, what) {
    var i = idnumber;
    if (isNaN(i)){
        alert("Something went wrong");
        return;
    }
    _("program").disabled = true;
    _("compile").disabled = true;
    var ajax = ajaxObj("POST", "php/program.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
                if(ajax.responseText != "not_signed_in"){
                    _("output").value +=ajax.responseText +"\n\n";
	                _("program").disabled = false;
	                _("compile").disabled = false;
	                _("output").scrollTop = _("output").scrollHeight;
				} else {
				    _("output").value +=ajax.responseText +"\n\n";
				    _("program").disabled = false;
				    _("compile").disabled = false;
				} 
	        }
        }
        ajax.send(what+"="+i+"&l="+lab_number);
}
var which_lab;
var datetime;
function initfullCallendar() {
    // page is now ready, initialize the calendar...
    $('#calendar').fullCalendar({
        // put your options and callbacks here
        dayClick: function(date, jsEvent, view, resourceObj) {
    
            console.log('Date: ' + date.format());
            
            var view = $('#calendar').fullCalendar('getView');
            if(view.name == "month"){
                $("#calendar").fullCalendar( "changeView", "agendaDay");
                $("#calendar").fullCalendar( 'gotoDate', date.format() );
            }
            if (view.name == "agendaDay"){
                datetime = date.format().replace("T", " ");
                if(confirm("You've chosen "+datetime+" as you lab time slot,\nIs this ok?")){
                    bookLab(datetime);
                }
            }
        }
    })
}


function chooseTime(ele) {
    _("lab_defn").style.display = "none";
    // _("booking_form").style.display = "block";
    initfullCallendar();
    _("calendar").style.display = "block";
    $("#calendar").fullCalendar("today");

    which_lab = ele.id.slice(-1);
}


function bookLab(dt) {
    var id = _("user_id").innerHTML;
    
    var ajax = ajaxObj("POST", "php/booking.php");
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if(ajax.responseText != "user_booked"){
                //console.log(ajax.responseText);
                alert(ajax.responseText);
                _("smn_").innerHTML = ajax.responseText;
            } else {
                alert("Time Booked Successfully");
                location.reload();
            }
        }
    }
    ajax.send("b="+which_lab+"&id="+id+"&dt="+dt);
}

