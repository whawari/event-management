<?php

// Contains at least one digit
// Password length at least 8 characters
function validatePassword($value)
{
    $regex = "/^(?=.*\d).{8,}$/";

    // Invalid 
    if (!preg_match($regex, $value)) {
        return false;
    }

    // Valid
    return true;
}
