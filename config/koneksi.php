<?php
/*
* Change the value of $password if you have set a password on the root userid
* Change NULL to port number to use DBMS other than the default using port 3306
*
*/
$host='localhost';
$user = 'root';
$password = 'ois'; //To be completed if you have set a password to root
$database = 'laundry'; //To be completed to connect to a database. The database must exist.
$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

?>
