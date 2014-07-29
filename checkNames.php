<?php
    include "login.php";

    // define variables
    $place = $_REQUEST['place'];
    $arr = array();
    $sqlvar = "%$place%";

    // connect to host
    $connection = new_i_connection();

    // execute query
    $result = $connection->prepare('SELECT `name` FROM `locations` WHERE `name` LIKE ?');
    $result->bind_param('s', $sqlvar);
    $result->execute();

    // get query results
    $result->bind_result($col1);

    while ($result->fetch()) {
        array_push($arr, $col1);
    }

    // return result
    $rtn = implode(',', $arr);
    echo $rtn;