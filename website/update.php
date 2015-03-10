<?php
date_default_timezone_set('Europe/Amsterdam');
$today = date('d:m:y');

$url = "http://5.231.63.236/log.php";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_FAILONERROR, true); 
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   
curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.64 Safari/537.36');
$result = curl_exec($curl); 

$filename = "data/raw/".$today.".txt";
touch($filename);
file_put_contents($filename, $result);

sleep(1);

// $url = "http://5.231.63.236/reset.php?verified=true&secure=false";
// $curl = curl_init($url);
// curl_setopt($curl, CURLOPT_FAILONERROR, true); 
// curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
// curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   
// curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.64 Safari/537.36');
// curl_exec($curl);

sleep(1);

//further calculations

$data = $result;

?>