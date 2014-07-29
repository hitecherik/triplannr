<?php
	include "login.php";
	include "classes.php";

	// retrieve inputs
	$place = ucwords($_REQUEST["place"]);
	$startAndEnd = [implode("-", array_reverse(explode("/", $_REQUEST["startDate"]))), implode("-", array_reverse(explode("/", $_REQUEST["endDate"])))];
	$indoorActivities = array(); // set below
	$activities = array(); // set below

	if (isset($_REQUEST["indoorActivity"])) {
		array_push($indoorActivities, new Activity("indoorActivity", true));
	}

	if (isset($_REQUEST["outdoorActivity"])) {
		array_push($activities, new Activity("outdoorActivity"));
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

			for ($i == 0; $i < 2; $i++) {
				if (Activity::compareCounts($acitvities[0]->count, $activities[1]->count)) {
					array_push($day_activities, $activities[0]->add());
				} else {
					array_push($day_activities, $activities[1]->add());
				}
			}
		} else if ($precipitation < 75) {
			for ($i == 0; $i < 2; $i++) {
				array_push($day_activities, $indoorActivities[0]->add());
			}

			if (Activity::compareCounts($acitvities[0]->count, $activities[1]->count)) {
				array_push($day_activities, $activities[0]->add());
			} else {
				array_push($day_activities, $activities[1]->add());
			}
		} else {
			for ($i == 0; $i < 3; $i++) {
				array_push($day_activities, $indoorActivities[0]->add());
			}
		}

		array_push($trip_activities, $day_activities);
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Temp Results</title>
</head>

<body>
	<h1>Temp Results</h1>

	<?php $forecasts[1]->outputData($weather_params); ?>
</body>
</html>