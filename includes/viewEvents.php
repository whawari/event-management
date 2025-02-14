<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once "../config/root-directory.php";
require_once "../config/db-connect.php";
require_once "../config/permissions.php";
require_once "../helpers/hasPermission.php";

$attendIcon = file_get_contents("../public/images/icons/attend.svg");
$attendedIcon = file_get_contents("../public/images/icons/attended.svg");
$attendingIcon = file_get_contents("../public/images/icons/attending.svg");
$locationIcon = file_get_contents("../public/images/icons/location.svg");

if (isset($_GET["action"]) && $_GET["action"] == "fetchEvents") {
    $loggedUserId = "";
    // $query = "";
    // logged out users view
    $query = "SELECT events.*, event_images.name AS image_name,
        COUNT(attendees.id) AS total_attendees
        FROM events
        INNER JOIN event_images ON events.id = event_images.event_id
        LEFT JOIN attendees ON events.id = attendees.event_id
        GROUP BY events.id, event_images.name
        ORDER BY events.id DESC;";

    $requestLocation = "";
    if (isset($_GET["requestLocation"])) {
        $requestLocation = $_GET["requestLocation"];
    }

    if (isset($_SESSION["loggedUserId"])) {
        // logged in users
        $loggedUserId = $_SESSION["loggedUserId"];

        // logged in user -> view all events 
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
            GROUP BY events.id, event_images.name
            ORDER BY events.id DESC;";

        if ($requestLocation === "dashboard") {
            // logged in user -> view created events
            if (hasPermission($createEvent)) {
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
                    WHERE events.created_by = $loggedUserId
                    GROUP BY events.id, event_images.name
                    ORDER BY events.id DESC;";
            } else if (hasPermission($attendEvent)) {
                // logged in user -> view attending events
                $query = "SELECT events.*, event_images.name AS image_name,
                    (SELECT COUNT(*) FROM attendees WHERE attendees.event_id = events.id) AS total_attendees,
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
                    WHERE attendees.user_id = $loggedUserId
                    GROUP BY events.id, event_images.name
                    ORDER BY events.id DESC;
                ";
            }
        } else if ($requestLocation === "category") {
            if (isset($_GET["categoryId"])) {
                $categoryId = $_GET["categoryId"];

                // logged in user -> view events by category id
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
                    WHERE events.category_id = $categoryId
                    GROUP BY events.id, event_images.name
                    ORDER BY events.id DESC;";
            } else {
                header('HTTP/1.1 400 Bad Request');
                echo "It looks like your request cannot be processed due to incorrect URL syntax";
                exit();
            }
        }
    } else {
        // logged out users
        if ($requestLocation === "category") {
            if (isset($_GET["categoryId"])) {
                $categoryId = $_GET["categoryId"];

                // logged out user -> view events by category id
                $query = "SELECT events.*, event_images.name AS image_name,
                    COUNT(attendees.id) AS total_attendees
                    FROM events
                    INNER JOIN event_images ON events.id = event_images.event_id
                    LEFT JOIN attendees ON events.id = attendees.event_id
                    WHERE events.category_id = $categoryId
                    GROUP BY events.id, event_images.name
                    ORDER BY events.id DESC;";
            } else {
                header('HTTP/1.1 400 Bad Request');
                echo "It looks like your request cannot be processed due to incorrect URL syntax";
                exit();
            }
        }
    }

    $result = mysqli_query($connection, $query);

    if ($result) {
        $count = mysqli_num_rows($result);

        if ($count) {
            $uploadsFolderDirectory = $rootDirectory . "public/images/uploads/";

            $editIcon = file_get_contents('../public/images/icons/edit.svg');
            $deleteIcon = file_get_contents('../public/images/icons/delete.svg');

            $counter = 1;

            echo "<div class='events-grid'>";
            while ($event = mysqli_fetch_assoc($result)) {
                $imageSrc = $uploadsFolderDirectory . $event["image_name"];
                $eventId = $event["id"];
                $eventTitle = $event["title"];
                $eventDate = $event["date"];
                $eventTime = $event["time"];
                $eventLocation = $event["location"];
                $totalAttendees = $event["total_attendees"];

                $isAttending = 0;
                if (isset($event["is_attending"])) {
                    $isAttending = $event["is_attending"];
                }

                $cta = "";
                if ($requestLocation !== "dashboard" && $loggedUserId) {
                    if (hasPermission($attendEvent)) {
                        if ($isAttending) {
                            $cta = "
                            <button type='button' title='Attended' class='icon-button icon-button--dark events-grid__item__content__cta unattend-button' data-id='$eventId'>
                                <i class='icon-button__icon'>
                                    $attendedIcon
                                </i>
                            </button>";
                        } else {
                            $cta = "
                            <button type='button' title='Attend' class='icon-button icon-button--dark events-grid__item__content__cta attend-button' data-id='$eventId'>
                                <i class='icon-button__icon'>
                                    $attendIcon
                                </i>
                            </button>";
                        }
                    }
                } else if ($loggedUserId) {
                    if (hasPermission($attendEvent)) {
                        if ($isAttending) {
                            $cta = "
                            <button type='button' title='Attended' class='icon-button icon-button--dark events-grid__item__content__cta unattend-button' data-id='$eventId'>
                                <i class='icon-button__icon'>
                                    $attendedIcon
                                </i>
                            </button>";
                        }
                    }
                }

                $footer = "";
                if ($requestLocation === "dashboard") {
                    if (hasPermission($editEvent) && hasPermission($deleteEvent)) {
                        $footer = "
                        <div class='events-grid__item__footer'>
                            <a href='" . $rootDirectory . "dashboard/edit-event.php?id=$eventId' type='button' class='icon-button icon-button--dark icon-button--mr-minus8' title='Edit'>
                                <i class='icon-button__icon'>$editIcon</i>
                            </a>
        
                            <button type='button' class='icon-button icon-button--danger icon-button--mr-minus8 delete-button' title='Delete' data-id='$eventId'>
                                <i class='icon-button__icon'>$deleteIcon</i>
                            </button>
                        </div>
                        ";
                    } else if (hasPermission($editEvent)) {
                        $footer = "
                        <div class='events-grid__item__footer'>
                            <a href='" . $rootDirectory . "dashboard/edit-event.php?id=$eventId' type='button' class='icon-button icon-button--dark icon-button--mr-minus8' title='Edit'>
                                <i class='icon-button__icon'>$editIcon</i>
                            </a>
                        </div>
                        ";
                    } else if (hasPermission($deleteEvent)) {
                        $footer = "
                        <div class='events-grid__item__footer'>    
                            <button type='button' class='icon-button icon-button--danger icon-button--mr-minus8 delete-button' title='Delete' data-id='$eventId'>
                                <i class='icon-button__icon'>$deleteIcon</i>
                            </button>
                        </div>
                        ";
                    }
                }

                echo "
                    <div class='events-grid__item'>
                        <a href='" . $rootDirectory . "event.php?id=$eventId' class='events-grid__item__anchor'>
                            <img src='$imageSrc' alt='$eventTitle' class='events-grid__item__anchor__img'>
                        </a>

                        <div class='events-grid__item__content'>
                            $cta
                            
                            <div class='events-grid__item__content__box--column'>
                                <span class='overline events-grid__item__content__box__location'>
                                    <i class='events-grid__item__content__box__location__icon'>$locationIcon</i>
                                
                                    $eventLocation
                                </span>
                            
                                <a href='" . $rootDirectory . "event.php?id=$eventId' class='text--dark'>
                                    <h5 class='events-grid__item__content__box__title'>$eventTitle</h5>
                                </a>
                            </div>

                            <div class='events-grid__item__content__box--row'>
                                <span class='subtitle'>$eventDate</span>

                                <div class='events-grid__item__content__box__attending'>
                                    <i class='events-grid__item__content__box__attending__icon'>" . $attendingIcon . "</i>

                                    <span class='overline'>$totalAttendees attending</span>
                                </div>
                            </div>
                        </div>

                        $footer
                    </div>
                ";

                if ($requestLocation === "homepage" && $counter === 6) {
                    break;
                }

                $counter++;
            }
            echo "</div>";

            if ($requestLocation === "homepage" && $counter >= 6) {
                echo "
                    <div class='centered-box mt-24'>
                        <a href='" . $rootDirectory . "events.php' class='button button--primary'>
                            Browse more
                        </a>
                    </div>
                ";
            }
        } else {
            $addEventCta = "";
            if ($loggedUserId) {
                if (hasPermission($createEvent)) {
                    $addEventCta = "
                    <a href='" . $rootDirectory . "dashboard/create-event.php' class='button button--primary'>
                        Add event
                    </a>
                    ";
                }

                if (hasPermission($attendEvent)) {
                    $addEventCta = "
                    <a href='" . $rootDirectory . "events.php' class='button button--primary'>
                        Browse events
                    </a>
                    ";
                }
            }

            $customMessage = "There are no events yet";

            if ($requestLocation === "dashboard") {
                if (hasPermission($createEvent)) {
                    $customMessage = "You did not create any events yet!";
                }

                if (hasPermission($attendEvent)) {
                    $customMessage = "You did not attend any events yet!";
                }
            }

            echo "
            <div class='feedback-container'>
                <p class='text--danger'>$customMessage</p>
    
                $addEventCta
            </div>
            ";
        }
    } else {
        header('HTTP/1.1 500 Internal Server Error');
        echo mysqli_error($connection);
        echo "<br>An error occurred while fetching data";
        exit();
    }
} else {
    header('HTTP/1.1 400 Bad Request');
    echo "It looks like your request cannot be processed due to invalid routing";
    exit();
}
