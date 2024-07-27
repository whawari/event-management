<?php

// Return categories []
function getCategories($connection)
{
    $query = "SELECT categories.* , category_images.name AS image_name
    FROM categories
    INNER JOIN category_images ON categories.id = category_images.category_id
    ORDER BY categories.id DESC;";

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
