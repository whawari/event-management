<?php
if (!isset($_SESSION)) {
    session_start();
}

$forbiddenImg = file_get_contents("public/images/forbidden.svg");

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
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/unauthorized.css">

    <title>EventHub - Permission Denied</title>
</head>

<body>

    <?php require_once "templates/header.php"; ?>

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

    <?php require_once "templates/footer.php"; ?>

    <?php
    if (isset($_SESSION["loggedUserId"])) {
        require_once "templates/dashboard-floating-button.php";
    }
    ?>
</body>

</html>