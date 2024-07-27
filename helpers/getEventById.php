<?php

// Return event [] row
function getEventById($connection, $eventId)
{
    $query = "";

    if (isset($_SESSION["loggedUserId"])) {
        $loggedUserId = $_SESSION["loggedUserId"];

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
    } else {
        $query = "SELECT events.*, event_images.name AS image_name,
        COUNT(attendees.id) AS total_attendees
        FROM events
        INNER JOIN event_images ON events.id = event_images.event_id
        LEFT JOIN attendees ON events.id = attendees.event_id
        WHERE events.id = $eventId
        GROUP BY events.id, event_images.name
        ORDER BY events.id DESC;";
    }

    $result = mysqli_query($connection, $query);

    $ar = array();
    if (!$result) {
        $ar["error"] = mysqli_error($connection);
        return $ar;
        exit();
    }

    $count = mysqli_num_rows($result);
    if ($count == 0) {
        $ar["error"] = "Category not found";
        return $ar;
        exit();
    }

    return mysqli_fetch_assoc($result);
}
