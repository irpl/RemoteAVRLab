<?php
include_once("check_login_status.php");
?>
<?php
if (isset($_POST["s"])) {
    // include_once("check_login_status.php");
    $code = $_POST["s"];
    $i = $_POST["i"];
    
    //$file = fopen("../users/$log_idnumber/main.c", "w") or die ("Unable to write to file!");
    if ($file = fopen("../users/".$log_idnumber."/main.c", "w"))
    {
        fwrite($file, $code);
        fclose($file);
        echo "changes_saved";
        exit();
    } else {
        echo "didnt work";
        exit();
    }
    
    //check to see if file content matches the intended changes
}
?>
<?php
$fileName = $_FILES["file1"]["name"]; // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
$fileExtention = pathinfo($fileName, PATHINFO_EXTENSION);
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
}
if($fileExtention != "c" && $fileExtention != "asm" && $fileExtention != "hex"){
    echo "Invalid file type. Please choose a .c, .asm or .hex file.";
    exit();
}
//if(move_uploaded_file($fileTmpLoc, "../users/620053626/$fileName")){
if(move_uploaded_file($fileTmpLoc, "../users/".$log_idnumber."/main.c")){
    echo "$fileName upload is complete";
} else {
    echo "move_uploaded_file function failed";
}
?>