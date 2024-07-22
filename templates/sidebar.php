<?php
$current_page = basename($_SERVER['PHP_SELF']);
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];

require_once $rootDirectory . "/event-management/config/permissions.php";
require_once $rootDirectory . "/event-management/helpers/hasPermission.php";
?>

<div class="sidebar sidebar--closed">
    <div class="sidebar__header">
        <a href="/event-management/public">
            <img src="/event-management/public/images/logo.svg" alt="logo" class="sidebar__header__logo">
        </a>

        <button type="button" class="sidebar__header__close">
            <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/close.svg") ?>
        </button>

        <button type="button" class="sidebar__header__resize" data-toggle="opened" title="Minimize">
            <img src="/event-management/public/images/icons/chevron-left.svg" alt="chevron left" width="20px">
        </button>
    </div>

    <nav class="sidebar__nav">
        <a href="/event-management/public/dashboard" class="sidebar__nav__link<?php if ($current_page === 'index.php') echo ' sidebar__nav__link--active' ?>">
            <i class="sidebar__nav__link__icon">
                <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/dashboard.svg") ?>
            </i>

            <span class="sidebar__nav__link__title">
                Dashboard
            </span>
        </a>

        <?php
        if (hasPermission($viewCategory)) {
            echo '<a href="/event-management/public/dashboard/categories.php" class="sidebar__nav__link';
            if ($current_page === 'categories.php' || $current_page === 'create-category.php') {
                echo ' sidebar__nav__link--active';
            }

            echo '"><i class="sidebar__nav__link__icon">
                    ' . file_get_contents($rootDirectory . "/event-management/public/images/icons/categories.svg") . '
                </i>

                <span class="sidebar__nav__link__title">
                    Categories
                </span>
            </a>';
        }
        ?>
    </nav>

    <div class="sidebar__footer">
        <a href="/event-management/includes/logout.php" class="button sidebar__footer__logout">
            Logout
        </a>
    </div>
</div>

<div style="display: flex;">
    <div class="sidebar-whitespace"></div>

    <header class="toolbar">
        <div class="toolbar__box">
            <button type="button" class="toolbar__burger">
                <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/burger.svg") ?>
            </button>

            <a href="/event-management/public">
                <img src="/event-management/public/images/logo.svg" alt="logo" class="toolbar__logo">
            </a>
        </div>
    </header>
</div>