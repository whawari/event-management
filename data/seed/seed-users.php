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

$userId = mysqli_insert_id($connection);
$query = "INSERT INTO user_roles (user_id, role_code) 
            VALUES ($userId, '$admin');";
if (mysqli_query($connection, $query)) {
    echo "Role '$admin' assigned to admin@mailinator.com <br>";
} else {
    echo "Error assigning role '$admin' to admin@mailinator.com: " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO users (name, email, password)
            VALUES ('organizer', 'organizer@mailinator.com', '$organizerPassword')";
if (mysqli_query($connection, $query)) {
    echo "Organizer created <br>";
} else {
    echo "Error creating organizer: " . mysqli_error($connection) . "<br>";
}

$userId = mysqli_insert_id($connection);
$query = "INSERT INTO user_roles (user_id, role_code) 
            VALUES ($userId, '$organizer');";
if (mysqli_query($connection, $query)) {
    echo "Role '$organizer' assigned to organizer@mailinator.com <br>";
} else {
    echo "Error assigning role '$organizer' to organizer@mailinator.com: " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO users (name, email, password)
            VALUES ('user', 'user@mailinator.com', '$userPassword')";
if (mysqli_query($connection, $query)) {
    echo "User created <br>";
} else {
    echo "Error creating user: " . mysqli_error($connection) . "<br>";
}

$userId = mysqli_insert_id($connection);
$query = "INSERT INTO user_roles (user_id, role_code) 
            VALUES ($userId, '$user');";
if (mysqli_query($connection, $query)) {
    echo "Role '$user' assigned to user@mailinator.com <br>";
} else {
    echo "Error assigning role '$user' to user@mailinator.com: " . mysqli_error($connection) . "<br>";
}
