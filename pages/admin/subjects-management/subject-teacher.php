<?php
<<<<<<< HEAD

$title = "Subject Teacher Assignment";
include(__DIR__ . '/../../../includes/header.php');

/* ------------------------------
   AUTHENTICATION CHECKS
------------------------------ */

=======
$title = "Subject Teacher Assignment";
include(__DIR__ . '/../../../includes/header.php');

>>>>>>> 271894334d344b716e30670c3770b73d583f3916
if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (!isset($user_type) || $user_type !== 'admin') {
<<<<<<< HEAD
    $_SESSION['failure'] = "Access denied. Only Admins are allowed.";
=======
    $_SESSION['failure'] = "Access denied! Only Admins are allowed.";
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    header("Location: " . route('home'));
    exit();
}

<<<<<<< HEAD
/* ------------------------------
   CSRF TOKEN
------------------------------ */
=======
>>>>>>> 271894334d344b716e30670c3770b73d583f3916

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

<<<<<<< HEAD
/* ------------------------------
   VALIDATE class_subject ID
------------------------------ */

=======
// Validate class_subject id
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ' . route('back'));
    exit();
}
<<<<<<< HEAD

$class_subject_id = (int) $_GET['id'];

/* ------------------------------
   FETCH CLASS-SUBJECT RECORD
------------------------------ */

$stmt = $pdo->prepare("
=======
$class_subject_id = (int) $_GET['id'];

// Fetch current class-subject record
$query = "
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    SELECT 
        cs.id AS cs_id,
        cs.teacher_id,
        s.name AS subject_name,
        c.name AS class_name
<<<<<<< HEAD

    FROM class_subjects cs

    INNER JOIN subjects s 
        ON cs.subject_id = s.id
        AND s.deleted_at IS NULL

    INNER JOIN classes c 
        ON cs.class_id = c.id
        AND c.deleted_at IS NULL

    WHERE cs.id = ?
      AND cs.deleted_at IS NULL
");
=======
    FROM class_subjects cs
    INNER JOIN subjects s ON cs.subject_id = s.id
    INNER JOIN classes c ON cs.class_id = c.id
    WHERE cs.id = ?
";
$stmt = $pdo->prepare($query);
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
$stmt->execute([$class_subject_id]);
$class_subject = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$class_subject) {
    die('<p class="text-red-600 font-semibold">Record not found.</p>');
}
<<<<<<< HEAD

$current_teacher_id = $class_subject['teacher_id'];

/* ------------------------------
   FETCH ACTIVE TEACHERS
------------------------------ */

$teachers = selectAllData('teachers', true); // true = filter deleted rows

/* ------------------------------
   FORM PROCESSING
------------------------------ */

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ------------------------------
       CSRF VALIDATION
    ------------------------------ */
    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    // Regenerate token after validation
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    /* ------------------------------
       SANITIZE INPUT
    ------------------------------ */
    $teacher_id = !empty($_POST['teacher_id']) ? (int) $_POST['teacher_id'] : null;

    /* ------------------------------
       VALIDATE TEACHER EXISTS
    ------------------------------ */
    if ($teacher_id !== null) {
        $stmt = $pdo->prepare("
            SELECT id 
            FROM teachers 
            WHERE id = ? AND deleted_at IS NULL
        ");
        $stmt->execute([$teacher_id]);

        if (!$stmt->fetch()) {
            $errors['teacher'] = "Selected teacher does not exist.";
        }
    }

    /* ------------------------------
       UPDATE TEACHER ASSIGNMENT
    ------------------------------ */
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                UPDATE class_subjects 
                SET teacher_id = ?, updated_at = NOW()
                WHERE id = ? AND deleted_at IS NULL
            ");

            $success = $stmt->execute([$teacher_id, $class_subject_id]);

            if ($success) {
                $_SESSION['success'] = "Teacher updated successfully.";
                header("Location: " . route('back'));
                exit();
            }

            $errors['general'] = "Failed to update the teacher.";
        } catch (PDOException $e) {
            $errors['general'] = "Database error: " . htmlspecialchars($e->getMessage());
        }
    }

    /* ------------------------------
       DISPLAY ERRORS
    ------------------------------ */
    foreach ($errors as $error) {
        echo "<p class='text-red-600 font-semibold'>$error</p>";
    }
}

?>

=======
$current_teacher_id = $class_subject['teacher_id'];

// Fetch all teachers (assuming selectAllData is already PDO-based)
$teachers = selectAllData('teachers');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $teacher_id = !empty($_POST['teacher_id']) ? (int) $_POST['teacher_id'] : null;

    try {
        $updateStmt = $pdo->prepare("UPDATE class_subjects SET teacher_id = ? WHERE id = ?");
        $success = $updateStmt->execute([$teacher_id, $class_subject_id]);

        if ($success) {
            $_SESSION['success'] = "Teacher updated successfully!";
            header("Location: " . route('back'));
            exit();
        } else {
            $errors['general'] = "Failed to update the teacher. Try again.";
        }
    } catch (PDOException $e) {
        $errors['general'] = "Database error: " . htmlspecialchars($e->getMessage());
    }
}
?>


>>>>>>> 271894334d344b716e30670c3770b73d583f3916
<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php') ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:texupdatet-5xl font-bold mb-4">Update Teacher for Subject</h1>
            <p class="text-xl text-blue-200">Assign or update the teacher for this subject and class</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Update Teacher</h2>

                        <?php if (!empty($errors['general'])): ?>
                            <div class="mb-4 text-red-600 font-semibold"><?= htmlspecialchars($errors['general']) ?></div>
                        <?php endif; ?>

                        <form id="updateTeacherForm" class="space-y-6" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>

                            <!-- Subject Name (Read-only) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Subject</label>
                                <input type="text"
                                    value="<?= htmlspecialchars($class_subject['subject_name']); ?>"
                                    readonly
                                    class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                            </div>

                            <!-- Class Name (Read-only) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Class</label>
                                <input type="text"
                                    value="<?= htmlspecialchars($class_subject['class_name']); ?>"
                                    readonly
                                    class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                            </div>

                            <!-- Teacher Select -->
                            <div>
                                <label for="teacher_id" class="block text-sm font-semibold text-gray-700 mb-2">Assigned Teacher</label>
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
                                <span>Each subject per class must have only one teacher.</span>
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
    <?php include(__DIR__ . '/../../../includes/footer.php'); ?>

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