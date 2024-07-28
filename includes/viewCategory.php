<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "../config/permissions.php";
require_once "../helpers/hasPermission.php";

if (empty($_GET["categoryId"])) {
    header('HTTP/1.1 400 Bad Request');
    echo "Your request could not be processed due to a syntax error";
    exit();
}

if (isset($_GET["action"]) && $_GET["action"] === "fetchCategory") {
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
} else {
    header('HTTP/1.1 400 Bad Request');
    echo "It looks like your request cannot be processed due to invalid routing";
    exit();
}
