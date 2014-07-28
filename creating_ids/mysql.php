<?php
	include "../login.php";

	$sitelist = simplexml_load_file("sitelist.xml");

	new_connection();

	foreach($sitelist as $site) {
		mysql_query("INSERT INTO `locations`(`id`, `name`) VALUES ({$site['id']},\"{$site['name']}\")") or die("insert");
	}
?>