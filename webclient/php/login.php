<?php 
include_once("check_login_status.php"); 

// If user is already logged in, header that weenis away
if($user_ok == true){ 
    header("location: user?i=".$_SESSION["idnumber"]); //pickle
    exit(); 
    
} 
?>
<?php 

// AJAX CALLS THIS LOGIN CODE TO EXECUTE
if(isset($_POST["i"])){ 
    // CONNECT TO THE DATABASE
    include_once("db_conx.php"); 
    
    // GATHER THE POSTED DATA INTO LOCAL VARIABLES AND SANITIZE
    $i = preg_replace('#[^0-9]#i', '', $_POST['i']); 
    $p = md5($_POST['p']); 
    // GET USER IP ADDRESS
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR')); 
    // FORM DATA ERROR HANDLING
    if($i == "" || $p == ""){ 
        echo "login_failed"; 
        exit(); 
        
    } else { 
        // END FORM DATA ERROR HANDLING
        $sql = "SELECT id, email, password FROM users WHERE idnumber='$i' AND activated='1' LIMIT 1"; 
        $query = mysqli_query($db_conx, $sql); 
        $row = mysqli_fetch_row($query); 
        $db_id = $row[0]; 
        $db_email = $row[1]; 
        $db_pass_str = $row[2];
        //$db_idnumber = $i;
        if($p != $db_pass_str){ 
            echo "login_failed"; 
            exit(); 
        } else { 
            // CREATE THEIR SESSIONS AND COOKIES
            $_SESSION['userid'] = $db_id; 
            $_SESSION['idnumber'] = $i; 
            $_SESSION['password'] = $db_pass_str; 
            setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE); 
            setcookie("idnumber", $i, strtotime( '+30 days' ), "/", "", "", TRUE); 
            setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
            // UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
            $sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE idnumber='$i' LIMIT 1";
            $query = mysqli_query($db_conx, $sql); 
            echo $i; 
            exit(); 
        } 
    } 
    exit(); 
} 
?>