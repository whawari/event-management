<?php

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION["loggedUserId"])) {
    unset($_SESSION["loggedUserId"]);
}

if (isset($_SESSION["loggedUserName"])) {
    unset($_SESSION["loggedUserName"]);
}

if (isset($_SESSION["loggedUserEmail"])) {
    unset($_SESSION["loggedUserEmail"]);
}

if (isset($_SESSION["loggedUserRole"])) {
    unset($_SESSION["loggedUserRole"]);
}

if (isset($_SESSION["loggedUserPermissions"])) {
    unset($_SESSION["loggedUserPermissions"]);
}

header("Location: ../public/login.php");
exit();
