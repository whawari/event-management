<?php
if (!isset($_SESSION)) {
    session_start();
}

$attendIcon = file_get_contents("public/images/icons/attend.svg");
$attendedIcon = file_get_contents("public/images/icons/attended.svg");
$attendingIcon = file_get_contents("public/images/icons/attending.svg");

$eventId = "";
$eventError = "";

if (isset($_GET["id"])) {
    $eventId = $_GET["id"];
} else {
    $eventError = "Event not found";
}
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
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/events.css">
    <link rel="stylesheet" href="public/css/snackbar.css">
    <link rel="stylesheet" href="public/css/event-page.css">

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <title>EventHub - Event</title>
</head>

<body>

    <?php require_once "templates/header.php"; ?>

    <div class="event">
        <div class="event__content" id="event-content"></div>

        <?php
        if (!$eventError) {
            echo "
            <div class='feedback-container'>
                <i class='spinner' id='spinner'>
                    <?php echo file_get_contents('public/images/icons/spinner.svg') ?>
                </i>

                <p class='text--danger' id='feedback'></p>
            </div>
            ";
        } else {
            echo "
            <div class='event__error container'>
                <p class='text--danger'>$eventError</p>

                <a href='events.php' class='button button--primary'>Browse events</a>
            </div>
            ";
        }
        ?>

        <div class="snackbar" id="snackbar">
            <p class="snackbar__text text--light body2" id="snackbar-message"></p>

            <button type="button" class="snackbar__close" id="snackbar-close">
                <span class="snackbar__close__slice"></span>
                <span class="snackbar__close__slice"></span>
            </button>
        </div>
    </div>

    <?php require_once "templates/footer.php"; ?>

    <?php
    if (isset($_SESSION["loggedUserId"])) {
        require_once "templates/dashboard-floating-button.php";
    }
    ?>

    <script type="text/javascript">
        $(document).ready(function() {
            <?php
            if ($eventId) {
            ?>
                fetchEvent();
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

        function fetchEvent() {
            $.ajax({
                url: "includes/viewEvent.php",
                method: "GET",
                data: {
                    action: "fetchEvent",
                    eventId: <?php echo $eventId ? $eventId : "null" ?>

                },
                success: function(data) {
                    $('#event-content').html(data);
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
                url: "includes/attendEvent.php",
                method: "GET",
                data: {
                    action: "attendEvent",
                    eventId: $eventId
                },
                success: function(data) {
                    showSnackbar(data, "success");

                    fetchEvent();
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
                url: "includes/unattendEvent.php",
                method: "GET",
                data: {
                    action: "attendEvent",
                    eventId: $eventId
                },
                success: function(data) {
                    showSnackbar(data, "success");

                    fetchEvent();
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