<?php
include('functions.php');

$info = serverInfo();

$player_raw = urldecode($_GET["p"]);
$player = preg_quote($player_raw, "/");

if(empty($player)){
	header('Location: index.php');
	break;
}

$result = getData();

$kill_pattern = "/(?:\[.{1,}\]) ($player) (headshot|slashed|gibbed|shredded|punctured) (.{1,})/i";
preg_match_all($kill_pattern, $result, $kill_matches);

$teamkill_pattern = "/(?:\[.{1,}\]) ($player) (headshot|slashed|gibbed|shredded|punctured) (?:(?:their)? teammate) (.{1,})/i";
preg_match_all($teamkill_pattern, $result, $teamkill_matches);

$headshot_pattern = "/(?:\[.{1,}\]) ($player) (headshot) (.{1,})/i";
preg_match_all($headshot_pattern, $result, $headshot_matches);

$death_pattern = "/(?:\[.{1,}\]) (.{1,})(?:| )(headshot|slashed|gibbed|shredded|punctured) (?:their teammate)?(?:| )($player)/i";
preg_match_all($death_pattern, $result, $death_matches);

$kills = count($kill_matches[0]);
$deaths = count($death_matches[0]);
$headshots = count($headshot_matches[0]);
$teamkills = count($teamkill_matches[0]);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>TKONSERVER</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
		<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/animate.css">

		<link rel="stylesheet" type="text/css" href="main.css">

		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
	<div class="center"><h1><b><span class="fa fa-cube"></span> TKONSERVER</b></h1>
	<i>Ip: 5.231.63.236</i><br>
	<i>Current players: <?php echo($info->players."/".$info->slots); ?></i>
	</div>

	<h1><?php echo($player_raw); ?></h1>
	<h3>Kills: <?php echo($kills); ?></h3>
	<h3>Deaths: <?php echo($deaths); ?></h3>
	<h3>Kills/Death ratio: <?php echo(round(($kills/$deaths)*10)/10); ?></h3>
	<h3>Headshots: <?php echo($headshots); ?></h3>
	<h3>Teamkills: <?php echo($teamkills); ?></h3>

	<a class="btn btn-danger btn-lg" href="index.php"><span class="fa fa-arrow-circle-left"></span> Back</a>

	</body>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/html5shiv.js"></script>

	<script type="text/javascript" src="main.js"></script>
</html>