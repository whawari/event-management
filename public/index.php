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
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="css/snackbar.css">

    <title>EventHub - Discover Events Around You</title>
</head>

<body>
    <?php include "../templates/header.php"; ?>

    <div class="hero">
        <h1 class="text--large text--light text--center">
            Creating positive
            <br>
            lasting impact
        </h1>

        <a href="../public/events.php" class="button button--primary">Discover events</a>
    </div>

    <?php
    if (isset($_GET["signup"]) && $_GET["signup"] === "success") {
        echo '
        <div class="snackbar snackbar--success">
            <p class="snackbar__text text--light body2">Signup success!</p>

            <button type="button" class="snackbar__close">
                <span class="snackbar__close__slice"></span>
                <span class="snackbar__close__slice"></span>
            </button>
        </div>

        <script src="js/snackbar-handler.js"></script>
        ';
    }
    ?>
</body>

</html>