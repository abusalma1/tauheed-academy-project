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
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validatePhone($phone)
{
    $phone = preg_replace('/\s+/', '', $phone);
    return preg_match('/^\+?234\d{10}$|^\d{11}$/', $phone);
}

function emailExist($email, $table, $whereIdIsNot = 0)
{
    global $pdo;

    if ($whereIdIsNot > 0) {
        $query = "SELECT id FROM $table WHERE email = ? AND id != ? LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email, $whereIdIsNot]);
    } else {
        $query = "SELECT id FROM $table WHERE email = ? LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);
    }

    return $stmt->rowCount() > 0;
}

function staffNumberExist($staff_no, $table, $whereIdIsNot = 0)
{
    global $pdo;

    if ($whereIdIsNot > 0) {
        $query = "SELECT id FROM $table WHERE staff_no = ? AND id != ? LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$staff_no, $whereIdIsNot]);
    } else {
        $query = "SELECT id FROM $table WHERE staff_no = ? LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$staff_no]);
    }

    return $stmt->rowCount() > 0;
}

function countDataTotal($table, $haveActivity = false)
{
    global $pdo;

    $totalQuery = $pdo->query("SELECT COUNT(*) AS total FROM $table WHERE deleted_at IS NULL");
    $total = number_format($totalQuery->fetch(PDO::FETCH_ASSOC)['total']);

    if ($haveActivity) {
        $activeQuery = $pdo->query("SELECT COUNT(*) AS active FROM $table WHERE status = 'active' AND deleted_at IS NULL");
        $active = number_format($activeQuery->fetch(PDO::FETCH_ASSOC)['active']);

        $inactiveQuery = $pdo->query("SELECT COUNT(*) AS inactive FROM $table WHERE status = 'inactive' AND deleted_at IS NULL");
        $inactive = number_format($inactiveQuery->fetch(PDO::FETCH_ASSOC)['inactive']);

        if ($table === 'admins') {
            $adminQuery = $pdo->query("SELECT COUNT(*) AS admin FROM $table WHERE type = 'admin' AND deleted_at IS NULL");
            $admin = number_format($adminQuery->fetch(PDO::FETCH_ASSOC)['admin']);

            $superAdminQuery = $pdo->query("SELECT COUNT(*) AS superAdmin FROM $table WHERE type = 'superAdmin' AND deleted_at IS NULL");
            $superAdmin = number_format($superAdminQuery->fetch(PDO::FETCH_ASSOC)['superAdmin']);

            return [
                'total' => $total,
                'active' => $active,
                'inactive' => $inactive,
                'admin' => $admin,
                'superadmin' => $superAdmin
            ];
        }

        return ['total' => $total, 'active' => $active, 'inactive' => $inactive];
    }

    return ['total' => $total];
}

function selectAllData($table, $whereIdIs = null, $whereIdIsNot = null)
{
    global $pdo;

    if ($whereIdIs) {
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE id = ? AND deleted_at IS NULL");
        $stmt->execute([$whereIdIs]);
    } else if ($whereIdIsNot) {
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE id != ? AND deleted_at IS NULL");
        $stmt->execute([$whereIdIsNot]);
    } else {
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE deleted_at IS NULL");
        $stmt->execute();
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getStudentResults($student_id)
{
    global $pdo;

    $stmt = $pdo->prepare("
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
    $stmt->execute([$student_id]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // --- Group for rendering ---
    $groupedResults = [];

    foreach ($results as $row) {
        $classKey = $row['class_name'] . '|' . $row['session_name'] . '|' . $row['arm_name'];
        $termKey = $row['term_name'];

        if (!isset($groupedResults[$classKey])) {
            $groupedResults[$classKey] = [
                'class_name' => $row['class_name'],
                'session_name' => $row['session_name'],
                'arm_name' => $row['arm_name'],
                'terms' => []
            ];
        }

        if (!isset($groupedResults[$classKey]['terms'][$termKey])) {
            $groupedResults[$classKey]['terms'][$termKey] = [
                'term_name' => $row['term_name'],
                'subjects_results' => []
            ];
        }

        $groupedResults[$classKey]['terms'][$termKey]['subjects_results'][] = [
            'subject_name' => $row['subject_name'],
            'ca' => $row['ca'] ?? 0,
            'exam' => $row['exam'] ?? 0,
            'total' => $row['total'] ?? 0,
            'grade' => $row['grade'] ?? '-',
            'remark' => $row['remark'] ?? 'No remark'
        ];
    }

    $finalResults = [];
    foreach ($groupedResults as $classData) {
        $classData['terms'] = array_values($classData['terms']);
        $finalResults[] = $classData;
    }

    return $finalResults;
}

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    exit; // stop execution
}


function ordinal($number)
{
    $ends = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];

    if (($number % 100) >= 11 && ($number % 100) <= 13) {
        return $number . 'th';
    }

    return $number . $ends[$number % 10];
}

function getNextTermForRecord(PDO $pdo, int $classId, int $sessionId, string $termName): array
{
    // Normalize term name
    $termName = strtolower(trim($termName));

    // Determine next term label
    if (strpos($termName, 'first') !== false) {
        $desired = 'second';
    } elseif (strpos($termName, 'second') !== false) {
        $desired = 'third';
    } elseif (strpos($termName, 'third') !== false) {
        $desired = 'first'; // move to next class
    } else {
        return [
            'term'  => null,
            'start' => null,
            'fee'   => null,
            'class' => null
        ];
    }

    $nextClassId = $classId;

    // If current term is THIRD → move to next class
    if ($desired === 'first' && strpos($termName, 'third') !== false) {

        $stmt = $pdo->prepare("
            SELECT * FROM classes
            WHERE level > (SELECT level FROM classes WHERE id = ?)
            ORDER BY level ASC
            LIMIT 1
        ");
        $stmt->execute([$classId]);
        $nextClass = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$nextClass) {
            // No next class exists
            return [
                'term'  => null,
                'start' => null,
                'fee'   => null,
                'class' => null
            ];
        }

        $nextClassId = (int)$nextClass['id'];
    }

    // Fetch the next term in the SAME session
    $stmt = $pdo->prepare("
        SELECT * FROM terms
        WHERE session_id = ? AND LOWER(name) LIKE ?
        LIMIT 1
    ");
    $stmt->execute([$sessionId, '%' . $desired . '%']);
    $nextTerm = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$nextTerm) {
        // No next term found in this session
        return [
            'term'  => null,
            'start' => null,
            'fee'   => null,
            'class' => $nextClassId
        ];
    }

    // Fetch fee for the next class
    $stmt = $pdo->prepare("SELECT * FROM fees WHERE class_id = ?");
    $stmt->execute([$nextClassId]);
    $feeRow = $stmt->fetch(PDO::FETCH_ASSOC);

    $fee = null;
    if ($feeRow) {
        $desiredLower = strtolower($desired);
        if ($desiredLower === 'first')  $fee = $feeRow['first_term'];
        if ($desiredLower === 'second') $fee = $feeRow['second_term'];
        if ($desiredLower === 'third')  $fee = $feeRow['third_term'];
    }

    return [
        'term'  => $nextTerm['name'] ?? null,
        'start' => $nextTerm['start_date'] ?? null,   // ✅ safe access
        'fee'   => $fee,
        'class' => $nextClassId
    ];
}
