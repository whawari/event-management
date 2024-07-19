<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "../helpers/sanitizeInput.php";

    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);

    // error handling
    $errors = [];

    if (empty($email)) {
        $errors["emailError"] = "Required";
    }

    if (empty($password)) {
        $errors["passwordError"] = "Required";
    }

    session_start();

    if ($errors) {
        $_SESSION['loginErrors'] = $errors;

        header("Location: ../public/login.php");

        die();
    }

    require_once "../config/db-connect.php";
    require_once "../helpers/getUser.php";

    $user = getUser($connection, $email);

    mysqli_close($connection);

    require_once "../helpers/hashPassword.php";
    $password = hashPassword($password);

    if ($user && $user["password"] === $password) {
        $_SESSION['logged'] = $user["id"];

        header("Location: ../public");
    } else {
        $errors["generalError"] = "Invalid credentials";

        $_SESSION['loginErrors'] = $errors;

        header("Location: ../public/login.php");

        die();
    }
} else {
    header("Location: ../public");
    die();
}
