<?php
if (!isset($_SESSION)) {
    session_start();
}

$rootDir = $_SERVER["DOCUMENT_ROOT"];

$forbiddenImg = file_get_contents($rootDir . "/event-management/public/images/forbidden.svg");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/unauthorized.css">

    <title>EventHub - Permission Denied</title>
</head>

<body>

    <?php include "../templates/header.php"; ?>

    <div class="unauthorized">
        <div class="container">
            <div class="unauthorized__content">
                <h3>Permission denied</h3>

                <p>You do not have permission to access this page</p>

                <div class="unauthorized__img">
                    <?php echo $forbiddenImg; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include "../templates/footer.php"; ?>

    <?php
    if (isset($_SESSION["loggedUserId"])) {
        include "../templates/dashboard-floating-button.php";
    }
    ?>
</body>

</html>