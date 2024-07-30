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

        header("Location: ../login.php");

        die();
    }

    require_once "../config/db-connect.php";
    require_once "../helpers/getUserWithRoleAndPermissions.php";

    $userDetails = getUserWithRoleAndPermissions($connection, $email, $password);

    mysqli_close($connection);

    if ($userDetails) {
        $_SESSION['loggedUserId'] = $userDetails["id"];
        $_SESSION['loggedUserName'] = $userDetails["name"];
        $_SESSION['loggedUserEmail'] = $userDetails["email"];
        $_SESSION['loggedUserRole'] = $userDetails["role_code"];
        $_SESSION['loggedUserPermissions'] = $userDetails["role_permissions"];

        require_once "../config/roles.php";

        if ($userDetails["role_code"] === $admin) {
            header("Location: ../dashboard");
        } else {
            header("Location: ../");
        }

        exit();
    } else {
        $errors["generalError"] = "Invalid email or password";

        $_SESSION['loginErrors'] = $errors;

        header("Location: ../login.php");
        exit();
    }
} else {
    header("Location: ../");
    die();
}
