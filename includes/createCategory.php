<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "../config/permissions.php";
require_once "../helpers/hasPermission.php";

if (
    !isset($_SESSION["loggedUserId"]) ||
    !isset($_SESSION["loggedUserPermissions"]) ||
    !hasPermission($createCategory) ||
    $_SERVER["REQUEST_METHOD"] !== "POST"
) {
    header("location: ../unauthorized.php");
    exit();
}

require_once "../helpers/sanitizeInput.php";

$name = sanitizeInput($_POST["name"]);
$file = $_FILES["image"];

// error handling
$errors = [];

if (empty($name)) {
    $errors["nameError"] = "Required";
}

require_once "../helpers/validateImageFile.php";

$isFileValid = validateImageFile($file);
if ($isFileValid !== "valid") {
    $errors["imageError"] = $isFileValid;
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['data'] = [
        "name" => $name,
    ];

    header("Location: ../dashboard/create-category.php");
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

    $query = "INSERT INTO categories (name) 
        VALUES ('$name')";

    if (!mysqli_query($connection, $query)) {
        unlink($imagePath);

        throw new Exception(mysqli_error($connection));
    }

    $lastInsertedId = mysqli_insert_id($connection);

    $query = "INSERT INTO category_images (category_id, name) 
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

header("Location: ../dashboard/create-category.php");
exit();
