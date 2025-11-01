<?php

$title = "Classe Update Form";
include(__DIR__ . '/../../../includes/header.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SERVER['HTTP_REFERER'])) {
    $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'];
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $statement = $connection->prepare('SELECT * FROM classes WHERE id=?');
    $statement->bind_param('i', $id);
    $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows > 0) {
        $class = $result->fetch_assoc();
    } else {
        header('Location: ' . $_SESSION['previous_page']);
    }
} else {
    header('Location: ' . $_SESSION['previous_page']);
}

$statement = $connection->prepare("SELECT * FROM sections");
$statement->execute();
$result = $statement->get_result();
$sections = $result->fetch_all(MYSQLI_ASSOC);

$statement = $connection->prepare("SELECT * FROM teachers");
$statement->execute();
$result = $statement->get_result();
$teachers = $result->fetch_all(MYSQLI_ASSOC);

$statement = $connection->prepare("SELECT * FROM class_arms");
$statement->execute();
$result = $statement->get_result();
$class_arms = $result->fetch_all(MYSQLI_ASSOC);


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
    $teacher = htmlspecialchars(trim($_POST['classTeacher'] ?? ''), ENT_QUOTES, 'UTF-8');
    $arm = htmlspecialchars(trim($_POST['classArm'] ?? ''), ENT_QUOTES, 'UTF-8');
    $id = htmlspecialchars(trim($_POST['classId'] ?? ''), ENT_QUOTES, 'UTF-8');


    if (empty($name)) {
        $nameError = "Name is required";
    }

    if (empty($section)) {
        $sectionError = "Section is required";
    }

    if (empty($teacher)) {
        $teacherError = "Teacher is required";
    }

    if (empty($arm)) {
        $armError = "Arm is required";
    }


    if (empty($nameError)  && empty($sectionError) && empty($teacherError) && empty($armError)) {
        $statement = $connection->prepare(
            "UPDATE classes SET name = ?, section_id = ?, teacher_id = ?, class_arm_id = ? WHERE id = ?"
        );
        $statement->bind_param('siiii', $name, $section, $teacher, $arm, $id);

        if ($statement->execute()) {
            header("Location: " . $_SESSION['previous_page']);
            exit();
        } else {
            echo "<script>alert('Failed to create section : " . $statement->error . "');</script>";
        }
    } else {
        echo "<script>alert('Failed to create section : ' . '<br>' .$nameError . '<br>' .$teacherError. '<br>' .$sectionError. '<br>'. $armError ');</script>";
    }
}


?>

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


                            <!-- Class Name -->
                            <div>
                                <label for="className" class="block text-sm font-semibold text-gray-700 mb-2">Class Name *</label>
                                <input type="text" id="className" name="className" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., JSS 1A, SSS 3B" value="<?= $class['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="classNameError"></span>
                            </div>

                            <!-- Class Arm -->
                            <div>
                                <label for="classArm" class="block text-sm font-semibold text-gray-700 mb-2">Class Arm</label>
                                <select id="classArm" name="classArm" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="">Select class arm</option>
                                    <?php foreach ($class_arms as $arm): ?>
                                        <option value="<?= $arm['id'] ?>" <?= $class['class_arm_id'] === $arm['id'] ? 'selected' : ''; ?>><?= $arm['name'] ?></option>
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
                                        <option value="<?= $section['id'] ?>" <?= $class['section_id'] === $section['id'] ? 'selected' : ''; ?>><?= $section['name']; ?></option>
                                    <?php endforeach ?>

                                </select>
                                <span class="text-red-500 text-sm hidden" id="classSectionError"></span>
                            </div>

                            <!-- Class Teacher -->

                            <div>
                                <label for="classTeacher" class="block text-sm font-semibold text-gray-700 mb-2">Class Teacher *</label>
                                <select id="classTeacher" name="classTeacher" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="">Select class teacher </option>

                                    <?php foreach ($teachers as $teacher): ?>
                                        <option value="<?= $teacher['id'] ?>" <?= $class['teacher_id'] === $teacher['id'] ? 'selected' : ''; ?>><?= $teacher['name']; ?></option>
                                    <?php endforeach ?>

                                </select>
                                <span class="text-red-500 text-sm hidden" id="classTeacherError"></span>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-green-900 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Class
                                </button>
                                <a href="<?= $_SESSION['previous_page'] ?>" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                    <i class="fas fa-arrow-left mr-2"></i>Back
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
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });


        const updateClassForm = document.getElementById('updateClassForm');

        updateClassForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const className = document.getElementById('className').value.trim();
            const classSection = document.getElementById('classSection').value.trim();
            const classTeacher = document.getElementById('classTeacher').value.trim();
            const classArm = document.getElementById('classArm').value.trim();

            let isValid = true;

            if (!className) {
                document.getElementById('classNameError').textContent = 'Class name is required';
                document.getElementById('classNameError').classList.remove('hidden');
                isValid = false;
            }

            if (!classSection) {
                document.getElementById('classSectionError').textContent = 'Class section is required';
                document.getElementById('classSectionError').classList.remove('hidden');
                isValid = false;
            }

            if (!classTeacher) {
                document.getElementById('classTeacherError').textContent = 'Class teacher is required';
                document.getElementById('classTeacherError').classList.remove('hidden');
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