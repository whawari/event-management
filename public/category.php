<?php
if (!isset($_SESSION)) {
    session_start();
}

$rootDir = $_SERVER["DOCUMENT_ROOT"];
require_once $rootDir . "/event-management/config/db-connect.php";
require_once $rootDir . "/event-management/helpers/getCategoryById.php";

$attendIcon = file_get_contents($rootDir . "/event-management/public/images/icons/attend.svg");
$attendedIcon = file_get_contents($rootDir . "/event-management/public/images/icons/attended.svg");
$attendingIcon = file_get_contents($rootDir . "/event-management/public/images/icons/attending.svg");

$categoryId = "";
$categoryName = "";
$categoryImage = "";
$categoryError = "";
$category = array();

if (isset($_GET["id"])) {
    $categoryId = $_GET["id"];

    $category = getCategoryById($connection, $categoryId ?? "null");

    if (isset($category["error"])) {
        $categoryError = $category["error"];
    } else {
        $categoryName = $category["name"];
        $categoryImage = $category["image_name"];
    }
} else {
    $categoryError = "Category not found";
}

mysqli_close($connection);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/events.css">
    <link rel="stylesheet" href="css/snackbar.css">
    <link rel="stylesheet" href="css/category-page.css">

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <title>EventHub - Category<?php echo $categoryName ? " | " . $categoryName : "" ?></title>
</head>

<body>

    <?php include "../templates/header.php"; ?>

    <div class="category">
        <?php
        if ($category && !$categoryError) {
            echo "
            <div class='category__header' style='background-image: url(images/uploads/$categoryImage);'>
                <div class='category__header__overlay'>
                    <h1 class='text--large text--light text--center'>$categoryName</h1>
                </div>
            </div>

            <div class='category__content'>
                <div class='container'>
                    <div id='events'></div>

                    <div class='feedback-container'>
                        <i class='spinner' id='spinner'>
                            <?php echo file_get_contents($rootDirectory . '/event-management/public/images/icons/spinner.svg') ?>
                        </i>

                        <p class='text--danger' id='feedback'></p>
                    </div>
                </div>
            </div>
            ";
        } else {
            echo "
            <div class='category__error container'>
                <p class='text--danger'>$categoryError</p>

                <a href='categories.php' class='button button--primary'>Categories</a>
            </div>
            ";
        }
        ?>


    </div>

    <?php
    if (isset($_SESSION["loggedUserId"])) {
        include "../templates/dashboard-floating-button.php";
    }
    ?>

    <script type="text/javascript">
        $(document).ready(function() {
            <?php
            if (!$categoryError && $categoryId) {
            ?>
                fetchEvents();
            <?php
            }
            ?>

            $(document).on("click", "#snackbar-close", function() {
                hideSnackbar();
            })

            $(document).on("click", ".attend-button", function() {
                attendEvent($(this).attr("data-id"));
            })

            $(document).on("click", ".unattend-button", function() {
                unattendEvent($(this).attr("data-id"));
            })
        });

        function fetchEvents() {
            $.ajax({
                url: "../includes/viewEvents.php",
                method: "GET",
                data: {
                    action: "fetchEvents",
                    requestLocation: "category",
                    categoryId: <?php echo $categoryId ?>

                },
                success: function(data) {
                    $('#events').html(data);
                },
                error: function(xhr) {
                    $('#feedback').show();

                    $('#feedback').html(xhr.responseText);
                },
                complete: function() {
                    $('#spinner').hide();
                }
            });
        }

        function attendEvent($eventId) {
            $.ajax({
                url: "../includes/attendEvent.php",
                method: "GET",
                data: {
                    action: "attendEvent",
                    eventId: $eventId
                },
                success: function(data) {
                    showSnackbar(data, "success");

                    fetchEvents();
                },
                error: function(xhr) {
                    showSnackbar(xhr.responseText, "danger");
                },
                complete: function() {
                    setTimeout(() => {
                        hideSnackbar();
                    }, 5000);
                }
            });
        }

        function unattendEvent($eventId) {
            $.ajax({
                url: "../includes/unattendEvent.php",
                method: "GET",
                data: {
                    action: "attendEvent",
                    eventId: $eventId
                },
                success: function(data) {
                    showSnackbar(data, "success");

                    fetchEvents();
                },
                error: function(xhr) {
                    showSnackbar(xhr.responseText, "danger");
                },
                complete: function() {
                    setTimeout(() => {
                        hideSnackbar();
                    }, 5000);
                }
            });
        }

        function showSnackbar($message, $state = "success") {
            $("#snackbar").css("visibility", "visible");
            $("#snackbar").css("right", "24px");

            if ($state === "danger") {
                $("#snackbar").addClass("snackbar--danger");
            } else {
                $("#snackbar").addClass("snackbar--success");
            }

            $("#snackbar-message").html($message);
        }

        function hideSnackbar() {
            $("#snackbar").css("right", "-100%");

            setTimeout(() => {
                $("#snackbar").css("visibility", "hidden");
            }, 500);

            $("#snackbar-message").html("");
        }
    </script>
</body>

</html>