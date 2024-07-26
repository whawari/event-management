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

    if (!isset($_SESSION["loggedUserPermissions"]) || !hasPermission($createEvent)) {
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

    <title>Create event</title>

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
                    <h4>Create a new event</h4>

                    <nav class="breadcrumbs">
                        <a href="../dashboard" class="link link--dark breadcrumbs__link">Dashboard</a>

                        <span class="breadcrumbs__separator"></span>

                        <a href="events.php" class="link link--dark breadcrumbs__link">Events</a>

                        <span class="breadcrumbs__separator"></span>

                        <span class="breadcrumbs__active">New event</span>
                    </nav>
                </div>

                <div class="panel__content__head__container"></div>
            </div>

            <div class="card">
                <form action="../../includes/createEvent.php" method="post" enctype="multipart/form-data" class="form">
                    <div class="form__field">
                        <label for="title" title="Required" class="form__field__label">
                            Title <span class="form__field__label__required">*</span>
                        </label>

                        <input type="text" name="title" id="title" value="<?php echo isset($data['title']) ? $data['title']  : '' ?>" class="form__field__input<?php echo isset($errors['titleError']) ? ' form__field__input--danger' : '' ?>">

                        <?php
                        if (isset($errors["titleError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["titleError"] . "</span>";
                        }
                        ?>
                    </div>

                    <div class="form__field">
                        <label for="description" title="Required" class="form__field__label">
                            Description <span class="form__field__label__required">*</span>
                        </label>

                        <textarea name="description" id="description" rows="10" class="form__field__input<?php echo isset($errors['descriptionError']) ? ' form__field__input--danger' : '' ?>"><?php echo isset($data['description']) ? $data['description']  : '' ?></textarea>

                        <?php
                        if (isset($errors["descriptionError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["descriptionError"] . "</span>";
                        }
                        ?>
                    </div>

                    <div class="form__field">
                        <label for="date" title="Required" class="form__field__label">
                            Date <span class="form__field__label__required">*</span>
                        </label>

                        <input type="date" name="date" id="date" value="<?php echo isset($data['date']) ? $data['date']  : '' ?>" class="form__field__input<?php echo isset($errors['dateError']) ? ' form__field__input--danger' : '' ?>">

                        <?php
                        if (isset($errors["dateError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["dateError"] . "</span>";
                        }
                        ?>
                    </div>

                    <div class="form__field">
                        <label for="time" title="Required" class="form__field__label">
                            Time <span class="form__field__label__required">*</span>
                        </label>

                        <input type="time" name="time" id="time" value="<?php echo isset($data['time']) ? $data['time']  : '' ?>" class="form__field__input<?php echo isset($errors['timeError']) ? ' form__field__input--danger' : '' ?>">

                        <?php
                        if (isset($errors["timeError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["timeError"] . "</span>";
                        }
                        ?>
                    </div>

                    <div class="form__field">
                        <label for="location" title="Required" class="form__field__label">
                            Location <span class="form__field__label__required">*</span>
                        </label>

                        <input type="text" name="location" id="location" value="<?php echo isset($data['location']) ? $data['location']  : '' ?>" class="form__field__input<?php echo isset($errors['locationError']) ? ' form__field__input--danger' : '' ?>">

                        <?php
                        if (isset($errors["locationError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["locationError"] . "</span>";
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

                    <div class="form__field">
                        <label for="categories-select" title="Required">
                            Category <span class="form__field__label__required">*</span>
                        </label>

                        <div class="form__field__select<?php echo isset($errors['categoryIdError']) ? ' form__field__select--danger' : '' ?>">
                            <select name="categoryId" id="categories-select" class="form__field__select__input">
                                <option value="" selected>Select</option>

                                <?php
                                require_once $rootDirectory . "/event-management/config/db-connect.php";
                                require_once $rootDirectory . "/event-management/helpers/getCategories.php";

                                $categories = getCategories($connection);
                                mysqli_close($connection);

                                if (!isset($categories["error"])) {
                                    foreach ($categories as $category) {
                                        echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>

                            <span class="form__field__select__focus"></span>
                        </div>

                        <?php
                        if (isset($errors["categoryIdError"])) {
                            echo "<span class='body2 form__field__info--danger'>" . $errors["categoryIdError"] . "</span>";
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
                    <p class="snackbar__text text--light body2">Event created!</p>

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