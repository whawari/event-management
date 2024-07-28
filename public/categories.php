<?php
if (!isset($_SESSION)) {
    session_start();
}

$rootDir = $_SERVER["DOCUMENT_ROOT"];
require_once $rootDir . "/event-management/config/db-connect.php";
require_once $rootDir . "/event-management/helpers/getCategories.php";

$categories = getCategories($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/categories-page.css">

    <title>EventHub - Categories</title>
</head>

<body>
    <?php include "../templates/header.php"; ?>

    <div class="categories">
        <div class="container">
            <?php
            if (isset($categories["error"])) {
                echo "<div class='feedback-container'>";
                echo "
                <p class='text--center text--danger'>" . $categories["error"] . "</p>
            ";

                if (hasPermission($createCategory)) {
                    echo "
                <a href='/event-management/public/dashboard/create-category.php' class='button button--primary'>
                    Add category
                </a>
                ";
                }

                echo "</div>";
            } else {
                echo "<div class='categories__grid'>";

                $counter = 1;
                foreach ($categories as $category) {
                    $categoryId = $category["id"];
                    $categoryName = $category["name"];
                    $categoryImage = $category["image_name"];

                    echo "
                    <div class='categories__grid__item'>
                        <a href='category.php?id=$categoryId' class='categories__grid__item__img-box text--dark'>
                            <img src='images/uploads/$categoryImage' alt='$categoryName' class='categories__grid__item__img'>
                        </a>

                        <a href='category.php?id=$categoryId' class='categories__grid__item__name-box text--dark'>
                            <h4>$categoryName</h4>
                        </a>
                    </div>
                ";
                }

                echo "</div>";
            }
            ?>
        </div>
    </div>

    <?php include "../templates/footer.php"; ?>

    <?php
    if (isset($_SESSION["loggedUserId"])) {
        include "../templates/dashboard-floating-button.php";
    }
    ?>
</body>

</html>