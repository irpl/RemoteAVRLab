<?php
if(isset($_POST["b"]) && isset($_POST["id"]) && isset($_POST["dt"])) {
    include_once("db_conx.php");
    date_default_timezone_set("America/Jamaica");

    if(is_nan($_POST["b"])) {
        echo "not_a_number";
        exit();
    } else {
        $lab_number = $_POST["b"];
    }
    $bookedlab1 = 0;
    $bookedlab2 = 0;
    $bookedlab3 = 0;
    if($lab_number == 1){
        $bookedlab1 = 1;
    } else if($lab_number == 2){
        $bookedlab2 = 1;
    } else if($lab_number == 3){
        $bookedlab3 = 1;
    }
    
    $idnumber = preg_replace('#[^0-9]#i', '', $_POST['id']);
    $startdatetime = preg_replace('#[^0-9-: ]#i', '', $_POST['dt']);
    // $book_date = preg_replace('#[\/]#i', '-', $book_date);
    // list($m, $d, $y) = explode("/", $book_date);
    // $book_date = $y.'-'.$m.'-'.$d;
    
    // $book_time = preg_replace('#[^0-9:APM]#i', '', $_POST['t']);
    
    // $ampm = substr($book_time, -2);
    // $time = substr($book_time, 0, -2);
    // $HHMM = explode(":", $time);
    
    // if(substr($book_time, -2) == "AM") {
    //     if ($HHMM[0] == "12"){
    //         $HHMM[0] = "00";
    //         $t = $HHMM[0].":".$HHMM[1].":00";
    //     } else {
    //         $t = $time.":00";
    //     }
    // } else if(substr($book_time, -2) == "PM"){
    //     if ($HHMM[0] != "12"){
    //         $HHMM[0] += 12; 
    //     }
    //     $t = $HHMM[0].":".$HHMM[1].":00";
    // }
    

    
    
    $sql = "SELECT labduration FROM lab_info WHERE labnumber='$lab_number'";
    $query = mysqli_query($db_conx, $sql);
    while($row = mysqli_fetch_row($query)){
        $duration = $row[0];
    }

    $enddatetime = date("Y-m-d H:i:s", strtotime($startdatetime)+(60*$duration)-1);
    if(strtotime(date("Y-m-d H:i:s")) > strtotime($startdatetime)){
        echo "too_early";
        exit();
    }
    
    $sql = "SELECT * FROM labs";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    if($numrows > 0){
        $sql = "SELECT bookedLab1, bookedLab2, bookedLab3, bookedStartTime, bookedEndTime FROM labs";
        $query = mysqli_query($db_conx, $sql);
        $new_lab = array($bookedlab1, $bookedlab2, $bookedlab3);
        while($row = mysqli_fetch_row($query)){
            $old_lab = array($row[0], $row[1], $row[2]);
            if(((strtotime($enddatetime) >= strtotime($row[3])) && (strtotime($enddatetime) <= strtotime($row[4])) || (strtotime($startdatetime) >= strtotime($row[3]))) && (strtotime($startdatetime) <= strtotime($row[4])) && ($new_lab == $old_lab)){
                echo "time_unavailable";
                exit();
            } 
        }
    }
    $sql = "INSERT INTO labs (idnumber, bookedLab1, bookedLab2, bookedLab3, timebooked, bookedStartTime, bookedEndTime) VALUES ('$idnumber', '$bookedlab1', '$bookedlab2', '$bookedlab3', NOW(), '$startdatetime', '$enddatetime') ON DUPLICATE KEY UPDATE bookedLab1='$bookedlab1', bookedLab2='$bookedlab2', bookedLab3='$bookedlab3', timebooked=NOW(), bookedStartTime='$startdatetime', bookedEndTime='$enddatetime'";
    $query = mysqli_query($db_conx, $sql);
    
    //check if it was done
    $sql = "SELECT idnumber FROM labs WHERE bookedStartTime='$startdatetime' AND bookedEndTime='$enddatetime' LIMIT 1";
    $query = mysqli_query($db_conx, $sql);
    $numrows = mysqli_num_rows($query);
    $row = mysqli_fetch_row($query);
    if ($numrows == 1 && $row[0] == $idnumber){
        echo "user_booked";    
    } else {
        echo "user_not_booked";
    }
    exit();
}
?>