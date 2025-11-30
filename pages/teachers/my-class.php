<?php

$title = "My Class";
include(__DIR__ . '/../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}



$stmt = $conn->prepare("SELECT t.name, s.name as session_name from terms t left join sessions s on t.session_id = s.id where t.status = ? ");
$ongoing = 'ongoing';
$stmt->bind_param('s', $ongoing);
$stmt->execute();
$currentTerm = $stmt->get_result()->fetch_assoc();

$teacher = $user;

$stmt = $conn->prepare("
   SELECT 
    c.id AS class_id,
    c.name AS class_name,
    ca.id AS arm_id,
    ca.name AS arm_name,
    s.id AS student_id,
    s.name AS student_name,
    s.status AS student_status,
    s.admission_number AS student_admission_number,
    s.email AS student_email

FROM class_class_arms cca
JOIN classes c ON c.id = cca.class_id
JOIN class_arms ca ON ca.id = cca.arm_id
LEFT JOIN students s ON s.class_id = cca.class_id AND s.arm_id = cca.arm_id
WHERE cca.teacher_id = ?
order by c.level, ca.name, s.name
");

$stmt->bind_param('i', $teacher['id']);
$stmt->execute();
$result = $stmt->get_result();

$classes = [];

while ($row = $result->fetch_assoc()) {
    $class_id = $row['class_id'];
    $arm_id = $row['arm_id'];

    // Create a unique key for each class-arm combo
    $key = $class_id . '_' . $arm_id;

    // Initialize if not already set
    if (!isset($classes[$key])) {
        $classes[$key] = [
            'class_id' => $class_id,
            'class_name' => $row['class_name'],
            'arm_id' => $arm_id,
            'arm_name' => $row['arm_name'],
            'students' => []
        ];
    }

    // Add student to the class-arm group **only if student exists**
    if ($row['student_id'] !== null) {
        $classes[$key]['students'][] = [
            'id' => $row['student_id'],
            'name' => $row['student_name'],
            'admission_number' => $row['student_admission_number'],
            'email' => $row['student_email'],
            'status' => $row['student_status']
        ];
    }
}


?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php'); ?>

    <!-- Page Header Section -->
    <section
        class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">My <?= (count($classes)  > 1) ? 'Classes' : 'Class' ?> </h1>
            <p class="text-xl text-blue-200">View and manage your <?= (count($classes)  > 1) ? 'classes' : 'class' ?> students</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-1 gap-8 mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">

                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Class Details</h2>

                    <div class="space-y-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-900">
                            <p class="text-sm text-gray-900"><?= (count($classes)  > 1) ? 'Classes' : 'Class' ?> </p>
                            <?php foreach ($classes as $class) : ?>
                                <p class="text-xl font-bold text-blue-900"><?= $class['class_name'] . ' ' . $class['arm_name'] ?></p>
                            <?php endforeach ?>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-900">
                            <p class="text-sm text-gray-900">Teacher</p>
                            <p class="text-xl font-bold text-blue-900"><?= $teacher['gender'] == 'male' ? "Mr." : "Mrs." ?> <?= $teacher['name']; ?></p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-900">
                            <p class="text-sm text-gray-900">Session</p>

                            <p class="text-xl font-bold text-blue-900"><?= $currentTerm['session_name'] ?></p>

                        </div>
                    </div>


                </div>


            </div>
            <?php foreach ($classes as $class) : ?>


                <!-- Students Table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                    <div class="bg-blue-900 text-white px-6 py-4">
                        <h3 class="text-lg font-semibold flex items-center gap-2">
                            <i class="fas fa-list"></i>
                            Class Students (<?= $class['class_name'] . ' ' . $class['arm_name'] ?>) - <?= count($class['students']) ?> Students
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-100 border-b border-gray-300">
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Student Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Admission No.</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Actions</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Resutls</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($class['students']) > 0): ?>
                                    <?php foreach ($class['students'] as $student) : ?>
                                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 text-sm text-gray-800"><?= $student['name'] ?? '-' ?></td>

                                            <td class="px-6 py-4 text-sm text-gray-600"><?= $student['admission_number'] ?? '-' ?></td>

                                            <td class="px-6 py-4">
                                                <div class="flex justify-center gap-2">

                                                    <a href="<?= route('update-class-student-password') ?>?id=<?= $student['id'] ?>" class="bg-blue-600 hover:bg-blue-800 text-white px-3 py-2 rounded text-xs font-medium transition flex items-center gap-1" title="Edit Details">
                                                        <i class="fas fa-edit"></i> Edit Password
                                                    </a>
                                                    <a href="<?= route('class-student-detials') ?>?id=<?= $student['id'] ?>" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-xs font-medium transition flex items-center gap-1" title="View Results">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>

                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex justify-center gap-2">
                                                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-xs font-medium transition flex items-center gap-1" title="Print Results">
                                                        <i class="fas fa-print"></i> 1st Term
                                                    </button>'

                                                    <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-xs font-medium transition flex items-center gap-1" title="Print Results">
                                                        <i class="fas fa-print"></i> 2nd Term
                                                    </button>

                                                    <button class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded text-xs font-medium transition flex items-center gap-1" title="Print Results">
                                                        <i class="fas fa-print"></i>3rd Term
                                                    </button>'
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>

                            </tbody>

                        </table><?php if (count($class['students']) <= 0): ?>
                            <span class="border-b border-gray-200 text-center block p-5 text-gray-500 hover:bg-gray-50 transition">
                                There is no students in this class at the moment.
                            </span>
                        <?php endif ?>
                    </div>
                </div>

                <!-- Bulk Print Section -->
                <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fas fa-print text-blue-900"></i>
                        Print Results for All <?= $class['class_name'] . ' ' . $class['arm_name'] ?> Students
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- First Term Print -->
                        <div class="bg-gradient-to-br from-blue-900 to-blue-800 text-white rounded-lg p-8 shadow-md hover:shadow-lg transition transform hover:scale-105">
                            <div class="text-center">
                                <i class="fas fa-calendar text-4xl mb-4 opacity-80"></i>
                                <h4 class="text-xl font-bold mb-2">First Term</h4>
                                <p class="text-blue-100 text-sm mb-6">Print all student results</p>
                                <button class="w-full bg-white text-blue-900 hover:bg-blue-50 px-6 py-3 rounded font-semibold transition flex items-center justify-center gap-2">
                                    <i class="fas fa-file-pdf"></i>
                                    Generate & Print
                                </button>
                            </div>
                        </div>

                        <!-- Second Term Print -->
                        <div class="bg-gradient-to-br from-green-700 to-green-600 text-white rounded-lg p-8 shadow-md hover:shadow-lg transition transform hover:scale-105">
                            <div class="text-center">
                                <i class="fas fa-calendar text-4xl mb-4 opacity-80"></i>
                                <h4 class="text-xl font-bold mb-2">Second Term</h4>
                                <p class="text-green-100 text-sm mb-6">Print all student results</p>
                                <button class="w-full bg-white text-green-700 hover:bg-green-50 px-6 py-3 rounded font-semibold transition flex items-center justify-center gap-2">
                                    <i class="fas fa-file-pdf"></i>
                                    Generate & Print
                                </button>
                            </div>
                        </div>

                        <!-- Third Term Print -->
                        <div class="bg-gradient-to-br from-purple-700 to-purple-600 text-white rounded-lg p-8 shadow-md hover:shadow-lg transition transform hover:scale-105">
                            <div class="text-center">
                                <i class="fas fa-calendar text-4xl mb-4 opacity-80"></i>
                                <h4 class="text-xl font-bold mb-2">Third Term</h4>
                                <p class="text-purple-100 text-sm mb-6">Print all student results</p>
                                <button class="w-full bg-white text-purple-700 hover:bg-purple-50 px-6 py-3 rounded font-semibold transition flex items-center justify-center gap-2">
                                    <i class="fas fa-file-pdf"></i>
                                    Generate & Print
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>

</body>

</html>