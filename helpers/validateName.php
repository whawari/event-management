<?php

// Only letters and whitespace
function validateName($value)
{
    $regex = "/^[a-zA-Z ]*$/";

    // Invalid 
    if (!preg_match($regex, $value)) {
        return false;
    }

    // Valid
    return true;
}
