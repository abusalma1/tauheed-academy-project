<?php

$title = "Session Creation";
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
   FETCH LATEST ACTIVE SESSIONS
------------------------------ */

$stmt = $pdo->prepare("
    SELECT *
    FROM sessions
    WHERE deleted_at IS NULL
    ORDER BY updated_at DESC
    LIMIT 10
");
$stmt->execute();
$sessions_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ------------------------------
   FETCH OTHER DATA (ACTIVE ONLY)
------------------------------ */

$sessions   = selectAllData('sessions', true);
$sections   = selectAllData('sections', true);
$class_arms = selectAllData('class_arms', true);

$sessionsCount = countDataTotal('sessions', true)['total'];

/* ------------------------------
   FORM PROCESSING
------------------------------ */
=======
// Fetch latest sessions
$stmt = $pdo->prepare("SELECT * FROM sessions WHERE deleted_at IS NULL ORDER BY updated_at DESC LIMIT 10");
$stmt->execute();
$sessions_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Other data fetches (assuming selectAllData is already PDO-based)
$sessions   = selectAllData('sessions');
$sections   = selectAllData('sections');
$class_arms = selectAllData('class_arms');

$sessionsCount = countDataTotal('sessions')['total'];
>>>>>>> 271894334d344b716e30670c3770b73d583f3916

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
<<<<<<< HEAD

    /* ------------------------------
       CSRF VALIDATION
    ------------------------------ */
    if (!isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF validation failed. Please refresh and try again.");
    }

    // Regenerate token after validation
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    /* ------------------------------
       SANITIZE INPUT
    ------------------------------ */
=======
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    } else {
        // regenerate after successful validation
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    $name       = trim($_POST['sessionName'] ?? '');
    $start_date = trim($_POST['startDate'] ?? '');
    $end_date   = trim($_POST['endDate'] ?? '');

<<<<<<< HEAD
    /* ------------------------------
       VALIDATION
    ------------------------------ */

    if ($name === '') {
        $errors['nameError'] = "Name is required.";
    }

    // Prevent duplicate session names
    $stmt = $pdo->prepare("
        SELECT id 
        FROM sessions 
        WHERE name = ? AND deleted_at IS NULL
    ");
    $stmt->execute([$name]);
    if ($stmt->fetch()) {
        $errors['nameError'] = "A session with this name already exists.";
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
       INSERT SESSION
    ------------------------------ */

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                INSERT INTO sessions (name, start_date, end_date, created_at, updated_at)
                VALUES (?, ?, ?, NOW(), NOW())
            ");

            $success = $stmt->execute([$name, $start_date, $end_date]);

            if ($success) {
                $pdo->commit();
                $_SESSION['success'] = "Session created successfully.";
                header("Location: " . route('back'));
                exit();
            }

            $pdo->rollBack();
            echo "<script>alert('Failed to create session');</script>";

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

            $stmt = $pdo->prepare("INSERT INTO sessions (name, start_date, end_date) VALUES (?, ?, ?)");
            $success = $stmt->execute([$name, $start_date, $end_date]);

            if ($success) {
                //  Commit transaction
                $pdo->commit();

                $_SESSION['success'] = "Session created successfully!";
                header("Location: " . route('back'));
                exit();
            } else {
                //  Rollback if insert fails
                $pdo->rollBack();
                echo "<script>alert('Failed to create session');</script>";
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

<<<<<<< HEAD

=======
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
<script>
    const sessions = <?= json_encode($sessions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>


<body class="bg-gray-50">
    <?php include(__DIR__ . '/../includes/admins-section-nav.php') ?>

    <!-- Page Header -->
    <section class="bg-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Create Session</h1>
            <p class="text-xl text-green-200">Create, update, and manage academeic sessions</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Add New Session</h2>

                        <form id="sessionFrom" class="space-y-6" method="post">

                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>



                            <!-- Session Name -->
                            <div>
                                <label for="sessionName" class="block text-sm font-semibold text-gray-700 mb-2">Session Name *</label>
                                <input type="text" id="sessionName" name="sessionName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., 2024/2025, 2025/2026">
                                <span class="text-red-500 text-sm hidden" id="sessionNameError"></span>
                            </div>


                            <!-- Start Date -->
                            <div>
                                <label for="startDate" class="block text-sm font-semibold text-gray-700 mb-2">Start Date *</label>
                                <input type="date" id="startDate" name="startDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                <span class="text-red-500 text-sm hidden" id="startDateError"></span>
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="endDate" class="block text-sm font-semibold text-gray-700 mb-2">End Date *</label>
                                <input type="date" id="endDate" name="endDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                <span class="text-red-500 text-sm hidden" id="endDateError"></span>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-green-900 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Create Session
                                </button>
                                <button type="reset" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                                    Clear Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-green-50 rounded-lg shadow p-6 border-l-4 border-green-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-green-900 mr-2"></i>Session Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Session name must be unique</span>
                            </li>

                        </ul>
                    </div>

                    <!-- Statistics -->
                    <div class="mt-6 bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Session Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Total Sessions</span>
                                <span class="text-2xl font-bold text-green-900" id="totalClasses"><?= $sessionsCount; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Session Table -->
            <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">All Sessions</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-green-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Session Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Start Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">End Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="classesTableBody" class="divide-y divide-gray-200">
                            <?php if (count($sessions_list) > 0): ?>
                                <?php foreach ($sessions_list as $session): ?>

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900"> <?= $session['name'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $session['start_date'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $session['end_date'] ?></td>

                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <a href="<?= route('update-session'); ?>?id=<?= $session['id'] ?>">
                                                <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            </a>
                                            <a href="<?= route('delete-session') . '?id=' . $session['id'] ?>">
                                                <button class="text-red-600 hover:text-red-900 font-semibold">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                        </td>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>

                                <tr class="text-center py-8">
                                    <td colspan="7" class="px-6 py-8 text-gray-500">No Session created yet</td>
                                </tr>
                            <?php endif ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../../../includes/footer.php'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#classArm", {
                plugins: ['remove_button'], // allows removing selected items
                placeholder: "Select class arms...",
                persist: false,
                create: false,
            });
        });

        // Form validation and submission
        const sessionFrom = document.getElementById('sessionFrom');


        sessionFrom.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const sessionName = document.getElementById('sessionName').value.trim();
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;


            let isValid = true;

            if (!sessionName) {
                document.getElementById('sessionNameError').textContent = 'Session name is required';
                document.getElementById('sessionNameError').classList.remove('hidden');
                isValid = false;
            }


            if (sessions.some(s => s.name === sessionName)) {
                document.getElementById('sessionNameError').textContent = 'Session already exists';
                document.getElementById('sessionNameError').classList.remove('hidden');
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
                sessionFrom.submit();
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