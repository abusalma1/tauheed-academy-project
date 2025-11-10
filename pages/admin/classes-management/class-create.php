<?php

$title = "Class Creation";
include(__DIR__ . '/../../../includes/header.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


$statement = $connection->prepare("
    SELECT 
        classes.id AS id,
        classes.name AS name,
        sections.name AS section_name,
        GROUP_CONCAT(class_arms.name SEPARATOR ', ') AS arm_names
    FROM classes
    LEFT JOIN class_class_arms ON classes.id = class_class_arms.class_id
    LEFT JOIN sections ON classes.section_id = sections.id
    LEFT JOIN class_arms ON class_class_arms.arm_id = class_arms.id
    GROUP BY classes.id
");
$statement->execute();
$result = $statement->get_result();
$classes = $result->fetch_all(MYSQLI_ASSOC);


$sections = selectAllData('sections');
$class_arms = selectAllData('class_arms');



$studentsCount  = countDataTotal('students')['total'];
$classesCount = countDataTotal('classes')['total'];

$errors  = [];

$name = $section = $teacher = $arm =  '';
$nameError = $sectionError = $teacherError = $armError =  '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $name = htmlspecialchars(trim($_POST['className'] ?? ''), ENT_QUOTES, 'UTF-8');
    $section = htmlspecialchars(trim($_POST['classSection'] ?? ''), ENT_QUOTES);
    $arms = $_POST['classArm'] ?? [];


    if (!is_array($arms)) {
        $arms = [$arms];
    }

    $arms = array_map(
        function ($arm) {
            return htmlspecialchars(trim($arm), ENT_QUOTES, 'UTF-8');
        },
        $arms
    );



    if (empty($name)) {
        $errors['nameError'] = "Name is required";
    }

    if (empty($section)) {
        $errors['sectionError'] = "Section is required";
    }

    if (empty($arms)) {
        $errors['armError'] = "Arm is required";
    }


    if (empty($errors)) {
        $statement = $connection->prepare(
            "INSERT INTO classes (name, section_id) VALUES (?, ?)"
        );
        $statement->bind_param('si', $name, $section);

        if ($statement->execute()) {
            $class_id = $statement->insert_id;
            $statement->close();

            $pivot_query = "INSERT INTO class_class_arms (arm_id, class_id) VALUES (?, ?)";
            $statement_pivot = $connection->prepare($pivot_query);

            foreach ($arms as $arm_id) {
                $statement_pivot->bind_param('ii', $arm_id, $class_id);
                $statement_pivot->execute();
            }
            $_SESSION['success'] = "Class created successfully!";
            header("Location: " .  route('back'));
            exit();
        } else {
            echo "<script>alert('Failed to create section : " . $statement->error . "');</script>";
        }
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
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Class Management</h1>
            <p class="text-xl text-green-200">Create, update, and manage school classes</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Add New Class</h2>

                        <form id="classForm" class="space-y-6" method="post">

                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>



                            <!-- Class Name -->
                            <div>
                                <label for="className" class="block text-sm font-semibold text-gray-700 mb-2">Class Name *</label>
                                <input type="text" id="className" name="className" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., JSS 1A, SSS 3B">
                                <span class="text-red-500 text-sm hidden" id="classNameError"></span>
                            </div>

                            <!-- Class Arm -->
                            <div>
                                <label for="classArm" class="block text-sm font-semibold text-gray-700 mb-2">Class Arm</label>
                                <select id="classArm" name="classArm[]" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" multiple>
                                    <option value="">Select class arm</option>
                                    <?php foreach ($class_arms as $arm): ?>
                                        <option value="<?= $arm['id'] ?>"><?= $arm['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="classArmError"></span>

                            </div>


                            <!-- Class section -->
                            <div>
                                <label for="classSection" class="block text-sm font-semibold text-gray-700 mb-2">Class Section *</label>
                                <select id="classSection" name="classSection" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="">Select section </option>

                                    <?php foreach ($sections as $section): ?>
                                        <option value="<?= $section['id'] ?>"><?= $section['name']; ?></option>
                                    <?php endforeach ?>

                                </select>
                                <span class="text-red-500 text-sm hidden" id="classSectionError"></span>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-green-900 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Add Class
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
                            <i class="fas fa-info-circle text-green-900 mr-2"></i>Class Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Class name must be unique</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Statistics -->
                    <div class="mt-6 bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Class Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Total Classes</span>
                                <span class="text-2xl font-bold text-green-900" id="totalClasses"><?= $classesCount; ?></span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Students</span>
                                <span class="text-2xl font-bold text-blue-600" id="totalStudents"><?= $studentsCount; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Classes Table -->
            <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">All Classes</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-green-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Class Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Arms</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Section</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="classesTableBody" class="divide-y divide-gray-200">
                            <?php if (count($classes) > 0): ?>
                                <?php foreach ($classes as $class): ?>

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900"> <?= $class['name'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $class['arm_names'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $class['section_name'] ?></td>

                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <a href="<?= route('update-class'); ?>?id=<?= $class['id'] ?>">
                                                <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            </a>
                                            <button class="text-red-600 hover:text-red-900 font-semibold">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>

                                <tr class="text-center py-8">
                                    <td colspan="7" class="px-6 py-8 text-gray-500">No classes created yet</td>
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
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#classArm", {
                plugins: ['remove_button'], // allows removing selected items
                placeholder: "Select class arms...",
                persist: false,
                create: false,
            });
        });

        // Form validation and submission
        const classForm = document.getElementById('classForm');


        classForm.addEventListener('submit', (e) => {
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
                classForm.submit();
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