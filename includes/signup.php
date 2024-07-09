<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "../helpers/sanitizeInput.php";

    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);
    $confirmPassword = sanitizeInput($_POST["confirm-password"]);

    require_once "../config/db-connect.php";

    // error handling
    $errors = [];

    if (empty($name)) {
        $errors["nameError"] = "Required";
    } else {
        require_once "../helpers/validateName.php";

        if (!validateName($name)) {
            $errors["nameError"] = "Only letters and whitespace";
        }
    }

    if (empty($email)) {
        $errors["emailError"] = "Required";
    } else {
        require_once "../helpers/validateEmail.php";

        if (!validateEmail($email)) {
            $errors["emailError"] = "Invalid email address";
        } else {
            require_once "../helpers/isEmailRegistered.php";

            if (isEmailRegistered($connection, $email)) {
                $errors["emailError"] = "Email already exists";
            }
        }
    }

    if (empty($password)) {
        $errors["passwordError"] = "Required";
    } else {
        require_once "../helpers/validatePassword.php";

        if (!validatePassword($password)) {
            $errors["passwordError"] = "Invalid password";
        }
    }

    if (empty($confirmPassword)) {
        $errors["confirmPasswordError"] = "Required";
    } else {
        if ($password !== $confirmPassword) {
            $errors["confirmPasswordError"] = "Password mismatch";
        }
    }

    session_start();

    if ($errors) {
        mysqli_close($connection);

        $_SESSION['signupErrors'] = $errors;
        $_SESSION['signupData'] = [
            "name" => $name,
            "email" => $email,
            "password" => $password,
            "confirmPassword" => $confirmPassword,
        ];

        header("Location: ../public/signup.php");

        die();
    }

    $createUserQuery = "INSERT INTO users (name, email, password)
    VALUES ('$name', '$email', '$password')";

    if (!mysqli_query($connection, $createUserQuery)) {
        $errors["generalError"] = mysqli_error($connection);

        $_SESSION['signupErrors'] = $errors;

        mysqli_close($connection);

        header("Location: ../public/signup.php");

        die();
    }

    mysqli_close($connection);

    $_SESSION['message'] = "SIGNUP_SUCCESS";
    header("Location: ../public");
} else {
    header("Location: ../public");
    die();
}
