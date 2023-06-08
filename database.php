<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "WDFP";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

?>


