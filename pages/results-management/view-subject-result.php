<?php
$title = "Subject Results/Class";
include(__DIR__ . '/../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (isset($_GET['class_id']) && isset($_GET['term_id']) && isset($_GET['subject_id'])) {
    $class_id = intval($_GET['class_id']);
    $session_id = intval($_GET['session_id']);
    $term_id = intval($_GET['term_id']);

    $subject_id = intval($_GET['subject_id']);

    $stmt = $conn->prepare("SELECT name from subjects where id = ?");
    $stmt->bind_param("i", $subject_id);
    $stmt->execute();
    $subject = $stmt->get_result()->fetch_assoc();

    $stmt = $conn->prepare("SELECT id, name from sessions where id = ?");
    $stmt->bind_param("i", $session_id);
    $stmt->execute();
    $session = $stmt->get_result()->fetch_assoc();

    $stmt = $conn->prepare("SELECT id, name from terms where id = ?");
    $stmt->bind_param("i", $term_id);
    $stmt->execute();
    $term = $stmt->get_result()->fetch_assoc();


    $stmt = $conn->prepare("
        SELECT 
            st.id AS id,
            st.name,
            st.admission_number,
            st.arm_id,
            
            r.ca,
            r.exam,
            r.total,
            r.grade,
            r.remark

        FROM students st

        LEFT JOIN student_class_records scr
            ON scr.student_id = st.id 
            AND scr.class_id = ?

        LEFT JOIN student_term_records str
            ON str.student_class_record_id = scr.id
            AND str.term_id = ?

        LEFT JOIN results r
            ON r.student_term_record_id = str.id
            AND r.subject_id = ?

        WHERE st.class_id = ?
        ORDER BY st.admission_number
    ");

    $stmt->bind_param("iiii", $class_id, $term_id, $subject_id, $class_id);
    $stmt->execute();
    $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    route('back');
}

?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php');  ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700  text-white py-16">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 flex items-center gap-3">
                </i>View Class Results
            </h1>
            <p class="text-xl text-blue-200">See students results per subject</p>
        </div>
    </section>


    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Content -->
            <div id="studentsByClassContainer" class="space-y-8">

                <div class="student-class-group bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white p-6">
                        <h3 class="text-2xl font-bold"><?= $subject['name'] ?></h3>
                        <p class="text-sm opacity-50 py-2"><?= $term['name'] ?>, <?= $session['name'] ?> Academic Session</p>
                        <p class="text-xs opacity-90"><?= count($students) ?> students</p>

                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Name</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Admission #</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">CA(40)</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Exam(60)</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Total(100)</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Grade</th>
                                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td class="px-4 py-3"><?= $student['name'] ?></td>
                                        <td class="px-4 py-3 text-center"><?= $student['admission_number'] ?></td>

                                        <td class="px-4 py-3 text-center"><?= $student['ca'] ?></td>
                                        <td class="px-4 py-3 text-center"><?= $student['exam'] ?></td>
                                        <td class="px-4 py-3 text-center font-bold"><?= $student['total'] ?></td>
                                        <td class="px-4 py-3 text-center font-bold text-green-600"><?= $student['grade'] ?></td>
                                        <td class="px-4 py-3 text-center"><?= $student['remark'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-8">
                <div class="grid md:grid-cols-3 gap-4">
                    <a href="<?= route('upload-results') . '?subject_id=' . $subject_id . '&class_id=' . $class_id . '&session_id=' . $session_id . '&term_id=' . $term_id ?>"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-upload"></i>Update
                    </a>
                    <button onclick="printTable()" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                        <i class="fas fa-print"></i>Print
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>


    <script>
    </script>
</body>

</html>