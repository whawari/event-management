<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "../config/permissions.php";
require_once "../helpers/hasPermission.php";

if (
    !isset($_SESSION["loggedUserId"]) ||
    !isset($_SESSION["loggedUserPermissions"]) ||
    !hasPermission($editEvent) ||
    $_SERVER["REQUEST_METHOD"] !== "POST"
) {
    header("location: ../unauthorized.php");
    exit();
}

require_once "../helpers/sanitizeInput.php";

$userId = $_SESSION["loggedUserId"];
$eventId = $_POST["eventId"];
$categoryId = sanitizeInput($_POST["categoryId"]);

$title = sanitizeInput($_POST["title"]);
$description = sanitizeInput($_POST["description"]);
$date = $_POST["date"];
$time = $_POST["time"];
$location = sanitizeInput($_POST["location"]);

$oldImageName = $_POST["oldImageName"];
$file = $_FILES["image"];

$isFileUploaded = $file['size'] == 0 && empty($file['tmp_name']) ? false : true;

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

if ($isFileUploaded) {
    require_once "../helpers/validateImageFile.php";

    $isFileValid = validateImageFile($file);
    if ($isFileValid !== "valid") {
        $errors["imageError"] = $isFileValid;
    }
}

if ($errors) {
    $_SESSION['errors'] = $errors;

    header("Location: ../dashboard/edit-event.php?id=$eventId");
    exit();
}

require_once "../config/db-connect.php";

mysqli_autocommit($connection, FALSE);

try {
    $fileName = "";
    $fileTmpName = "";
    $targetDir = "../public/images/uploads/";
    $targetFile = "";

    if ($isFileUploaded) {
        $fileName = $file["name"];
        $fileTmpName = $file["tmp_name"];
        $targetFile = $targetDir . basename($fileName);

        if (!move_uploaded_file($fileTmpName, $targetFile)) {
            throw new Exception("There was an error uploading your image");
        }
    }

    $imagePath = "";
    if ($isFileUploaded) {
        $imagePath = addslashes(realpath($targetFile));
    }

    $query = "UPDATE events
        SET title='$title',
        description='$description',
        date='$date',
        time='$time',
        location='$location',
        category_id='$categoryId'
        WHERE id='$eventId';";

    if (!mysqli_query($connection, $query)) {
        if ($isFileUploaded) {
            unlink($imagePath);
        }

        throw new Exception(mysqli_error($connection));
    }

    if ($isFileUploaded) {
        $query = "UPDATE event_images
            SET name='$fileName'
            WHERE id='$eventId';";

        if (!mysqli_query($connection, $query)) {
            unlink($imagePath);

            throw new Exception(mysqli_error($connection));
        }
    }

    if (!mysqli_commit($connection)) {
        throw new Exception("Commit transaction failed");
    }

    $imageName = "";
    if ($isFileUploaded) {
        unlink($targetDir . $oldImageName);

        $imageName = $fileName;
    } else {
        $imageName = $oldImageName;
    }

    $_SESSION['message'] = "SUCCESS";
} catch (Exception $e) {
    mysqli_rollback($connection);

    $errors["generalError"] = $e->getMessage();

    $_SESSION['errors'] = $errors;
}

mysqli_autocommit($connection, TRUE);
mysqli_close($connection);

header("Location: ../dashboard/edit-event.php?id=$eventId");
exit();
