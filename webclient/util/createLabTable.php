<?php
include_once("../php/db_conx.php");

$tbl_labs = "CREATE TABLE labs (
			  idnumber VARCHAR(9) NOT NULL,
              bookedLab1 ENUM('0','1') NOT NULL DEFAULT '0',
              bookedLab2 ENUM('0','1') NOT NULL DEFAULT '0',
              bookedLab3 ENUM('0','1') NOT NULL DEFAULT '0',
              timebooked DATETIME NOT NULL,
              bookedStartTime DATETIME NOT NULL,
              bookedEndTime DATETIME NOT NULL,
              PRIMARY KEY (idnumber)
             )";
$query = mysqli_query($db_conx, $tbl_labs);
if ($query === TRUE) {
	echo "<h3>lab table created OK :) </h3>"; 
} else {
	echo "<h3>lab table NOT created :( </h3>"; 
	echo $query;
}
?>