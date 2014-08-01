<?php
	session_start();
	if (isset($_COOKIE['user'])) {
		$_SESSION['user'] = $_COOKIE['user'];
	}
	if (isset($_SESSION['user'])) {
		header('Location: index.php');
	}
?>
<!doctype html>
<html id="signup_page">
<head>
	<meta charset="UTF-8" />
	<title>triplannr :: Sign up</title>
	<link href="css/opensans.css" rel='stylesheet' type='text/css' />
	<link rel="stylesheet" href="css/stylesheet.css" />
	<link rel="icon" href="img/logo.png">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/CryptoJS.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
</head>
<body>
	<div class="jumbotron">
		<nav>
			<h1>triplannr: <small>Dynamic Trip Planner</small></h1>
			<ul>
				<li><a href="index.php"><span>Home</span></a></li>
				<li><a href="login-page.php"><span>Login</span></a></li>
				<li><a href="signup.php"><span>Sign up</span></a></li>
				<li><a href="thanks.php"><span>Thanks</span></a></li>
			</ul>			
		</nav>
		<form method="GET" class="user_form">
				<p>
					First Name: <input type= "text" id="firstname" name="firstname">
				</p>
				<p>
					Surname: <input type= "text" id="surname" name="surname">
				</p>
				<p>
					Username: <input type="text" id="username" name="username">
				</p>
				<p>
					Password: <input type="password" id="password" name="password">
				</p>
				<p><button type="submit" class="button">Register</button></p>
			</form>
	</div>
</body>
</html>