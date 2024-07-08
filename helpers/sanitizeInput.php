<?php

// Trim whitespace, remove backslashes, escape special chars
function sanitizeInput($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);

    return $value;
}
