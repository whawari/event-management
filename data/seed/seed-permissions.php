<?php

require_once "../../config/permissions.php";

// Managing event permissions
// --------------------------
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

$query = "INSERT INTO permissions (code) VALUES ('$attendEvent');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$attendEvent' created <br>";
} else {
    echo "Error creating permission '$attendEvent': " . mysqli_error($connection) . "<br>";
}

// Managing categories permissions
// -------------------------------
$query = "INSERT INTO permissions (code) VALUES ('$viewCategory');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$viewCategory' created <br>";
} else {
    echo "Error creating permission '$viewCategory': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO permissions (code) VALUES ('$createCategory');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$createCategory' created <br>";
} else {
    echo "Error creating permission '$createCategory': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO permissions (code) VALUES ('$editCategory');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$editCategory' created <br>";
} else {
    echo "Error creating permission '$editCategory': " . mysqli_error($connection) . "<br>";
}

$query = "INSERT INTO permissions (code) VALUES ('$deleteCategory');";
if (mysqli_query($connection, $query)) {
    echo "Permission '$deleteCategory' created <br>";
} else {
    echo "Error creating permission '$deleteCategory': " . mysqli_error($connection) . "<br>";
}
