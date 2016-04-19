<?php
if(isset($_POST["b"]) && isset($_POST["id"]) && isset($_POST["dt"])) {
    include_once("db_conx.php");
    date_default_timezone_set("America/Jamaica");

    if(is_nan($_POST["b"])) {
        echo "not_a_number";
        exit();
    } else {
        $bookedlab = $_POST["b"];
    }
    // $bookedlab1 = 0;
    // $bookedlab2 = 0;
    // $bookedlab3 = 0;
    // if($lab_number == 1){
    //     $bookedlab1 = 1;
    // } else if($lab_number == 2){
    //     $bookedlab2 = 1;
    // } else if($lab_number == 3){
    //     $bookedlab3 = 1;
    // }
    
    $idnumber = preg_replace('#[^0-9]#i', '', $_POST['id']);
    $startdatetime = preg_replace('#[^0-9-: ]#i', '', $_POST['dt']);

    $sql = "SELECT labduration FROM lab_info WHERE labnumber='$bookedlab'";
    $query = mysqli_query($db_conx, $sql);
    while($row = mysqli_fetch_row($query)){
        $duration = $row[0];
    }

    $enddatetime = date("Y-m-d H:i:s", strtotime($startdatetime)+(60*$duration)-1);
    if(strtotime(date("Y-m-d H:i:s")) > strtotime($startdatetime)){
        echo "too_early";
        exit();
    }
    
    $sql = "SELECT * FROM labbooking";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows > 0){
        $sql = "SELECT labbooked, bookedStartTime, bookedEndTime FROM labbooking";
        $query = mysqli_query($db_conx, $sql);
        ///$new_lab = array($bookedlab1, $bookedlab2, $bookedlab3);
        while($row = mysqli_fetch_row($query)){
            //$old_lab = array($row[0], $row[1], $row[2]);
            //if(((strtotime($enddatetime) >= strtotime($row[3])) && (strtotime($enddatetime) <= strtotime($row[4])) || (strtotime($startdatetime) >= strtotime($row[3]))) && (strtotime($startdatetime) <= strtotime($row[4])) && ($new_lab == $old_lab)){
            if ( 
                ($bookedlab == $row[0])// check to see if the lab being booked has a bookee already
                && 
                (     //if this end time is after existing start time       but  if this end time is before same existing end time
                    ( ( strtotime($enddatetime)    >= strtotime($row[1]) )  &&  (strtotime($enddatetime)    <= strtotime($row[2])) )
                    ||//if this start time is before existing end time      but  if this start time is after same existing start time
                    ( ( strtotime($startdatetime)  <= strtotime($row[2]) )  &&  (strtotime($startdatetime)  >= strtotime($row[1])) )
                )
            )
            {
                echo "time_unavailable";
                exit();
            } 
        }
    }
    // $sql = "INSERT INTO labbooking (idnumber, labbooked, timebooked, bookedStartTime, bookedEndTime) VALUES ('$idnumber', '$bookedlab', NOW(), '$startdatetime', '$enddatetime') ON DUPLICATE KEY UPDATE labbooked='$bookedlab', timebooked=NOW(), bookedStartTime='$startdatetime', bookedEndTime='$enddatetime'";
    $sql = "INSERT INTO labbooking (idnumber, labbooked, timebooked, bookedStartTime, bookedEndTime) VALUES ('$idnumber', '$bookedlab', NOW(), '$startdatetime', '$enddatetime')";
    $query = mysqli_query($db_conx, $sql);
    
    //check if it was done
    $sql = "SELECT idnumber FROM labbooking WHERE labbooked='$bookedlab' AND bookedStartTime='$startdatetime' AND bookedEndTime='$enddatetime'";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    $row = mysqli_fetch_row($query);
    if ($numrows > 0){
        echo "user_booked";    
    } else {
        echo "user_not_booked";
    }
    exit();
}
?>