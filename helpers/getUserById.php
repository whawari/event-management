<?php

// Return user [] row
function getUserById($connection, $userId)
{
    $query = "SELECT name, email
    FROM users
    WHERE id=$userId;";

    $result = mysqli_query($connection, $query);

    $ar = array();
    if (!$result) {
        $ar["error"] = mysqli_error($connection);
        return $ar;
        exit();
    }

    $count = mysqli_num_rows($result);
    if ($count == 0) {
        $ar["error"] = "User not found";
        return $ar;
        exit();
    }

    return mysqli_fetch_assoc($result);
}
