<?php

define("SERVER_NAME", "localhost");
define("SERVER_USER", "root");
define("SERVER_PASSWORD", "");
define("DATABASE_NAME", "event_hub");

$connection = mysqli_connect(SERVER_NAME, SERVER_USER, SERVER_PASSWORD);

if (!$connection) {
    die("Connection to server failed: " . mysqli_connect_error());
}

// Check if the database exists
$checkDatabaseQuery = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . DATABASE_NAME . "'";
$result = mysqli_query($connection, $checkDatabaseQuery);

// Create the database if it does not exist
if (mysqli_num_rows($result) === 0) {
    $createDatabaseQuery = "CREATE DATABASE IF NOT EXISTS " . DATABASE_NAME;

    if (!mysqli_query($connection, $createDatabaseQuery)) {
        die("Error creating database '" . DATABASE_NAME . "': " . mysqli_error($connection));
    }
}

// Select the database
mysqli_select_db($connection, DATABASE_NAME);
