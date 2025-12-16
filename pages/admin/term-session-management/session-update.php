<?php

$title = "Session Update Form";
include(__DIR__ . '/../../../includes/header.php');

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


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM sessions WHERE id = ?');
    $stmt->execute([$id]);
    $session = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($session) {
        $session_id = $session['id'];
    } else {
        header('Location: ' . route('back'));
        exit();
    }
} else {
    header('Location: ' . route('back'));
    exit();
}

// Assuming selectAllData is already PDO-based
$sessions = selectAllData('sessions', null, $session_id);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    } else {
        // regenerate after successful validation
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $id         = (int) trim($_POST['sessionId'] ?? '');
    $name       = trim($_POST['sessionName'] ?? '');
    $start_date = trim($_POST['startDate'] ?? '');
    $end_date   = trim($_POST['endDate'] ?? '');

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
                "UPDATE sessions SET name = ?, start_date = ?, end_date = ? WHERE id = ?"
            );
            $success = $stmt->execute([$name, $start_date, $end_date, $id]);

            if ($success) {
                //  Commit transaction
                $pdo->commit();

                $_SESSION['success'] = "Session updated successfully!";
                header("Location: " . route('back'));
                exit();
            } else {
                //  Rollback if update fails
                $pdo->rollBack();
                echo "<script>alert('Failed to update session');</script>";
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "<script>alert('Database error: " . htmlspecialchars($e->getMessage()) . "');</script>";
        }
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}

?>


<script>
    const sessions = <?= json_encode($sessions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>


<body class="bg-gray-50">
    <?php include(__DIR__ . '/../includes/admins-section-nav.php') ?>
    <!-- Page Header -->

    <section class="bg-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Session Information</h1>
            <p class="text-xl text-green-200">Modify session details and settings</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Session Details</h2>

                        <form id="updatesessionFrom" class="space-y-6" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="sessionId" value="<?= $session['id'] ?>">

                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>

                            <!-- Session Name -->
                            <div>
                                <label for="sessionName" class="block text-sm font-semibold text-gray-700 mb-2">Session Name *</label>
                                <input type="text" id="sessionName" name="sessionName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., 2024/2025, 2025/2026" value="<?= $session['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="sessionNameError"></span>
                            </div>


                            <!-- Start Date -->
                            <div>
                                <label for="startDate" class="block text-sm font-semibold text-gray-700 mb-2">Start Date *</label>
                                <input type="date" id="startDate" name="startDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" value="<?= date('Y-m-d', strtotime($session['start_date'])) ?>">
                                <span class="text-red-500 text-sm hidden" id="startDateError"></span>
                            </div>

                            <!-- End Date -->
                            <div>
                                <label for="endDate" class="block text-sm font-semibold text-gray-700 mb-2">End Date *</label>
                                <input type="date" id="endDate" name="endDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" value="<?= date('Y-m-d', strtotime($session['end_date'])) ?>">
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
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#classArm", {
                plugins: ['remove_button'], // allows removing selected items
                placeholder: "Select class arms...",
                persist: false,
                create: false,
            });
        });


        const updatesessionFrom = document.getElementById('updatesessionFrom');

        updatesessionFrom.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const sessionName = document.getElementById('sessionName').value.trim();
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;


            let isValid = true;

            if (!sessionName) {
                document.getElementById('sessionNameError').textContent = 'Class name is required';
                document.getElementById('sessionNameError').classList.remove('hidden');
                isValid = false;
            }


            if (sessions.some(s => s.name === sessionName)) {
                document.getElementById('sessionNameError').textContent = 'Class already exists';
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
                updatesessionFrom.submit();
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