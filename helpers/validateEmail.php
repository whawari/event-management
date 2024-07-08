<?php

// Valid email address with @ and .
function validateEmail($value)
{
    $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    // Invalid
    if (!preg_match($regex, $value)) {
        return false;
    }

    // Valid
    return true;
}
