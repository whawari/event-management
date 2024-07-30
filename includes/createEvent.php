<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "../config/permissions.php";
require_once "../helpers/hasPermission.php";

if (
    !isset($_SESSION["loggedUserId"]) ||
    !isset($_SESSION["loggedUserPermissions"]) ||
    !hasPermission($createEvent) ||
    $_SERVER["REQUEST_METHOD"] !== "POST"
) {
    header("location: ../unauthorized.php");
    exit();
}

require_once "../helpers/sanitizeInput.php";

$userId = $_SESSION["loggedUserId"];
$title = sanitizeInput($_POST["title"]);
$description = sanitizeInput($_POST["description"]);
$date = $_POST["date"];
$time = $_POST["time"];
$location = sanitizeInput($_POST["location"]);
$file = $_FILES["image"];
$categoryId = sanitizeInput($_POST["categoryId"]);

// error handling
$errors = [];

if (empty($title)) {
    $errors["titleError"] = "Required";
}

if (!strlen($description)) {
    $errors["descriptionError"] = "Required";
}

if (empty($date)) {
    $errors["dateError"] = "Required";
} else if (strtotime($date) === false) {
    $errors["dateError"] = "Invalid date";
}

if (empty($time)) {
    $errors["timeError"] = "Required";
}

if (empty($location)) {
    $errors["locationError"] = "Required";
}

if (!strlen($categoryId)) {
    $errors["categoryIdError"] = "Required";
}

require_once "../helpers/validateImageFile.php";

$isFileValid = validateImageFile($file);
if ($isFileValid !== "valid") {
    $errors["imageError"] = $isFileValid;
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = [
        "title" => $title,
        "description" => $description,
        "date" => $date,
        "time" => $time,
        "location" => $location,
    ];

    header("Location: ../dashboard/create-event.php");
    exit();
}

$fileName = $file["name"];
$fileTmpName = $file["tmp_name"];
$targetDir = "../public/images/uploads/";
$targetFile = $targetDir . basename($fileName);

require_once "../config/db-connect.php";

mysqli_autocommit($connection, FALSE);

try {
    if (!is_dir($targetDir)) {
        // Create the directory with proper permissions
        // Owner: Read and write.
        // Group: Read.
        // Others: Read.
        // The true parameter allows the creation of nested directories
        mkdir($targetDir, 0644, true);
    }

    if (!move_uploaded_file($fileTmpName, $targetFile)) {
        throw new Exception("There was an error uploading your image");
    }

    $imagePath = addslashes(realpath($targetFile));

    $query = "INSERT INTO events
        (title, description, date, time, location, category_id, created_by) 
        VALUES ('$title', '$description', '$date', '$time', '$location', '$categoryId', '$userId');";

    if (!mysqli_query($connection, $query)) {
        unlink($imagePath);

        throw new Exception(mysqli_error($connection));
    }

    $lastInsertedId = mysqli_insert_id($connection);

    $query = "INSERT INTO event_images (event_id, name) 
        VALUES ($lastInsertedId, '$fileName');";

    if (!mysqli_query($connection, $query)) {
        unlink($imagePath);

        throw new Exception(mysqli_error($connection));
    }


    if (!mysqli_commit($connection)) {
        throw new Exception("Commit transaction failed");
    }

    $_SESSION['message'] = "SUCCESS";
} catch (Exception $e) {
    mysqli_rollback($connection);

    $errors["generalError"] = $e->getMessage();

    $_SESSION['errors'] = $errors;
}

mysqli_autocommit($connection, TRUE);
mysqli_close($connection);

header("Location: ../dashboard/create-event.php");
exit();
