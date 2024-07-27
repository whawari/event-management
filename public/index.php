<?php
if (!isset($_SESSION)) {
    session_start();
}

$rootDir = $_SERVER["DOCUMENT_ROOT"];
require_once $rootDir . "/event-management/config/db-connect.php";
require_once $rootDir . "/event-management/helpers/getCategories.php";

$categories = getCategories($connection);

$attendIcon = file_get_contents($rootDir . "/event-management/public/images/icons/attend.svg");
$attendedIcon = file_get_contents($rootDir . "/event-management/public/images/icons/attended.svg");
$attendingIcon = file_get_contents($rootDir . "/event-management/public/images/icons/attending.svg");

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
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="css/events.css">
    <link rel="stylesheet" href="css/snackbar.css">

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <title>EventHub - Discover Events Around You</title>
</head>

<body>
    <?php include "../templates/header.php"; ?>

    <div class="hero">
        <h1 class="text--large text--light text--center">
            Creating positive
            <br>
            lasting impact
        </h1>

        <a href="events.php" class="button button--primary">Discover events</a>
    </div>

    <div class="home-description">
        <div class="container">
            <h2 class="text--light text--center home-description__text">Transforming your events hosting experience</h2>
        </div>
    </div>

    <div class="home-categories">
        <h3 class="text--center home-categories__text">Latest categories</h3>

        <?php
        if (isset($categories["error"])) {
            echo "<div class='feedback-container'>";
            echo "
                <p class='text--center text--danger'>" . $categories["error"] . "</p>
            ";

            if (hasPermission($createCategory)) {
                echo "
                <a href='/event-management/public/dashboard/create-category.php' class='button button--primary'>
                    Add category
                </a>
                ";
            }

            echo "</div>";
        } else {
            echo "<div class='home-categories__grid'>";

            $counter = 1;
            foreach ($categories as $category) {
                $categoryId = $category["id"];
                $categoryName = $category["name"];
                $categoryImage = $category["image_name"];

                echo "
                    <div class='home-categories__grid__item'>
                        <a href='category.php?id=$categoryId' class='home-categories__grid__item__anchor text--light'>
                            <img src='images/uploads/$categoryImage' alt='$categoryName' class='home-categories__grid__item__img'>

                            <h4 class='home-categories__grid__item__name'>$categoryName</h4>
                        </a>
                    </div>
                ";

                if ($counter === 4) {
                    break;
                }
                $counter++;
            }

            echo "</div>";
        }
        ?>

        <div class="centered-box mt-24">
            <a href="categories.php" class="button button--primary">All categories</a>
        </div>
    </div>

    <div class="home-events">
        <div class="container">
            <h3 class="text--center home-events__text">Upcoming events</h3>

            <div id="events"></div>

            <div class="feedback-container">
                <i class="spinner" id="spinner">
                    <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/spinner.svg") ?>
                </i>

                <p class="text--danger" id="feedback"></p>
            </div>
        </div>
    </div>

    <div class="snackbar" id="snackbar">
        <p class="snackbar__text text--light body2" id="snackbar-message"></p>

        <button type="button" class="snackbar__close" id="snackbar-close">
            <span class="snackbar__close__slice"></span>
            <span class="snackbar__close__slice"></span>
        </button>
    </div>

    <?php
    if (isset($_SESSION["loggedUserId"])) {
        include "../templates/dashboard-floating-button.php";
    }
    ?>

    <script type="text/javascript">
        $(document).ready(function() {
            fetchEvents();

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
                    requestLocation: "homepage"
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