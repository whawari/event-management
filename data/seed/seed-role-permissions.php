<?php

require_once "../../config/db-connect.php";
require_once "../../config/roles.php";
require_once "../../config/permissions.php";

// ----------------------------------------------------------------------

// Creating user role permissions
// ------------------------------
// User can view event
$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$user', '$viewEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$viewEvent' added to role '$user' <br>";
} else {
    echo "Error adding permission '$viewEvent' to role '$user': " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------

// Creating organizer role permissions
// -----------------------------------
// organizer can view, create, and edit event
$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$organizer', '$viewEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$viewEvent' added to role '$organizer' <br>";
} else {
    echo "Error adding permission '$viewEvent' to role '$organizer': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$organizer', '$createEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$createEvent' added to role '$organizer' <br>";
} else {
    echo "Error adding permission '$createEvent' to role '$organizer': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$organizer', '$editEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$editEvent' added to role '$organizer' <br>";
} else {
    echo "Error adding permission '$editEvent' to role '$organizer': " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------

// Creating admin role permissions
// -------------------------------
// admin can view, create, edit, and delete event
$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$admin', '$viewEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$viewEvent' added to role '$admin' <br>";
} else {
    echo "Error adding permission '$viewEvent' to role '$admin': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$admin', '$createEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$createEvent' added to role '$admin' <br>";
} else {
    echo "Error adding permission '$createEvent' to role '$admin': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$admin', '$editEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$editEvent' added to role '$admin' <br>";
} else {
    echo "Error adding permission '$editEvent' to role '$admin': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$admin', '$deleteEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$deleteEvent' added to role '$admin' <br>";
} else {
    echo "Error adding permission '$deleteEvent' to role '$admin': " . mysqli_error($connection) . "<br>";
}

// admin can view, create, edit, and delete category
$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$admin', '$viewCategory');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$viewCategory' added to role '$admin' <br>";
} else {
    echo "Error adding permission '$viewCategory' to role '$admin': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$admin', '$createCategory');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$createCategory' added to role '$admin' <br>";
} else {
    echo "Error adding permission '$createCategory' to role '$admin': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$admin', '$editCategory');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$editCategory' added to role '$admin' <br>";
} else {
    echo "Error adding permission '$editCategory' to role '$admin': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO role_permissions (role_code, permission_code) VALUES ('$admin', '$deleteCategory');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$deleteCategory' added to role '$admin' <br>";
} else {
    echo "Error adding permission '$deleteCategory' to role '$admin': " . mysqli_error($connection) . "<br>";
}

mysqli_close($connection);
