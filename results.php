<?php
	include "login.php";
	include "classes.php";

	// retrieve inputs
	$place = ucwords($_REQUEST["place"]);
	$startAndEnd = [implode("-", array_reverse(explode("/", $_REQUEST["startDate"]))), implode("-", array_reverse(explode("/", $_REQUEST["endDate"])))];
	$indoorActivities = array(); // set below
	$activities = array(); // set below

	if (isset($_REQUEST["indoorActivity"])) {
		array_push($indoorActivities, new Activity("Museum", true));
	}

	if (isset($_REQUEST["outdoorActivity"])) {
		array_push($activities, new Activity("Beach"));
	}

	if (count($indoorActivities) > 0) {
		$activities = array_merge($activities, $indoorActivities);
	} else {
		$indoorActivities = $activities;
	}

	// doctors dates
	$notEnded = true;
	$dates = [$startAndEnd[0]];
	while ($notEnded) {
		$newDate = date("Y-m-d", strtotime("+1 day", strtotime($dates[count($dates)-1])));

		array_push($dates, $newDate);

		if ($newDate == $startAndEnd[1]) {
			$notEnded = false;
		}
	}

	// establish connection
	new_connection();
	$result = mysql_query("SELECT * FROM `locations` WHERE `name` = \"$place\"");
	$id = mysql_result($result, 0);

	$weather_info = simplexml_load_file("http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/xml/$id?res=daily&key={$api_key}");

	$weather_params = array();
	$forecasts = array();
	$trip_activities = array();

	foreach ($weather_info->Wx->Param as $param) {
		$weather_params[(string) $param["name"]] = [$param["units"], $param];
	}

	foreach ($weather_info->DV->Location->Period as $period) {
		$period_day = substr($period["value"], 0, -1);

		if (in_array($period_day, $dates)) {
			array_push($forecasts, new Day($period));	
		}
	}

	foreach ($forecasts as $day) {
		$day_activities = array();

		$precipitation = (int) $day->day["PPd"];

		if ($precipitation < 25) {
			for ($i = 0; $i < 3; $i++) {
				if (Activity::compareCounts($activities[0]->count, $activities[1]->count)) {
					array_push($day_activities, $activities[0]->add());
				} else {
					array_push($day_activities, $activities[1]->add());
				}
			}
		} else if ($precipitation < 50) {
			array_push($day_activities, $indoorActivities[0]->add());

			for ($i = 0; $i < 2; $i++) {
				if (Activity::compareCounts($activities[0]->count, $activities[1]->count)) {
					array_push($day_activities, $activities[0]->add());
				} else {
					array_push($day_activities, $activities[1]->add());
				}
			}
		} else if ($precipitation < 75) {
			for ($i = 0; $i < 2; $i++) {
				array_push($day_activities, $indoorActivities[0]->add());
			}

			if (Activity::compareCounts($activities[0]->count, $activities[1]->count)) {
				array_push($day_activities, $activities[0]->add());
			} else {
				array_push($day_activities, $activities[1]->add());
			}
		} else {
			for ($i = 0; $i < 3; $i++) {
				array_push($day_activities, $indoorActivities[0]->add());
			}
		}

		array_push($trip_activities, $day_activities);
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Triplannr | Results</title>
	<link href="css/opensans.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/stylesheet.css" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>

	<style>
		.days {
			display: flex;
		}

		.day {
			padding: 0 25px;
		}

		table {

		}

		td:first-child {
			font-weight: bold;
			padding-right: 10px;
		}
	</style>
</head>
<body>
	<!-- <div class="wrap"> -->
	<div class="jumbotron">
		<nav>
			<h1>Triplannr: Dynamic Holiday Planner</h1>
			<ul>
				<li class="active"><a href="#" ><span>Home</span></a></li>
				<li><a href="#"><span>Holidays</span></a></li>
				<li><a href="#"><span>Thanks</span></a></li>
				<li class="last"><a href="#"><span>Ideas</span></a></li>
			</ul>
		</nav>

		
	</div>
	<div class="wrap">
		<div class="body">
			
			<div class="text">
				<h2>Here is your trip:</h2>

				<div class="days">
					<?php
						$i = 0;
						$times = array("9am", "Noon", "3pm");
						foreach ($trip_activities as $day_activities) {
							$i++;
							$j = 0;

							echo "<div class=\"day\"><h3>Day $i</h3><table>";

							foreach ($day_activities as $day_activity) {
								echo "<tr><td>{$times[$j]}</td><td>$day_activity</td></tr>";
								$j++;
							}

							echo "</table></div>";
						}
					?>
			 	</div>
			</div>
		</div>

		<footer>
			<a href="#"><img src="img/facebook.png" id="FB_Icon" /></a>
			<a href="#"><img src="img/twitter.png" id="T_Icon" /></a>
			<a href="http://www.youtube.com"><img src="img/youtube.png" id="YT_Icon" /></a>
			<p>Copyright  | Last updated 28/07/2014 | Under <a href="http://creativecommons.org/licenses/by-sa/4.0/" target="_blank">Creative Commons Attribution-ShareAlike 4.0 International</a> license.</p>
		</footer>
	</div>
</body>
</html>