<?php
	include "login.php";

	session_start();

	$url = false;

	if (isset($_COOKIE['user'])) {
		$_SESSION['user'] = $_COOKIE['user'];
		$username = explode(",", $_COOKIE["user"])[1];

		$mysqli = new_i_connection();
		$result = $mysqli->prepare("SELECT `url` FROM `trips` WHERE `user` = ?");
		$result->bind_param('s', $username);
		$result->execute();
		$result->bind_result($col1);
		while ($result->fetch()) {
			$url = $col1;
		}
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>triplannr :: Thanks</title>
	<link href="css/opensans.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/stylesheet.css" />
	<link rel="icon" href="img/logo.png">
</head>
<body>
	<div class="jumbotron">
		<nav>
			<h1>triplannr: <small>Dynamic Trip Planner</small></h1>
			<ul>
				<li><a href="index.php"><span>Home</span></a></li>
				<?php if (isset($_COOKIE["user"]) && $url) { ?>		
				<li><a href="<?php echo $url; ?>"><span>Last trip</span></a></li>
				<?php }

					if ($_SESSION["user"]) {
				?>
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
		<div class="text">
			<h2 class="">This website wouldn't be possible without: </h2>
			<p>
				<a href="http://www.jquery.com">jQuery</a>, <a href="http://www.unsplash.com">Unsplash</a>, <a href="http://www.metoffice.gov.uk">Met Office</a>, <a href="https://developers.google.com/places">Google Places API</a>, <a href="http://www.uk-postcodes.com/api">UK Postcode API</a>
			</p>
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