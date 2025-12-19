<?php

$title = "Term Update Form";
include(__DIR__ . '/../../../includes/header.php');

<<<<<<< HEAD
/* ------------------------------
   AUTHENTICATION CHECKS
------------------------------ */

=======
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
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
   FETCH TERM TO UPDATE
------------------------------ */

if (!isset($_GET['id'])) {
=======
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare('SELECT
        terms.id AS id, 
        terms.name AS name,
        terms.start_date AS start_date,
        terms.end_date AS end_date,
        sessions.id AS session_id, 
        sessions.name AS session_name,
        sessions.start_date AS session_start_date,
        sessions.end_date AS session_end_date
     FROM terms 
     LEFT JOIN sessions ON terms.session_id = sessions.id
     WHERE terms.id = ?');
    $stmt->execute([$id]);
    $term = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($term) {
        $term_id = $term['id'];
    } else {
        header('Location: ' . route('back'));
        exit();
    }
} else {
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    header('Location: ' . route('back'));
    exit();
}

<<<<<<< HEAD
$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT 
        t.id AS id,
        t.name AS name,
        t.start_date AS start_date,
        t.end_date AS end_date,
        t.session_id AS session_id,

        s.name AS session_name,
        s.start_date AS session_start_date,
        s.end_date AS session_end_date

    FROM terms t
    LEFT JOIN sessions s 
        ON t.session_id = s.id 
        AND s.deleted_at IS NULL

    WHERE t.id = ? 
      AND t.deleted_at IS NULL
");
$stmt->execute([$id]);
$term = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$term) {
    $_SESSION['failure'] = "Term not found!";
    header('Location: ' . route('back'));
    exit();
}

$term_id    = $term['id'];
$session_id = $term['session_id'];

/* ------------------------------
   FETCH OTHER TERMS IN SAME SESSION
------------------------------ */

