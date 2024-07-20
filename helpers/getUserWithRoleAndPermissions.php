<?php

// Return user [] row with its role and permissions
function getUserWithRoleAndPermissions($connection, $email, $password)
{
    require_once "hashPassword.php";

    $password = hashPassword($password);

    $getUserQuery = "SELECT users.*, user_roles.role_code, role_permissions.permission_code
    FROM users
    INNER JOIN user_roles ON users.id = user_roles.user_id
    INNER JOIN role_permissions ON user_roles.role_code = role_permissions.role_code
    WHERE users.email = '$email'
    AND users.password = '$password'";

    $result = mysqli_query($connection, $getUserQuery);

    $count = mysqli_num_rows($result);

    if ($count === 0) {
        return [];
    }

    $row = mysqli_fetch_assoc($result);

    $rows["id"] = $row["id"];
    $rows["name"] = $row["name"];
    $rows["email"] = $row["email"];
    $rows["role_code"] = $row["role_code"];
    $rows["role_permissions"] = [];

    do {
        $rows['role_permissions'][] = $row['permission_code'];
    } while ($row = mysqli_fetch_assoc($result));

    return $rows;
}
