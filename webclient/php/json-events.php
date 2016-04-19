<?php
include_once("db_conx.php");
if(isset($_POST["l"])){
    $lab_number = "";
    if(!is_nan($_POST["l"])){
        $lab_number = $_POST["l"];
    } else {
        exit("NaN");
    }
    $sql = "SELECT idnumber, bookedStartTime, bookedEndTime FROM labbooking WHERE labbooked='$lab_number'";
    $query = mysqli_query($db_conx, $sql);
    while ($record = mysqli_fetch_array($query)) {
        $event_array[] = array(
            'title' => $record['idnumber'],
            'start' => $record['bookedStartTime'],
            'end' => $record['bookedEndTime'],
            'allDay' => false
        );
    }

    echo json_encode($event_array);
    exit();
}
?>