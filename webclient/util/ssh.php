<?php
//set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib/');
include('Net/SSH2.php');
include('Net/SFTP.php');

$sftp = new Net_SFTP('72.252.157.203');
if (!$sftp->login('root', 'twotothenthr00t')) {
    exit('Login Failed');
}

//$code = file_get_contents('../users/620053626/main.c');

echo $sftp->exec('pwd');
// $sftp->put('/home/odroid/Desktop/t85_test/main.c', '../users/620053626/main.c', NET_SFTP_LOCAL_FILE);
// $sftp->write("make install -C /home/odroid/Desktop/t85_test/\n");
// echo $sftp->read();
// while($sftp->read() != ""){
//     echo $sftp->read();
// }

/*
sudo apt-get install php5-pgsql php-pear
sudo pear channel-discover phpseclib.sourceforge.net
sudo pear remote-list -c phpseclib
sudo pear install phpseclib/Net_SSH2
sudo service apache2 restart
*/
?>


