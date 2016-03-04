<?php
include_once("../php/db_conx.php");

$tbl_users = "CREATE TABLE users (
              id INT(11) NOT NULL AUTO_INCREMENT,
			  idnumber VARCHAR(9) NOT NULL,
			  fname VARCHAR(100) NOT NULL,
			  lname VARCHAR(100) NOT NULL,
			  email VARCHAR(255) NOT NULL,
			  password VARCHAR(255) NOT NULL,
			  signup DATETIME NOT NULL,
			  lastlogin DATETIME NOT NULL,
			  ip VARCHAR(255) NOT NULL,
			  activated ENUM('0','1') NOT NULL DEFAULT '0',
			  activation VARCHAR(74) NOT NULL,
			  admin ENUM('0','1') NOT NULL DEFAULT '0', 
              PRIMARY KEY (id),
			  UNIQUE KEY idnumber (idnumber,email)
             )";
$query = mysqli_query($db_conx, $tbl_users);
if ($query === TRUE) {
	echo "<h3>user table created OK :) </h3>"; 
} else {
	echo "<h3>user table NOT created :( </h3>"; 
}