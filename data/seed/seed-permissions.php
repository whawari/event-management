<?php

require_once "../../config/db-connect.php";
require_once "../../config/permissions.php";

// Creating permissions
// --------------------
$query = "INSERT INTO permissions (code) VALUES ('$viewEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$viewEvent' created <br>";
} else {
    echo "Error creating permission '$viewEvent': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO permissions (code) VALUES ('$createEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$createEvent' created <br>";
} else {
    echo "Error creating permission '$createEvent': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO permissions (code) VALUES ('$editEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$editEvent' created <br>";
} else {
    echo "Error creating permission '$editEvent': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO permissions (code) VALUES ('$deleteEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$deleteEvent' created <br>";
} else {
    echo "Error creating permission '$deleteEvent': " . mysqli_error($connection) . "<br>";
}

mysqli_close($connection);
