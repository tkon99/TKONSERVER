<?php
include('auth.php');

include('FtpClient/FtpWrapper.php');
include('FtpClient/FtpException.php');
include('FtpClient/FtpClient.php');

$secure = $_GET["secure"]; //should be false
$verified = $_GET["verified"]; //should be true

if($secure !== 'false' && $secure !== false){
	if($verified !== 'true' && $verified !== true){
		echo('Verification failed');
		exit();
	}
}

$host = '5.231.63.236';
$login = $ftp_user;
$password = $ftp_pass;

$ftp = new \FtpClient\FtpClient();
$ftp->connect($host);
$ftp->login($login, $password);

$ftp->up();
$ftp->up();
$ftp->remove('AC/screenlog.0');
?>