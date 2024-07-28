<?php
if (!isset($_SESSION)) {
    session_start();
}

$rootDir = $_SERVER["DOCUMENT_ROOT"];

require_once $rootDir . "/event-management/config/db-connect.php";
require_once $rootDir . "/event-management/config/permissions.php";
require_once $rootDir . "/event-management/helpers/hasPermission.php";

$attendIcon = file_get_contents($rootDir . "/event-management/public/images/icons/attend.svg");
$attendedIcon = file_get_contents($rootDir . "/event-management/public/images/icons/attended.svg");
$attendingIcon = file_get_contents($rootDir . "/event-management/public/images/icons/attending.svg");
$editIcon = file_get_contents($rootDir . "/event-management/public/images/icons/edit.svg");
$locationIcon = file_get_contents($rootDir . "/event-management/public/images/icons/location.svg");
$clockIcon = file_get_contents($rootDir . "/event-management/public/images/icons/clock.svg");
$emailIcon = file_get_contents($rootDir . "/event-management/public/images/icons/email.svg");

if (empty($_GET["eventId"]) || $_GET["eventId"] == "null" || $_GET["eventId"] == null) {
    header('HTTP/1.1 400 Bad Request');
    echo "Your request could not be processed due to a syntax error";
    exit();
}

if (isset($_GET["action"]) && $_GET["action"] === "fetchEvent") {
    $loggedUserId = "";
    $eventId = $_GET["eventId"];

    if (isset($_SESSION["loggedUserId"])) {
        $loggedUserId = $_SESSION["loggedUserId"];
    }

    $query = "SELECT events.*, event_images.name AS image_name,
        COUNT(attendees.id) AS total_attendees
        FROM events
        INNER JOIN event_images ON events.id = event_images.event_id
        LEFT JOIN attendees ON events.id = attendees.event_id
        WHERE events.id = $eventId
        GROUP BY events.id, event_images.name
        ORDER BY events.id DESC;";

    if ($loggedUserId) {
        $query = "SELECT events.*, event_images.name AS image_name,
            COUNT(attendees.id) AS total_attendees,
            CASE 
                WHEN EXISTS (
                    SELECT 1 
                    FROM attendees 
                    WHERE attendees.event_id = events.id AND attendees.user_id = $loggedUserId
                )
                THEN 1 
                ELSE 0 
            END AS is_attending
            FROM events
            INNER JOIN event_images ON events.id = event_images.event_id
            LEFT JOIN attendees ON events.id = attendees.event_id
            WHERE events.id = $eventId
            GROUP BY events.id, event_images.name
            ORDER BY events.id DESC;";
    }

    require_once "../config/db-connect.php";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        header('HTTP/1.1 500 Internal server error');
        echo mysqli_error($connection);
        echo "<br>An error occurred while fetching data";
        mysqli_close($connection);
        exit();
    }

    $count = mysqli_num_rows($result);

    if ($count === 0) {
        header('HTTP/1.1 404 Not Found');
        echo "Event not found";
        mysqli_close($connection);
        exit();
    }

    $event = mysqli_fetch_assoc($result);

    $uploadsFolderDirectory = "/event-management/public/images/uploads/";
    $imageSrc = $uploadsFolderDirectory . $event["image_name"];
    $eventTitle = $event["title"];
    $eventDescription = $event["description"];
    $eventDate = $event["date"];
    $eventTime = $event["time"];
    $eventLocation = $event["location"];
    $totalAttendees = $event["total_attendees"];
    $categoryId = $event["category_id"];
    $createdById = $event["created_by"];

    require_once "../helpers/getCategoryById.php";

    $category = getCategoryById($connection, $categoryId);

    $categoryName = "";
    if (!isset($category["error"])) {
        $categoryName = $category["name"];
    }

    require_once "../helpers/getUserById.php";

    $createdBy = getUserById($connection, $createdById);

    $createdByName = "";
    $createdByEmail = "";
    if (!isset($createdBy["error"])) {
        $createdByName = $createdBy["name"];
        $createdByEmail = $createdBy["email"];
    }

    mysqli_close($connection);

    $categoryNameSection = "";
    if ($categoryName) {
        $categoryNameSection = "<a href='/event-management/public/category.php?id=$categoryId' class='subtitle link link--accent event-category'>$categoryName</a>";
    }

    $organizedBySection = "";
    if ($createdByName && $createdByEmail) {
        $organizedBySection = "
        <div class='event-column'>
            <h5>Organized by</h5>

            <div class='event-row'>
                <span>Name: $createdByName</span>
            </div>

            <div class='event-row'>
                <i>$emailIcon</i>

                <span class='event-createdBy-email'>$createdByEmail</span>
            </div>
        </div>
        ";
    }

    $attendCtaSection = "";
    $editSection = "";
    if ($loggedUserId) {
        $isAttending = 0;
        if (isset($event["is_attending"])) {
            $isAttending = $event["is_attending"];
        }

        if (hasPermission($attendEvent)) {
            if ($isAttending) {
                $attendCtaSection = "
                <div class='event__content__body__action'>
                    <button type='button' title='Attended' class='icon-button icon-button--dark unattend-button' data-id='$eventId'>
                        <i class='icon-button__icon'>
                            $attendedIcon
                        </i>
                    </button>
                </div>
                ";
            } else {
                $attendCtaSection = "
                <div class='event__content__body__action'>
                    <button type='button' title='Attend' class='icon-button icon-button--dark attend-button' data-id='$eventId'>
                        <i class='icon-button__icon'>
                            $attendIcon
                        </i>
                    </button>
                </div>
                ";
            }
        } else if (hasPermission($editEvent)) {
            $editSection = "
            <div class='event__content__body__action'>
                <a href='/event-management/public/dashboard/edit-event.php?id=$eventId' type='button' class='icon-button icon-button--dark icon-button--mr-minus8' title='Edit'>
                    <i class='icon-button__icon'>$editIcon</i>
                </a>
            </div>
            ";
        }
    }

    echo "
    <div class='event__content__hero' style='background-image: url($imageSrc)'>
        <div class='event__content__hero__overlay'></div>
    </div>

    <div class='event__content__body'>
        $editSection

        $attendCtaSection
    
        <div class='event__content__body__container'>
            <div class='event-box'>
                $categoryNameSection

                <h3 class='event-title text--center'>$eventTitle</h3>
            </div>

            <p class='event-description text--center mt-24'>$eventDescription</p>

            <div class='event-column'>
                <h5>Location</h5>

                <div class='event-row'>
                    <i>$locationIcon</i>

                    <span>$eventLocation</span>
                </div>
            </div>

            <div class='event-column'>
                <h5>Date and time</h5>

                <div class='event-row'>
                    <i>$clockIcon</i>

                    <span>$eventDate At $eventTime</span>
                </div>
            </div>

            $organizedBySection

            <div class='event-column'>
                <h5>Total attending</h5>

                <div class='event-row'>
                    <i>$attendingIcon</i>

                    <span class='event-attendees'>$totalAttendees attending</span>
                </div>
            </div>
        </div>
    </div>
    ";
} else {
    header('HTTP/1.1 403 Forbidden');
    echo "Unauthorized";
    exit();
}
