<?php

// Return user [] row or false
function getUser($connection, $email)
{
    $getUserQuery = "SELECT * FROM users WHERE email = '$email'";

    $result = mysqli_query($connection, $getUserQuery);

    return mysqli_fetch_assoc($result);
}
