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
    <link rel="stylesheet" href="css/signup.css">

    <title>EventHub | Sign Up</title>
</head>

<body>
    <main class="signup">
        <div class="signup__container">
            <div class="content">
                <a href="../public/" class="content__logo">
                    <img src="./images/logo.svg" alt="logo" class="content__logo__img">
                </a>

                <h1>Sign up</h1>

                <form action="" class="form">
                    <div class="form__field">
                        <label for="name" title="Required" class="form__field__label">
                            Name <span class="form__field__label__required">*</span>
                        </label>

                        <input type="text" name="name" id="name" class="form__field__input">
                    </div>

                    <div class="form__field">
                        <label for="email" title="Required" class="form__field__label">
                            Email <span class="form__field__label__required">*</span>
                        </label>

                        <input type="email" name="email" id="email" autocomplete="email" class="form__field__input">
                    </div>

                    <div class="form__field">
                        <label for="password" title="Required" class="form__field__label">
                            Password <span class="form__field__label__required">*</span>
                        </label>

                        <input type="password" name="password" id="password" autocomplete="current-password" class="form__field__input">

                        <span class="body2 form__field__info">Password must contain at least eight characters and include at least one digit</span>
                    </div>

                    <div class="form__field">
                        <label for="confirm-password" title="Required" class="form__field__label">
                            Confirm password <span class="form__field__label__required">*</span>
                        </label>

                        <input type="password" name="confirm-password" id="confirm-password" autocomplete="new-password" class="form__field__input">
                    </div>

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