<?php
	if (strlen(strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox')) > 0) {
	    $className = "firefox";
	} else {
		$className = "no-firefox";
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>Home | Festival of Code</title>
	<link href="css/opensans.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/stylesheet.css" />
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/smoothscroll.js"></script>
</head>
<body class="<?php echo $className; ?>">
	<div class="jumbotron">
		<nav>
			<h1>Dynamic Trip Planner</h1>
			<ul>
				<li class="active"><a href="#" ><span>Home</span></a></li>
				<li><a href="#"><span>Holidays</span></a></li>
				<li><a href="login.html"><span>Login</span></a></li>
				<li class="last"><a href="#"><span>Thanks</span></a></li>
			</ul>
		</nav>
        <form action="results.php" method="get">
			<div class="wrap_1">
				<div id="travel">
					<p>
						I am going to <input type="text" name="destination" id="destination" placeholder="Madrid, Spain" /> from
						<input type="text" name="startDate" id="startDate" placeholder="01/08/2014" /> to <input type="text" name="endDate" id="endDate" placeholder="03/08/2014" /> and <br>
						<span>Optional:</span> I'm staying at <input type="text" name="hotel" id="hotel" placeholder="The Marriot" />
						and the postcode is <input type="text" name="postcode" id="postcode" placeholder="CR5 1ES" />
					</p>
					<button type="submit" class="button">Go!</button>
				</div>
				<div class="options">		
					<input type="checkbox" name="museum" id="museum" value="museum"><label for="museum">Museum</label><br>
					<input type="checkbox" name="restaurant" id="restaurant" value="restaurant"><label for="restaurant">Restaurant</label><br>
					<input type="checkbox" name="beach" id="beach" value="beach"><label for="beach">Beach</label><br>
					<input type="checkbox" name="cafe" id="cafe" value="cafe"><label for="cafe">Cafe</label><br>
					<input type="checkbox" name="walk" id="walk" value="walk"><label for="walk">Walk</label><br>
					<input type="checkbox" name="outdoor" id="outdoor" value="outdoor"><label for="outdoor">Other outdoor activity</label><br>
					<input type="checkbox" name="indoor" id="indoor" value="indoor"><label for="indoor">Other indoor activity</label><br>
				</div>
			</div>
		</form>
	</div>

	<div class="wrap grid">
		<div class="body">
			<div class="row_2">
				<div class="box_1 column_1">
					<p>
						Use the checkbox to select the activities you wish to do.
					</p>
				</div>
				<div class="box_2 gallery column_1">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure voluptates expedita quaerat, magnam, voluptatum facere itaque eveniet consequuntur fuga culpa deleniti atque aliquid distinctio sapiente possimus magni dolores a adipisci?
					</p>
				</div>
			</div>
			<div class="text row_1">
				<div class="column_1">
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor at reprehenderit at voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt at culpa qui officia deserunt mollit anim id est laborum.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor at reprehenderit at voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt at culpa qui officia deserunt mollit anim id est laborum.</p>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam veniam voluptatum perspiciatis, voluptate sint ipsum deleniti suscipit nobis optio at dolorem labore cupiditate saepe ad dolore officia eum iusto voluptates.</p>
				</div>
			</div>
		</div>
		<footer>
			<a href="#"><img src="img/facebook.png" alt="" id="FB_Icon" /></a>
			<a href="#"><img src="img/twitter.png" alt="" id="T_Icon" /></a>
			<a href="http://www.youtube.com"><img src="img/youtube.png" id="YT_Icon" alt="" /></a>
			<p>Copyright  | Last updated 28/07/2014 | Under <a href="http://creativecommons.org/licenses/by-sa/4.0/" target="_blank">Creative Commons Attribution-ShareAlike 4.0 International</a> license.</p>
		</footer>
	</div>
</body>
</html>