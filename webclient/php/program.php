<?php
include_once("check_login_status.php");
include('Net/SFTP.php');
?>
<?php
if(isset($_POST["y"])) {
    if (is_nan($_POST["y"]))
    {
        echo "not_a_number";
        exit();
    } else {
        $port = $_POST["y"];
    }
    
    $sftp = new Net_SFTP('63.143.90.38');
    if (!$sftp->login('root', 'twotothenthr00t')) {
        exit('Login Failed');
    }
    
    $sftp->exec("/home/odroid/bin/ykush -d a");
    $sftp->exec("/home/odroid/bin/ykush -u ".$port);/*$port*/
    $sftp->exec("exit");
    
    echo "loaded_lab".$port;
    exit();
    
}

if ((isset($_POST['p']) || isset($_POST['c'])) && isset($_POST["l"])){
    
    $l = $_POST["l"];
    $dir = "";
    $file = "";
    
    if(intval($l) == 1){
        $dir = "t85_test";
        $file = "main.S";
    } else if (intval($l) == 2){
        $dir = "attiny2313_test";
        $file = "main.c";
    } else if (intval($l) == 3){
        $dir = "328p_test";
        $file = "main.c";
    } else {
        echo '$l is '.$_POST['l'];
        exit();
    }
    
    
    
    if(isset($_POST['p'])){
        $cmd = "make install";
        $i = preg_replace('#[^0-9]#i', '', $_POST['p']);
    } else {
        $cmd = "make";;
        $i = preg_replace('#[^0-9]#i', '', $_POST['c']);
    }
    
    if($i != $log_idnumber){
        echo "not_signed_in";
        exit();
    }
    
    //set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib/');
    //include('Net/SFTP.php');
    
    $sftp = new Net_SFTP('63.143.90.38');
    if (!$sftp->login('root', 'twotothenthr00t')) {
        exit('Login Failed');
    }
    
    $sftp->put("/home/odroid/Desktop/".$dir."/".$file, "../users/".$i."/main", NET_SFTP_LOCAL_FILE);
    echo $sftp->exec($cmd." -C /home/odroid/Desktop/".$dir);
    $sftp->exec("exit");
    exit();
}
?>