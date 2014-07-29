<?php
    include "login.php";

    $place = $_REQUEST['place'];

    // connect to host
    $arr = array();
    $sqlvar = "%$place%";
    $connection = new_i_connection();
    $result = $connection->prepare('SELECT `name` FROM `locations` WHERE `name` LIKE ?');
    $result->bind_param('s', $sqlvar);
    $result->execute();
    $result->bind_result($col1);
    while ($result->fetch()) {
        array_push($arr, $col1);
    }
    $rtn = implode(',', $arr);
    echo($rtn);