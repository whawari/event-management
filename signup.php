<?php
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["loggedUserId"])) {
    header("location: ../public");

    exit();
}

$errors = [];
if (isset($_SESSION["signupErrors"])) {
    $errors = $_SESSION["signupErrors"];

    unset($_SESSION["signupErrors"]);
}

if (isset($_SESSION["signupData"])) {
    $data = $_SESSION["signupData"];

    unset($_SESSION["signupData"]);
}

require_once "config/root-directory.php";
require_once "config/roles.php";
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
    <link rel="stylesheet" href="public/css/form.css">
    <link rel="stylesheet" href="public/css/signup.css">

    <title>EventHub | Sign Up</title>
</head>

<body>
    <main class="signup">
        <div class="signup__container">
            <div class="content">
                <a href="<?php echo $rootDirectory ?>" class="content__logo">
                    <img src="public/images/logo.svg" alt="logo" class="content__logo__img">
                </a>

                <h1>Sign up</h1>

                <form method="post" action="includes/signup.php" class="form">
                    <div class="form__field">
                        <label for="name" title="Required" class="form__field__label">
                            Name <span class="form__field__label__required">*</span>
                        </label>

                        <input type="text" name="name" id="name" value="<?php echo isset($data["name"]) ? $data["name"]  : "" ?>" class="form__field__input<?php echo isset($errors["nameError"]) ? " form__field__input--danger" : "" ?>">

                        <?php
                        if (isset($errors["nameError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["nameError"] . "</span>";
                        }
                        ?>
                    </div>

                    <div class="form__field">
                        <label for="email" title="Required" class="form__field__label">
                            Email <span class="form__field__label__required">*</span>
                        </label>

                        <input type="email" name="email" id="email" value="<?php echo isset($data["email"]) ? $data["email"]  : "" ?>" autocomplete="email" class="form__field__input<?php echo isset($errors["emailError"]) ? " form__field__input--danger" : "" ?>">

                        <?php
                        if (isset($errors["emailError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["emailError"] . "</span>";
                        }
                        ?>
                    </div>

                    <div class="form__field">
                        <label for="password" title="Required" class="form__field__label">
                            Password <span class="form__field__label__required">*</span>
                        </label>

                        <input type="password" name="password" id="password" value="<?php echo isset($data["password"]) ? $data["password"]  : "" ?>" autocomplete="current-password" class="form__field__input<?php echo isset($errors["passwordError"]) ? " form__field__input--danger" : "" ?>">

                        <?php
                        if (isset($errors["passwordError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["passwordError"] . "</span>";
                        }
                        ?>

                        <span class="body2 form__field__info">Password must contain at least eight characters and include at least one digit</span>
                    </div>

                    <div class="form__field">
                        <label for="confirm-password" title="Required" class="form__field__label">
                            Confirm password <span class="form__field__label__required">*</span>
                        </label>

                        <input type="password" name="confirm-password" id="confirm-password" value="<?php echo isset($data["confirmPassword"]) ? $data["confirmPassword"]  : "" ?>" autocomplete="new-password" class="form__field__input<?php echo isset($errors["confirmPasswordError"]) ? " form__field__input--danger" : "" ?>">

                        <?php
                        if (isset($errors["confirmPasswordError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["confirmPasswordError"] . "</span>";
                        }
                        ?>
                    </div>

                    <p>Sign up as</p>

                    <div class="form__radio-group form__radio-group--horizontal">
                        <label class="form__radio-group__label">
                            <span class="form__radio-group__radio" tabindex="0">
                                <input type="radio" name="role" value="<?php echo $user; ?>" checked class="form__radio-group__radio__input">

                                <span class="form__radio-group__radio__checked"></span>
                            </span>

                            <span><?php echo $user; ?></span>
                        </label>

                        <label class="form__radio-group__label">
                            <span class="form__radio-group__radio" tabindex="0">
                                <input type="radio" name="role" value="<?php echo $organizer; ?>" class="form__radio-group__radio__input">

                                <span class="form__radio-group__radio__checked"></span>
                            </span>

                            <span><?php echo $organizer; ?></span>
                        </label>
                    </div>

                    <?php
                    if (isset($errors["generalError"])) {
                        echo "<p class='body2 text--danger form__error'>" . $errors["generalError"] . "</p>";
                    }
                    ?>

                    <button type="submit" class="button button--primary full-width form__button">Sign up</button>
                </form>

                <p>
                    Already have an account?
                    <a href="login.php" class="link link--accent">Log in</a>
                </p>
            </div>
        </div>

        <div class="visual"></div>
    </main>
</body>

</html>