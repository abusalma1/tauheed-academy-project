<?php

$title = "Term Status Update Form";
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
    $stmt = $pdo->prepare('SELECT
        t.id AS id, 
        t.name AS name,
        t.status,
        s.id AS session_id, 
        s.name AS session_name
 
     FROM terms t
     LEFT JOIN sessions s ON t.session_id = s.id
     WHERE t.id = ?');
    $stmt->execute([$id]);
    $term = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($term) {
        $term_id = $term['id'];
    } else {
        header('Location: ' . route('back'));
        exit();
    }
} else {
    header('Location: ' . route('back'));
    exit();
}

// Assuming selectAllData is already PDO-based
$terms = selectAllData('terms', null, $term_id);

// Fetch other terms in the same session
$stmt = $pdo->prepare('SELECT * FROM terms WHERE session_id = ? AND id != ?');
$stmt->execute([$term['session_id'], $term_id]);
$terms = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    } else {
        // regenerate after successful validation
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $id = (int) trim($_POST['termId'] ?? '');
    $status = trim($_POST['termStatus'] ?? '');


    // Validations
    if (empty($status)) {
        $errors['nameError'] = "Status is required";
    }


    if (empty($errors)) {
        try {
            //  Start transaction
            $pdo->beginTransaction();

            $stmt = $pdo->prepare(
                "UPDATE terms SET  status = ? WHERE id = ?"
            );
            $success = $stmt->execute([$status, $id]);

            if ($success) {
                if ($atatus === 'ongoing') {
                }
                $stmt = $pdo->prepare("UPDATE terms set status = ? where status = ? and != ?");
                $statusChanged = $stmt->execute(['pending', 'ongoing', $id]);

                if ($statusChanged) {
                    //  Commit transaction
                    $pdo->commit();

                    $_SESSION['success'] = "Term Status updated successfully!";
                    header("Location: " . route('back'));
                    exit();
                }
            } else {
                //  Rollback if update fails
                $pdo->rollBack();
                echo "<script>alert('Failed to update term');</script>";
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


                            <!-- Term & Session Name (Read-only) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Term/ Session</label>
                                <input type="text"
                                    value="<?= htmlspecialchars($term['name'] . '  ' . $term['session_name']); ?>"
                                    class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed"
                                    readonly>
                            </div>

                            <!-- Term Satus -->
                            <div>
                                <label for="termStatus" class="block text-sm font-semibold text-gray-700 mb-2">Term Status *</label>
                                <select type="text" id="termStatus" name="termStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="">-- Select status --</option>
                                    <option value="pending" <?= $term['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="ongoing" <?= $term['status'] === 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                                    <option value="finished" <?= $term['status'] === 'finished' ? 'selected' : '' ?>>Completed</option>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="termStatusError"></span>
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

            const termStatus = document.getElementById('termStatus').value.trim();


            let isValid = true;

            if (!termStatus) {
                document.getElementById('termStatusError').textContent = 'Term status is required';
                document.getElementById('termStatusError').classList.remove('hidden');
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