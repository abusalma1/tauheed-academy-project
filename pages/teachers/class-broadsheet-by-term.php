<?php
$title = "Class Results  Bu Terms";
include(__DIR__ . '/../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (isset($_GET['class_id']) && isset($_GET['session_id'])) {
    $class_id   = (int) $_GET['class_id'];
    $session_id = (int) $_GET['session_id'];
} else {
    $_SESSION['failure'] = "Class and session are not found";
    header('Location: ' . route('back'));
    exit();
}

//  Use PDO instead of MySQLi
$stmt = $pdo->prepare("
    SELECT
        t.id AS term_id,
        t.name AS term_name,
        t.session_id,

        s.id AS student_id,
        s.name AS student_name,
        s.admission_number,
        s.class_id,
        s.arm_id,
        

        scr.id AS student_class_record_id,

        str.id AS student_term_record_id,
        str.total_marks,
        str.average_marks,
        str.position_in_class,
        str.class_size,
        str.overall_grade

    FROM terms t
    CROSS JOIN students s
    LEFT JOIN student_class_records scr
        ON scr.student_id = s.id
        AND scr.session_id = t.session_id
        AND scr.class_id = s.class_id
        AND scr.arm_id = s.arm_id
    LEFT JOIN student_term_records str
        ON str.student_class_record_id = scr.id
        AND str.term_id = t.id
    WHERE t.session_id = ? AND s.class_id = ?
    ORDER BY t.id, str.position_in_class, s.name
");
$stmt->execute([$session_id, $class_id]);
$terms = $stmt->fetchAll(PDO::FETCH_ASSOC);

//  Group results by term
$grouped = [];

foreach ($terms as $row) {
    $tid = $row['term_id'];

    if (!isset($grouped[$tid])) {
        $grouped[$tid] = [
            'term_id'   => $row['term_id'],
            'term_name' => $row['term_name'],
            'students'  => []
        ];
    }

    $grouped[$tid]['students'][] = [
        'student_id'       => $row['student_id'],
        'student_name'     => $row['student_name'],
        'admission_number' => $row['admission_number'],
        'total_marks'      => $row['total_marks'],
        'average_marks'    => $row['average_marks'],
        'position_in_class' => $row['position_in_class'],
        'overall_grade'    => $row['overall_grade'],
    ];
}
?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php'); ?>

    <!-- Page Header Section -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Class Results</h1>
            <p class="text-xl text-blue-200">
                Performance for <?= htmlspecialchars($currentTerm['session_name'] ?? '') ?> session
            </p>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="flex items-center justify-end">
                <a href="<?= route('class-broadsheet-by-session') ?>?class_id=<?= $class_id ?>&session_id=<?= $session_id ?>"
                    class="bg-blue-900 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    <i class="fas fa-eye mr-2"></i>View Class Broadsheet for Entire Session
                </a>
            </div>
        </div>
    </section>


    <!-- Main Content -->
    <section class="py-5 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <?php foreach ($grouped as $term): ?>
                <!-- Term Results Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                    <div class="bg-blue-900 text-white px-6 py-4">
                        <h3 class="text-lg font-semibold flex items-center gap-2">
                            <i class="fas fa-list"></i>
                            <?= htmlspecialchars($term['term_name']) ?> Results – <?= count($term['students']) ?> Students
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-100 border-b border-gray-300">
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Student Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Admission No.</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Total Marks</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Average</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Position</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($term['students']) > 0): ?>
                                    <?php foreach ($term['students'] as $student): ?>
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 text-sm text-gray-800"><?= htmlspecialchars($student['student_name'] ?? '-') ?></td>
                                            <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($student['admission_number'] ?? '-') ?></td>
                                            <td class="px-6 py-4 text-sm text-center text-gray-800"><?= htmlspecialchars($student['total_marks'] ?? '-') ?></td>
                                            <td class="px-6 py-4 text-sm text-center text-gray-800"><?= htmlspecialchars($student['average_marks'] ?? '-') ?></td>
                                            <td class="px-6 py-4 text-sm text-center text-gray-800"><?= htmlspecialchars($student['position_in_class'] ?? '-') ?></td>
                                            <td class="px-6 py-4 text-sm text-center text-gray-800"><?= htmlspecialchars($student['overall_grade'] ?? '-') ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center p-5 text-gray-500">No results available for this term.</td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>
</body>


</html>