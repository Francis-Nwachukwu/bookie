<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "73029228ai";
$dbname = "bookiedb";

$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if(!$con) {
    die("Failed to connect to database");
}

?>