<?php
$title = "Islamiyya Upload Results";
include(__DIR__ . '/../../../../includes/header.php');

// Access control: only logged-in admins allowed
if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (!isset($user_type) || $user_type !== 'admin') {
    $_SESSION['failure'] = "Access denied! Only Admins are allowed.";
    header("Location: " . route('home'));
    exit();
}

// Generate CSRF token if missing
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Islamiyya data sources
$subjects  = selectAllData('islamiyya_subjects');
$classes   = selectAllData('islamiyya_classes');
$terms     = selectAllData('terms');      // shared
$sessions  = selectAllData('sessions');   // shared

$students = [];

if (isset($_GET['class_id'], $_GET['arm_id'], $_GET['term_id'], $_GET['subject_id'])) {
    // Get current ongoing term
    $stmt = $pdo->prepare("
            SELECT t.id, t.name, s.id as session_id, s.name as session_name
            FROM terms t 
            LEFT JOIN sessions s ON t.session_id = s.id 
            WHERE t.status = ?
        ");
    $stmt->execute(['ongoing']);
    $currentTerm = $stmt->fetch(PDO::FETCH_ASSOC);

    $class_id   = (int) $_GET['class_id'];
    $arm_id     = (int) $_GET['arm_id'];
    $term_id    = (int) $_GET['term_id'];
    $subject_id = (int) $_GET['subject_id'];

    // Get session_id of selected term
    $stmt = $pdo->prepare("
            SELECT t.id, t.name, s.id as session_id, s.name as session_name
            FROM terms t 
            LEFT JOIN sessions s ON t.session_id = s.id 
            WHERE t.id = ?
        ");
    $stmt->execute([$term_id]);
    $SelectedTerm = $stmt->fetch(PDO::FETCH_ASSOC);
    $session_id   = $SelectedTerm['session_id'];

    // Get arm name
    $stmt = $pdo->prepare("SELECT name FROM islamiyya_class_arms WHERE id = ?");
    $stmt->execute([$arm_id]);
    $arm = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($arm) {
        $armName = $arm['name'];
    }

    // CASE 1: current term → use students table
    if ($currentTerm && $term_id == $currentTerm['id']) {

        $stmt = $pdo->prepare("
            SELECT 
                st.id AS id,
                st.name,
                st.admission_number,
                st.islamiyya_arm_id as arm_id,
                r.ca,
                r.exam,
                r.grade,
                r.total,
                r.remark
            FROM students st
            LEFT JOIN islamiyya_student_class_records scr 
                ON scr.student_id = st.id 
                AND scr.class_id = ? 
                AND scr.arm_id = ?
            LEFT JOIN islamiyya_student_term_records str 
                ON str.student_class_record_id = scr.id 
                AND str.term_id = ?
            LEFT JOIN islamiyya_results r 
                ON r.student_term_record_id = str.id 
                AND r.subject_id = ?
            WHERE st.islamiyya_class_id = ? 
            AND st.islamiyya_arm_id = ?
            ORDER BY st.admission_number
        ");
        $stmt->execute([$class_id, $arm_id, $term_id, $subject_id, $class_id, $arm_id]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // CASE 2: past term → use historical records
    else {
        $stmt = $pdo->prepare("
    SELECT 
        st.id AS id,
        st.name,
        st.admission_number,
        scr.arm_id,
        r.ca,
        r.exam,
        r.grade,
        r.total,
        r.remark
    FROM islamiyya_student_class_records scr
    INNER JOIN students st 
        ON st.id = scr.student_id
    LEFT JOIN islamiyya_student_term_records str 
        ON str.student_class_record_id = scr.id 
        AND str.term_id = ?
    LEFT JOIN islamiyya_results r 
        ON r.student_term_record_id = str.id 
        AND r.subject_id = ?
    WHERE scr.class_id = ? 
      AND scr.arm_id = ?
      AND scr.session_id = ? 
    ORDER BY st.admission_number
");
        $stmt->execute([$term_id, $subject_id, $class_id, $arm_id, $session_id]);
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    } else {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // regenerate after validation
    }

    $class_id   = (int) $_POST['class_id'];
    $term_id    = (int) $_POST['term_id'];
    $session_id = (int) $_POST['session_id'];
    $subject_id = (int) $_POST['subject_id'];

    $ca_scores   = $_POST['ca'] ?? [];
    $exam_scores = $_POST['exam'] ?? [];
    $arm_ids     = $_POST['arm'] ?? [];

    try {
        // Start transaction
        $pdo->beginTransaction();

        foreach ($ca_scores as $student_id => $ca_value) {
            $ca    = max(0, min(40, (int) $ca_value));
            $exam  = max(0, min(60, (int) ($exam_scores[$student_id] ?? 0)));
            $total = $ca + $exam;
            $arm_id = (int) $arm_ids[$student_id];

            // Grade + remark
            if ($total >= 75) $grade = 'A';
            elseif ($total >= 60) $grade = 'B';
            elseif ($total >= 50) $grade = 'C';
            elseif ($total >= 40) $grade = 'D';
            else $grade = 'E';

            $remark_map = [
                'A' => 'Excellent',
                'B' => 'Very Good',
                'C' => 'Good',
                'D' => 'Fair',
                'E' => 'Poor'
            ];
            $remark = $remark_map[$grade];

            // STEP 1: islamiyya_student_class_records
            $stmt = $pdo->prepare("
                SELECT id FROM islamiyya_student_class_records
                WHERE student_id = ? AND class_id = ? AND arm_id = ? AND session_id = ?
                LIMIT 1
            ");
            $stmt->execute([$student_id, $class_id, $arm_id, $session_id]);
            $class_record = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($class_record) {
                $student_class_record_id = $class_record['id'];
            } else {
                $stmt = $pdo->prepare("
                    INSERT INTO islamiyya_student_class_records (student_id, class_id, arm_id, session_id)
                    VALUES (?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE
                        class_id = VALUES(class_id),
                        arm_id = VALUES(arm_id),
                        updated_at = CURRENT_TIMESTAMP
                ");
                $stmt->execute([$student_id, $class_id, $arm_id, $session_id]);
                $student_class_record_id = $pdo->lastInsertId();
            }

            // STEP 2: islamiyya_student_term_records
            $stmt = $pdo->prepare("
                SELECT id FROM islamiyya_student_term_records
                WHERE student_class_record_id = ? AND term_id = ?
                LIMIT 1
            ");
            $stmt->execute([$student_class_record_id, $term_id]);
            $term_record = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($term_record) {
                $student_term_record_id = $term_record['id'];
            } else {
                $stmt = $pdo->prepare("
                    INSERT INTO islamiyya_student_term_records (student_class_record_id, term_id) 
                    VALUES (?, ?)
                ");
                $stmt->execute([$student_class_record_id, $term_id]);
                $student_term_record_id = $pdo->lastInsertId();
            }

            // STEP 3: islamiyya_results
            $stmt = $pdo->prepare("
                INSERT INTO islamiyya_results (student_term_record_id, subject_id, ca, exam, grade, remark, total)
                VALUES (?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE
                    ca = VALUES(ca),
                    exam = VALUES(exam),
                    grade = VALUES(grade),
                    remark = VALUES(remark),
                    total = VALUES(total)
            ");
            $stmt->execute([$student_term_record_id, $subject_id, $ca, $exam, $grade, $remark, $total]);
        }

        // ===========================================
        // CALCULATE TERM TOTALS, AVERAGES, AND POSITIONS
        // ===========================================

        // 1. Get all students in this class for this term
        $stmt = $pdo->prepare("
            SELECT str.id AS student_term_record_id
            FROM islamiyya_student_term_records str
            JOIN islamiyya_student_class_records scr ON str.student_class_record_id = scr.id
            WHERE str.term_id = ? AND scr.class_id = ?
        ");
        $stmt->execute([$term_id, $class_id]);
        $student_term_records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 2. Loop through each student to calculate total and average
        foreach ($student_term_records as $str) {
            $student_term_id = $str['student_term_record_id'];

            $stmt = $pdo->prepare("
                SELECT SUM(total) AS total_marks, AVG(total) AS average_marks
                FROM islamiyya_results
                WHERE student_term_record_id = ?
            ");
            $stmt->execute([$student_term_id]);
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            $total_marks   = (float) ($res['total_marks'] ?? 0);
            $average_marks = (float) ($res['average_marks'] ?? 0);

            // Determine overall grade based on average
            if ($average_marks >= 75) $overall_grade = 'A';
            elseif ($average_marks >= 60) $overall_grade = 'B';
            elseif ($average_marks >= 50) $overall_grade = 'C';
            elseif ($average_marks >= 40) $overall_grade = 'D';
            else $overall_grade = 'E';

            $stmt = $pdo->prepare("
                UPDATE islamiyya_student_term_records
                SET total_marks = ?, average_marks = ?, overall_grade = ?
                WHERE id = ?
            ");
            $stmt->execute([$total_marks, $average_marks, $overall_grade, $student_term_id]);
        }

        // 3. Update positions in class-arm
        $stmt = $pdo->prepare("
            SELECT str.id, str.total_marks
            FROM islamiyya_student_term_records str
            JOIN islamiyya_student_class_records scr ON str.student_class_record_id = scr.id
            WHERE str.term_id = ? AND scr.class_id = ? AND scr.arm_id = ?
            ORDER BY str.total_marks DESC
        ");
        $stmt->execute([$term_id, $class_id, $arm_id]);
        $students_ordered = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $position = 0;
        $previous_total = null;
        $same_rank_count = 0;
        $class_size = count($students_ordered);

        foreach ($students_ordered as $student) {
            $student_term_id = $student['id'];
            $total = (float) $student['total_marks'];

            if ($previous_total !== null && $total == $previous_total) {
                $same_rank_count++;
            } else {
                $position += $same_rank_count + 1;
                $same_rank_count = 0;
            }
            $previous_total = $total;

            $stmt = $pdo->prepare("
                UPDATE islamiyya_student_term_records
                SET position_in_class = ?, class_size = ?
                WHERE id = ?
            ");
            $stmt->execute([$position, $class_size, $student_term_id]);
        }

        // 4. Update session-level totals and averages
        $stmt = $pdo->prepare("
            SELECT scr.id AS student_class_record_id,
                SUM(str.total_marks) AS session_total,
                AVG(str.average_marks) AS session_average
            FROM islamiyya_student_class_records scr
            JOIN islamiyya_student_term_records str ON str.student_class_record_id = scr.id
            WHERE scr.session_id = ? AND scr.class_id = ? AND scr.arm_id = ?
            GROUP BY scr.id
        ");
        $stmt->execute([$session_id, $class_id, $arm_id]);
        $session_records = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($session_records as $record) {
            $scr_id          = $record['student_class_record_id'];
            $session_total   = (float) ($record['session_total'] ?? 0);
            $session_average = (float) ($record['session_average'] ?? 0);

            // Overall grade based on session average
            if ($session_average >= 75) $overall_grade = 'A';
            elseif ($session_average >= 60) $overall_grade = 'B';
            elseif ($session_average >= 50) $overall_grade = 'C';
            elseif ($session_average >= 40) $overall_grade = 'D';
            else $overall_grade = 'E';

            $stmtUpdate = $pdo->prepare("
                UPDATE islamiyya_student_class_records
                SET overall_total = ?, overall_average = ?, promotion_status = ?
                WHERE id = ?
            ");
            $stmtUpdate->execute([$session_total, $session_average, 'pending', $scr_id]);
        }

        // 5. Update session positions
        $stmt = $pdo->prepare("
                SELECT id, overall_total
                FROM islamiyya_student_class_records
                WHERE session_id = ? AND class_id = ? AND arm_id = ?
                ORDER BY overall_total DESC
            ");
        $stmt->execute([$session_id, $class_id, $arm_id]);
        $students_ordered = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $position = 0;
        $previous_total = null;
        $same_rank_count = 0;
        $class_size = count($students_ordered);

        foreach ($students_ordered as $student) {
            $scr_id = $student['id'];
            $total  = (float) $student['overall_total'];

            if ($previous_total !== null && $total == $previous_total) {
                $same_rank_count++;
            } else {
                $position += $same_rank_count + 1;
                $same_rank_count = 0;
            }
            $previous_total = $total;

            $stmt = $pdo->prepare("
                UPDATE islamiyya_student_class_records
                SET overall_position = ?
                WHERE id = ?
            ");
            $stmt->execute([$position, $scr_id]);
        }

        // Commit transaction
        $pdo->commit();

        $_SESSION['success'] = "Islamiyya results uploaded successfully!";
        header("Location: " . route('back'));
        exit();
    } catch (PDOException $e) {
        // Rollback on error
        $pdo->rollBack();
        echo "<p class='text-red-500'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
}

?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/admins-section-nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700  text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Upload Islamiyya Class Results</h1>
            <p class="text-xl text-blue-200">Enter Results for Entire islamiyya Class</p>
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
                        <select name="class_id" id="classSelect" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" required disabled>
                            <option value="">-- Select Class --</option>
                            <?php foreach ($classes as $class) : ?>
                                <option value="<?= $class['id'] ?>" <?= (isset($_GET['class_id']) && $_GET['class_id'] == $class['id']) ? 'selected' : '' ?>>
                                    <?= $class['name'] ?>
                                    <?= $armName ?>


                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Subject</label>
                        <select name="subject_id" id="subjectSelect" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" required disabled>
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
                        <select name="session_id" id="sessionSelect" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" required disabled>
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
                        <select name="term_id" id="termSelect" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" required disabled>
                            <option value="">-- Select Term --</option>
                            <?php foreach ($terms as $term) : ?>
                                <option value="<?= $term['id'] ?>" data-session="<?= $term['session_id'] ?>" <?= (isset($_GET['term_id']) && $_GET['term_id'] == $term['id']) ? 'selected' : '' ?>>
                                    <?= $term['name']; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

            </form>


            <!-- Results Table -->
            <form method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

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
                                                <input type="number" min="0" max="40" name="ca[<?= $student['id'] ?>]" data-index="<?= $index ?>" value="<?= $student['ca'] ?? '' ?>" class="ca-input w-20 px-2 py-1 border border-gray-300 rounded text-center focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <input type="number" min="0" max="60" name="exam[<?= $student['id'] ?>]" data-index="<?= $index ?>" value="<?= $student['exam'] ?? '' ?>" class="exam-input w-20 px-2 py-1 border border-gray-300 rounded text-center focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            </td>
                                            <td class="px-6 py-4 text-center font-bold">
                                                <span class="total-score" data-index="<?= $index ?>"><?= $student['total'] ?? 0 ?></span>
                                            </td>
                                            <td class="px-6 py-4 text-center font-bold">
                                                <span class="grade" data-index="<?= $index ?>"><?= $student['grade'] ?? '-' ?></span>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="remark" data-index="<?= $index ?>"><?= $student['remark'] ?? '-' ?></span>
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
                        <button type="button" onclick="window.history.back()" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                            <i class="fas fa-arrow-left"></i> Back
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
    <?php include(__DIR__ . '/../../../../includes/footer.php'); ?>

    <script>
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
            if (score >= 75) return 'A';
            if (score >= 60) return 'B';
            if (score >= 50) return 'C';
            if (score >= 40) return 'D';
            return 'E';
        }

        function getRemark(grade) {
            const remarks = {
                'A': 'Excellent',
                'B': 'Very Good',
                'C': 'Good',
                'D': 'Fair',
                'E': 'Poor',
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