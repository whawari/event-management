<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . "/../config/root-directory.php";
require_once __DIR__ . "/../config/roles.php";
require_once __DIR__ . "/../config/permissions.php";
require_once __DIR__ . "/../helpers/hasPermission.php";
?>

<link rel="stylesheet" href="<?php echo $rootDirectory . 'public/css/header.css' ?>">

<header class="header">
    <div class="container">
        <div class="header__container">
            <a href="<?php echo $rootDirectory ?>" class="header__logo">
                <img src="<?php echo $rootDirectory . 'public/images/logo.svg' ?>" alt="logo" class="header__logo__img">
            </a>

            <nav class="header__menu">
                <a href="<?php echo $rootDirectory ?>" class="link link--light header__menu__link">Home</a>

                <a href="<?php echo $rootDirectory . 'categories.php' ?>" class="link link--light header__menu__link">Categories</a>

                <a href="<?php echo $rootDirectory . 'events.php' ?>" class="link link--light header__menu__link">Events</a>
            </nav>

            <?php
            if (isset($_SESSION["loggedUserId"])) {
                if (hasPermission($createEvent) && $_SESSION["loggedUserRole"] === $organizer) {
                    echo "<a href='" . $rootDirectory . "dashboard/create-event.php' class='button button--primary header__cta'>Create event</a>";
                }
            } else {
                echo "<a href='" . $rootDirectory . "login.php' class='button button--primary header__cta'>Log in</a>";
            }
            ?>

            <button type="button" class="icon-button icon-button--mr-minus8 header__burger">
                <i class="icon-button__icon">
                    <?php echo file_get_contents(__DIR__ . "/../public/images/icons/burger.svg") ?>
                </i>
            </button>
        </div>
    </div>

    <?php
    include __DIR__ . "/../templates/navigation-drawer.php";
    ?>

</header>

<script src="<?php echo $rootDirectory . 'public/js/header-scroll.js' ?>"></script>

<script src="<?php echo $rootDirectory . 'public/js/navigation-drawer-toggle.js' ?>"></script>