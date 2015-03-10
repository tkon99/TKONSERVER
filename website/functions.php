<?php
function serverInfo(){
	$url = "http://5.231.63.236/serverinfo.php?s=5.231.63.236&p=28764";
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_FAILONERROR, true); 
	//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   
	curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.64 Safari/537.36');
	$result = json_decode(curl_exec($curl)); 
	return $result;
}

function getData(){
	$url = "http://5.231.63.236/log.php";
	$curl = curl_init($url); 
	curl_setopt($curl, CURLOPT_FAILONERROR, true); 
	//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   
	curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.64 Safari/537.36');
	$result = curl_exec($curl); 
	return $result;
}

function getStats($result){

	$pattern = '/(?:\[.{1,}\]) (.{1,}) (headshot|slashed|gibbed|shredded|punctured|picked off) (.{1,})/i';
	preg_match_all($pattern, $result, $matches);

	$teamkill_pattern = '/(?:\[.{1,}\]) (.{1,}) (headshot|slashed|gibbed|shredded|punctured|picked off) (?:(?:their)? teammate) (.{1,})/i';
	preg_match_all($teamkill_pattern, $result, $teamkill_matches);

	$teamkills = array();
	$headshots = array();
	$kills = array();

	$headshot_count = 0;
	$kill_count = count($matches[0]) + count($teamkill_matches[0]);
	$teamkill_count = count($teamkill_matches[0]);

	for($i = 0; $i < count($teamkill_matches[0]); $i++){
		$killer = $teamkill_matches[1][$i];

		if(strpos($killer,'says') !== false){
			continue;
		}

		$victim = $teamkill_matches[3][$i];
		$method = $teamkill_matches[2][$i];

		if(array_key_exists($killer, $teamkills)){
			$teamkills[$killer] = $teamkills[$killer] + 1;
		}else{
			$teamkills[$killer] = 1;
		}
	}

	for($i = 0; $i < count($matches[0]); $i++){
		$killer = $matches[1][$i];

		if(strpos($killer,'says') !== false){
			continue;
		}

		$victim = $matches[3][$i];
		$method = $matches[2][$i];

		if(strtolower($method) == "headshot"){
			$headshot_count++;
			if(array_key_exists($killer, $headshots)){
				$headshots[$killer] = $headshots[$killer] + 1;
			}else{
				$headshots[$killer] = 1;
			}
		}

		if(array_key_exists($killer, $kills)){
			$kills[$killer] = $kills[$killer] + 1;
		}else{
			$kills[$killer] = 1;
		}
	}

	$final = array(
		"count" => array(
			"headshot" => $headshot_count,
			"kills" => $kill_count,
			"teamkill" => $teamkill_count
			),
		"stats" => array(
			"headshot" => $headshots,
			"kills" => $kills,
			"teamkill" => $teamkills
			)
		);

	return $final;
}