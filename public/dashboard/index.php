<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION["loggedUserId"])) {
    header("location: ../login.php");

    exit();
}

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];

$analyticsImg = file_get_contents($rootDirectory . "/event-management/public/images/analytics.svg");

require_once $rootDirectory . "/event-management/config/roles.php";

$adminView = "
<p class='mt-24'>As an admin you can create, edit, and delete categories.</p>
<a href='/event-management/public/dashboard/create-category.php' class='button button--primary'>Add category</a>
";

$organizerView = "
<p class='mt-24'>As an organizer you can create, edit, and delete events.</p>
<p>Also, you can view events that you have created!</p>
<a href='/event-management/public/dashboard/create-event.php' class='button button--primary mt-24'>Add event</a>
";

$userView = "
<p class='mt-24'>Do not miss on events that you are going to attend.</p>
<p>Click the button below to view attending events!</p>
<a href='/event-management/public/dashboard/events.php' class='button button--primary mt-24'>Events</a>
";

$loggedUserView = "";
switch ($_SESSION["loggedUserRole"]) {
    case $admin:
        $loggedUserView = $adminView;
        break;
    case $organizer:
        $loggedUserView = $organizerView;
        break;
    case $user:
    default:
        $loggedUserView = $userView;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
    <?php
    include "../../templates/sidebar.php";
    ?>

    <div class="panel">
        <div class="sidebar-whitespace"></div>

        <main class="panel__content">
            <div class="dashboard-grid">
                <div class="container">
                    <div class="dashboard-grid__item">
                        <div class="card">
                            <div class="dashboard-grid__item__container">
                                <div>
                                    <h5>Welcome back 👋</h5>
                                    <h4><?php echo $_SESSION["loggedUserName"]; ?></h4>

                                    <?php echo $loggedUserView; ?>
                                </div>

                                <div class="dashboard__img">
                                    <?php echo $analyticsImg; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="/event-management/public/js/sidebar.js"></script>
</body>

</html>