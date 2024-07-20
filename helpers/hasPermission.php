<?php

// check if a logged in user has a certain permission
function hasPermission($permission)
{
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['loggedUserPermissions']) && is_array($_SESSION['loggedUserPermissions'])) {
        return in_array($permission, $_SESSION['loggedUserPermissions']);
    }

    return false;
}
