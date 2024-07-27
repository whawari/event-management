<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "../config/permissions.php";
require_once "../helpers/hasPermission.php";

if (
    !isset($_SESSION["loggedUserId"]) ||
    !isset($_SESSION["loggedUserPermissions"]) ||
    !hasPermission($attendEvent) ||
    (!isset($_GET["action"]) && $_GET["action"] != "attendEvent")
) {
    header('HTTP/1.1 403 Forbidden');
    echo "Unauthorized";
    exit();
}

if (empty($_GET["eventId"])) {
    header('HTTP/1.1 400 Bad Request');
    echo "Your request could not be processed due to a syntax error";
    exit();
}

$userId = $_SESSION["loggedUserId"];
$eventId = $_GET["eventId"];

require_once "../config/db-connect.php";

$query = "INSERT into attendees
            (user_id, event_id)
            VALUES ($userId, $eventId);";

if (!mysqli_query($connection, $query)) {
    header('HTTP/1.1 500 Internal server error');
    echo "Something went wrong!";
    mysqli_close($connection);
    exit();
}

echo "Attended!";

mysqli_close($connection);
