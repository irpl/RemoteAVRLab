<?php
{
$ip = "72.252.157.140";
$user = "admin";
$pass = "kickmonkeydoukeN1";
$port = "3306";
$db = "ral_db";
}
$db_conx = mysqli_connect(localhost, "irpl","" , "ral_db");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
}
?>