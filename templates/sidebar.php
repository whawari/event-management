<?php
$current_page = basename($_SERVER['PHP_SELF']);
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
?>

<div class="sidebar sidebar--closed">
    <div class="sidebar__header">
        <img src="/event-management/public/images/logo.svg" alt="logo" class="sidebar__header__logo">

        <button type="button" class="sidebar__header__close">
            <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/close.svg") ?>
        </button>

        <button type="button" class="sidebar__header__resize" data-toggle="opened">
            <img src="/event-management/public/images/icons/chevron-left.svg" alt="chevron left" width="20px">
        </button>
    </div>

    <nav class="sidebar__nav">
        <a href="" class="sidebar__nav__link<?php if ($current_page === 'index.php') echo ' sidebar__nav__link--active' ?>">
            <i class="sidebar__nav__link__icon">
                <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/dashboard.svg") ?>
            </i>

            <span class="sidebar__nav__link__title">
                Dashboard
            </span>
        </a>
    </nav>
</div>

<div style="display: flex;">
    <div class="sidebar-whitespace"></div>

    <header class="toolbar">
        <button type="button" class="toolbar__burger">
            <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/burger.svg") ?>
        </button>

        <img src="/event-management/public/images/logo.svg" alt="logo" class="toolbar__logo">
    </header>
</div>