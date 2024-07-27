<?php

require_once "../../config/roles.php";
require_once "../../helpers/hashPassword.php";

$adminPassword = hashPassword("admin");
$organizerPassword = hashPassword("organizer");
$userPassword = hashPassword("user");

// Creating users (admin, organizer, user)
$query = "INSERT INTO users (name, email, password)
            VALUES ('admin', 'admin@mailinator.com', '$adminPassword')";
if (mysqli_query($connection, $query)) {
    echo "Admin created <br>";
} else {
    echo "Error creating admin: " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO users (name, email, password)
            VALUES ('organizer', 'organizer@mailinator.com', '$organizerPassword')";
if (mysqli_query($connection, $query)) {
    echo "Organizer created <br>";
} else {
    echo "Error creating organizer: " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO users (name, email, password)
            VALUES ('user', 'user@mailinator.com', '$userPassword')";
if (mysqli_query($connection, $query)) {
    echo "User created <br>";
} else {
    echo "Error creating user: " . mysqli_error($connection) . "<br>";
}
