<?php

require_once "../config/db-connect.php";

// Create users table
$usersSqlFilePath = 'users.sql';
$createUsersTableQuery = file_get_contents($usersSqlFilePath);

if (mysqli_query($connection, $createUsersTableQuery)) {
    echo "Table 'Users' created successfully";
} else {
    echo "Error creating 'Users' table: " . mysqli_error($connection);
}

mysqli_close($connection);
