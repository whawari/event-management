<?php

// Return categories []
function getCategories($connection)
{
    $query = "SELECT * FROM categories;";

    $result = mysqli_query($connection, $query);

    $ar = array();
    if (!$result) {
        $ar["error"] = mysqli_error($connection);
        return $ar;
        exit();
    }

    $count = mysqli_num_rows($result);
    if ($count == 0) {
        $ar["error"] = "There are no categories yet!";
        return $ar;
        exit();
    }

    $rows = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}
