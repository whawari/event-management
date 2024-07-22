<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["loggedUserId"])) {
    header("location: ../login.php");

    exit();
} else {
    $rootDirectory = $_SERVER['DOCUMENT_ROOT'];

    require_once $rootDirectory . "/event-management/config/permissions.php";
    require_once $rootDirectory . "/event-management/helpers/hasPermission.php";

    if (!isset($_SESSION["loggedUserPermissions"]) || !hasPermission($viewCategory)) {
        header("location: ../unauthorized.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Categories</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>

<body>
    <?php
    include "../../templates/sidebar.php";
    ?>

    <div class="panel">
        <div class="sidebar-whitespace"></div>

        <main class="panel__content">
            <a href="create-category.php" class="button button--primary header__cta">Create category</a>
        </main>
    </div>

    <script src="/event-management/public/js/sidebar.js"></script>
</body>

</html>