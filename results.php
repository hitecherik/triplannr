<?php
	include "login.php";

	class Parameter {
		public $name = "";
		public $unit = "";
		public $code = "";

		function __construct($param) {
			$this->name = $param;
			$this->unit = $param["units"];
			$this->code = $param["name"];
		}
	}

	class Day {
		public $date = "";
		public $day = array();
		public $night = array();

		function __construct($period) {
			$this->date = substr($period["value"], 0, -1);

			foreach ($period->Rep[0]->attributes() as $name => $value) {
				$this->day[$name] = $value;
			}

			foreach ($period->Rep[1]->attributes() as $name => $value) {
				$this->night[$name] = $value;
			}
		}

		public function outputData() {
			echo $this->date;

			echo "<h2>Day</h2>";
			foreach ($this->day as $name => $value) {
				echo "$name: $value\n";
			}

			echo "<h2>Night</h2>";
			foreach ($this->night as $name => $value) {
				echo "$name: $value\n";
			}
		}
	}

	// retrieve inputs
	$place = ucwords($_REQUEST["place"]);
	$dates = [$_REQUEST["startDate"], $_REQUEST["endDate"]];
	$activities = [isset($_REQUEST["indoorActivity"]) ? true : false, isset($_REQUEST["outdoorActivity"]) ? true : false]; // both values should be true


	// establish connection
	new_connection();
	$result = mysql_query("SELECT * FROM `locations` WHERE `name` = \"$place\"");
	$id = mysql_result($result, 0);

	$weather_info = simplexml_load_file("http://datapoint.metoffice.gov.uk/public/data/val/wxfcs/all/xml/$id?res=daily&key=0f43f66d-6694-4bd8-bfa9-9ca78623b9bc");
	$weather_params = array();
	$forecasts = array();

	foreach ($weather_info->Wx->Param as $param) {
		array_push($weather_params, new Parameter($param));
	}

	foreach ($weather_info->DV->Location->Period as $period) {
		array_push($forecasts, new Day($period));
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

	<?php $forecasts[0]->outputData(); ?>
</body>
</html>