<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once "../config/permissions.php";
require_once "../helpers/hasPermission.php";

if (!isset($_SESSION["loggedUserId"])) {
    header("location: ../login.php");

    exit();
} else {
    if (!isset($_SESSION["loggedUserPermissions"]) || !hasPermission($viewCategory)) {
        header("location: ../unauthorized.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Categories</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" href="../public/css/index.css">
    <link rel="stylesheet" href="../public/css/sidebar.css">
    <link rel="stylesheet" href="../public/css/categories.css">

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <?php require_once "../templates/sidebar.php"; ?>

    <div class="panel">
        <div class="sidebar-whitespace"></div>

        <main class="panel__content">
            <div class="panel__content__head">
                <div class="panel__content__head__container">
                    <h4>Categories</h4>

                    <nav class="breadcrumbs">
                        <a href="../dashboard" class="link link--dark breadcrumbs__link">Dashboard</a>

                        <span class="breadcrumbs__separator"></span>

                        <span class="breadcrumbs__active">Categories</span>
                    </nav>
                </div>

                <?php
                if (hasPermission($createCategory)) {
                    echo "<a href='create-category.php' class='button button--primary panel__content__head__cta'>New category</a>";
                }
                ?>
            </div>

            <div class="panel__content__body">
                <div class="container">
                    <div id="categories"></div>

                    <div class="feedback-container">
                        <i class="spinner" id="spinner">
                            <?php echo file_get_contents("../public/images/icons/spinner.svg") ?>
                        </i>

                        <p class="text--danger" id="feedback"></p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="../public/js/sidebar.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#feedback').hide();

            fetchCategories();

            $(document).on("click", ".delete-button", function() {
                deleteCategory($(this).attr("data-id"));
            })
        });

        function fetchCategories() {
            $.ajax({
                url: "../includes/viewCategories.php",
                method: "GET",
                data: {
                    action: "fetchCategories"
                },
                success: function(data) {
                    $('#categories').html(data);
                },
                error: function(xhr) {
                    $('#feedback').show();

                    $('#feedback').html(xhr.responseText);
                },
                complete: function() {
                    $('#spinner').hide();
                }
            });
        }

        function deleteCategory($categoryId) {
            $.ajax({
                url: "../includes/deleteCategory.php",
                method: "GET",
                data: {
                    action: "deleteCategory",
                    categoryId: $categoryId
                },
                success: function(data) {
                    fetchCategories();
                }
            });
        }
    </script>
</body>

</html>