<?php
if (!isset($_SESSION)) {
    session_start();
}

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];

require_once "../config/roles.php";
require_once "../config/permissions.php";
require_once "../helpers/hasPermission.php";
?>

<link rel="stylesheet" href="/event-management/public/css/header.css">

<header class="header">
    <div class="container">
        <div class="header__container">
            <a href="/event-management/public/" class="header__logo">
                <img src="/event-management/public/images/logo.svg" alt="logo" class="header__logo__img">
            </a>

            <nav class="header__menu">
                <a href="/event-management/public/" class="link link--light header__menu__link">Home</a>

                <a href="/event-management/public/events.php" class="link link--light header__menu__link">Events</a>
            </nav>

            <?php
            if (isset($_SESSION["loggedUserId"])) {
                if (hasPermission($createEvent) && $_SESSION["loggedUserRole"] === $organizer) {
                    echo '<a href="/event-management/public/dashboard/create-event.php" class="button button--primary header__cta">Create event</a>';
                }
            } else {
                echo '<a href="/event-management/public/login.php" class="button button--primary header__cta">Log in</a>';
            }
            ?>

            <button type="button" class="icon-button icon-button--mr-minus8 header__burger">
                <i class="icon-button__icon">
                    <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/burger.svg") ?>
                </i>
            </button>
        </div>
    </div>

    <?php
    include "navigation-drawer.php";
    ?>

</header>

<script src="../public/js/header-scroll.js"></script>

<script src="../public/js/navigation-drawer-toggle.js"></script>