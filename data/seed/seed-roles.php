<?php

require_once "../../config/roles.php";

// Creating roles (admin, organizer, user)
$query = "INSERT INTO roles (code) VALUES ('$admin');";
if (mysqli_query($connection, $query)) {
    echo "Role '$admin' created <br>";
} else {
    echo "Error creating role '$admin': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO roles (code) VALUES ('$organizer');";
if (mysqli_query($connection, $query)) {
    echo "Role '$organizer' created <br>";
} else {
    echo "Error creating role '$organizer': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO roles (code) VALUES ('$user');";
if (mysqli_query($connection, $query)) {
    echo "Role '$user' created <br>";
} else {
    echo "Error creating role '$user': " . mysqli_error($connection) . "<br>";
}
