<?php

// Return category [] row
function getCategoryById($connection, $categoryId)
{
    $query = "SELECT categories.id, categories.name, category_images.name AS image_name
    FROM categories
    INNER JOIN category_images ON categories.id = category_images.category_id
    WHERE categories.id=$categoryId;";

    $result = mysqli_query($connection, $query);

    $ar = array();
    if (!$result) {
        $ar["error"] = mysqli_error($connection);
        return $ar;
        exit();
    }

    $count = mysqli_num_rows($result);
    if ($count == 0) {
        $ar["error"] = "Category not found";
        return $ar;
        exit();
    }

    return mysqli_fetch_assoc($result);
}
