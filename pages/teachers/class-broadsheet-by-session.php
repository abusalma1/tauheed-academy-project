<?php
$title = "Class Results By Session";
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

//  Query overall class performance from student_class_records
$stmt = $pdo->prepare("
    SELECT 
        s.id AS student_id,
        s.name AS student_name,
        s.admission_number,
        scr.overall_total,
        scr.overall_average,
        scr.overall_position,
        scr.promotion_status
    FROM student_class_records scr
    INNER JOIN students s ON scr.student_id = s.id
    WHERE scr.session_id = ? AND scr.class_id = ?
    ORDER BY scr.overall_position ASC, s.name ASC
");
$stmt->execute([$session_id, $class_id]);
$overallResults = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php'); ?>

    <!-- Page Header Section -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Class Results</h1>
            <p class="text-xl text-blue-200">
                Overall Performance for <?= htmlspecialchars($currentTerm['session_name'] ?? '') ?> Session
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Overall Class Results Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="bg-blue-900 text-white px-6 py-4">
                    <h3 class="text-lg font-semibold flex items-center gap-2">
                        <i class="fas fa-list"></i>
                        Overall Class Results – <?= count($overallResults) ?> Students
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
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Promotion Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($overallResults) > 0): ?>
                                <?php foreach ($overallResults as $student): ?>
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-800"><?= htmlspecialchars($student['student_name'] ?? '-') ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($student['admission_number'] ?? '-') ?></td>
                                        <td class="px-6 py-4 text-sm text-center text-gray-800"><?= htmlspecialchars($student['overall_total'] ?? '-') ?></td>
                                        <td class="px-6 py-4 text-sm text-center text-gray-800"><?= htmlspecialchars($student['overall_average'] ?? '-') ?></td>
                                        <td class="px-6 py-4 text-sm text-center text-gray-800"><?= htmlspecialchars($student['overall_position'] ?? '-') ?></td>
                                        <td class="px-6 py-4 text-sm text-center text-gray-800">
                                            <?= ucfirst(htmlspecialchars($student['promotion_status'] ?? 'pending')) ?>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center p-5 text-gray-500">No overall results available for this class.</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>
</body>

</html>