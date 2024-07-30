<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . "/../config/root-directory.php";
?>

<link rel="stylesheet" href="<?php echo $rootDirectory . 'public/css/navigation-drawer.css'?>">

<div class="navigation-drawer navigation-drawer--close">
    <button type="button" class="icon-button icon-button--dark navigation-drawer__close">
        <i class="icon-button__icon">
            <?php echo file_get_contents(__DIR__ . "/../public/images/icons/close.svg") ?>
        </i>
    </button>

    <div class="navigation-drawer__container">
        <a href="<?php echo $rootDirectory ?>" class="navigation-drawer__logo">
            <img src="<?php echo $rootDirectory . 'public/images/logo.svg'?>" alt="logo" class="navigation-drawer__logo__img">
        </a>

        <nav class="navigation-drawer__menu">
            <a href="<?php echo $rootDirectory ?>" class="link link--dark">Home</a>

            <a href="<?php echo $rootDirectory . 'categories.php'?>" class="link link--dark">Categories</a>

            <a href="<?php echo $rootDirectory . 'events.php'?>" class="link link--dark">Events</a>
        </nav>

        <?php
        if (!isset($_SESSION["loggedUserId"])) {
            echo "<a href='" . $rootDirectory . "login.php' class='button button--primary'>Log in</a>";
        }
        ?>
    </div>
</div>