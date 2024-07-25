<?php

// Return category [] row
function getCategoryById($connection, $categoryId)
{
    $query = "SELECT categories.id, categories.name, category_images.name AS image_name
    FROM categories
    INNER JOIN category_images ON categories.id = category_images.category_id
    WHERE categories.id=$categoryId;";

    $result = mysqli_query($connection, $query);

    
    if (!$result) {
        $ar["error"] = mysqli_error($connection);
        return $ar;
        exit();
    }

    return mysqli_fetch_assoc($result);
}
