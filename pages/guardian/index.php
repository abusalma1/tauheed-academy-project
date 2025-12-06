<?php
$title = 'Guardian Dashboard';

include __DIR__ . '/../../includes/header.php';

if ($is_logged_in === false) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

//  Use PDO instead of MySQLi
$stmt = $pdo->prepare("
    SELECT 
        s.*, 
        c.name AS class_name, 
        ca.name AS arm_name,
        ic.name AS islamiyya_class_name, 
        ica.name AS islamiyya_arm_name
    FROM students s
    LEFT JOIN classes c ON c.id = s.class_id
    LEFT JOIN class_arms ca ON ca.id = s.arm_id
    LEFT JOIN islamiyya_classes ic ON ic.id = s.islamiyya_class_id
    LEFT JOIN islamiyya_class_arms ica ON ica.id = s.islamiyya_arm_id
    WHERE s.guardian_id = ?
");

$stmt->execute([$user['id']]);
$children = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($children as &$child) {
        // Calculate overall average from General Studies
        $stmt = $pdo->prepare("
        SELECT AVG(r.total) AS avg_score
        FROM results r
        JOIN student_term_records str ON r.student_term_record_id = str.id
        JOIN student_class_records scr ON str.student_class_record_id = scr.id
        WHERE scr.student_id = ?
    ");
        $stmt->execute([$child['id']]);
        $genAvg = $stmt->fetchColumn();

        // Calculate overall average from Islamiyya
        $stmt = $pdo->prepare("
        SELECT AVG(r.total) AS avg_score
        FROM islamiyya_results r
        JOIN islamiyya_student_term_records str ON r.student_term_record_id = str.id
        JOIN islamiyya_student_class_records scr ON str.student_class_record_id = scr.id
        WHERE scr.student_id = ?
    ");
        $stmt->execute([$child['id']]);
        $islamiyyaAvg = $stmt->fetchColumn();

        // Store in child array (rounded to 2 decimals)
        $child['overall_avg'] = round(($genAvg + $islamiyyaAvg) / 2, 2);
    }


    $totalAvg = 0;
$count = 0;

foreach ($children as $child) {
    if (!empty($child['overall_avg'])) {
        $totalAvg += $child['overall_avg'];
        $count++;
    }
}

$guardianOverallAvg = $count > 0 ? round($totalAvg / $count, 2) : 0;


?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php') ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Guardian Dashboard</h1>
            <p class="text-xl text-blue-200">Welcome, <?= $user['gender'] === 'male' ? "Mr. " : 'Mrs.' ?> <?= $user['name']; ?>. View your children's academic progress</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Guardian Profile -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <img src="/placeholder.svg?height=120&width=120" alt="Guardian Photo" class="h-28 w-28 rounded-full border-4 border-blue-900">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900">
                            <?= $user['gender'] === 'male' ? "Mr. " : 'Mrs.' ?>
                            <?= $user['name'] ?>
                        </h2>
                        <p class="text-gray-600">Email: <?= $user['email'] ?></p>
                        <p class="text-gray-600">Phone: <?= $user['email'] ?></p>
                        <p class="text-gray-600">Relationship: <?= ucwords($user['relationship']) ?></p>
                    </div>
                    <button class="bg-blue-900 hover:bg-blue-800 text-white px-6 py-3 rounded-lg font-semibold transition">
                        <i class="fas fa-edit mr-2"></i>Edit Profile
                    </button>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Children</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">3</p>
                        </div>
                        <i class="fas fa-children text-4xl text-blue-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Average Performance</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2"><?= $guardianOverallAvg ?>%</p>
                        </div>
                        <i class="fas fa-chart-line text-4xl text-green-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Recent Activity</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">Today</p>
                        </div>
                        <i class="fas fa-clock text-4xl text-purple-200"></i>
                    </div>
                </div>
            </div>

            <!-- Children Cards -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">My Children</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <?php foreach ($children as $child): ?>

                        <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-900 to-blue-700 h-32"></div>
                            <div class="relative px-6 pb-6">
                                <img src="/placeholder.svg?height=100&width=100" alt="Child Photo" class="h-24 w-24 rounded-full border-4 border-white -mt-16 mx-auto mb-4">
                                <h3 class="text-xl font-bold text-center text-gray-900"><?= $child['name'] ?></h3>
                                <p class="text-gray-600 text-center text-sm mb-4">Gen. Stu. Class: <?= $child['class_name'] . ' - ' .  $child['arm_name'] ?></p>
                                <p class="text-gray-600 text-center text-sm mb-4">Islamiyya Class: <?= $child['islamiyya_class_name'] . ' - ' .  $child['islamiyya_arm_name'] ?></p>

                                <div class="bg-blue-50 p-3 rounded-lg mb-4">
                                    <div class="flex justify-between text-sm mb-2">
                                        <span class="text-gray-600">Admission No:</span>
                                        <span class="font-semibold"><?= $child['admission_number'] ?></span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Current Avg:</span>
                                        <span class="font-semibold text-green-600"><?= $child['overall_avg'] ?>%</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                    <a href="<?= route('student-result') . '?id=' . $child['id'] ?>" class="block w-full bg-blue-900 hover:bg-blue-800 text-white py-2 rounded-lg font-semibold text-center transition">
                                        <i class="fas fa-eye mr-2"></i>View Results
                                    </a>
                                    <a href="<?= route('student-islamiyya-result') . '?id=' . $child['id'] ?>" class="block w-full bg-blue-900 hover:bg-blue-800 text-white py-2 rounded-lg font-semibold text-center transition">
                                        <i class="fas fa-eye mr-2"></i>View Islamiyya Results
                                    </a>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
            </div>


        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php') ?>


    <script>
    </script>
</body>

</html>