<?php
include('functions.php');
$data = getData();
$stats = getStats($data);

$info = serverInfo();
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
	<i>Current players: <?php echo($info->players."/".$info->slots); ?></i><br>
	<i>Current map: <?php echo($info->map); ?></i>
	</div>
	<h2 class="inline">Totals:</h2> <i class="inline">(since <?php echo($info->online->h);?> hours ago)</i>
	<h3>Kills: <?php echo($stats["count"]["kills"]); ?></h3>
	<h3>Headshots: <?php echo($stats["count"]["headshot"]); ?> (<?php echo(round(($stats["count"]["headshot"] / $stats["count"]["kills"])*1000)/10); ?>%)</h3>
	<h3>Teamkills: <?php echo($stats["count"]["teamkill"]); ?> (<?php echo(round(($stats["count"]["teamkill"] / $stats["count"]["kills"])*1000)/10); ?>%)</h3>
	<hr>
	<h2 class="inline">Personal stats:</h2> <i class="inline">(press enter after typing)</i><br>
	<form action="playerstats.php" method="get">
	<input type="text" class="form-control" placeholder="Your ingame name..." name="p">
	</form><br>
	<hr>
	<h2>Ranking:</h2>
	<a class="btn btn-lg btn-danger" onclick="showRanking('kills')"><span class="fa fa-tachometer"></span> Kills</a> <a class="btn btn-lg btn-danger" onclick="showRanking('headshot')"><span class="fa fa-rocket"></span> Headshots</a> <a class="btn btn-lg btn-danger" onclick="showRanking('teamkill')"><span class="fa fa-meh-o"></span> Teamkills</a>
	<br>
	<div id="kills-table">
	<b>Kills:</b><br>
	<table>
	<?php
		$data = $stats["stats"]["kills"];
		arsort($data);

		$count = 1;
		foreach($data as $person => $kill){
			if($kill == 1){
				$text = "kill";
			}else{
				$text = "kills";
			}
			echo("<tr>");

			echo("<td>$count</td>");
			echo("<td>$person</td>");
			echo("<td>$kill $text</td>");

			echo("</tr>");

			if($count == 10){
				break;
			}

			$count++;
		}
	?>
	</table>
	</div>
	<div id="headshot-table">
	<b>Headshots:</b><br>
	<table>
	<?php
		$data = $stats["stats"]["headshot"];
		arsort($data);

		$count = 1;
		foreach($data as $person => $kill){
			if($kill == 1){
				$text = "headshot";
			}else{
				$text = "headshots";
			}
			echo("<tr>");

			echo("<td>$count</td>");
			echo("<td>$person</td>");
			echo("<td>$kill $text</td>");

			echo("</tr>");

			if($count == 10){
				break;
			}

			$count++;
		}
	?>
	</table>
	</div>
	<div id="teamkill-table">
	<b>Teamkills:</b><br>
	<table>
	<?php
		$data = $stats["stats"]["teamkill"];
		arsort($data);

		$count = 1;
		foreach($data as $person => $kill){
			if($kill == 1){
				$text = "teamkill";
			}else{
				$text = "teamkills";
			}
			echo("<tr>");

			echo("<td>$count</td>");
			echo("<td>$person</td>");
			echo("<td>$kill $text</td>");

			echo("</tr>");

			if($count == 10){
				break;
			}

			$count++;
		}
	?>
	</table>
	</div>
	</body>
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/html5shiv.js"></script>

	<script type="text/javascript" src="main.js"></script>
</html>