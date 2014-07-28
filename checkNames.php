<?php
    include "login.php";

    // connect to host
    new_connection();
    $result = mysql_query('SELECT * FROM `locations` WHERE `name` LIKE "%$place%"');
    
    // get length of result
    $rowNum = mysql_num_rows($result);
    if($rowNum == 0) {
        die('None');
    }
    if($rowNum == 1) {
        die('One');
    }
    $arr = [];
    for($i = 0; $i < $rowNum; $i++) {
        array_push($arr, mysql_result($result, $i));
    }
    $rtn = implode(',', $arr);
    echo($rtn);
?>