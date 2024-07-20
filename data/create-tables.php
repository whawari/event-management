<?php

require_once "../config/db-connect.php";

// ----------------------------------------------------------------------
// Drop role_permissions table
echo "Dropping 'role_permissions' table <br>";
$dropRolePermissionsTable = "DROP TABLE IF EXISTS role_permissions;";

if (mysqli_query($connection, $dropRolePermissionsTable)) {
    echo "Table 'role_permissions' dropped <br>";
} else {
    echo "Error creating 'role_permissions' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Drop user_roles table
echo "Dropping 'user_roles' table <br>";
$dropUserRolesTable = "DROP TABLE IF EXISTS user_roles;";

if (mysqli_query($connection, $dropUserRolesTable)) {
    echo "Table 'user_roles' dropped <br>";
} else {
    echo "Error creating 'user_roles' table: " . mysqli_error($connection) . "<br>";
}

// ----------------------------------------------------------------------
// Drop permissions table
echo "Dropping 'permissions' table <br>";
$dropPermissionsTable = "DROP TABLE IF EXISTS permissions;";

if (mysqli_query($connection, $dropPermissionsTable)) {
    echo "Table 'permissions' dropped <br>";
} else {
    echo "Error creating 'permissions' table: " . mysqli_error($connection) . "<br>";
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
    echo "Error creating 'users' table: " . mysqli_error($connection) . "<br>";
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

mysqli_close($connection);
