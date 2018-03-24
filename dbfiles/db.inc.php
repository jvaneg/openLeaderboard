<?php

// setting up vars for db
$dbServername = "localhost";
$dbUsername = "root";

//$dbPassword = "joelisgreat";
$dbPassword = "";

$dbName = "openleaderboard";

// connecting to db
// $connection = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
$connection = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

if ($connection->connect_error) {
    die("Connection failed [check db.inc.php?]: " . $connection->connect_error);
}

// echo "Connected successfully!";
?>

