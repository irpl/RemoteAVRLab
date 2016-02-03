<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


// Allow certain file formats
if($imageFileType != "c" && $imageFileType != "asm" && $imageFileType != "hex") 
{
    echo "Sorry, only c, asm and hex files are allowed.";
    $uploadOk = 0;
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
        header('Location: index.html');
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


?>