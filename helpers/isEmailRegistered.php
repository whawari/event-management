<?php

// Check if email is already registered 
function isEmailRegistered($connection, $email)
{
    $getEmailQuery = "SELECT email FROM users WHERE email = '$email'";

    $result = mysqli_query($connection, $getEmailQuery);

    // Email does not exist
    if (mysqli_num_rows($result) === 0) {
        return false;
    }

    // Email exists
    return true;
}
