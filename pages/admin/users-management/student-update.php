<?php

$title = "Students Managment";
include(__DIR__ . '/../../../includes/header.php');


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $statement = $connection->prepare("  SELECT 
        s.*, 
        g.id AS guardian_id, 
        g.name AS guardian_name,

        scr.id as student_class_record_id,
        scr.class_id,
        c.name AS class_name,
        scr.arm_id,
        ca.name AS arm_name,
        scr.term_id,
        t.name AS term_name,
        t.session_id,
        se.name AS session_name,
        se.start_date AS session_start,
        se.end_date AS session_end,
        
        c.section_id,
        sec.name AS section_name,
        
        cca.teacher_id,
        tea.name AS teacher_name

    FROM students s
    LEFT JOIN guardians g ON s.guardian_id = g.id
    LEFT JOIN student_class_records scr ON s.id = scr.student_id AND scr.is_current = 1
    LEFT JOIN classes c ON scr.class_id = c.id
    LEFT JOIN class_arms ca ON scr.arm_id = ca.id
    LEFT JOIN terms t ON scr.term_id = t.id
    LEFT JOIN sessions se ON t.session_id = se.id
    LEFT JOIN sections sec ON c.section_id = sec.id
    LEFT JOIN class_class_arms cca ON cca.class_id = scr.class_id AND cca.arm_id = scr.arm_id
    LEFT JOIN teachers tea ON cca.teacher_id = tea.id
    WHERE s.id = ?
    ");

    $statement->bind_param('i', $id);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        header('Location: ' . route('back'));
        exit;
    }
}



$guardians = selectAllData('guardians');
$students = selectAllData('students', null, $id);

