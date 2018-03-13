<?php

// setting up vars for db
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "joelisgreat";
$dbName = "openLeaderboard";

// connecting to db
$connection = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
