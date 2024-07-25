<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once "../config/permissions.php";
require_once "../helpers/hasPermission.php";

if (
    !isset($_SESSION["loggedUserId"]) ||
    !isset($_SESSION["loggedUserPermissions"]) ||
    !hasPermission($deleteCategory) ||
    (!isset($_GET["action"]) && $_GET["action"] != "deleteCategory")
) {
    header('HTTP/1.1 403 Forbidden');
    echo "Unauthorized";
    exit();
}

if (empty($_GET["categoryId"])) {
    header('HTTP/1.1 400 Bad Request');
    echo "Your request could not be processed due to a syntax error";
    exit();
}

$categoryId = $_GET["categoryId"];

require_once "../config/db-connect.php";
require_once "../helpers/getCategoryById.php";

$category = getCategoryById($connection, $categoryId);

if (isset($category["error"])) {
    header('HTTP/1.1 404 Not Found');
    echo $category["error"];
    mysqli_close($connection);
    exit();
}

mysqli_autocommit($connection, FALSE);

try {
    $query = "DELETE FROM category_images WHERE category_id=$categoryId;";

    if (!mysqli_query($connection, $query)) {
        throw new Exception(mysqli_error($connection));
    }

    $query = "DELETE FROM categories WHERE id=$categoryId;";

    if (!mysqli_query($connection, $query)) {
        throw new Exception(mysqli_error($connection));
    }

    $imageName = $category["image_name"];

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
