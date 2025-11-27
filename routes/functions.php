<?php

include(__DIR__ .  '/./web.php');

function route($name)
{
    global $routes, $baseUrl;

    if (isset($routes[$name])) {
        return $routes[$name]['url'];
    }

    // fallback: go to home
    return $baseUrl . "/index.php";
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


function emailExist($email, $table, $whereIdIsNot = 0)
{
    global $conn;

    if ($whereIdIsNot > 0) {
        // Check if email exists for others excluding this ID
        $query = "SELECT id FROM $table WHERE email = ? AND id != ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $email, $whereIdIsNot);
    } else {
        // Normal check for email existence
        $query = "SELECT id FROM $table WHERE email = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
    }

    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
}


function staffNumberExist($staff_no, $table, $whereIdIsNot = 0)
{
    global $conn;

    if ($whereIdIsNot > 0) {
        // Check if staff number exists for others excluding this ID
        $query = "SELECT id FROM $table WHERE staff_no = ? AND id != ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('si', $staff_no, $whereIdIsNot);
    } else {
        // Normal check for staff number existence
        $query = "SELECT id FROM $table WHERE staff_no = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $staff_no);
    }

    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
}


function countDataTotal($table, $haveActivity = false)
{
    global $conn;

    // Count total users
    $totalQuery = $conn->query("SELECT COUNT(*) AS total FROM $table WHERE deleted_at is null");
    $total = $totalQuery->fetch_assoc()['total'];
    $total = number_format($total);


    if ($haveActivity) {
        // Count active users
        $activeQuery = $conn->query("SELECT COUNT(*) AS active FROM $table WHERE status = 'active'and deleted_at is null");
        $active = $activeQuery->fetch_assoc()['active'];
        $active = number_format($active);


        // Count inactive users
        $inactiveQuery = $conn->query("SELECT COUNT(*) AS inactive FROM $table WHERE status = 'inactive' and deleted_at is null");
        $inactive = $inactiveQuery->fetch_assoc()['inactive'];
        $inactive = number_format($inactive);


        if ($table === 'admins') {
            // Count active admins
            $activeQuery = $conn->query("SELECT COUNT(*) AS admin FROM $table WHERE type = 'admin' and deleted_at is null");
            $admin = $activeQuery->fetch_assoc()['admin'];
            $admin = number_format($admin);


            // Count inactive superadmins
            $inactiveQuery = $conn->query("SELECT COUNT(*) AS superAdmin FROM $table WHERE type = 'superAdmin' and deleted_at is null");
            $superAdmin = $inactiveQuery->fetch_assoc()['superAdmin'];
            $superAdmin = number_format($superAdmin);

            return ['total' => $total, 'active' => $active, 'inactive' => $inactive, 'admin' => $admin, 'superadmin' => $superAdmin];
        }


        return ['total' => $total, 'active' => $active, 'inactive' => $inactive];
    }

    return ['total' => $total];
}

function selectAllData($table, $whereIdIs = null, $whereIdIsNot = null)
{
    global $conn;

    if ($whereIdIs) {
        $stmt = $conn->prepare("SELECT * FROM $table WHERE id =  ? and deleted_at is null");
        $stmt->bind_param('i', $whereIdIs);
    } else if ($whereIdIsNot) {
        $stmt = $conn->prepare("SELECT * FROM $table WHERE id != ?  and deleted_at is null");
        $stmt->bind_param('i', $whereIdIsNot);
    } else {
        $stmt = $conn->prepare("SELECT * FROM $table where deleted_at is null");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    return $data;
}


function getStudentResults($student_id)
{
    global $conn;

    // --- Fetch data ---
    $stmt = $conn->prepare("
        SELECT 
            sessions.id AS session_id,
            sessions.name AS session_name,
            terms.id AS term_id,
            terms.name AS term_name,
            classes.id AS class_id,
            classes.name AS class_name,
            class_arms.name AS arm_name,
            subjects.name AS subject_name,
            results.ca,
            results.exam,
            results.total,
            results.grade,
            results.remark
        FROM results
        INNER JOIN student_class_records 
            ON results.student_record_id = student_class_records.id
        INNER JOIN terms 
            ON student_class_records.term_id = terms.id
        INNER JOIN sessions 
            ON terms.session_id = sessions.id
        INNER JOIN classes 
            ON student_class_records.class_id = classes.id
        INNER JOIN class_arms 
            ON student_class_records.arm_id = class_arms.id
        INNER JOIN subjects 
            ON results.subject_id = subjects.id
        WHERE student_class_records.student_id = ?
        ORDER BY sessions.id DESC, classes.id ASC, terms.id ASC, subjects.name ASC
    ");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // --- Group for rendering ---
    $groupedResults = [];

    foreach ($results as $row) {
        $classKey = $row['class_name'] . '|' . $row['session_name'] . '|' . $row['arm_name'];
        $termKey = $row['term_name'];

        // Create class entry if not exists
        if (!isset($groupedResults[$classKey])) {
            $groupedResults[$classKey] = [
                'class_name' => $row['class_name'],
                'session_name' => $row['session_name'],
                'arm_name' => $row['arm_name'],
                'terms' => []
            ];
        }

        // Create term entry if not exists
        if (!isset($groupedResults[$classKey]['terms'][$termKey])) {
            $groupedResults[$classKey]['terms'][$termKey] = [
                'term_name' => $row['term_name'],
                'subjects_results' => []
            ];
        }

        // Add subject result
        $groupedResults[$classKey]['terms'][$termKey]['subjects_results'][] = [
            'subject_name' => $row['subject_name'],
            'ca' => $row['ca'] ?? 0,
            'exam' => $row['exam'] ?? 0,
            'total' => $row['total'] ?? 0,
            'grade' => $row['grade'] ?? '-',
            'remark' => $row['remark'] ?? 'No remark'
        ];
    }

    // Convert associative terms → indexed array
    $finalResults = [];
    foreach ($groupedResults as $classData) {
        $classData['terms'] = array_values($classData['terms']);
        $finalResults[] = $classData;
    }

    return $finalResults;
}

function asset($path)
{
    return "/tauheed-academy-project/static/" . $path;
}
