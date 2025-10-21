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



function emailExist($connection, $email)
{

    // Prepare query dynamically for selected column
    $query = "SELECT id FROM teachers WHERE email = ? LIMIT 1";
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

?>