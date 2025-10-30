<?php

include(__DIR__ .  '/./web.php');

function route($name)
{
    global $routes;

    if (isset($routes[$name])) {
        return $routes[$name]['url'];
    }

    return '/tauheed-academy-project/';
}

function validateEmail($email)
{
    // Check if the email is valid using PHP's built-in filter
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePhone($phone)
{
    // Remove all spaces
    $phone = preg_replace('/\s+/', '', $phone);

    // Match Nigerian phone format: either +234XXXXXXXXXX or 11-digit local number
    return preg_match('/^\+?234\d{10}$|^\d{11}$/', $phone);
}



function emailExist($connection, $email, $table)
{

    // Prepare query dynamically for selected column
    $query = "SELECT id FROM $table WHERE email = ? LIMIT 1";
    $stmt = $connection->prepare($query);

    // Bind the value type correctly (s = string)
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
}

function staffNumberExist($connection, $staff_no, $table)
{

    // Prepare query dynamically for selected column
    $query = "SELECT id FROM $table WHERE staff_no = ? LIMIT 1";
    $stmt = $connection->prepare($query);

    // Bind the value type correctly (s = string)
    $stmt->bind_param('s', $staff_no);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
}


function countDataTotal($table, $haveActivity = false)
{
    global $connection;

    // Count total users
    $totalQuery = $connection->query("SELECT COUNT(*) AS total FROM $table");
    $total = $totalQuery->fetch_assoc()['total'];
    $total = number_format($total);


    if ($haveActivity) {
        // Count active users
        $activeQuery = $connection->query("SELECT COUNT(*) AS active FROM $table WHERE status = 'active'");
        $active = $activeQuery->fetch_assoc()['active'];
        $active = number_format($active);


        // Count inactive users
        $inactiveQuery = $connection->query("SELECT COUNT(*) AS inactive FROM $table WHERE status = 'inactive'");
        $inactive = $inactiveQuery->fetch_assoc()['inactive'];
        $inactive = number_format($inactive);


        if ($table === 'admins') {
            // Count active admins
            $activeQuery = $connection->query("SELECT COUNT(*) AS admin FROM $table WHERE type = 'admin'");
            $admin = $activeQuery->fetch_assoc()['admin'];
            $admin = number_format($active);


            // Count inactive superadmins
            $inactiveQuery = $connection->query("SELECT COUNT(*) AS superadmin FROM $table WHERE type = 'superadmin'");
            $superadmin = $inactiveQuery->fetch_assoc()['superadmin'];
            $superadmin = number_format($inactive);

            return ['total' => $total, 'active' => $active, 'inactive' => $inactive, 'admin' => $admin, 'superadmin' => $superadmin];
        }


        return ['total' => $total, 'active' => $active, 'inactive' => $inactive];
    }

    return ['total' => $total];
}

function selectAllData($table)
{
    global $connection;
    $statement = $connection->prepare("SELECT * FROM $table");
    $statement->execute();
    $result = $statement->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    return $data;
}
