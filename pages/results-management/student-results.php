<?php

$title = "My Results";
include(__DIR__ . "/../../includes/header.php");

$student_id = $user['id']; // logged in student

// --- Get student info ---
$stmt = $conn->prepare("SELECT students.*, 
           classes.name AS current_class, 
           class_arms.name AS current_arm,
           terms.name AS current_term,
           sessions.name AS current_session
    FROM students
    LEFT JOIN student_class_records AS studentRecords ON studentRecords.student_id = students.id AND studentRecords.is_current = 1
    LEFT JOIN classes ON studentRecords.class_id = classes.id
    LEFT JOIN class_arms ON studentRecords.arm_id = class_arms.id
    LEFT JOIN terms ON studentRecords.term_id = terms.id
    LEFT JOIN sessions ON terms.session_id = sessions.id
    WHERE students.id = ?
");
$stmt->bind_param('i', $student_id);
$stmt->execute();
$studentInfo = $stmt->get_result()->fetch_assoc();


$stmt = $conn->prepare("SELECT * FROM classes");
// $stmt->bind_param("");
$stmt->execute();
$result = $stmt->get_result();
$classes = $result->fetch_all(MYSQLI_ASSOC);

$stmt = $conn->prepare("SELECT 
    students.*,
    student_class_records.*, 
    classes.id = class_id,
    classes.name = class_name,
    class_arms.id = arm_id,
    class_arms.name = arm_name

    FROM  student_class_records
    left join students on students.id = student_class_records.student_id
    left join classes on classes.id = student_class_records.class_id
    left join class_class_arms on class_class_arms.class_id = classes.id
    left join class_arms on class_arms.id = class_class_arms.arm_id

    where student_class_records.student_id = ?
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$classes = $result->fetch_all(MYSQLI_ASSOC);

?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/../../includes/nav.php");    ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">My Results</h1>
            <p class="text-xl text-blue-200">View Your Academic Performance</p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <!-- Student Information Card with hardcoded student data -->
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <div class="grid md:grid-cols-2 gap-8 items-start">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">My Academic Results</h1>
                    <p class="text-gray-600">Complete Academic History</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-300">
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Student Name</p>
                            <p class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($studentInfo['name']) ?></p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Current Class</p>
                                <p class="text-xl font-bold text-blue-900"><?= htmlspecialchars($studentInfo['current_class']) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Current Arm</p>
                                <p class="text-xl font-bold text-blue-900"><?= htmlspecialchars($studentInfo['current_arm']) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Current Session</p>
                                <p class="text-xl font-bold text-blue-900"><?= htmlspecialchars($studentInfo['current_session']) ?></p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 font-semibold">Current Term</p>
                                <p class="text-xl font-bold text-blue-900"><?= htmlspecialchars($studentInfo['current_term']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- All classes and terms hardcoded in HTML with no JavaScript rendering -->

        <?php if (!empty($classes)): ?>
            <?php foreach ($classes as $class): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
                    <div class="bg-gradient-to-r from-blue-900 to-blue-800 text-white p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-3xl font-bold"><?= htmlspecialchars($class['class_name']) ?></h2>
                                <p class="text-blue-200 text-lg">Session: <?= htmlspecialchars($class['session_name']) ?></p>
                                <p class="text-blue-200 text-sm">Arm: <?= htmlspecialchars($class['arm_name']) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-12">
                        <?php foreach ($class['terms'] as $term): ?>
                            <div class="border-l-4 border-blue-900 pl-6 mb-8">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($term['term_name']) ?></h3>
                                </div>

                                <div class="overflow-x-auto mb-6">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="bg-blue-900 text-white">
                                                <th class="px-6 py-4 text-left font-semibold">Subject</th>
                                                <th class="px-6 py-4 text-center font-semibold">CA (40)</th>
                                                <th class="px-6 py-4 text-center font-semibold">Exam (60)</th>
                                                <th class="px-6 py-4 text-center font-semibold">Total (100)</th>
                                                <th class="px-6 py-4 text-center font-semibold">Grade</th>
                                                <th class="px-6 py-4 text-center font-semibold">Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($term['subjects_results'] as $result): ?>
                                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                                    <td class="px-6 py-4 font-semibold"><?= htmlspecialchars($result['subject_name']) ?></td>
                                                    <td class="px-6 py-4 text-center"><?= htmlspecialchars($result['ca']) ?></td>
                                                    <td class="px-6 py-4 text-center"><?= htmlspecialchars($result['exam']) ?></td>
                                                    <td class="px-6 py-4 text-center font-bold"><?= htmlspecialchars($result['total']) ?></td>
                                                    <td class="px-6 py-4 text-center"><?= htmlspecialchars($result['grade']) ?></td>
                                                    <td class="px-6 py-4 text-center"><?= htmlspecialchars($result['remark']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <p class="text-sm text-gray-700">
                                        <span class="font-semibold">Teacher's Remark:</span>
                                        <?= htmlspecialchars($result['remark']) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-600">No results found.</p>
        <?php endif; ?>



    </main>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../includes/footer.php");    ?>
</body>

</html>