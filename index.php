<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Temp Homepage</title>
</head>

<body>
	<h1>Temp Homepage</h1>

	<form action="results.php" method="get">
		<input type="text" name="place" value="London">
		<input type="date" name="startDate" value="29/07/2014">
		<input type="date" name="endDate" value="01/08/2014">
		<input type="checkbox" name="indoorActivity" id="indoorActivity" value="true"> <label for="indoorActivity">Indoor Activity</label>
		<input type="checkbox" name="outdoorActivity" id="outdoorActivity" value="true"><label for="outdoorActivity">Outdoor Activity</label>
		<button type="submit">Submit</button>
	</form>
</body>
</html>