$statement = $connection->prepare(" SELECT 
        classes.id AS class_id,
        classes.name as class_name,
        teachers.id AS teacher_id,
        teachers.name AS teacher_name,
        sections.id as section_id,
        sections.name as section_name,
        class_arms.id as arm_id,
        class_arms.name as arm_name

    FROM classes
     LEFT JOIN class_class_arms 
    ON class_class_arms.class_id = classes.id
    LEFT JOIN teachers 
    ON class_class_arms.teacher_id = teachers.id
     LEFT JOIN sections 
    ON classes.section_id = sections.id
     LEFT JOIN class_arms 
    ON class_class_arms.arm_id = class_arms.id
");
$statement->execute();
$result = $statement->get_result();
$classes = $result->fetch_all(MYSQLI_ASSOC);


$statement = $connection->prepare("SELECT 
        sessions.id as session_id,
        sessions.name as session_name,
        sessions.start_date as session_start_date,
        sessions.end_date as session_end_date,

        terms.id as id,
        terms.name as name,
        terms.start_date as start_date,
        terms.end_date as end_date

    FROM terms
    LEFT JOIN sessions on sessions.id = terms.session_id
");
$statement->execute();
$result = $statement->get_result();
$terms = $result->fetch_all(MYSQLI_ASSOC);


// Count total students
$studentsCount =  countDataTotal('students', true);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token.");
    }

    // Collect and sanitize input
    $id = trim($_POST['id'] ?? '');
    $name = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $admissionNumber = trim($_POST['admissionNumber'] ?? '');
    $class = trim($_POST['class'] ?? '');
    $term = trim($_POST['term'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $guardian = trim($_POST['guardian'] ?? '');
    $status = trim($_POST['status'] ?? 'inactive');


    $errors = [];

    if (empty($name)) {
        $errors['name'] = "Full name is required.";
    }

    if (empty($admissionNumber)) {
        $errors['admissionNumber'] = "Admission number is required.";
    }

    if (empty($class)) {
        $errors['class'] = "Please select a class.";
    } else {
        list($class_id, $arm_id) = explode('|', $class);
    }

    if (empty($term)) {
        $errors['term'] = "Please select a term.";
    }


    if (empty($dob)) {
        $errors['dob'] = "Date of birth is required.";
    }

    if (empty($gender)) {
        $errors['gender'] = "Gender is required.";
    }

    if (empty($guardian)) {
        $errors['guardian'] = "Guardian is required.";
    }


    if (!empty($phone) && !preg_match('/^[0-9+\s-]{7,15}$/', $phone)) {
        $errors['phone'] = "Invalid phone number format.";
    }

    // Admission number uniqueness
    $checkAdmission = $connection->prepare("SELECT id FROM students WHERE admission_number = ? and id != ?");
    $checkAdmission->bind_param("si", $admissionNumber, $id);
    $checkAdmission->execute();
    $checkAdmission->store_result();
    if ($checkAdmission->num_rows > 0) {
        $errors['admissionNumber'] = "Admission number already exists.";
    }
    $checkAdmission->close();


    if (!empty($email)) {
        if (!validateEmail($email)) {
            $errors['emailError '] = 'Please enter a valid email address';
        } elseif (emailExist($email, 'students', $id)) {
            $errors['emailError'] = "Email already exists!";
        }
    }

    // --- FINAL DECISION ---
    if (empty($errors)) {

        $stmt = $connection->prepare("UPDATE students set
           name = ?, email = ?, phone = ?, admission_number = ?,  dob = ?, gender = ?, status = ?, guardian_id = ?  where id = ?");
        $stmt->bind_param(
            "sssssssii",
            $name,
            $email,
            $phone,
            $admissionNumber,
            $dob,
            $gender,
            $status,
            $guardian,
            $id

        );

        if ($stmt->execute()) {
            $statement = $connection->prepare("
        UPDATE student_class_records 
        SET class_id = ?, arm_id = ?, term_id = ? 
        WHERE id = ?
    ");
            $statement->bind_param(
                'iiii',
                $class_id,
                $arm_id,
                $term,
                $student['student_class_record_id']
            );
            $statement->execute();
            $_SESSION['success'] = "Student account updated successfully!";

            header("Location: " . route('back'));
            exit;
        } else {
            echo "<p class='text-red-500'>Error inserting record: " . htmlspecialchars($stmt->error) . "</p>";
        }

        $stmt->close();
    } else {
        // Display all validation errors
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}


?>

<script>
    const students = <?= json_encode($students, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php')  ?>


    <!-- Page Header -->
    <section class="bg-orange-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Student Account</h1>
            <p class="text-xl text-orange-200">Edit student account information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Student Information</h2>

                        <form id="updateStudentForm" class="space-y-6" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="id" value="<?= $student['id'] ?>">


                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>


                            <!-- Full Name -->
                            <div>
                                <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" placeholder="Enter full name" value="<?= $student['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="fullNameError"></span>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address (optional)</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" placeholder="Enter email address" value="<?= $student['phone'] ?>">
                                <span class="text-red-500 text-sm hidden" id="emailError"></span>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number (optional)</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="Enter phone number" value="<?= $student['email'] ?>">
                                <span class="text-red-500 text-sm hidden" id="phoneError"></span>
                            </div>


                            <!-- Admission Number -->
                            <div>
                                <label for="admissionNumber" class="block text-sm font-semibold text-gray-700 mb-2">Admission Number *</label>
                                <input type="text" id="admissionNumber" name="admissionNumber" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" placeholder="e.g., EA/2025/001" value="<?= $student['admission_number'] ?>">
                                <span class="text-red-500 text-sm hidden" id="admissionNumberError"></span>
                            </div>

                            <!-- Class -->
                            <div>
                                <label for="class" class="block text-sm font-semibold text-gray-700 mb-2">Class *</label>
                                <select id="class" name="class" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                    <option value="">Select class</option>
                                    <?php foreach ($classes as $classItem): ?>
                                        <option value="<?= $classItem['class_id'] . '|' . $classItem['arm_id'] ?>"
                                            <?= ($student && $classItem['class_id'] == $student['class_id'] && $classItem['arm_id'] == $student['arm_id']) ? 'selected' : '' ?>>
                                            <?= $classItem['class_name'] . ' ' . $classItem['arm_name'] ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                                <span class="text-red-500 text-sm hidden" id="classError"></span>
                            </div>

                            <!-- Term & Session  -->
                            <div>
                                <label for="term" class="block text-sm font-semibold text-gray-700 mb-2">Term & Session *</label>
                                <select id="term" name="term" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                    <option value="">Select term</option>
                                    <?php foreach ($terms as $termItem): ?>
                                        <option value="<?= $termItem['id'] ?>"
                                            <?= ($student && $termItem['id'] == $student['term_id']) ? 'selected' : '' ?>>
                                            <?= $termItem['name'] . ' ' . $termItem['session_name'] ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                                <span class="text-red-500 text-sm hidden" id="termError"></span>
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="dob" class="block text-sm font-semibold text-gray-700 mb-2">Date of Birth *</label>
                                <input type="date" id="dob" name="dob" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" value="<?= date('Y-m-d', strtotime($student['dob'])) ?>">
                                <span class="text-red-500 text-sm hidden" id="dobError"></span>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">Gender *</label>
                                <select id="gender" name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                    <option value="">Select gender</option>
                                    <option value="male" <?= $student['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                                    <option value="female" <?= $student['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="genderError"></span>
                            </div>

                            <!-- Guardian -->
                            <div>
                                <label for="guardian" class="block text-sm font-semibold text-gray-700 mb-2">Guardian *</label>
                                <select id="guardian" name="guardian" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                    <option value="">Select guardian</option>
                                    <?php foreach ($guardians as $guardian) : ?>
                                        <option value="<?= $guardian['id'] ?>" <?= $guardian['id'] === $student['guardian_id'] ? 'selected' : '' ?>><?= $guardian['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="guardianError"></span>

                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                    <option value="active" <?= $student['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $student['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-orange-900 text-white py-3 rounded-lg font-semibold hover:bg-orange-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Student Account
                                </button>
                                <a href="<?= route('back') ?>" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-orange-50 rounded-lg shadow p-6 border-l-4 border-orange-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-orange-900 mr-2"></i>Student Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Admission number must be unique</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Select appropriate class level</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Modify the details as needed</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Email must be unique</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Guardian email is optional</span>
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
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Form validation and submission
        const updateStudentForm = document.getElementById('updateStudentForm');
        const studentIndex = new URLSearchParams(window.location.search).get('index');

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        updateStudentForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const admissionNumber = document.getElementById('admissionNumber').value.trim();
            const studentClass = document.getElementById('class').value;
            const studentTerm = document.getElementById('term').value;

            const dob = document.getElementById('dob').value;
            const gender = document.getElementById('gender').value;
            const guardian = document.getElementById('guardian').value.trim();
            const status = document.getElementById('status').value;

            let isValid = true;

            if (!fullName) {
                document.getElementById('fullNameError').textContent = 'Full name is required';
                document.getElementById('fullNameError').classList.remove('hidden');
                isValid = false;
            }



            if (email) {
                if (!validateEmail(email)) {
                    document.getElementById('emailError').textContent = 'Please enter a valid email address';
                    document.getElementById('emailError').classList.remove('hidden');
                    isValid = false;
                }



                if (students.some(s => s.email === email)) {
                    document.getElementById('emailError').textContent = 'Email already exists';
                    document.getElementById('emailError').classList.remove('hidden');
                    isValid = false;
                }
            }



            if (phone) {
                if (!validatePhone(phone)) {
                    document.getElementById('phoneError').textContent = 'Please enter a valid phone number';
                    document.getElementById('phoneError').classList.remove('hidden');
                    isValid = false;
                }
            }


            if (!admissionNumber) {
                document.getElementById('admissionNumberError').textContent = 'Admission number is required';
                document.getElementById('admissionNumberError').classList.remove('hidden');
                isValid = false;
            }


            if (students.some(s => s.admissionNumber === admissionNumber)) {
                document.getElementById('admissionNumberError').textContent = 'Admission number already exists';
                document.getElementById('admissionNumberError').classList.remove('hidden');
                isValid = false;
            }



            if (!studentClass) {
                document.getElementById('classError').textContent = 'Please select a class';
                document.getElementById('classError').classList.remove('hidden');
                isValid = false;
            }

            if (!studentTerm) {
                document.getElementById('termError').textContent = 'Please select a term';
                document.getElementById('termError').classList.remove('hidden');
                isValid = false;
            }

            if (!dob) {
                document.getElementById('dobError').textContent = 'Date of birth is required';
                document.getElementById('dobError').classList.remove('hidden');
                isValid = false;
            }


            if (!gender) {
                document.getElementById('genderError').textContent = 'Please select a gender';
                document.getElementById('genderError').classList.remove('hidden');
                isValid = false;
            }


            if (!guardian) {
                document.getElementById('guardianError').textContent = 'Please select a guardian';
                document.getElementById('guardianError').classList.remove('hidden');
                isValid = false;
            }

            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                updateStudentForm.submit();
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