<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["loggedUserId"])) {
    header("location: ../login.php");
    exit();
} else {
    require_once "../config/permissions.php";
    require_once "../helpers/hasPermission.php";

    if (!isset($_SESSION["loggedUserPermissions"]) || !hasPermission($editCategory)) {
        header("location: ../unauthorized.php");
        exit();
    }
}

require_once "../config/db-connect.php";
require_once "../helpers/getCategoryById.php";

$categoryId = isset($_GET["id"]) ? $_GET["id"] : "";
if (empty($categoryId)) {
    header('HTTP/1.1 400 Bad Request');
    echo "Your request could not be processed due to a syntax error";
    exit();
}

$category = getCategoryById($connection, $categoryId);

$data = array();
if (isset($category["error"])) {
    header('HTTP/1.1 404 Not Found');
    mysqli_close($connection);
} else {
    $data["name"] = $category["name"];
    $data["image_name"] = $category["image_name"];
}

$errors = [];
if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];

    unset($_SESSION["errors"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit category</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" href="../public/css/index.css">
    <link rel="stylesheet" href="../public/css/sidebar.css">
    <link rel="stylesheet" href="../public/css/form.css">
    <link rel="stylesheet" href="../public/css/snackbar.css">
</head>

<body>
    <?php require_once "../templates/sidebar.php"; ?>

    <div class="panel">
        <div class="sidebar-whitespace"></div>

        <main class="panel__content">
            <div class="panel__content__head">
                <div class="panel__content__head__container">
                    <h4>Edit category</h4>

                    <nav class="breadcrumbs">
                        <a href="../dashboard" class="link link--dark breadcrumbs__link">Dashboard</a>

                        <span class="breadcrumbs__separator"></span>

                        <a href="categories.php" class="link link--dark breadcrumbs__link">Categories</a>

                        <span class="breadcrumbs__separator"></span>

                        <span class="breadcrumbs__active">Edit category</span>
                    </nav>
                </div>

                <div class="panel__content__head__container"></div>
            </div>

            <?php
            if (isset($category["error"])) {
            ?>
                <div class="error-container">
                    <?php
                    echo "<p class='text--danger'>" . $category['error'] . "</p>";
                    ?>
                </div>
            <?php
            } else {
            ?>
                <div class="container">
                    <div class="card">
                        <form action="../includes/editCategory.php" method="post" enctype="multipart/form-data" class="form">
                            <!-- not secure -->
                            <input type="hidden" name="categoryId" value="<?php echo $categoryId ?>">

                            <div class="form__field">
                                <label for="name" title="Required" class="form__field__label">
                                    Name <span class="form__field__label__required">*</span>
                                </label>

                                <input type="text" name="name" id="name" value="<?php echo isset($data['name']) ? $data['name']  : '' ?>" class="form__field__input<?php echo isset($errors['nameError']) ? ' form__field__input--danger' : '' ?>">

                                <?php
                                if (isset($errors["nameError"])) {
                                    echo "<span class='body2 form__field__info--danger'>" . $errors["nameError"] . "</span>";
                                }
                                ?>
                            </div>

                            <div class="form__field">
                                <p for="name" title="Required" class="form__field__label">
                                    Featured image <span class="form__field__label__required">*</span>
                                </p>

                                <label class="form__field__file<?php echo isset($errors['imageError']) ? ' form__field__file--danger' : '' ?>" tabindex="0" onkeydown="triggerButtonClick(event)">
                                    <input type="file" name="image" class="form__field__file__input" accept="image/jpg,image/jpeg,image/png,image/webp" onchange="previewImage(event)">
                                    <!-- not secure -->
                                    <input type="hidden" name="oldImageName" value="<?php echo isset($data['image_name']) ? $data['image_name'] : '' ?>">

                                    <i class="form_field_file_icon">
                                        <?php echo file_get_contents("../public/images/icons/upload.svg") ?>
                                    </i>

                                    <span class="form__field__file__title">Select image</span>

                                    <img src="<?php echo isset($data['image_name']) ? '../public/images/uploads/' . $data['image_name'] : '#' ?>" style="<?php echo isset($data['image_name']) ? 'display: block;' : '' ?>" alt="Image preview" class="form__field__file__img">
                                </label>

                                <p class="body2 form__field__info">Upload a JPG, JPEG, PNG or WEBP image of a maximum size of 2 MB</p>

                                <?php
                                if (isset($errors["imageError"])) {
                                    echo "<span class='body2 form__field__info--danger'>" . $errors["imageError"] . "</span>";
                                }
                                ?>
                            </div>

                            <?php
                            if (isset($errors["generalError"])) {
                                echo "<p class='body2 text--danger form__error'>" . $errors["generalError"] . "</p>";
                            }
                            ?>

                            <button type="submit" class="button button--primary full-width form__button">Save</button>
                        </form>
                    </div>
                </div>
            <?php
            }
            ?>

            <?php
            if (isset($_SESSION["message"]) && $_SESSION["message"] === "SUCCESS") {
                echo '
                <div class="snackbar snackbar--success">
                    <p class="snackbar__text text--light body2">Category updated!</p>

                    <button type="button" class="snackbar__close">
                        <span class="snackbar__close__slice"></span>
                        <span class="snackbar__close__slice"></span>
                    </button>
                </div>';

                unset($_SESSION["message"]);
            }
            ?>
        </main>
    </div>

    <script src="../public/js/sidebar.js"></script>
    <script src="../public/js/preview-image.js"></script>
    <script src="../public/js/trigger-button-click.js"></script>
    <script src="../public/js/snackbar-handler.js"></script>
</body>

</html>