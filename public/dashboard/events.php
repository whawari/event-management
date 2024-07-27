<?php
if (!isset($_SESSION)) {
    session_start();
}

$rootDirectory = $_SERVER['DOCUMENT_ROOT'];

require_once $rootDirectory . "/event-management/config/permissions.php";
require_once $rootDirectory . "/event-management/helpers/hasPermission.php";

if (!isset($_SESSION["loggedUserId"])) {
    header("location: ../login.php");

    exit();
} else {
    if (!isset($_SESSION["loggedUserPermissions"]) || !hasPermission($viewEvent)) {
        header("location: ../unauthorized.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Events</title>

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">

    <!-- Custom styles -->
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/events.css">
    <link rel="stylesheet" href="../css/snackbar.css">

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include "../../templates/sidebar.php";
    ?>

    <div class="panel">
        <div class="sidebar-whitespace"></div>

        <main class="panel__content">
            <div class="panel__content__head">
                <div class="panel__content__head__container">
                    <?php
                    if(hasPermission($createEvent)) {
                        echo "<h4>My events</h4>";
                    } else if (hasPermission($attendEvent)) {
                        echo "<h4>Attending events</h4>";
                    } else {
                        echo "<h4>Events</h4>";
                    }
                    ?>

                    <nav class="breadcrumbs">
                        <a href="../dashboard" class="link link--dark breadcrumbs__link">Dashboard</a>

                        <span class="breadcrumbs__separator"></span>

                        <span class="breadcrumbs__active">Events</span>
                    </nav>
                </div>

                <?php
                if (hasPermission($createEvent)) {
                    echo "<a href='create-event.php' class='button button--primary panel__content__head__cta'>New event</a>";
                }
                ?>
            </div>

            <div class="panel__content__body">
                <div class="container">
                    <div id="events"></div>

                    <div class="feedback-container">
                        <i class="spinner" id="spinner">
                            <?php echo file_get_contents($rootDirectory . "/event-management/public/images/icons/spinner.svg") ?>
                        </i>

                        <p class="text--danger" id="feedback"></p>
                    </div>
                </div>

                <div class="snackbar" id="snackbar">
                    <p class="snackbar__text text--light body2" id="snackbar-message">Category created!</p>

                    <button type="button" class="snackbar__close" id="snackbar-close">
                        <span class="snackbar__close__slice"></span>
                        <span class="snackbar__close__slice"></span>
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script src="/event-management/public/js/sidebar.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#feedback').hide();

            fetchEvents();

            $(document).on("click", ".delete-button", function() {
                deleteEvent($(this).attr("data-id"));
            })

            $(document).on("click", "#snackbar-close", function() {
                hideSnackbar();
            })

            $(document).on("click", ".unattend-button", function() {
                unattendEvent($(this).attr("data-id"));
            })
        });

        function fetchEvents() {
            $.ajax({
                url: "../../includes/viewEvents.php",
                method: "GET",
                data: {
                    action: "fetchEvents",
                    requestLocation: "dashboard"
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

        function deleteEvent($eventId) {
            $('#feedback').hide();

            $.ajax({
                url: "../../includes/deleteEvent.php",
                method: "GET",
                data: {
                    action: "deleteEvent",
                    eventId: $eventId
                },
                success: function(data) {
                    fetchEvents();
                },
                error: function(xhr) {
                    $('#feedback').show();

                    $('#feedback').html(xhr.responseText);
                },
            });
        }

        function unattendEvent($eventId) {
            $.ajax({
                url: "../../includes/unattendEvent.php",
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