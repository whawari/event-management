<?php require_once __DIR__ . "/../config/root-directory.php"; ?>

<link rel="stylesheet" href="<?php echo $rootDirectory . 'public/css/floating-button.css' ?>">

<div class="floating-button" title="Dashboard">
    <a href="<?php echo $rootDirectory . 'dashboard' ?>" class="floating-button__anchor">
        <i class="floating-button__icon">
            <?php echo file_get_contents(__DIR__ . "/../public/images/icons/dashboard.svg") ?>
        </i>
    </a>
</div>