<?php
	include "login.php";
	include "classes.php";

	session_start();

	if (isset($_COOKIE["user"])) {
		$_SESSION["user"] = $_COOKIE["user"];
		$username = explode(",", $_COOKIE["user"])[1];
		$url = $_SERVER["REQUEST_URI"];

		new_connection();
		mysql_query("DELETE FROM `trips` WHERE `user` = \"$username\"");
		$query = mysql_query("INSERT INTO `trips`(`user`, `url`) VALUES (\"$username\", \"$url\")");
	}

	// retrieve inputs
	$place = ucwords($_REQUEST["destination"]);
	$startAndEnd = [implode("-", array_reverse(explode("/", $_REQUEST["startDate"]))), implode("-", array_reverse(explode("/", $_REQUEST["endDate"])))];
	$postcode = str_replace(" ", "", $_REQUEST["postcode"]);
	$activities = array(); // set below

	if (isset($_REQUEST["museum"])) {
		array_push($activities, new Activity("Museum", true));
	}

	if (isset($_REQUEST["cafe"])) {
		array_push($activities, new Activity("Cafe", true));
	}

	if (isset($_REQUEST["restaurant"])) {
		array_push($activities, new Activity("Restaurant", true));
	}

	if (isset($_REQUEST["beach"])) {
		array_push($activities, new Activity("Beach"));
	}

	if (isset($_REQUEST["walk"])) {
		array_push($activities, new Activity("Walk"));
	}

	if (isset($_REQUEST["indoor"])) {
		array_push($activities, new Activity("Indoor Activity", true));
	}

	if (isset($_REQUEST["outdoor"])) {
		array_push($activities, new Activity("Outdoor Activity"));
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

	$weather_info = simplexml_load_file("http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/xml/$id?res=3hourly&key={$api_key}");

	$weather_params = array();
	$forecasts = array();

	// fetches weather parameters
	foreach ($weather_info->Wx->Param as $param) {
		$weather_params[(string) $param["name"]] = [$param["units"], $param];
	}

	// fetches weather info
	foreach ($weather_info->DV->Location->Period as $period) {
		$period_day = substr($period["value"], 0, -1);

		if (in_array($period_day, $dates)) {
			array_push($forecasts, new Day($period));	
		}
	}

	// generates activity for each day
	$trip_activities = array();

	foreach ($forecasts as $day) {
		$precipitations = [(int) $day->nine["Pp"], (int) $day->noon["Pp"], (int) $day->three["Pp"]];
		$iteration = 0;
		$day_activities = array();

		foreach ($precipitations as $precipitation) {
			$iteration++;

			Activity::compareCounts($activities);
			
			if ($precipitation > 40) {
				foreach ($activities as $activity) {
					if ($activity->allowsPrecipitation) {
						array_push($day_activities, $activity->add());
						break;
					}
				}
			}

			if ($precipitation < 41 || count($day_activities) == $iteration - 1) {
				array_push($day_activities, $activities[0]->add());
			}
		}

		array_push($trip_activities, $day_activities);
	}

	// finds the latitude and longitude of the current location
	$postcode_data = simplexml_load_file("http://www.uk-postcodes.com/postcode/$postcode.xml")->geo;

	// recomends activity
	$museums = false;
	$museums_i = 0;
	$cafes = false;
	$cafes_i = 0;
	$restaurants = false;
	$restaurants_i = 0;
	$latlon = "{$postcode_data->lat},{$postcode_data->lng}";
	foreach ($trip_activities as &$trip_activity) {
		foreach ($trip_activity as &$day_activity) {
			switch ($day_activity) {
				case "Museum":
					if ($museums == false) {
						$museums = simplexml_load_file("https://maps.googleapis.com/maps/api/place/nearbysearch/xml?radius=5000&key={$google_api_key}&location={$latlon}&types=museum")->result;
					}

					if (!isset($museums[$museums_i])) {
						$museums_i = 0;
					}

					$day_activity = "<span>$day_activity:</span> {$museums[$museums_i]->name}";
					$museums_i++;

					break;
				
				case "Cafe":
					if ($cafes == false) {
						$cafes = simplexml_load_file("https://maps.googleapis.com/maps/api/place/nearbysearch/xml?radius=5000&key={$google_api_key}&location={$latlon}&types=cafe")->result;
					}

					if (!isset($cafes[$cafes_i])) {
						$cafes_i = 0;
					}
					
					$day_activity = "<span>$day_activity:</span> {$cafes[$cafes_i]->name}";
					$cafes_i++;

					break;

				case "Restaurant":
					if ($restaurants == false) {
						$restaurants = simplexml_load_file("https://maps.googleapis.com/maps/api/place/nearbysearch/xml?radius=5000&key={$google_api_key}&location={$latlon}&types=restaurant")->result;
					}

					if (!isset($restaurants[$restaurants_i])) {
						$restaurants_i = 0;
					}

					$day_activity = "<span>$day_activity:</span> {$restaurants[$restaurants_i]->name}";
					$restaurants_i++;

					break;

				default:
					$day_activity = "<span>$day_activity</span>";

					break;
			}
		}
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>triplannr :: Results</title>
	<link href="css/opensans.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/stylesheet.css" />
	<link rel="icon" href="img/logo.png">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
</head>
<body id="results_page">
	<div class="jumbotron">
		<nav>
			<h1>triplannr: <small>Dynamic Trip Planner</small></h1>
			<ul>
				<li><a href="index.php"><span>Home</span></a></li>
				<?php if ($_COOKIE["user"]) { ?>
					<li><a href="index.php?logout=1"><span>Log out</span></a></li>
				<?php } else { ?>
					<li><a href="login-page.php"><span>Login</span></a></li>
					<li><a href="signup.php"><span>Sign up</span></a></li>
				<?php } ?>
				<li><a href="thanks.php"><span>Thanks</span></a></li>
			</ul>
		</nav>
	</div>
	<div class="wrap">
		<div class="text clearfix">
			<h2 class="trip_heading">Here is your trip:</h2>

			<div class="days grid">
				<?php
					$i = 0;
					$times = array("9am", "Noon", "3pm");
					$columns = count($trip_activities);
				?>
				<div class="row_<?php echo $columns; ?>">
					<?php
						foreach ($trip_activities as $day_activities) {
							$i++;
							$j = 0;

							echo "<div class=\"day column_1\"><h3>Day $i <span class='temp'>{$forecasts[$i-1]->avgTemp} &deg;C</span></h3><table>";

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
			<p>Copyright &copy; Alex Nielsen, Sophie Speed, Ollie Cole and Carl Ntifo 2014 under <a href="http://creativecommons.org/licenses/by/4.0/" target="_blank">Creative Commons Attribution 4.0 International Licence</a>.</p>
		</footer>
	</div>
</body>
</html>