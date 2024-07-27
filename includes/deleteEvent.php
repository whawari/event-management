<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "../config/permissions.php";
require_once "../helpers/hasPermission.php";

if (
    !isset($_SESSION["loggedUserId"]) ||
    !isset($_SESSION["loggedUserPermissions"]) ||
    !hasPermission($deleteEvent) ||
    (!isset($_GET["action"]) && $_GET["action"] != "deleteEvent")
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

$eventId = $_GET["eventId"];

require_once "../config/db-connect.php";
require_once "../helpers/getEventById.php";

$event = getEventById($connection, $eventId);

if (isset($event["error"])) {
    header('HTTP/1.1 404 Not Found');
    echo $event["error"];
    mysqli_close($connection);
    exit();
}

mysqli_autocommit($connection, FALSE);

try {
    $query = "DELETE FROM event_images WHERE event_id=$eventId;";

    if (!mysqli_query($connection, $query)) {
        throw new Exception(mysqli_error($connection));
    }

    $query = "DELETE FROM attendees WHERE event_id=$eventId;";

    if (!mysqli_query($connection, $query)) {
        throw new Exception(mysqli_error($connection));
    }

    $query = "DELETE FROM events WHERE id=$eventId;";

    if (!mysqli_query($connection, $query)) {
        throw new Exception(mysqli_error($connection));
    }

    $imageName = $event["image_name"];

    $rootDirectory = $_SERVER['DOCUMENT_ROOT'];
    $uploadsFolderDirectory = "/event-management/public/images/uploads/";

    unlink($rootDirectory . $uploadsFolderDirectory . $imageName);

    if (!mysqli_commit($connection)) {
        throw new Exception("Commit transaction failed");
    }
} catch (Exception $e) {
    mysqli_rollback($connection);

    header('HTTP/1.1 500 Internal Server Error');

    echo $e->getMessage();
}

mysqli_autocommit($connection, TRUE);
mysqli_close($connection);
