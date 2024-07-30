<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "../helpers/sanitizeInput.php";

    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);
    $confirmPassword = sanitizeInput($_POST["confirm-password"]);
    $role = sanitizeInput($_POST["role"]);

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

    require_once "../config/roles.php";
    if ($role !== $user && $role !== $organizer) {
        $errors["generalError"] = "Unrecognized user role!";
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

        header("Location: ../signup.php");

        die();
    }

    require_once "../helpers/hashPassword.php";
    $password = hashPassword($password);

    mysqli_autocommit($connection, FALSE);

    try {
        $createUserQuery = "INSERT INTO users (name, email, password) 
        VALUES ('$name', '$email', '$password')";

        if (!mysqli_query($connection, $createUserQuery)) {
            throw new Exception(mysqli_error($connection));
        }

        $userId = mysqli_insert_id($connection);

        $assignRoleToUser = "INSERT INTO user_roles (user_id, role_code) 
        VALUES ($userId, '$role');";

        if (!mysqli_query($connection, $assignRoleToUser)) {
            throw new Exception(mysqli_error($connection));
        }

        $getRolePermissions = "SELECT permission_code
                                FROM role_permissions
                                WHERE role_code = '$role';";

        $result = mysqli_query($connection, $getRolePermissions);

        if (!mysqli_query($connection, $getRolePermissions)) {
            throw new Exception(mysqli_error($connection));
        }

        $rolePermissions = array();

        while($permission = mysqli_fetch_assoc($result)) {
            $rolePermissions[] = $permission['permission_code'];
        }

        if (!mysqli_commit($connection)) {
            throw new Exception("Commit transaction failed");
        }

        $_SESSION['loggedUserId'] = $userId;
        $_SESSION['loggedUserRole'] = $role;
        $_SESSION['loggedUserName'] = $name;
        $_SESSION['loggedUserEmail'] = $email;
        $_SESSION['loggedUserPermissions'] = $rolePermissions;


        mysqli_autocommit($connection, TRUE);
        mysqli_close($connection);

        header("Location: ../");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($connection);

        $errors["generalError"] = $e->getMessage();

        $_SESSION['signupErrors'] = $errors;

        mysqli_autocommit($connection, TRUE);
        mysqli_close($connection);

        header("Location: ../signup.php");
        exit();
    }
} else {
    header("Location: ../");
    die();
}
