<?php
$title = "Update Subject";
include(__DIR__ . '/../../../includes/header.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare('SELECT * FROM subjects WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $subject = $result->fetch_assoc();
    } else {
        $_SESSION['success'] = "Subject added successfully!";
        header('Location: ' .  route('back'));
    }
} else {
    header('Location: ' .  route('back'));
}

$subject_id = $subject['id'];


$stmt = $conn->prepare('SELECT * FROM class_subjects WHERE subject_id = ? and deleted_at is null');
$stmt->bind_param('i', $subject['id']);
$stmt->execute();
$result = $stmt->get_result();
$class_subjects = $result->fetch_all(MYSQLI_ASSOC);

$classes = selectAllData('classes');
$subjects = selectAllData('subjects', null, $subject['id']);

// Handle POST (update)
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $name = trim($_POST['name'] ?? '');
    $class_ids = isset($_POST['classes']) ? $_POST['classes'] : [];

    // Validations
    if ($name === '') {
        $errors['name'] = "Subject name is required.";
    }

    if (empty($class_ids) || !is_array($class_ids)) {
        $errors['classes'] = "Please select at least one class.";
    }


    if (empty($errors)) {
        // Update subject name
        $updateStmt = $conn->prepare("UPDATE subjects SET name = ? WHERE id = ?");
        $updateStmt->bind_param('si', $name, $subject_id);

        if ($updateStmt->execute()) {
            // Replace pivot rows: delete old, insert new
            $delStmt = $conn->prepare("DELETE FROM class_subjects WHERE subject_id = ?");
            $delStmt->bind_param('i', $subject_id);
            $delStmt->execute();
            $delStmt->close();

            $insertPivot = $conn->prepare("INSERT INTO class_subjects (class_id, subject_id) VALUES (?, ?)");
            foreach ($class_ids as $cid) {
                $cid = intval($cid);
                $insertPivot->bind_param('ii', $cid, $subject_id);
                $insertPivot->execute();
            }
            $insertPivot->close();


            $_SESSION['success'] = "Subject updated successfully!";

            header('Location: ' . route('back'));
            exit;
        } else {
            $errors['general'] = "Failed to update subject. Try again.";
        }
        $updateStmt->close();
    }
}
?>
<script>
    const subjects = <?= json_encode($subjects, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php') ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Subject</h1>
            <p class="text-xl text-blue-200">Edit subject and its class assignments</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Update Subject</h2>

                        <?php if (!empty($errors['general'])): ?>
                            <div class="mb-4 text-red-600 font-semibold"><?= htmlspecialchars($errors['general']) ?></div>
                        <?php endif; ?>

                        <form id="subjectFrom" class="space-y-6" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="subject_id" value="<?= $subject_id; ?>">

                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>


                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Subject name *</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="<?= htmlspecialchars($subject['name'] ?? '') ?>"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900"
                                    placeholder="Enter Subject name">
                                <span class="text-red-500 text-sm <?= isset($errors['name']) ? '' : 'hidden' ?>" id="nameError"><?= htmlspecialchars($errors['name'] ?? '') ?></span>
                            </div>

                            <div>
                                <label for="classes" class="block text-sm font-semibold text-gray-700 mb-2">Classes</label>
                                <select id="classes" name="classes[]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" multiple>
                                    <option value="">Select Classes</option>
                                    <?php
                                    // Collect all linked class IDs for easier checking
                                    $linked_class_ids = array_column($class_subjects, 'class_id');
                                    foreach ($classes as $class):
                                        $selected = in_array($class['id'], $linked_class_ids) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $class['id'] ?>" <?= $selected ?>><?= htmlspecialchars($class['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="classesError"></span>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                                    <i class="fas fa-save mr-2"></i>Save Changes
                                </button>
                                <a href="<?= route('back') ?>" class="flex-1 text-center bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
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
                            <i class="fas fa-info-circle text-blue-900 mr-2"></i>Subject Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Subject Name Must Be Unique</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Atleast One class must be picked</span>
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
              document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#classes", {
                plugins: ['remove_button'], // allows removing selected items
                placeholder: "Select class arms...",
                persist: false,
                create: false,
            });
        });

        // Form validation and submission (client-side)
        const subjectFrom = document.getElementById('subjectFrom');
        subjectFrom.addEventListener('submit', (e) => {

            e.preventDefault();

            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            const name = document.getElementById('name').value.trim();
            const classes = document.getElementById('classes').value.trim();


            // Validate name
            if (!name) {
                document.getElementById('nameError').textContent = 'Subject name is required.';
                document.getElementById('nameError').classList.remove('hidden');
                isValid = false;
            }

            if (subjects.some(t => t.name === name)) {
                document.getElementById('nameError').textContent = 'Subject already exists';
                document.getElementById('nameError').classList.remove('hidden');
                isValid = false;
            }


            if (!classes) {
                document.getElementById('classesError').textContent = 'Choose atleast 1 class';
                document.getElementById('classesError').classList.remove('hidden');
                isValid = false;
            }



            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                subjectFrom.submit();
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