<?php

$title = "Class Update Form";
include(__DIR__ . '/../../../includes/header.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare('SELECT * FROM classes WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $class = $result->fetch_assoc();
        $class_id = $class['id'];
    } else {
        header('Location: ' . route('back'));
        exit;
    }
} else {
    header('Location: ' . route('back'));
    exit;
}

$sections = selectAllData('sections');
$classes = selectAllData('classes', null, $class_id);
$class_arms = selectAllData('class_arms');

$stmt = $conn->prepare("SELECT * FROM class_class_arms WHERE class_id = ?");
$stmt->bind_param('i', $class_id);
$stmt->execute();
$result = $stmt->get_result();
$selected_class_arms = $result->fetch_all(MYSQLI_ASSOC);
$linked_class_arms = array_column($selected_class_arms, 'arm_id');

$name = $section = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $name = htmlspecialchars(trim($_POST['className'] ?? ''), ENT_QUOTES, 'UTF-8');
    $section = htmlspecialchars(trim($_POST['classSection'] ?? ''), ENT_QUOTES, 'UTF-8');
    $id = htmlspecialchars(trim($_POST['classId'] ?? ''), ENT_QUOTES, 'UTF-8');
    $arms = $_POST['classArm'] ?? [];

    if (!is_array($arms)) {
        $arms = [$arms];
    }

    $arms = array_map(
        fn($arm) => htmlspecialchars(trim($arm), ENT_QUOTES, 'UTF-8'),
        $arms
    );

    if (empty($name)) {
        $errors['nameError'] = "Name is required";
    }

    if (empty($section)) {
        $errors['sectionError'] = "Section is required";
    }

    if (empty($arms)) {
        $errors['armError'] = "At least one arm is required";
    }

    if (empty($errors)) {
        $updateStmt = $conn->prepare(
            "UPDATE classes SET name = ?, section_id = ? WHERE id = ?"
        );
        $updateStmt->bind_param('sii', $name, $section, $id);
        if ($updateStmt->execute()) {

            $delStmt = $conn->prepare("DELETE FROM class_class_arms WHERE class_id = ?");
            $delStmt->bind_param('i', $id);
            $delStmt->execute();


            $insert_stmt = $conn->prepare("INSERT INTO class_class_arms (class_id, arm_id) VALUES (?, ?)");
            foreach ($arms as $arm_id) {
                $insert_stmt->bind_param('ii', $id, $arm_id);
                $insert_stmt->execute();
            }
            $_SESSION['success'] = "Class updated successfully!";
            header("Location: " . route('back'));
            exit();
        } else {
            $errors['general'] = "Failed to update subject. Try again.";
        }
        $updateStmt->close();
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}
?>


<script>
    const classes = <?= json_encode($classes, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>


<body class="bg-gray-50">
    <?php include(__DIR__ . '/../includes/admins-section-nav.php') ?>
    <!-- Page Header -->

    <section class="bg-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Class Information</h1>
            <p class="text-xl text-green-200">Modify class details and settings</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Class Details</h2>

                        <form id="updateClassForm" class="space-y-6" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="classId" value="<?= $class['id'] ?>">

                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>



                            <!-- Class Name -->
                            <div>
                                <label for="className" class="block text-sm font-semibold text-gray-700 mb-2">Class Name *</label>
                                <input type="text" id="className" name="className" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., JSS 1A, SSS 3B" value="<?= $class['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="classNameError"></span>
                            </div>

                            <!-- Class Arm -->
                            <div>
                                <label for="classArm" class="block text-sm font-semibold text-gray-700 mb-2">Class Arms *</label>
                                <select id="classArm" name="classArm[]" multiple class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <?php foreach ($class_arms as $arm):
                                        $selected = in_array($arm['id'], $linked_class_arms) ? 'selected' : ''; ?>
                                        <option value="<?= $arm['id'] ?>" <?= $selected ?>><?= $arm['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="classArmError"></span>
                            </div>


                            <!-- Class section -->
                            <div>
                                <label for="classSection" class="block text-sm font-semibold text-gray-700 mb-2">Class Section *</label>
                                <select id="classSection" name="classSection" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="">Select section </option>

                                    <?php foreach ($sections as $section): ?>
                                        <option value="<?= $section['id'] ?>" <?= $class['section_id'] === $section['id'] ? 'selected' : ''; ?>><?= $section['name']; ?></option>
                                    <?php endforeach ?>

                                </select>
                                <span class="text-red-500 text-sm hidden" id="classSectionError"></span>
                            </div>


                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-green-900 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Class
                                </button>
                                <a href="<?= route('back') ?>" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
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


        const updateClassForm = document.getElementById('updateClassForm');

        updateClassForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const className = document.getElementById('className').value.trim();
            const classSection = document.getElementById('classSection').value.trim();
            const classArm = document.getElementById('classArm').value.trim();

            let isValid = true;

            if (!className) {
                document.getElementById('classNameError').textContent = 'Class name is required';
                document.getElementById('classNameError').classList.remove('hidden');
                isValid = false;
            }


            if (classes.some(s => s.name === className)) {
                document.getElementById('classNameError').textContent = 'Class already exists';
                document.getElementById('classNameError').classList.remove('hidden');
                isValid = false;
            }


            if (!classSection) {
                document.getElementById('classSectionError').textContent = 'Class section is required';
                document.getElementById('classSectionError').classList.remove('hidden');
                isValid = false;
            }
            if (!classArm) {
                document.getElementById('classArmError').textContent = 'Class arm is required';
                document.getElementById('classArmError').classList.remove('hidden');
                isValid = false;
            }




            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                updateClassForm.submit();
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