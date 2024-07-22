<?php
if (!isset($_SESSION)) {
    session_start();
}

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];

if (!isset($_SESSION["loggedUserId"])) {
    header("location: ../login.php");
    exit();
} else {
    require_once $rootDirectory . "/event-management/config/permissions.php";
    require_once $rootDirectory . "/event-management/helpers/hasPermission.php";

    if (!isset($_SESSION["loggedUserPermissions"]) || !hasPermission($createCategory)) {
        header("location: ../unauthorized.php");
        exit();
    }
}

$errors = [];
if (isset($_SESSION["errors"])) {
    $errors = $_SESSION["errors"];

    unset($_SESSION["errors"]);
}

if (isset($_SESSION["data"])) {
    $data = $_SESSION["data"];

    unset($_SESSION["data"]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create category</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/snackbar.css">
</head>

<body>
    <?php
    include "../../templates/sidebar.php";
    ?>

    <div class="panel">
        <div class="sidebar-whitespace"></div>

        <main class="panel__content">
            <div class="panel__content__head">
                <div class="panel__content__head__container">
                    <h4>Create a new category</h4>

                    <nav class="breadcrumbs">
                        <a href="../dashboard" class="link link--dark breadcrumbs__link">Dashboard</a>

                        <span class="breadcrumbs__separator"></span>

                        <a href="categories.php" class="link link--dark breadcrumbs__link">Categories</a>

                        <span class="breadcrumbs__separator"></span>

                        <span class="breadcrumbs__active">New category</span>
                    </nav>
                </div>

                <div class="panel__content__head__container"></div>
            </div>

            <div class="card">
                <form action="../../includes/createCategory.php" method="post" enctype="multipart/form-data" class="form">
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

                            <i class="form_field_file_icon">
                                <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/upload.svg") ?>
                            </i>

                            <span class="form__field__file__title">Select image</span>

                            <img src="#" alt="Image preview" class="form__field__file__img">
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

                    <button type="submit" class="button button--primary full-width form__button">Create</button>
                </form>
            </div>

            <?php
            if (isset($_SESSION["message"]) && $_SESSION["message"] === "SUCCESS") {
                echo '
                <div class="snackbar snackbar--success">
                    <p class="snackbar__text text--light body2">Category created!</p>

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

    <script src="/event-management/public/js/sidebar.js"></script>
    <script src="/event-management/public/js/preview-image.js"></script>
    <script src="/event-management/public/js/trigger-button-click.js"></script>
    <script src="/event-management/public/js/snackbar-handler.js"></script>
</body>

</html>