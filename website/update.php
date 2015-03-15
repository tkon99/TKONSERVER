<?php
date_default_timezone_set('Europe/Amsterdam');
$today = date('d-m-y');

$url = "http://5.231.63.236/log.php";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_FAILONERROR, true); 
//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
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

//paterns
$pattern = '/(?:\[.{1,}\]) ((?:[\w\d{}$@!%&*()+\-=~?<>\[\],.]){1,}) (headshot|slashed|gibbed|shredded|punctured|picked off) ((?:[\w\d{}$@!%&*()+\-=~?<>\[\],.]){1,})/i';
$teamkill_pattern = '/(?:\[.{1,}\]) ((?:[\w\d{}$@!%&*()+\-=~?<>\[\],.]){1,}) (headshot|slashed|gibbed|shredded|punctured|picked off) (?:(?:their)? teammate) ((?:[\w\d{}$@!%&*()+\-=~?<>\[\],.]){1,})/i';
$suicide_pattern = '/(?:\[.{1,}\]) ((?:[\w\d{}$@!%&*()+\-=~?<>\[\],.]){1,}) (suicided)/i';

//execute regex
preg_match_all($pattern, $data, $matches);
preg_match_all($teamkill_pattern, $data, $teamkill_matches);
preg_match_all($suicide_pattern, $data, $suicide_matches);

//variables
$day = array();
$totals = array("kill"=>0, "death"=>0, "headshot"=>0, "knife"=>0, "teamkill"=>0, "suicide"=>0);
global $users;
$users = array();

function add2user($user, $type){
	if(empty($user) || empty($type)){
		return false;
	}else{
		global $users;
		if(!isset($users[$user])){
			$users[$user] = array("kill"=>0, "death"=>0, "headshot"=>0, "knife"=>0, "teamkill"=>0, "suicide"=>0);
		}

		$users[$user][$type]++;
	}
}

//normal kills
for($i = 0; $i < count($matches[0]); $i++){
	$killer = $matches[1][$i];

	if(strpos($killer,'says') !== false){ //safety so someone can't use chat to boost stats
		continue;
	}

	$victim = $matches[3][$i];
	$method = $matches[2][$i];

	$totals["kill"]++;
	add2user($killer, "kill");

	$totals["death"]++;
	add2user($victim, "death");

	if(strtolower($method) == "headshot"){
		$totals["headshot"]++;
		add2user($killer, "headshot");
	}else if(strtolower($method) == "slashed"){
		$totals["knife"]++;
		add2user($killer, "knife");
	}
}

//teamkills
for($i = 0; $i < count($teamkill_matches[0]); $i++){
	$killer = $teamkill_matches[1][$i];

	if(strpos($killer,'says') !== false){ //safety so someone can't use chat to boost stats
		continue;
	}

	$victim = $teamkill_matches[3][$i];
	$method = $teamkill_matches[2][$i];

	$totals["teamkill"]++;
	add2user($killer, "teamkill");
	$totals["kill"]++;
	add2user($killer, "kill");

	$totals["death"]++;
	add2user($victim, "death");

	if(strtolower($method) == "headshot"){
		$totals["headshot"]++;
		add2user($killer, "headshot");
	}else if(strtolower($method) == "slashed"){
		$totals["knife"]++;
		add2user($killer, "knife");
	}
}

//suicides
for($i = 0; $i < count($suicide_matches[0]); $i++){
	$killer = $teamkill_matches[1][$i];

	if(strpos($killer,'says') !== false){ //safety so someone can't use chat to boost stats
		continue;
	}

	$totals["suicide"]++;
	add2user($killer, "suicide");
	$totals["death"]++;
	add2user($killer, "death");
}



$day["totals"] = $totals;
$day["users"] =  $users;

$day_filename = "data/day/".$today.".json";
touch($day_filename);
file_put_contents($day_filename, json_encode($day));

//update totals
$old = json_decode(file_get_contents("data/totals.json"), 1);
$old_users = $old["users"];
foreach($users as $user => $values){
	if(isset($old_users[$user])){
		$old_users[$user]["kill"] = $old_users[$user]["kill"] + $values["kill"];
		$old_users[$user]["death"] = $old_users[$user]["death"] + $values["death"];
		$old_users[$user]["headshot"] = $old_users[$user]["headshot"] + $values["headshot"];
		$old_users[$user]["knife"] = $old_users[$user]["knife"] + $values["knife"];
		$old_users[$user]["teamkill"] = $old_users[$user]["teamkill"] + $values["teamkill"];
		$old_users[$user]["suicide"] = $old_users[$user]["suicide"] + $values["suicide"];
	}else{
		$old_users[$user] = $values;
	}
}
$old_totals = $old["totals"];
$old_totals["kill"] = $old_totals["kill"] + $totals["kill"];
$old_totals["death"] = $old_totals["death"] + $totals["death"];
$old_totals["headshot"] = $old_totals["headshot"] + $totals["headshot"];
$old_totals["knife"] = $old_totals["knife"] + $totals["knife"];
$old_totals["teamkill"] = $old_totals["teamkill"] + $totals["teamkill"];
$old_totals["suicide"] = $old_totals["suicide"] + $totals["suicide"];

$new = array();
$new["totals"] = $old_totals;
$new["users"] = $old_users;

file_put_contents("data/totals.json", json_encode($new));
?>