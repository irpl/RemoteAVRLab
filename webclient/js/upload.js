function _(el){
	return document.getElementById(el);
}
function uploadFile(){
	var file = _("file1").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("file1", file);
	var ajax = new XMLHttpRequest();
	ajax.upload.addEventListener("progress", progressHandler, false);
	ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.open("POST", "php/upload.php");
	ajax.send(formdata);
}
function progressHandler(event){
	_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
	var percent = (event.loaded / event.total) * 100;
	_("progressBar").value = Math.round(percent);
	_("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function completeHandler(event){
	_("status").innerHTML = event.target.responseText;
	_("progressBar").value = 0;
	
	var file = _("file1").files[0];
	if (file) {
	    var reader = new FileReader();
	    reader.readAsText(file, "UTF-8");
	    reader.onload = function (evt) {
	        //document.getElementById("code").value = evt.target.result;
	        //editor.getDoc().setValue(document.getElementById("code").value);
	        editor.getDoc().setValue(evt.target.result);
	    }
	    reader.onerror = function (evt) {
	        document.getElementById("code").value = "error reading file";
	    }
	}
	
}
function errorHandler(event){
	_("status").innerHTML = "Upload Failed";
}
function abortHandler(event){
	_("status").innerHTML = "Upload Aborted";
}
function save() {
	var code = editor.getValue();
	
	var ajax = ajaxObj("POST", "php/upload.php"); 
        ajax.onreadystatechange = function() { 
            if(ajaxReturn(ajax) == true) { 
                if(ajax.responseText == "changes_saved"){ 
                	_("save").innerHTML = "All changes saved"; 
                	//_("error").innerHTML = code; 
                    
                } else { 
                    _("error").innerHTML =  ajax.responseText; 
                } 
            } 
        } 
        ajax.send("s="+encodeURIComponent(code)); 
	
}