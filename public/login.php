<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["loggedUserId"])) {
    header("location: ../public");

    exit();
}

$errors = [];
if (isset($_SESSION["loginErrors"])) {
    $errors = $_SESSION["loginErrors"];

    unset($_SESSION["loginErrors"]);
}
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
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/login.css">

    <title>EventHub - Log In</title>
</head>

<body>
    <main class="login">
        <div class="login__container">
            <div class="content">
                <a href="../public/" class="content__logo">
                    <img src="./images/logo.svg" alt="logo" class="content__logo__img">
                </a>

                <h1>Log in</h1>

                <form method="post" action="../includes/login.php" class="form">
                    <div class="form__field">
                        <label for="email" class="form__field__label">Email</label>

                        <input type="email" name="email" id="email" autocomplete="email" class="form__field__input<?php echo isset($errors["emailError"]) ? " form__field__input--danger" : "" ?>"">

                        <?php
                        if (isset($errors["emailError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["emailError"] . "</span>";
                        }
                        ?>
                    </div>

                    <div class=" form__field">
                        <label for="password" class="form__field__label">Password</label>

                        <input type="password" name="password" id="password" autocomplete="current-password" class="form__field__input<?php echo isset($errors["passwordError"]) ? " form__field__input--danger" : "" ?>"">

                        <?php
                        if (isset($errors["passwordError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["passwordError"] . "</span>";
                        }
                        ?>
                    </div>

                    <?php
                    if (isset($errors["generalError"])) {
                        echo "<p class='body2 text--danger form__error'>" . $errors["generalError"] . "</p>";
                    }
                    ?>

                    <button type=" submit" class="button button--primary full-width form__button">Log in</button>
                </form>

                <p>
                    Don't have an account?
                    <a href="signup.php" class="link link--accent">Sign up</a>
                </p>
            </div>
        </div>

        <div class="visual"></div>
    </main>
</body>

</html>