<?php
include_once("../php/db_conx.php");

$tbl_labs = "CREATE TABLE lab_info (
			  labnumber INT(3) NOT NULL AUTO_INCREMENT,
              title VARCHAR(40) NOT NULL,
              labduration INT NOT NULL,
              PRIMARY KEY (labnumber)
             )";
$query = mysqli_query($db_conx, $tbl_labs);
if ($query === TRUE) {
	echo "<h3>lab_info table created OK :) </h3>"; 
} else {
	echo "<h3>lab_info table NOT created :( </h3>"; 
	echo $query;
}
?>