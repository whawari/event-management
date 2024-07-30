<?php
require_once "../config/root-directory.php";
require_once "../config/db-connect.php";

if (isset($_GET["action"]) && $_GET["action"] == "fetchCategories") {
    $categories = array();

    $query = "SELECT categories.*, category_images.name AS image_name
    FROM categories
    INNER JOIN category_images ON categories.id = category_images.category_id;";

    $result = mysqli_query($connection, $query);

    if ($result) {
        $count = mysqli_num_rows($result);

        if ($count) {
            $uploadsFolderDirectory = $rootDirectory . "public/images/uploads/";

            $editIcon = file_get_contents('../public/images/icons/edit.svg');
            $deleteIcon = file_get_contents('../public/images/icons/delete.svg');

            echo "<div class='categories-grid'>";
            while ($category = mysqli_fetch_assoc($result)) {
                $imageSrc = $uploadsFolderDirectory . $category["image_name"];
                $imageName = $category["image_name"];
                $categoryName = $category["name"];
                $categoryId = $category["id"];

                echo "
                    <div class='categories-grid__item'>
                        <a href='" . $rootDirectory . "category.php?id=$categoryId' class='categories-grid__item__anchor'>
                            <img src='$imageSrc' alt='$imageName' class='categories-grid__item__img' >
                        </a>
    
                        <div class='categories-grid__item__footer'>
                            <a href='" . $rootDirectory . "category.php?id=$categoryId' class='text--dark'>
                                <p class='subtitle'>$categoryName</p>
                            </a>
    
                            <div class='categories-grid__item__footer__ctas'>
                                <a href='edit-category.php?id=$categoryId' type='button' class='icon-button icon-button--dark icon-button--mr-minus8' title='Edit'>
                                    <i class='icon-button__icon'>$editIcon</i>
                                </a>
    
                                <button type='button' class='icon-button icon-button--danger icon-button--mr-minus8 delete-button' title='Delete' data-id='$categoryId'>
                                    <i class='icon-button__icon'>$deleteIcon</i>
                                </button>
                            </div>
                        </div>
                    </div>
                ";
            }
            echo "</div>";
        } else {
            echo "
            <div class='feedback-container'>
                <p class='text--danger'>There are no categories yet!</p>
    
                <a href='create-category.php' class='button button--primary'>
                    Add category
                </a>
            </div>
            ";
        }
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo "An error occurred while fetching data";
        exit();
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo "It looks like your request cannot be processed due to invalid routing";
    exit();
}
