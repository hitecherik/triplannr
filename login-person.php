<?php
    session_start();
    require("login.php");
    $mysqli = new_i_connection();
    if ($mysqli->connect_error) {
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    $mysqli->query('UNLOCK TABLE USERS WRITE');
    /*if(!$mysqli->query('DROP TABLE USERS')) {
        printf("Errormessage: %s\n", $mysqli->error);
    }*/
    $mysqli->query('CREATE TABLE IF NOT EXISTS USERS (ID INTEGER AUTO_INCREMENT PRIMARY KEY, NAME varchar(50), USERNAME varchar(50) UNIQUE, PASSWORD BLOB, PHONE varchar(50) UNIQUE)');
    
    $vars = array('name', 'username', 'password', 'type');
    for ($i = 0; $i < count($vars); $i++) {
        $vars[$vars[$i]] = $_POST[$vars[$i]];
        unset($vars[$i]);
    }
    $error = '';
    switch ($vars['type']) {
        case 'insert':
            $statement = $mysqli->prepare('INSERT INTO USERS (USERNAME, PASSWORD, NAME) VALUES(?, ?, ?)');
            $statement->bind_param('sss', $vars['username'], $vars['password'], $vars['name']);
            $result = $statement->execute();
            if(!$result) {
                echo $mysqli->error;
            } else {
                $arr = [$vars['name'], $vars['username']];
                $_SESSION['user'] = implode(",", $arr);
                $expire = time() + 60 * 60 * 24 * 30;
                setcookie('user', implode(",", $arr), $expire);
                echo "success";
            }
            break;
        case 'login':
            $statement = $mysqli->prepare('SELECT `USERNAME`, `ID`, `NAME` FROM `USERS` WHERE `USERNAME` = ? AND `PASSWORD` = ?');
            $statement->bind_param('ss', $vars['username'], $vars['password']);
            $statement->execute();
            $statement->bind_result($col1, $col2, $col3);
            while($statement->fetch()) {
                $username = $col1;
                $id = $col2;
                $name = $col3;
            }
            if ($username && $id && $name) {
                $arr = [$name, $username];
                $_SESSION['user'] = implode(",", $arr);
                $expire = time() + 60 * 60 * 24 * 30;
                setcookie('user', implode(",", $arr), $expire);
                echo "success";
            } else {
                echo "fail";
            }
            break;
    }
?>