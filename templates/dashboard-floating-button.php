<?php
$rootDirectory = $_SERVER['DOCUMENT_ROOT'];
?>

<link rel="stylesheet" href="../public/css/floating-button.css">

<div class="floating-button" title="Dashboard">
    <a href="/event-management/public/dashboard" class="floating-button__anchor">
        <i class="floating-button__icon">
            <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/dashboard.svg") ?>
        </i>
    </a>
</div>