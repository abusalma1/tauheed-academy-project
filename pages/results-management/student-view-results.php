<?php
$title = "My Results";

include(__DIR__ . '/../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

$student_id = 3;   // The ID of the student whose results you want
$term_id    = 1;   // The term ID (optional: can be dynamic from filter)
$is_current = 1;   // If you want to filter by current record

//  Prepare and execute with PDO
$stmt = $pdo->prepare("
    SELECT
        s.id AS student_id,
        s.name AS student_name,
        s.admission_number AS student_admission_number,
        scr.id AS student_record_id,
        scr.class_id,
        scr.arm_id,
        scr.term_id,
        r.id AS result_id,
        r.subject_id,
        sub.name AS subject_name,
        r.ca,
        r.exam,
        r.total,
        r.grade,
        r.remark
    FROM students s
    LEFT JOIN student_class_records scr
        ON scr.student_id = s.id
        AND scr.is_current = ?
        AND scr.term_id = ?
    LEFT JOIN results r
        ON r.student_record_id = scr.id
    LEFT JOIN subjects sub
        ON sub.id = r.subject_id
    WHERE s.id = ?
");
$stmt->execute([$is_current, $term_id, $student_id]);

//  Fetch all results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">My Results</h1>
            <p class="text-xl text-blue-200">View Your Academic Performance</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Student Info Section -->
            <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-lg shadow-lg p-8 mb-8">
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="flex items-center gap-6">
                        <img src="/placeholder.svg?height=100&width=100" alt="Student Photo" class="h-24 w-24 rounded-full border-4 border-white">
                        <div>
                            <h2 class="text-2xl font-bold">Muhammad Ahmad</h2>
                            <p class="text-blue-200">Primary 5 - Arm A</p>
                            <p class="text-blue-200">Admission No: EXA/2025/ADM/0001</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <p class="text-sm text-blue-200">Class Average</p>
                            <p class="text-2xl font-bold">78.5%</p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <p class="text-sm text-blue-200">Position in Class</p>
                            <p class="text-2xl font-bold">2nd of 35</p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <p class="text-sm text-blue-200">Overall Average</p>
                            <p class="text-2xl font-bold">82.3%</p>
                        </div>
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <p class="text-sm text-blue-200">Attendance</p>
                            <p class="text-2xl font-bold">95/100 days</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Term Filter -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-calendar mr-2"></i>Select Term
                </label>
                <select id="termFilter" class="px-4 py-2 border-2 border-blue-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 w-full md:w-48">
                    <option value="First Term">First Term</option>
                    <option value="Second Term">Second Term</option>
                    <option value="Third Term">Third Term</option>
                </select>
            </div>

            <!-- Results Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2 border-blue-900">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-blue-900 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">Subject</th>
                                <th class="px-6 py-4 text-center font-semibold">CA (40)</th>
                                <th class="px-6 py-4 text-center font-semibold">Exam (60)</th>
                                <th class="px-6 py-4 text-center font-semibold">Total (100)</th>
                                <th class="px-6 py-4 text-center font-semibold">Grade</th>
                                <th class="px-6 py-4 text-left font-semibold">Remark</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($results as $result) : ?>
                                <tr class="hover:bg-blue-50">
                                    <td class="px-6 py-4"><?= $result['subject_name'] ?></td>
                                    <td class="px-6 py-4 text-center"><?= $result['ca'] ?></td>
                                    <td class="px-6 py-4 text-center"><?= $result['exam'] ?></td>
                                    <td class="px-6 py-4 text-center font-bold"><?= $result['total'] ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-bold"><?= $result['grade'] ?></span>
                                    </td>
                                    <td class="px-6 py-4"><?= $result['remark'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Teacher & Principal Remarks -->
            <div class="grid md:grid-cols-2 gap-6 mt-8">
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">
                        <i class="fas fa-user-tie text-blue-900 mr-2"></i>Class Teacher's Remark
                    </h3>
                    <p class="text-gray-700">John is an excellent student who demonstrates outstanding dedication to his studies. He actively participates in class discussions and shows great leadership qualities. Keep up the excellent work!</p>
                </div>
                <div class="bg-green-50 border-2 border-green-200 rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-3">
                        <i class="fas fa-medal text-green-900 mr-2"></i>Principal's Remark
                    </h3>
                    <p class="text-gray-700">Exceptional performance! John's consistency in academics and exemplary conduct make him an outstanding role model for his peers. We are proud of your achievements.</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 mt-8 justify-center">
                <button onclick="window.print()" class="bg-blue-900 hover:bg-blue-800 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                    <i class="fas fa-print"></i>Print Results
                </button>
                <button onclick="downloadPDF()" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                    <i class="fas fa-download"></i>Download PDF
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>

    <script>
        function downloadPDF() {
            alert('PDF download feature will be implemented with a backend service.');
        }

        document.getElementById('termFilter').addEventListener('change', function() {
            console.log('Filter results by term: ' + this.value);
            // Results will be filtered based on selected term
        });
    </script>
</body>

</html>