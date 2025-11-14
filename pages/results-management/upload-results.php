<?php
$title = "Upload Results";
include(__DIR__ . '/../../includes/header.php');

if(!$is_logged_in){
    $_SESSION['failure'] = "Login is Required!";
   header("Location: " . route('home'));
    exit();
}


$subjects = selectAllData('subjects');
$classes = selectAllData('classes');
$terms = selectAllData('terms');
$sessions = selectAllData('sessions');

$students = [];

if (isset($_GET['class_id']) && isset($_GET['term_id'])) {
    $class_id = intval($_GET['class_id']);
    $term_id = intval($_GET['term_id']);
    $subject_id = intval($_GET['subject_id']);

    $stmt = $conn->prepare("SELECT *
        FROM students
        WHERE class_id = ? AND term_id = ?
        ORDER BY name ASC
    ");

    $stmt->bind_param("ii", $class_id, $term_id);
    $stmt->execute();
    $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $class_id = intval($_POST['class_id']);
    $term_id = intval($_POST['term_id']);
    $session_id = intval($_POST['session_id']);
    $subject_id = intval($_POST['subject_id']);

    $ca_scores = $_POST['ca'] ?? [];
    $exam_scores = $_POST['exam'] ?? [];
    $arm_ids = $_POST['arm'] ?? [];


    foreach ($ca_scores as $student_id => $ca_value) {

        // Validate scores
        $ca = max(0, min(40, intval($ca_value)));
        $exam = max(0, min(60, intval($exam_scores[$student_id] ?? 0)));
        $total = $ca + $exam;
        $arm_id = intval($arm_ids[$student_id]);


        // Determine grade
        if ($total >= 70) $grade = 'A';
        elseif ($total >= 60) $grade = 'B';
        elseif ($total >= 50) $grade = 'C';
        elseif ($total >= 45) $grade = 'D';
        else $grade = 'F';

        $remark_map = [
            'A' => 'Excellent',
            'B' => 'Very Good',
            'C' => 'Good',
            'D' => 'Pass',
            'F' => 'Fail'
        ];
        $remark = $remark_map[$grade];

        // STEP 1: Check if student_class_record exists
        $check = $conn->prepare("
            SELECT id 
            FROM student_class_records 
            WHERE student_id = ? AND class_id = ? AND arm_id = ? AND term_id = ?
            LIMIT 1
        ");
        $check->bind_param("iiii", $student_id, $class_id, $arm_id, $term_id);
        $check->execute();
        $record = $check->get_result()->fetch_assoc();

        if ($record) {
            // Use existing record
            $student_record_id = $record['id'];
        } else {
            // STEP 2: Create new student_class_record
            $insert = $conn->prepare("
                INSERT INTO student_class_records (student_id, class_id, arm_id, term_id)
                VALUES (?, ?, ?, ?)
            ");
            $insert->bind_param("iiii", $student_id, $class_id, $arm_id, $term_id);
            $insert->execute();
            $student_record_id = $conn->insert_id;
        }

        // STEP 3: Insert or update result
        $save = $conn->prepare("
            INSERT INTO results (student_record_id, subject_id, ca, exam, grade, remark)
            VALUES (?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE
                ca = VALUES(ca),
                exam = VALUES(exam),
                grade = VALUES(grade),
                remark = VALUES(remark)
        ");
        $save->bind_param("iiiiss", $student_record_id, $subject_id, $ca, $exam, $grade, $remark);
        $save->execute();
    }

    $_SESSION['success'] = "Results uploaded successfully!";
    header("Location: " . route('upload-results'));
    exit;
}



?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php');  ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Upload Class Results</h1>
            <p class="text-xl text-blue-200">Enter Results for Entire Class</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Section -->
            <form method="GET" action="" class="bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <i class="fas fa-filter"></i>Select Class & Subject
                </h2>
                <div class="grid md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Class</label>
                        <select name="class_id" id="classSelect" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="">-- Select Class --</option>
                            <?php foreach ($classes as $class) : ?>
                                <option value="<?= $class['id'] ?>" <?= (isset($_GET['class_id']) && $_GET['class_id'] == $class['id']) ? 'selected' : '' ?>>
                                    <?= $class['name'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Subject</label>
                        <select name="subject_id" id="subjectSelect" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="">-- Select Subject --</option>
                            <?php foreach ($subjects as $subject) : ?>
                                <option value="<?= $subject['id'] ?>" <?= (isset($_GET['subject_id']) && $_GET['subject_id'] == $subject['id']) ? 'selected' : '' ?>>
                                    <?= $subject['name'] ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Session</label>
                        <select name="session_id" id="sessionSelect" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="">-- Select Session --</option>
                            <?php foreach ($sessions as $session) : ?>
                                <option value="<?= $session['id'] ?>" <?= (isset($_GET['session_id']) && $_GET['session_id'] == $session['id']) ? 'selected' : '' ?>>
                                    <?= $session['name']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Term</label>
                        <select name="term_id" id="termSelect" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                            <option value="">-- Select Term --</option>
                            <?php foreach ($terms as $term) : ?>
                                <option value="<?= $term['id'] ?>" data-session="<?= $term['session_id'] ?>" <?= (isset($_GET['term_id']) && $_GET['term_id'] == $term['id']) ? 'selected' : '' ?>>
                                    <?= $term['name']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="flex justify-center mt-6">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-search"></i> Load Students
                    </button>
                </div>
            </form>


            <!-- Results Table -->
            <form method="POST">
                <input type="hidden" name="class_id" value="<?= isset($_GET['class_id']) ? $_GET['class_id'] : '' ?>">
                <input type="hidden" name="subject_id" value="<?= isset($_GET['subject_id']) ? $_GET['subject_id'] : '' ?>">
                <input type="hidden" name="term_id" value="<?= isset($_GET['term_id']) ? $_GET['term_id'] : '' ?>">
                <input type="hidden" name="session_id" value="<?= isset($_GET['session_id']) ? $_GET['session_id'] : '' ?>">

                <div class=" bg-white rounded-lg shadow-lg overflow-hidden border-2 border-blue-900">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-blue-900 text-white sticky top-0">
                                <tr>
                                    <th class="px-6 py-4 text-left font-semibold">Student Name</th>
                                    <th class="px-6 py-4 text-left font-semibold">Addmission No.</th>
                                    <th class="px-6 py-4 text-center font-semibold">CA (40)</th>
                                    <th class="px-6 py-4 text-center font-semibold">Exam (60)</th>
                                    <th class="px-6 py-4 text-center font-semibold">Total (100)</th>
                                    <th class="px-6 py-4 text-center font-semibold">Grade</th>
                                    <th class="px-6 py-4 text-center font-semibold">Remark</th>
                                </tr>
                            </thead>
                            <tbody id="resultsBody" class="divide-y divide-gray-200">
                                <?php if (!empty($students)) : ?>
                                    <?php foreach ($students as $index => $student) : ?>
                                        <input type="hidden" value="<?= $student['arm_id'] ?>" name="arm[<?= $student['id'] ?>]">
                                        <tr class="hover:bg-blue-50">
                                            <td class="px-6 py-4"><?= htmlspecialchars($student['name']) ?></td>
                                            <td class="px-6 py-4"><?= htmlspecialchars($student['admission_number']) ?></td>
                                            <td class="px-6 py-4 text-center">
                                                <input type="number" min="0" max="40" name="ca[<?= $student['id'] ?>]" data-index="<?= $index ?>" class="ca-input w-16 px-2 py-1 border border-gray-300 rounded text-center focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <input type="number" min="0" max="60" name="exam[<?= $student['id'] ?>]" data-index="<?= $index ?>" class="exam-input w-16 px-2 py-1 border border-gray-300 rounded text-center focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            </td>
                                            <td class="px-6 py-4 text-center font-bold">
                                                <span class="total-score" data-index="<?= $index ?>">0</span>
                                            </td>
                                            <td class="px-6 py-4 text-center font-bold">
                                                <span class="grade" data-index="<?= $index ?>">-</span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="remark" data-index="<?= $index ?>">-</span>
                                            </td>

                                        </tr>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            Select a class and click “Load Students”
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>
                    </div>
                </div>


                <!-- Action Buttons -->
                <div class="flex justify-center mt-8">
                    <div class="grid md:grid-cols-3 gap-4">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                            <i class="fas fa-save"></i> Save All Results
                        </button>

                        <button onclick="resetForm()" class="bg-gray-400 hover:bg-gray-500 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                            <i class="fas fa-redo"></i>Clear Form
                        </button>
                        <button onclick="printTable()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                            <i class="fas fa-print"></i>Print
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>

    <script>
        //  Mobile Menu Script
        const mobileMenuBtn = document.getElementById("mobile-menu-btn");
        const mobileMenu = document.getElementById("mobile-menu");

        mobileMenuBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });

        // Filter terms based on selected session
        document.getElementById('sessionSelect').addEventListener('change', function() {
            const selectedSessionId = this.value;
            const termSelect = document.getElementById('termSelect');
            const allTerms = termSelect.querySelectorAll('option');

            allTerms.forEach(termOption => {
                const sessionId = termOption.getAttribute('data-session');
                if (!sessionId) return; // skip the first "-- Select Term --" option

                if (selectedSessionId === '' || sessionId === selectedSessionId) {
                    termOption.style.display = ''; // show
                } else {
                    termOption.style.display = 'none'; // hide
                }
            });

            // Reset term dropdown selection
            termSelect.value = '';
        });

        function getGrade(score) {
            if (score > 100) return 'Over';
            if (score >= 70) return 'A';
            if (score >= 60) return 'B';
            if (score >= 50) return 'C';
            if (score >= 45) return 'D';
            return 'F';
        }

        function getRemark(grade) {
            const remarks = {
                'A': 'Excellent',
                'B': 'Very Good',
                'C': 'Good',
                'D': 'Pass',
                'F': 'Fail',
                'Over': 'Over Marking'

            };
            return remarks[grade] || '';
        }

        function calculateRow(input) {
            const index = input.dataset.index;
            const caInput = document.querySelector(`.ca-input[data-index="${index}"]`);
            const examInput = document.querySelector(`.exam-input[data-index="${index}"]`);
            const totalSpan = document.querySelector(`.total-score[data-index="${index}"]`);
            const gradeSpan = document.querySelector(`.grade[data-index="${index}"]`);
            const remarkSpan = document.querySelector(`.remark[data-index="${index}"]`);

            const ca = parseInt(caInput.value) || 0;
            const exam = parseInt(examInput.value) || 0;
            const total = ca + exam;

            totalSpan.textContent = total;
            const grade = getGrade(total);
            gradeSpan.textContent = grade;
            remarkSpan.textContent = getRemark(grade);
        }

        function saveAllResults() {
            const classVal = document.getElementById('classSelect').value;
            const subject = document.getElementById('subjectSelect').value;
            const term = document.getElementById('termSelect').value;

            if (!classVal || !subject || !term) {
                alert('Please select Class, Subject, and Term');
                return;
            }

            let results = JSON.parse(localStorage.getItem('bulkResults')) || [];
            const rows = document.querySelectorAll('#resultsBody tr');

            rows.forEach((row, index) => {
                const ca = parseInt(row.querySelector('.ca-input').value) || 0;
                const exam = parseInt(row.querySelector('.exam-input').value) || 0;
                if (ca > 0 || exam > 0) {
                    const student = row.querySelector('td').textContent.trim();

                    const total = ca + exam;
                    const grade = getGrade(total);

                    results.push({
                        student,
                        class: classVal,
                        subject,
                        term,
                        ca,
                        exam,
                        total,
                        grade,
                        date: new Date().toLocaleDateString()
                    });
                }
            });

            localStorage.setItem('bulkResults', JSON.stringify(results));
            alert('Results saved successfully!');
        }

        function resetForm() {
            document.getElementById('classSelect').value = '';
            document.getElementById('subjectSelect').value = '';
            document.getElementById('termSelect').value = '';
            document.getElementById('resultsBody').innerHTML = '<tr><td colspan="6" class="px-6 py-8 text-center text-gray-500"><i class="fas fa-info-circle mr-2"></i>Select a class to view students</td></tr>';
        }

        function validateInput(input) {
            const min = parseInt(input.getAttribute('min'));
            const max = parseInt(input.getAttribute('max'));
            const value = parseInt(input.value);

            if (isNaN(value)) {
                input.style.borderColor = '#d1d5db'; // default gray
                return false;
            }

            if (value < min || value > max) {
                input.style.borderColor = 'red'; // highlight invalid input
                return false;
            } else {
                input.style.borderColor = '#3b82f6'; // blue (valid)
                return true;
            }
        }

        document.querySelectorAll('.ca-input, .exam-input').forEach(input => {
            input.addEventListener('input', function() {
                validateInput(this); // check if value is valid
                calculateRow(this); // update total, grade, remark
            });
        });



        function printTable() {
            window.print();
        }
    </script>
</body>

</html>