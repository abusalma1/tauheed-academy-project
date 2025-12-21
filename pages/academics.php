<?php
$title = 'About & Contact';

include(__DIR__ . '/../includes/header.php');

// =======================
// General Studies Classes
// =======================
$stmt = $pdo->prepare("
    SELECT 
        classes.id AS class_id,
        classes.name AS class_name,
        subjects.id AS subject_id,
        subjects.name AS subject_name
    FROM classes
    LEFT JOIN class_subjects 
        ON class_subjects.class_id = classes.id
    LEFT JOIN subjects 
        ON class_subjects.subject_id = subjects.id
    ORDER BY classes.level, subjects.name
");

$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$classes = [];
foreach ($rows as $row) {
    $classId = $row['class_id'];

    if (!isset($classes[$classId])) {
        $classes[$classId] = [
            'name'     => $row['class_name'],
            'subjects' => []
        ];
    }

    if (!empty($row['subject_name'])) {
        $classes[$classId]['subjects'][] = [
            'name' => $row['subject_name']
        ];
    }
}
$classes = array_values($classes);

// =======================
// Islamiyya Classes
// =======================
$stmt = $pdo->prepare("
    SELECT 
        islamiyya_classes.id AS islamiyya_class_id,
        islamiyya_classes.name AS islamiyya_class_name,
        islamiyya_subjects.id AS islamiyya_subject_id,
        islamiyya_subjects.name AS islamiyya_subject_name
    FROM islamiyya_classes
    LEFT JOIN islamiyya_class_subjects 
        ON islamiyya_class_subjects.class_id = islamiyya_classes.id
    LEFT JOIN islamiyya_subjects 
        ON islamiyya_class_subjects.subject_id = islamiyya_subjects.id
    ORDER BY islamiyya_classes.level, islamiyya_subjects.name
");

$stmt->execute();
$islamiyyaRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$islamiyyaClasses = [];
foreach ($islamiyyaRows as $row) {
    $classId = $row['islamiyya_class_id'];

    if (!isset($islamiyyaClasses[$classId])) {
        $islamiyyaClasses[$classId] = [
            'name'     => $row['islamiyya_class_name'],
            'subjects' => []
        ];
    }

    if (!empty($row['islamiyya_subject_name'])) {
        $islamiyyaClasses[$classId]['subjects'][] = [
            'name' => $row['islamiyya_subject_name']
        ];
    }
}
$islamiyyaClasses = array_values($islamiyyaClasses);
?>



<body class="bg-gray-50">
    <?php include(__DIR__ .  '/../includes/nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Academics</h1>
            <p class="text-xl text-blue-200">Subjects, Results & Academic Excellence</p>
        </div>
    </section>

    <!-- Subjects by Class -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Gen. Subjects by Class Category</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">


                <?php foreach ($classes as $class) : ?>
                    <div class="bg-white border-2 border-blue-900 rounded-lg p-6 shadow-lg">

                        <h3 class="text-xl font-bold text-gray-900 mb-3"><?= $class['name'] ?></h3>
                        <ul class="space-y-2 text-gray-700">
                            <?php foreach ($class['subjects'] as $subject) : ?>
                                <li><i class="fas fa-check text-green-600 mr-2"></i><?= $subject['name'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>


            </div>
        </div>
    </section>


    <!-- Islamiyya Subjects by Class -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Islamiyya Subjects by Class Category</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php foreach ($islamiyyaClasses as $class) : ?>
                    <div class="bg-white border-2 border-green-700 rounded-lg p-6 shadow-lg">

                        <h3 class="text-xl font-bold text-gray-900 mb-3"><?= $class['name'] ?></h3>
                        <ul class="space-y-2 text-gray-700">
                            <?php foreach ($class['subjects'] as $subject) : ?>
                                <li><i class="fas fa-check text-green-600 mr-2"></i><?= $subject['name'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>

    <!-- Sample Results -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Sample Student Results</h2>

            <!-- Result Card -->
            <div class="max-w-4xl mx-auto mb-12">
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Student Result Card</h3>
                <div class="bg-white rounded-lg shadow-xl border-2 border-gray-200 overflow-hidden">
                    <div class="bg-blue-900 text-white p-6 text-center">
                        <img src="<?= asset('images/logo.png') ?>" alt="School Logo" class="h-20 w-20 mx-auto mb-3  rounded-full">
                        <h4 class="text-2xl font-bold">Tauheed Academy</h4>
                        <p class="text-blue-200">First Term Report Card - 2024/2025</p>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                            <div>
                                <p class="text-gray-600">Student Name:</p>
                                <p class="font-semibold">Muhammad Ahmad</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Admission No:</p>
                                <p class="font-semibold">EXA/2025/ADM/0001</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Class:</p>
                                <p class="font-semibold">Primary 5</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Term:</p>
                                <p class="font-semibold">First Term</p>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-blue-900 text-white">
                                    <tr>
                                        <th class="px-4 py-3 text-left">Subject</th>
                                        <th class="px-4 py-3 text-center">CA (40)</th>
                                        <th class="px-4 py-3 text-center">Exam (60)</th>
                                        <th class="px-4 py-3 text-center">Total (100)</th>
                                        <th class="px-4 py-3 text-center">Grade</th>
                                        <th class="px-4 py-3 text-left">Remark</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-4 py-3">English Language</td>
                                        <td class="px-4 py-3 text-center">35</td>
                                        <td class="px-4 py-3 text-center">52</td>
                                        <td class="px-4 py-3 text-center font-bold">87</td>
                                        <td class="px-4 py-3 text-center font-bold text-green-600">A</td>
                                        <td class="px-4 py-3">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Mathematics</td>
                                        <td class="px-4 py-3 text-center">38</td>
                                        <td class="px-4 py-3 text-center">55</td>
                                        <td class="px-4 py-3 text-center font-bold">93</td>
                                        <td class="px-4 py-3 text-center font-bold text-green-600">A</td>
                                        <td class="px-4 py-3">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Basic Science</td>
                                        <td class="px-4 py-3 text-center">32</td>
                                        <td class="px-4 py-3 text-center">48</td>
                                        <td class="px-4 py-3 text-center font-bold">80</td>
                                        <td class="px-4 py-3 text-center font-bold text-green-600">A</td>
                                        <td class="px-4 py-3">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Social Studies</td>
                                        <td class="px-4 py-3 text-center">30</td>
                                        <td class="px-4 py-3 text-center">45</td>
                                        <td class="px-4 py-3 text-center font-bold">74</td>
                                        <td class="px-4 py-3 text-center font-bold text-blue-600">B</td>
                                        <td class="px-4 py-3">Good</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Computer Studies</td>
                                        <td class="px-4 py-3 text-center">36</td>
                                        <td class="px-4 py-3 text-center">50</td>
                                        <td class="px-4 py-3 text-center font-bold">86</td>
                                        <td class="px-4 py-3 text-center font-bold text-green-600">A</td>
                                        <td class="px-4 py-3">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3">Verbal Reasoning</td>
                                        <td class="px-4 py-3 text-center">34</td>
                                        <td class="px-4 py-3 text-center">47</td>
                                        <td class="px-4 py-3 text-center font-bold">81</td>
                                        <td class="px-4 py-3 text-center font-bold text-green-600">A</td>
                                        <td class="px-4 py-3">Very Good</td>
                                    </tr>
                                    <tr class="bg-blue-50 font-bold">
                                        <td class="px-4 py-3" colspan="2">Total Score</td>
                                        <td class="px-4 py-3 text-center" colspan="2">501/600</td>
                                        <td class="px-4 py-3 text-center" colspan="2">Average: 83.66%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 grid md:grid-cols-3 gap-4 text-sm">
                            <div class="bg-gray-50 p-4 rounded">
                                <p class="text-gray-600">Position in Class:</p>
                                <p class="font-bold text-lg">2nd out of 35</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded">
                                <p class="text-gray-600">Class Average:</p>
                                <p class="font-bold text-lg">68.5%</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded">
                                <p class="text-gray-600">Attendance:</p>
                                <p class="font-bold text-lg">95/100 days</p>
                            </div>
                        </div>

                        <div class="mt-6 border-t pt-4">
                            <p class="text-sm"><strong>Class Teacher's Remark:</strong> John is an excellent student who shows great dedication to his studies. Keep up the good work!</p>
                            <p class="text-sm mt-2"><strong>Principal's Remark:</strong> Outstanding performance. Well done!</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grading System -->
            <div class="max-w-3xl mx-auto">
                <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Grading System</h3>
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <table class="w-full">
                        <thead class="bg-blue-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left">Score Range</th>
                                <th class="px-6 py-3 text-center">Grade</th>
                                <th class="px-6 py-3 text-left">Remark</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-3">75 - 100</td>
                                <td class="px-6 py-3 text-center font-bold text-green-600">A</td>
                                <td class="px-6 py-3">Excellent</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">60 - 74</td>
                                <td class="px-6 py-3 text-center font-bold text-blue-600">B</td>
                                <td class="px-6 py-3">Very Good</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">50 - 59</td>
                                <td class="px-6 py-3 text-center font-bold text-yellow-600">C</td>
                                <td class="px-6 py-3">Good</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">40 - 49</td>
                                <td class="px-6 py-3 text-center font-bold text-orange-600">D</td>
                                <td class="px-6 py-3">Fair</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-3">0 - 39</td>
                                <td class="px-6 py-3 text-center font-bold text-red-600">E</td>
                                <td class="px-6 py-3">Poor</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../includes/footer.php') ?>

</body>

</html>