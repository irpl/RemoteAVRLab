<?php
if(isset($_POST["b"]) && isset($_POST["id"]) && isset($_POST["d"]) && isset($_POST["t"])) {
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
    $book_date = preg_replace('#[^0-9\/]#i', '', $_POST['d']);
    // $book_date = preg_replace('#[\/]#i', '-', $book_date);
    list($m, $d, $y) = explode("/", $book_date);
    $book_date = $y.'-'.$m.'-'.$d;
    
    $book_time = preg_replace('#[^0-9:APM]#i', '', $_POST['t']);
    
    $ampm = substr($book_time, -2);
    $time = substr($book_time, 0, -2);
    $HHMM = explode(":", $time);
    
    if(substr($book_time, -2) == "AM") {
        if ($HHMM[0] == "12"){
            $HHMM[0] = "00";
            $t = $HHMM[0].":".$HHMM[1].":00";
        } else {
            $t = $time.":00";
        }
    } else if(substr($book_time, -2) == "PM"){
        if ($HHMM[0] != "12"){
            $HHMM[0] += 12; 
        }
        $t = $HHMM[0].":".$HHMM[1].":00";
    }
    include_once("db_conx.php");
    
    $sql = "SELECT labduration FROM lab_info WHERE labnumber='$lab_number'";
    $query = mysqli_query($db_conx, $sql);
    while($row = mysqli_fetch_row($query)){
        $duration = $row[0];
    }

    $startdatetime = $book_date ." ". $t;
    $enddatetime = date("Y-m-d H:i:s", strtotime($startdatetime)+(60*$duration));
    // echo $enddatetime;
    // exit();
    
    
    $sql = "INSERT INTO labs (idnumber, bookedLab1, bookedLab2, bookedLab3, timebooked, bookedStartTime, bookedEndTime) VALUES ('$idnumber', '$bookedlab1', '$bookedlab2', '$bookedlab3', NOW(), '$startdatetime', '$enddatetime')";
    $query = mysqli_query($db_conx, $sql);
    
    //check if it was done
    
    if (true){
        echo "user_booked";    
    } else {
        echo "user_not_booked";
    }
    exit();
}
?>

<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--<meta charset="utf-8">-->
<!--<title>jQuery UI Datepicker - Default functionality</title>-->
    
<!--    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
<!--    <script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
<!--    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
<!--    <script type="text/javascript" src="js/jquery.ptTimeSelect.js"></script>-->
<!--    <link rel="stylesheet" href="/resources/demos/style.css">  -->
<!--    <link rel="stylesheet" href="css/jquery.ptTimeSelect.css">-->
    
<!--    <script>-->
<!--        $(function() {-->
<!--            $( "#datepicker" ).datepicker();-->
<!--        });-->
<!--        $(document).ready(function(){-->
            // find the input fields and apply the time select to them.
<!--            $("#timepicker").ptTimeSelect({timeFormat: "H:i"});-->
<!--        });-->
<!--    </script>-->
    
<!--</head>-->
<!--<body>-->
    
<!--<form>-->
<!--    <div>Date: <input id="datepicker" type="text"/></div>-->
<!--    <div>Time: <input id="timepicker" type="text"/></div>-->
<!--    <button id="booklab" onclick="bookLab(<?php echo $profile_idnumber ?>, 1)" >Book Lab</button>-->
<!--</form>-->

<!--</body>-->
<!--</html>-->