<?php
$title = "Islamiyya Class Teacher Assignment";
include(__DIR__ . '/../../../../../includes/header.php');

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

// CSRF token setup
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch class + arm details
if (isset($_GET['class_id']) && isset($_GET['arm_id'])) {
    $class_id = (int) $_GET['class_id'];
    $arm_id   = (int) $_GET['arm_id'];

    $stmt = $pdo->prepare('
        SELECT
            islamiyya_classes.name AS class_name,
            islamiyya_class_arms.name AS arm_name,
            islamiyya_class_class_arms.class_id AS class_id,
            islamiyya_class_class_arms.arm_id AS arm_id,
            islamiyya_class_class_arms.teacher_id AS teacher_id
        FROM islamiyya_class_class_arms 
        LEFT JOIN islamiyya_classes 
               ON islamiyya_classes.id = islamiyya_class_class_arms.class_id 
        LEFT JOIN islamiyya_class_arms 
               ON islamiyya_class_arms.id = islamiyya_class_class_arms.arm_id 
        WHERE islamiyya_class_class_arms.class_id = ? 
          AND islamiyya_class_class_arms.arm_id = ? 
    ');
    $stmt->execute([$class_id, $arm_id]);
    $class = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$class) {
        header('Location: ' . route('back'));
        exit();
    }
} else {
    header('Location: ' . route('back'));
    exit();
}

$current_teacher_id = $class['teacher_id'] ?? '';
$teachers = selectAllData('teachers'); 

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $teacher_id = $_POST['teacher_id'] ? intval($_POST['teacher_id']) : null;

    if ($teacher_id === null) {
        $errors['general'] = "Please select a teacher.";
    } else {
        $updateStmt = $pdo->prepare("
            UPDATE islamiyya_class_class_arms 
            SET teacher_id = ? 
            WHERE class_id = ? AND arm_id = ? 
        ");
        $success = $updateStmt->execute([$teacher_id, $class['class_id'], $class['arm_id']]);

        if ($success) {
            $_SESSION['success'] = "Islamiyya class teacher updated successfully!";
            header("Location: " . route('back'));
            exit();
        } else {
            $errors['general'] = "Failed to update the teacher. Try again.";
        }
    }
}
?>



<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../../includes/admins-section-nav.php') ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:texupdatet-5xl font-bold mb-4">Update Teacher for Islamiyya Classes</h1>
            <p class="text-xl text-blue-200">Assign or update the teacher for this class</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Update islamiyya Class Teacher</h2>

                        <?php if (!empty($errors['general'])): ?>
                            <div class="mb-4 text-red-600 font-semibold"><?= htmlspecialchars($errors['general']) ?></div>
                        <?php endif; ?>

                        <form id="updateTeacherForm" class="space-y-6" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                            <?php include(__DIR__ . '/../../../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../../../includes/components/form-loader.php'); ?>

                            <!-- Class Name (Read-only) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                                <input type="text"
                                    value="<?= htmlspecialchars($class['class_name'] . ' ' . $class['arm_name']) ?>"
                                    readonly
                                    class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                            </div>

                            <!-- Teacher Select -->
                            <div>
                                <label for="teacher_id" class="block text-sm font-semibold text-gray-700 mb-2">Assigned Teacher</label>
                                <span class="text-gray-500 text-sm">Click Here to <a href="<?= route('teacher-create') ?>" class="text-blue-700 font-bold underline cursor-pointer">Create Teacher Account</a></span>

                                <select id="teacher_id" name="teacher_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                                    <option value="" <?= is_null($current_teacher_id) ? 'selected' : '' ?>>-- No Teacher Assigned --</option>
                                    <?php foreach ($teachers as $teacher): ?>
                                        <option value="<?= $teacher['id'] ?>"
                                            <?= $teacher['id'] == $current_teacher_id ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($teacher['name']) ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="teacherError"></span>
                            </div>

                            <!-- Buttons -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Teacher
                                </button>
                                <a type="button" onclick="window.history.back()" class="flex-1 text-center bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-blue-50 rounded-lg shadow p-6 border-l-4 border-blue-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-blue-900 mr-2"></i>Teacher Assignment Tips
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Each class must have only one teacher.</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>You can reassign a teacher at any time.</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Teachers not listed here can be added in the teachers section.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../../../includes/footer.php'); ?>

    <script>
        const updateTeacherForm = document.getElementById('updateTeacherForm');

        updateTeacherForm.addEventListener('submit', (e) => {
            e.preventDefault(); // always prevent, then submit when valid

            // Clear previous inline errors (nameError/classesError pattern exists elsewhere)
            document.querySelectorAll('[id$="Error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            let isValid = true;

            // Validate teacher select
            const teacherSelect = document.getElementById('teacher_id');
            const teacherErrorEl = document.getElementById('teacherError');
            const selectedTeacher = teacherSelect.value;

            if (!selectedTeacher) {
                teacherErrorEl.textContent = 'Please select a teacher.';
                teacherErrorEl.classList.remove('hidden');
                isValid = false;
                teacherSelect.focus();
            } else {
                teacherErrorEl.classList.add('hidden');
                teacherErrorEl.textContent = '';
            }

            if (isValid) {
                // scroll to top for success UI (keeps behaviour consistent)
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                updateTeacherForm.submit();
                showLoader();
            } else {
                // scroll to top so user sees the inline error (matching other flows)
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showErrorMessage();
            }
        });
    </script>
</body>

</html>