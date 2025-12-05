<?php
$title = "Create Subject";
include(__DIR__ . '/../../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch classes
$stmt = $pdo->prepare("
    SELECT *
    FROM classes
    WHERE deleted_at IS NULL
    GROUP BY level
");
$stmt->execute();
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch subjects with class names
$stmt = $pdo->prepare("
    SELECT 
        subjects.id AS id,
        subjects.name AS name,
        GROUP_CONCAT(classes.name SEPARATOR ', ') AS class_names
    FROM subjects
    LEFT JOIN class_subjects ON class_subjects.subject_id = subjects.id
    LEFT JOIN classes ON classes.id = class_subjects.class_id
    WHERE subjects.deleted_at IS NULL
    GROUP BY subjects.id
");
$stmt->execute();
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    } else {
        // regenerate after successful validation
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $name      = trim($_POST['name']);
    $class_ids = isset($_POST['classes']) ? $_POST['classes'] : [];

    if (empty($name)) {
        $errors['name'] = "Subject name is required.";
    }

    if (empty($class_ids) || !is_array($class_ids)) {
        $errors['classes'] = "Please select at least one class.";
    }

    if (empty($errors)) {
        try {
            //  Start transaction
            $pdo->beginTransaction();

            // Insert subject
            $stmt = $pdo->prepare("INSERT INTO subjects (name) VALUES (?)");
            $stmt->execute([$name]);
            $subject_id = $pdo->lastInsertId();

            // Insert into pivot table
            $stmt_pivot = $pdo->prepare("INSERT INTO class_subjects (class_id, subject_id) VALUES (?, ?)");
            foreach ($class_ids as $class_id) {
                $stmt_pivot->execute([intval($class_id), $subject_id]);
            }

            //  Commit transaction
            $pdo->commit();

            $_SESSION['success'] = "Subject added successfully!";
            header("Location: " . route('back'));
            exit();
        } catch (PDOException $e) {
            //  Rollback transaction on error
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
    const subjects = <?= json_encode($subjects, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/admins-section-nav.php') ?>


    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Create Subject</h1>
            <p class="text-xl text-blue-200">Create and manage subjects</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Create New Subject</h2>

                        <form id="subjectFrom" class="space-y-6" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                            <?php include(__DIR__ . '/../../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../../includes/components/form-loader.php'); ?>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Subject name *</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter Subject name">
                                <span class="text-red-500 text-sm hidden" id="nameError"></span>
                            </div>


                            <div>
                                <label for="classes" class="block text-sm font-semibold text-gray-700 mb-2">Classes</label>
                                <span class="text-gray-500 text-sm">Click Here to <a href="<?= route('create-islamiyya-class') ?>" class="text-blue-700 font-bold underline cursor-pointer">Create Class</a></span>

                                <select id="classes" name="classes[]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" multiple>
                                    <option value="">Select Classes</option>
                                    <?php foreach ($classes as $class): ?>

                                        <option value="<?= $class['id'] ?>"><?= $class['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="classesError"></span>

                            </div>
                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Create Subject
                                </button>
                                <button type="reset" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                                    Clear From
                                </button>
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

                    <!-- Statistics -->
                    <!-- 
                    <div class="mt-6 bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">SUbjects Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Total Teachers</span>
                                <span class="text-2xl font-bold text-blue-900" id="totalTeachers"><?= $teachersCount['total'] ?></span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Active</span>
                                <span class="text-2xl font-bold text-green-600" id="activeTeachers"><?= $teachersCount['active'] ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Inactive</span>
                                <span class="text-2xl font-bold text-red-600" id="inactiveTeachers"><?= $teachersCount['inactive'] ?></span>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Subject Table -->

            <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">All Subjects</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-blue-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">classes</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="teachersTableBody" class="divide-y divide-gray-200">
                            <?php if (count($subjects) > 0) : ?>
                                <?php foreach ($subjects as $subject): ?>

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-900"><?= $subject['name'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $subject['class_names'] ?></td>
                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <a href="<?= route('update-islamiyya-subject') . '?id=' . $subject['id'] ?>">
                                                <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            </a>
                                            <a href="<?= route('delete-islamiyya-subject') ?>?id=<?= $subject['id'] ?>">
                                                <button class="text-red-600 hover:text-red-900 font-semibold">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>


                                <tr class="text-center py-8">
                                    <td colspan="6" class="px-6 py-8 text-gray-500">No teacher accounts created yet</td>
                                </tr>
                            <?php endif ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../../includes/footer.php'); ?>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#classes", {
                plugins: ['remove_button'], // allows removing selected items
                placeholder: "Select classes...",
                persist: false,
                create: false,
            });
        });


        // Form validation and submission
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
                showErrorMessage()
            }
        });
    </script>
</body>

</html>