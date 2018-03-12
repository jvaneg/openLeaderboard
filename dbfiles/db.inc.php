<?php

// setting up vars for db
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "loginsystem";

// connecting to db
$connection = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
