<?php
$current_page = basename($_SERVER['PHP_SELF']);

require_once __DIR__ . "/../config/root-directory.php";
require_once __DIR__ . "/../config/permissions.php";
require_once __DIR__ . "/../helpers/hasPermission.php";
?>

<div class="sidebar sidebar--closed">
    <div class="sidebar__header">
        <a href="<?php echo $rootDirectory ?>">
            <img src="<?php echo $rootDirectory . 'public/images/logo.svg' ?>" alt="logo" class="sidebar__header__logo">
        </a>

        <button type="button" class="icon-button icon-button--mr-minus8 sidebar__header__close">
            <i class="icon-button__icon">
                <?php echo file_get_contents(__DIR__ . "/../public/images/icons/close.svg") ?>
            </i>
        </button>

        <button type="button" class="icon-button sidebar__header__resize" data-toggle="opened" title="Minimize">
            <img src="<?php echo $rootDirectory . 'public/images/icons/chevron-left.svg' ?>" alt="chevron left" class="icon-button__icon">
        </button>
    </div>

    <nav class="sidebar__nav">
        <a href="<?php echo $rootDirectory . 'dashboard' ?>" class="sidebar__nav__link<?php if ($current_page === 'index.php') echo ' sidebar__nav__link--active' ?>">
            <i class="sidebar__nav__link__icon">
                <?php echo file_get_contents(__DIR__ . "/../public/images/icons/dashboard.svg") ?>
            </i>

            <span class="sidebar__nav__link__title">
                Dashboard
            </span>
        </a>

        <?php
        if (hasPermission($viewCategory)) {
            echo "<a href='" . $rootDirectory . "dashboard/categories.php' class='sidebar__nav__link";
            if ($current_page === 'categories.php' || $current_page === 'create-category.php' || $current_page === 'edit-category.php') {
                echo ' sidebar__nav__link--active';
            }

            echo "'><i class='sidebar__nav__link__icon'>
                    " . file_get_contents(__DIR__ . '/../public/images/icons/categories.svg') . "
                </i>

                <span class='sidebar__nav__link__title'>
                    Categories
                </span>
            </a>";
        }
        ?>

        <?php
        if (hasPermission($viewEvent)) {
            echo "<a href='" . $rootDirectory . "dashboard/events.php' class='sidebar__nav__link";
            if ($current_page === 'events.php' || $current_page === 'create-event.php' || $current_page === 'edit-event.php') {
                echo ' sidebar__nav__link--active';
            }

            echo "'>
                <i class='sidebar__nav__link__icon'>
                    " . file_get_contents(__DIR__ . '/../public/images/icons/events.svg') . "
                </i>

                <span class='sidebar__nav__link__title'>
                    Events
                </span>
            </a>";
        }
        ?>
    </nav>

    <div class="sidebar__footer">
        <a href="<?php echo $rootDirectory . 'includes/logout.php' ?>" class="button sidebar__footer__logout">
            Logout
        </a>
    </div>
</div>

<div style="display: flex;">
    <div class="sidebar-whitespace"></div>

    <header class="toolbar">
        <div class="toolbar__box">
            <button type="button" class="icon-button icon-button--ml-minus8 icon-button--dark toolbar__burger">
                <i class="icon-button__icon">
                    <?php echo file_get_contents(__DIR__ . "/../public/images/icons/burger.svg") ?>
                </i>
            </button>

            <a href="<?php echo $rootDirectory ?>">
                <img src="<?php echo $rootDirectory . 'public/images/logo.svg' ?>" alt="logo" class="toolbar__logo">
            </a>
        </div>
    </header>
</div>