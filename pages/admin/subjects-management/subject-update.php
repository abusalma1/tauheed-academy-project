<?php
$title = "Update Subject";
include(__DIR__ . '/../../../includes/header.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// All classes for multi-select
$classes = selectAllData('classes');

// Validate subject id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ' . route('back'));
}
$subject_id = intval($_GET['id']);

// Fetch subject
$subjectStmt = $connection->prepare("SELECT * FROM subjects WHERE id = ?");
$subjectStmt->bind_param('i', $subject_id);
$subjectStmt->execute();
$subjectResult = $subjectStmt->get_result();
if ($subjectResult->num_rows === 0) {
    die('<p class="text-red-600 font-semibold">Subject not found.</p>');
}
$current_subject = $subjectResult->fetch_assoc();

// Fetch associated classes
$selected_classes = [];
$csStmt = $connection->prepare("SELECT class_id FROM class_subjects WHERE subject_id = ?");
$csStmt->bind_param('i', $subject_id);
$csStmt->execute();
$csRes = $csStmt->get_result();
while ($r = $csRes->fetch_assoc()) {
    $selected_classes[] = (int)$r['class_id'];
}
$csStmt->close();

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

    // Optionally ensure unique name (exclude current subject)
    $uniqueStmt = $connection->prepare("SELECT id FROM subjects WHERE name = ? AND id != ?");
    $uniqueStmt->bind_param('si', $name, $subject_id);
    $uniqueStmt->execute();
    $uniqueRes = $uniqueStmt->get_result();
    if ($uniqueRes->num_rows > 0) {
        $errors['name'] = "A subject with this name already exists.";
    }
    $uniqueStmt->close();

    if (empty($errors)) {
        // Update subject name
        $updateStmt = $connection->prepare("UPDATE subjects SET name = ? WHERE id = ?");
        $updateStmt->bind_param('si', $name, $subject_id);

        if ($updateStmt->execute()) {
            // Replace pivot rows: delete old, insert new
            $delStmt = $connection->prepare("DELETE FROM class_subjects WHERE subject_id = ?");
            $delStmt->bind_param('i', $subject_id);
            $delStmt->execute();
            $delStmt->close();

            $insertPivot = $connection->prepare("INSERT INTO class_subjects (class_id, subject_id) VALUES (?, ?)");
            foreach ($class_ids as $cid) {
                $cid = intval($cid);
                $insertPivot->bind_param('ii', $cid, $subject_id);
                $insertPivot->execute();
            }
            $insertPivot->close();


            $_SESSION['success'] = "Subject updated successfully!";

            // Redirect back to previous page after successful update
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
    const selectedClasses = <?= json_encode($selected_classes, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
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
                                    value="<?= htmlspecialchars($current_subject['name'] ?? '') ?>"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900"
                                    placeholder="Enter Subject name">
                                <span class="text-red-500 text-sm <?= isset($errors['name']) ? '' : 'hidden' ?>" id="nameError"><?= htmlspecialchars($errors['name'] ?? '') ?></span>
                            </div>

                            <!-- classes -->
                            <div class="relative w-full" id="multi-select-wrapper">
                                <label for="classes" class="block text-sm font-semibold text-gray-700 mb-2">Classes</label>

                                <!-- Input / Display -->
                                <div id="multi-select-input" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-900">
                                    <span id="multi-select-placeholder" class="text-gray-500 w-full <?= count($selected_classes) ? 'hidden' : '' ?>">Select classes... </span>
                                    <span id="multi-select-selected" class="text-gray-800 <?= count($selected_classes) ? '' : 'hidden' ?>"></span>
                                </div>

                                <!-- Dropdown List -->
                                <div id="multi-select-options" class="absolute w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-scroll z-10 hidden">
                                    <?php foreach ($classes as $class): ?>
                                        <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                            <input type="checkbox" value="<?= $class['id'] ?>" class="form-checkbox text-blue-900" />
                                            <span class="ml-2"><?= htmlspecialchars($class['name']) ?></span>
                                        </label>
                                    <?php endforeach ?>
                                </div>

                                <!-- Hidden inputs to submit selection -->
                                <div id="multi-select-hidden"></div>
                                <span class="text-red-500 text-sm <?= isset($errors['classes']) ? '' : 'hidden' ?>" id="classesError"><?= htmlspecialchars($errors['classes'] ?? '') ?></span>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Subject
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
        // Multi-select UI wiring
        const input = document.getElementById('multi-select-input');
        const dropdown = document.getElementById('multi-select-options');
        const placeholder = document.getElementById('multi-select-placeholder');
        const selectedDisplay = document.getElementById('multi-select-selected');
        const hiddenContainer = document.getElementById('multi-select-hidden');
        const checkboxes = dropdown.querySelectorAll('input[type="checkbox"]');

        function rebuildHiddenInputs() {
            const checked = Array.from(checkboxes).filter(i => i.checked).map(i => i.value);
            hiddenContainer.innerHTML = '';
            if (checked.length > 0) {
                placeholder.classList.add('hidden');
                selectedDisplay.classList.remove('hidden');
                selectedDisplay.textContent = checked.join(', ');
            } else {
                placeholder.classList.remove('hidden');
                selectedDisplay.classList.add('hidden');
                selectedDisplay.textContent = '';
            }
            checked.forEach(value => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'classes[]';
                hiddenInput.value = value;
                hiddenContainer.appendChild(hiddenInput);
            });
        }

        input.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!document.getElementById('multi-select-wrapper').contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', rebuildHiddenInputs);
        });

        // Preselect classes (from PHP selectedClasses)
        window.addEventListener('DOMContentLoaded', () => {
            if (Array.isArray(selectedClasses) && selectedClasses.length > 0) {
                checkboxes.forEach(cb => {
                    if (selectedClasses.includes(parseInt(cb.value))) {
                        cb.checked = true;
                    }
                });
                rebuildHiddenInputs();
            }
        });

        // Form validation and submission (client-side)
        const subjectFrom = document.getElementById('subjectFrom');
        subjectFrom.addEventListener('submit', (e) => {
            e.preventDefault();

            let isValid = true;

            // Clear previous visible errors
            document.querySelectorAll('[id$="Error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            const name = document.getElementById('name').value.trim();
            const classInputs = document.querySelectorAll('input[name="classes[]"]');

            // Validate name
            if (!name) {
                const nameError = document.getElementById('nameError');
                nameError.textContent = 'Subject name is required.';
                nameError.classList.remove('hidden');
                isValid = false;
            }

            // Validate classes
            const classesErrorEl = document.getElementById('classesError');
            if (classInputs.length === 0) {
                classesErrorEl.textContent = 'Please select at least one class.';
                classesErrorEl.classList.remove('hidden');
                isValid = false;
            } else {
                classesErrorEl.classList.add('hidden');
                classesErrorEl.textContent = '';
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