$stmt = $pdo->prepare("
    SELECT id, name 
    FROM terms 
    WHERE session_id = ? 
      AND id <> ? 
      AND deleted_at IS NULL
");
$stmt->execute([$session_id, $term_id]);
$other_terms = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ------------------------------
   FORM PROCESSING
------------------------------ */
=======
// Assuming selectAllData is already PDO-based
$terms = selectAllData('terms', null, $term_id);

// Fetch other terms in the same session
$stmt = $pdo->prepare('SELECT * FROM terms WHERE session_id = ? AND id != ?');
$stmt->execute([$term['session_id'], $term_id]);
$terms = $stmt->fetchAll(PDO::FETCH_ASSOC);
>>>>>>> 271894334d344b716e30670c3770b73d583f3916

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
<<<<<<< HEAD

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
    $id         = (int) ($_POST['termId'] ?? 0);
=======
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    } else {
        // regenerate after successful validation
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $id         = (int) trim($_POST['termId'] ?? '');
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    $name       = trim($_POST['termName'] ?? '');
    $start_date = trim($_POST['startDate'] ?? '');
    $end_date   = trim($_POST['endDate'] ?? '');

<<<<<<< HEAD
    /* ------------------------------
       VALIDATION
    ------------------------------ */

    if ($name === '') {
        $errors['nameError'] = "Name is required.";
    }

    // Prevent duplicate term names inside the same session
    $stmt = $pdo->prepare("
        SELECT id 
        FROM terms 
        WHERE name = ? 
          AND session_id = ? 
          AND id <> ? 
          AND deleted_at IS NULL
    ");
    $stmt->execute([$name, $session_id, $term_id]);
    if ($stmt->fetch()) {
        $errors['nameError'] = "Another term with this name already exists in this session.";
    }

    if ($start_date === '') {
        $errors['startDateError'] = "Start Date is required.";
    }

    if ($end_date === '') {
        $errors['endDateError'] = "End Date is required.";
    }

    if ($start_date && $end_date && $end_date < $start_date) {
        $errors['endDateError'] = "End Date cannot be earlier than Start Date.";
    }

    /* ------------------------------
       UPDATE TERM
    ------------------------------ */

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                UPDATE terms
                SET name = ?, start_date = ?, end_date = ?, updated_at = NOW()
                WHERE id = ? AND deleted_at IS NULL
            ");

            $success = $stmt->execute([$name, $start_date, $end_date, $id]);

            if ($success) {
                $pdo->commit();
                $_SESSION['success'] = "Term updated successfully!";
                header("Location: " . route('back'));
                exit();
            }

            $pdo->rollBack();
            echo "<script>alert('Failed to update term');</script>";
=======
    // Validations
    if (empty($name)) {
        $errors['nameError'] = "Name is required";
    }
    if (empty($start_date)) {
        $errors['startDateError'] = "Start Date is required";
    }
    if (empty($end_date)) {
        $errors['endDateError'] = "End Date is required";
    }

    if (empty($errors)) {
        try {
            //  Start transaction
            $pdo->beginTransaction();

            $stmt = $pdo->prepare(
                "UPDATE terms SET name = ?, start_date = ?, end_date = ? WHERE id = ?"
            );
            $success = $stmt->execute([$name, $start_date, $end_date, $id]);

            if ($success) {
                //  Commit transaction
                $pdo->commit();

                $_SESSION['success'] = "Term updated successfully!";
                header("Location: " . route('back'));
                exit();
            } else {
                //  Rollback if update fails
                $pdo->rollBack();
                echo "<script>alert('Failed to update term');</script>";
            }
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "<script>alert('Database error: " . htmlspecialchars($e->getMessage()) . "');</script>";
        }
<<<<<<< HEAD
    }

    /* ------------------------------
       DISPLAY ERRORS
    ------------------------------ */
    foreach ($errors as $error) {
        echo "<p class='text-red-600 font-semibold'>$error</p>";
=======
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    }
}

?>



<script>
    const terms = <?= json_encode($terms, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>


<body class="bg-gray-50">
    <?php include(__DIR__ . '/../includes/admins-section-nav.php') ?>
    <!-- Page Header -->

    <section class="bg-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Term Information</h1>
            <p class="text-xl text-green-200">Modify Term details and settings</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Term Details</h2>

                        <form id="updatetermFrom" class="space-y-6" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="termId" value="<?= $term['id'] ?>">

                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>


                            <!-- Session Name (Read-only) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Session</label>
                                <input type="text"
                                    value="<?= htmlspecialchars($term['session_name']); ?>"
                                    class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed"
                                    readonly>
                            </div>

                            <!-- Term Name -->
                            <div>
                                <label for="termName" class="block text-sm font-semibold text-gray-700 mb-2">Term Name *</label>
                                <input type="text" id="termName" name="termName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., 2024/2025, 2025/2026" value="<?= $term['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="termNameError"></span>
                            </div>


                            <!-- Start Date -->
                            <div>
                                <label for="startDate" class="block text-sm font-semibold text-gray-700 mb-2">Start Date *</label>
                                <input type="date" id="startDate" name="startDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" value="<?= date('Y-m-d', strtotime($term['start_date'])) ?>">
                                <span class="text-red-500 text-sm hidden" id="startDateError"></span>
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="endDate" class="block text-sm font-semibold text-gray-700 mb-2">End Date *</label>
                                <input type="date" id="endDate" name="endDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" value="<?= date('Y-m-d', strtotime($term['end_date'])) ?>">
                                <span class="text-red-500 text-sm hidden" id="endDateError"></span>
                            </div>



                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-green-900 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                                    <i class="fas fa-save mr-2"></i>Save Changes
                                </button>
                                <a type="button" onclick="window.history.back()" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                    <i class="fas fa-arrow-left mr-2"></i>back
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-green-50 rounded-lg shadow p-6 border-l-4 border-green-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-green-900 mr-2"></i>Update Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Modify the details as needed</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Click Update to save changes</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </section>
    <?php include(__DIR__ . '/../../../includes/footer.php');    ?>


    <script>
        const updatetermFrom = document.getElementById('updatetermFrom');

        updatetermFrom.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const termName = document.getElementById('termName').value.trim();
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;


            let isValid = true;

            if (!termName) {
                document.getElementById('termNameError').textContent = 'Class name is required';
                document.getElementById('termNameError').classList.remove('hidden');
                isValid = false;
            }


            if (terms.some(s => s.name === termName)) {
                document.getElementById('termNameError').textContent = 'Class already exists';
                document.getElementById('termNameError').classList.remove('hidden');
                isValid = false;
            }


            if (!startDate) {
                document.getElementById('startDateError').textContent = 'Start Date is required';
                document.getElementById('startDateError').classList.remove('hidden');
                isValid = false;
            }

            if (!endDate) {
                document.getElementById('endDateError').textContent = 'End Date  is required';
                document.getElementById('endDateError').classList.remove('hidden');
                isValid = false;
            }




            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                updatetermFrom.submit();
            } else {
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