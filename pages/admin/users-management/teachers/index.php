<?php
$title = 'Users Management';
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

// Fetch data using helper functions (assuming they are PDO-based)
$admins    = selectAllData('admins');
$guardians = selectAllData('guardians');
$teachers  = selectAllData('teachers');

$adminsCount    = countDataTotal('admins', true);
$teachersCount  = countDataTotal('teachers', true);
$guardiansCount = countDataTotal('guardians', true);
$studentsCount  = countDataTotal('students', true);

$totalUsers          = $adminsCount['total'] + $teachersCount['total'] + $guardiansCount['total'] + $studentsCount['total'];
$totalActiveUsers    = $adminsCount['active'] + $teachersCount['active'] + $guardiansCount['active'] + $studentsCount['active'];
$totalInactiveUsers  = $adminsCount['inactive'] + $teachersCount['inactive'] + $guardiansCount['inactive'] + $studentsCount['inactive'];

//  PDO query for students with classes and arms
$stmt = $pdo->prepare("
    SELECT 
        classes.id AS class_id,
        classes.name AS class_name,
        class_arms.id AS arm_id,
        class_arms.name AS arm_name,
        students.id AS student_id,
        students.name AS student_name,
        students.admission_number,
        students.gender,
        students.status
    FROM students
    LEFT JOIN classes 
        ON classes.id = students.class_id
    LEFT JOIN class_arms 
        ON class_arms.id = students.arm_id
    WHERE students.deleted_at IS NULL
    ORDER BY classes.id, class_arms.id, students.name
");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$classes = [];

foreach ($rows as $row) {
    $classId = $row['class_id'];

    if (!isset($classes[$classId])) {
        $classes[$classId] = [
            'class_id'   => $row['class_id'],
            'class_name' => $row['class_name'],
            'students'   => []
        ];
    }

    if (!empty($row['student_id'])) {
        $classes[$classId]['students'][] = [
            'student_id'        => $row['student_id'],
            'student_name'      => $row['student_name'],
            'gender'            => $row['gender'],
            'status'            => $row['status'],
            'admission_number'  => $row['admission_number'],
            'arm_name'          => $row['arm_name']
        ];
    }
}

// Other counts
$classesCount        = countDataTotal('classes')['total'];
$armsCount           = countDataTotal('class_arms')['total'];
$sectionsCount       = countDataTotal('sections')['total'];
$studentsCountList   = countDataTotal('students', true);
$studentsCount       = $studentsCountList['total'];
$totalActiveStudents = $studentsCountList['active'];
