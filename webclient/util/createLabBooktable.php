<?php
include_once("../php/db_conx.php");

$tbl_labs = "CREATE TABLE labbooking (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  idnumber VARCHAR(9) NOT NULL,
              labbooked INT(2) NOT NULL DEFAULT '0',
              timebooked DATETIME NOT NULL,
              bookedStartTime DATETIME NOT NULL,
              bookedEndTime DATETIME NOT NULL,
              PRIMARY KEY (id)
             )";
$query = mysqli_query($db_conx, $tbl_labs);
if ($query === TRUE) {
	echo "<h3>lab table created OK :) </h3>"; 
} else {
	echo "<h3>lab table NOT created :( </h3>"; 
	echo $query;
}
?>