<?php
	session_start();

	if (strlen(strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox')) > 0) {
	    $className = "firefox";
	} else {
		$className = "no-firefox";
	}
	
	if (isset($_GET['logout'])) {
		if ($_GET['logout'] == '1') {
			session_destroy();
			setcookie('user', null, -1, '/');
			header('Location: http://triplannr.tk');
		}
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>triplannr</title>
	<link href="css/opensans.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/stylesheet.css" />
	<link rel="icon" href="img/logo.png">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/smoothscroll.js"></script>
</head>
<body class="<?php echo $className; ?>" id="index_page">
	<div class="jumbotron">
		<nav>
			<h1>triplannr: <small>Dynamic Trip Planner</small></h1>
			<ul>
				<li><a href="index.php"><span>Home</span></a></li>
				<li><a href="results.php"><span>Last trip</span></a></li>
				<?php if ($_COOKIE["user"]) { ?>
					<li><a href="index.php?logout=1"><span>Log out</span></a></li>
				<?php } else { ?>
					<li><a href="login-page.php"><span>Login</span></a></li>
					<li><a href="signup.php"><span>Sign up</span></a></li>
				<?php } ?>
				<li><a href="thanks.html"><span>Thanks</span></a></li>
			</ul>
		</nav>
        <form action="results.php" method="post">
			<div class="wrap_1 grid">
				<div class="row_8">
					<div id="travel" class="column_5">
						<p>
							I am going to <input type="text" name="destination" id="destination" placeholder="Plymouth" /> from
							<input type="text" name="startDate" id="startDate" placeholder="28/07/2014" /> to <input type="text" name="endDate" id="endDate" placeholder="30/07/2014" /> and I'm staying at <input type="text" name="postcode" id="postcode" placeholder="PL4 8AA" /> <small>(postcode)</small>.
						</p>
					</div>
					<div class="options column_3">		
						<input type="checkbox" name="museum" id="museum" value="museum"><label for="museum">Museum</label><br>
						<input type="checkbox" name="restaurant" id="restaurant" value="restaurant"><label for="restaurant">Restaurant</label><br>
						<input type="checkbox" name="beach" id="beach" value="beach"><label for="beach">Beach</label><br>
						<input type="checkbox" name="cafe" id="cafe" value="cafe"><label for="cafe">Cafe</label><br>
						<input type="checkbox" name="walk" id="walk" value="walk"><label for="walk">Walk</label><br>
						<input type="checkbox" name="outdoor" id="outdoor" value="outdoor"><label for="outdoor">Other outdoor activity</label><br>
						<input type="checkbox" name="indoor" id="indoor" value="indoor"><label for="indoor">Other indoor activity</label><br>
					</div>
				</div>
				<div class="row_2">
					<div class="column_2 button_container">
						<button type="submit" class="button">Go!</button>
					</div>
				</div>
			</div>
			
		</form>
	</div>

	<div class="wrap">
		<div class="text">
			<p>Enter your trip destination, dates, accomodation location and what you want to do, and triplannr will sort out your trip's schedule for you!</p>

			<p>We also give you recommendations for the places you can visit - from museums to cafes and restaurants.</p>

			<p>triplannr also stores your recent trips inside your optional user account - keep details of all of your trips and never forget a thing!</p>
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