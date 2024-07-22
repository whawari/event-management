<?php
if (!isset($_SESSION)) {
    session_start();
}

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
?>

<link rel="stylesheet" href="../public/css/navigation-drawer.css">

<div class="navigation-drawer navigation-drawer--close">
    <button type="button" class="icon-button icon-button--dark navigation-drawer__close">
        <i class="icon-button__icon">
            <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/close.svg") ?>
        </i>
    </button>

    <div class="navigation-drawer__container">
        <a href="../public/" class="navigation-drawer__logo">
            <img src="../public/images/logo.svg" alt="logo" class="navigation-drawer__logo__img">
        </a>

        <nav class="navigation-drawer__menu">
            <a href="../public/" class="link link--dark">Home</a>

            <a href="../public/events.php" class="link link--dark">Events</a>
        </nav>

        <?php
        if (!isset($_SESSION["loggedUserId"])) {
            echo '<a href="../public/login.php" class="button button--primary">Log in</a>';
        }
        ?>
    </div>
</div>