<?php

require_once "../config/db-connect.php";

// ----------------------------------------------------------------------
// Drop role_permissions table
echo "Dropping 'role_permissions' table <br>";
$dropRolePermissionsTable = "DROP TABLE IF EXISTS role_permissions;";

if (mysqli_query($connection, $dropRolePermissionsTable)) {
    echo "Table 'role_permissions' dropped <br>";
} else {
    echo "Error dropping 'role_permissions' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Drop user_roles table
echo "Dropping 'user_roles' table <br>";
$dropUserRolesTable = "DROP TABLE IF EXISTS user_roles;";

if (mysqli_query($connection, $dropUserRolesTable)) {
    echo "Table 'user_roles' dropped <br>";
} else {
    echo "Error dropping 'user_roles' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Drop permissions table
echo "Dropping 'permissions' table <br>";
$dropPermissionsTable = "DROP TABLE IF EXISTS permissions;";

if (mysqli_query($connection, $dropPermissionsTable)) {
    echo "Table 'permissions' dropped <br>";
} else {
    echo "Error dropping 'permissions' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Drop roles table
echo "Dropping 'roles' table <br>";
$dropRolesTable = "DROP TABLE IF EXISTS roles;";

if (mysqli_query($connection, $dropRolesTable)) {
    echo "Table 'roles' dropped <br>";
} else {
    echo "Error dropping 'roles' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Drop users table
echo "Dropping 'users' table <br>";
$dropUsersTable = "DROP TABLE IF EXISTS users;";

if (mysqli_query($connection, $dropUsersTable)) {
    echo "Table 'users' dropped <br>";
} else {
    echo "Error dropping 'users' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Drop category_images table
echo "Dropping 'category_images' table <br>";
$dropCategoryImagesTable = "DROP TABLE IF EXISTS category_images;";

if (mysqli_query($connection, $dropCategoryImagesTable)) {
    echo "Table 'category_images' dropped <br>";
} else {
    echo "Error dropping 'category_images' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Drop categories table
echo "Dropping 'categories' table <br>";
$dropCategoriesTable = "DROP TABLE IF EXISTS categories;";

if (mysqli_query($connection, $dropCategoriesTable)) {
    echo "Table 'categories' dropped <br>";
} else {
    echo "Error dropping 'categories' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Drop event_images table
echo "Dropping 'event_images' table <br>";
$dropEventImagesTable = "DROP TABLE IF EXISTS event_images;";

if (mysqli_query($connection, $dropEventImagesTable)) {
    echo "Table 'event_images' dropped <br>";
} else {
    echo "Error dropping 'event_images' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Drop events table
echo "Dropping 'events' table <br>";
$dropEventsTable = "DROP TABLE IF EXISTS events;";

if (mysqli_query($connection, $dropEventsTable)) {
    echo "Table 'events' dropped <br>";
} else {
    echo "Error dropping 'events' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Create roles table
echo "Creating 'roles' table <br>";
$rolesSqlFilePath = 'users/roles.sql';
$createRolesTableQuery = file_get_contents($rolesSqlFilePath);

if (mysqli_query($connection, $createRolesTableQuery)) {
    echo "Table 'roles' created successfully <br>";
} else {
    echo "Error creating 'roles' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Create permissions table
echo "Creating 'permissions' table <br>";
$permissionsSqlFilePath = 'users/permissions.sql';
$createPermissionsTableQuery = file_get_contents($permissionsSqlFilePath);

if (mysqli_query($connection, $createPermissionsTableQuery)) {
    echo "Table 'permissions' created successfully <br>";
} else {
    echo "Error creating 'permissions' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Create role_permissions table
echo "Creating 'role_permissions' table <br>";
$rolePermissionsSqlFilePath = 'users/rolePermissions.sql';
$createRolePermissionsTableQuery = file_get_contents($rolePermissionsSqlFilePath);

if (mysqli_query($connection, $createRolePermissionsTableQuery)) {
    echo "Table 'role_permissions' created successfully <br>";
} else {
    echo "Error creating 'role_permissions' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Create users table
echo "Creating 'users' table <br>";
$usersSqlFilePath = 'users/users.sql';
$createUsersTableQuery = file_get_contents($usersSqlFilePath);

if (mysqli_query($connection, $createUsersTableQuery)) {
    echo "Table 'users' created successfully <br>";
} else {
    echo "Error creating 'users' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Create user_roles table
echo "Creating 'user_roles' table <br>";
$userRolesSqlFilePath = 'users/userRoles.sql';
$createUserRolesTableQuery = file_get_contents($userRolesSqlFilePath);

if (mysqli_query($connection, $createUserRolesTableQuery)) {
    echo "Table 'user_roles' created successfully <br>";
} else {
    echo "Error creating 'user_roles' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Create categories table
echo "Creating 'categories' table <br>";
$categoriesSqlFilePath = 'events/categories.sql';
$createCategoriesTableQuery = file_get_contents($categoriesSqlFilePath);

if (mysqli_query($connection, $createCategoriesTableQuery)) {
    echo "Table 'categories' created successfully <br>";
} else {
    echo "Error creating 'categories' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Create category_images table
echo "Creating 'category_images' table <br>";
$categoryImagesSqlFilePath = 'events/categoryImages.sql';
$createCategoryImagesTableQuery = file_get_contents($categoryImagesSqlFilePath);

if (mysqli_query($connection, $createCategoryImagesTableQuery)) {
    echo "Table 'category_images' created successfully <br>";
} else {
    echo "Error creating 'category_images' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Create events table
echo "Creating 'events' table <br>";
$eventsSqlFilePath = 'events/events.sql';
$createEventsTableQuery = file_get_contents($eventsSqlFilePath);

if (mysqli_query($connection, $createEventsTableQuery)) {
    echo "Table 'events' created successfully <br>";
} else {
    echo "Error creating 'events' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Create event_images table
echo "Creating 'event_images' table <br>";
$eventImagesSqlFilePath = 'events/eventImages.sql';
$createEventImagesTableQuery = file_get_contents($eventImagesSqlFilePath);

if (mysqli_query($connection, $createEventImagesTableQuery)) {
    echo "Table 'event_images' created successfully <br>";
} else {
    echo "Error creating 'event_images' table: " . mysqli_error($connection) . "<br>";
}

mysqli_close($connection);
