<?php
$host = "localhost";
$usr = "root";
$pwd = "KaltorakX1";
$dbname = "moz";
$connection = @mysql_connect($host, $usr, $pwd);
if(!$connection) {
    die("Connection error");
}

mysql_select_db($dbname, $connection);
?>
