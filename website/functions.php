<?php
class tkonserver{
	private function serverInfo(){
		$url = "http://5.231.63.236/serverinfo.php?s=5.231.63.236&p=28764";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_FAILONERROR, true); 
		//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);   
		curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.64 Safari/537.36');
		$result = json_decode(curl_exec($curl), 1); 
		return $result;
	}

	private function getLiveData(){
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

	function getCurrentPlayers(){
		$raw = this->serverInfo();
		$return = array("players"=>$raw["players"], "slots"=>$raw["slots"]);
		return $return;
	}

	function getPlayerStats($user, $day = "total"){
		if($day == "total"){
			$raw = this->getTotals();
			if(isset($raw["users"][$user])){
				return $raw["users"][$user];
			}else{
				return false;
			}
		}else{
			if(file_exists("data/day/".$day.".json")){
				$raw = json_decode(file_get_contents("data/day/".$day.".json"), 1);
				if(isset($raw["users"][$user])){
					return $raw["users"][$user];
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}

	function getTotals(){
		$raw = json_decode(file_get_contents("data/totals.json"), 1);
		return $raw["totals"];
	}
}