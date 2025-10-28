<?php

$title = "Students Managment";
include(__DIR__ . '/../../includes/header.php');


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>  window.addEventListener('DOMContentLoaded', () => showSuccessMessage());
            </script>";
}

$statement = $connection->prepare("
    SELECT 
        students.id AS id,
        students.name AS name,
        students.admission_number AS admission_number,
        students.status AS status,
        classes.id AS class_id,
        classes.name AS class_name,
        class_arms.name AS class_arm_name
    FROM students
    LEFT JOIN classes ON students.class_id = classes.id
    LEFT JOIN class_arms ON classes.class_arm_id = class_arms.id
");


$statement->execute();
$result = $statement->get_result();
$students = $result->fetch_all(MYSQLI_ASSOC);

$statement = $connection->prepare("SELECT * FROM guardians");
$statement->execute();
$result = $statement->get_result();
$guardians = $result->fetch_all(MYSQLI_ASSOC);

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
    LEFT JOIN teachers 
    ON classes.teacher_id = teachers.id
     LEFT JOIN sections 
    ON classes.section_id = sections.id
     LEFT JOIN class_arms 
    ON classes.class_arm_id = class_arms.id
");
$statement->execute();
$result = $statement->get_result();
$classes = $result->fetch_all(MYSQLI_ASSOC);




// Count total students
$studentsCount =  countDataTotal($connection, 'students', true);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Invalid CSRF token.");
    }

    // Collect and sanitize input
    $name = trim($_POST['fullName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $admissionNumber = trim($_POST['admissionNumber'] ?? '');
    $class = trim($_POST['class'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $guardian = trim($_POST['guardian'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $status = trim($_POST['status'] ?? 'inactive');

    // Initialize error variables
    $errors = [];

    // --- VALIDATION RULES ---

    // Required fields
    if (empty($name)) {
        $errors['name'] = "Full name is required.";
    }

    if (empty($admissionNumber)) {
        $errors['admissionNumber'] = "Admission number is required.";
    }

    if (empty($class)) {
        $errors['class'] = "Please select a class.";
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

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif (strlen($password) < 5) {
        $errors['password'] = "Password must be at least 5 characters long.";
    }

    if ($password !== $confirmPassword) {
        $errors['confirmPassword'] = "Passwords do not match.";
    }

    // Optional fields
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }


    if (!empty($phone) && !preg_match('/^[0-9+\s-]{7,15}$/', $phone)) {
        $errors['phone'] = "Invalid phone number format.";
    }

    // Admission number uniqueness
    $checkAdmission = $connection->prepare("SELECT id FROM students WHERE admission_number = ?");
    $checkAdmission->bind_param("s", $admissionNumber);
    $checkAdmission->execute();
    $checkAdmission->store_result();
    if ($checkAdmission->num_rows > 0) {
        $errors['admissionNumber'] = "Admission number already exists.";
    }
    $checkAdmission->close();

    // Email uniqueness (only if provided)
    if (!empty($email)) {
        $checkEmail = $connection->prepare("SELECT id FROM students WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();
        if ($checkEmail->num_rows > 0) {
            $errors['email'] = "Email already exists.";
        }
        $checkEmail->close();
    }

    // --- FINAL DECISION ---
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $connection->prepare("INSERT INTO students 
            (name, email, phone, admission_number,  dob, gender,  password, status, guardian_id, class_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
        $stmt->bind_param(
            "ssssssssii",
            $name,
            $email,
            $phone,
            $admissionNumber,
            $dob,
            $gender,
            $hashed_password,
            $status,
            $guardian,
            $class,

        );

        if ($stmt->execute()) {
            header("Location: students-management.php?success=1");
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
    <?php include(__DIR__ . '/./includes/users-management-nav.php')  ?>


    <!-- Page Header -->
    <section class="bg-orange-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Student Management</h1>
            <p class="text-xl text-orange-200">Create and manage student accounts</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Create New Student Account</h2>

                        <form id="studentForm" class="space-y-6" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">



                            <!-- Success Message -->
                            <div id="successMessage" class="hidden mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                <span>User is created successfully!</span>
                            </div>


                            <!-- Full Name -->
                            <div>
                                <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" placeholder="Enter full name">
                                <span class="text-red-500 text-sm hidden" id="fullNameError"></span>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address (optional)</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" placeholder="Enter email address">
                                <span class="text-red-500 text-sm hidden" id="emailError"></span>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number (optional)</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="Enter phone number">
                                <span class="text-red-500 text-sm hidden" id="phoneError"></span>
                            </div>


                            <!-- Admission Number -->
                            <div>
                                <label for="admissionNumber" class="block text-sm font-semibold text-gray-700 mb-2">Admission Number *</label>
                                <input type="text" id="admissionNumber" name="admissionNumber" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" placeholder="e.g., EA/2025/001">
                                <span class="text-red-500 text-sm hidden" id="admissionNumberError"></span>
                            </div>

                            <!-- Class -->
                            <div>
                                <label for="class" class="block text-sm font-semibold text-gray-700 mb-2">Class *</label>
                                <select id="class" name="class" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                    <option value="">Select class</option>
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?= $class['class_id'] ?>"><?= $class['class_name'] . $class['arm_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="classError"></span>
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label for="dob" class="block text-sm font-semibold text-gray-700 mb-2">Date of Birth *</label>
                                <input type="date" id="dob" name="dob" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                <span class="text-red-500 text-sm hidden" id="dobError"></span>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">Gender *</label>
                                <select id="gender" name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                    <option value="">Select gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="genderError"></span>
                            </div>

                            <!-- Guardian -->
                            <div>
                                <label for="guardian" class="block text-sm font-semibold text-gray-700 mb-2">Guardian *</label>
                                <select id="guardian" name="guardian" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                    <option value="">Select guardian</option>
                                    <?php foreach ($guardians as $guardian) : ?>
                                        <option value="<?= $guardian['id'] ?>"><?= $guardian['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="guardianError"></span>

                            </div>


                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" placeholder="Enter password">
                                    <button type="button" id="togglePassword" class="absolute right-3 top-2.5 text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div id="passwordStrength" class="mt-2 space-y-1">
                                    <div class="flex gap-1">
                                        <div id="strength1" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                                        <div id="strength2" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                                        <div id="strength3" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                                        <div id="strength4" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                                    </div>
                                    <p id="strengthText" class="text-xs text-gray-600">Password strength: Weak</p>
                                </div>
                                <span class="text-red-500 text-sm hidden" id="passwordError"></span>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="confirmPassword" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password *</label>
                                <input type="password" id="confirmPassword" name="confirmPassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" placeholder="Confirm password">
                                <span class="text-red-500 text-sm hidden" id="confirmPasswordError"></span>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-orange-900 text-white py-3 rounded-lg font-semibold hover:bg-orange-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Create Student Account
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
                                <span>Password must be 5+ characters</span>
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

                    <!-- Statistics -->
                    <div class="mt-6 bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Student Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Total Students</span>
                                <span class="text-2xl font-bold text-orange-900" id="totalStudents"><?= $studentsCount['total'] ?></span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Active</span>
                                <span class="text-2xl font-bold text-green-600" id="activeStudents"><?= $studentsCount['active'] ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Inactive</span>
                                <span class="text-2xl font-bold text-red-600" id="inactiveStudents"><?= $studentsCount['inactive'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">Student Accounts</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-orange-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Admission No.</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Class</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="studentsTableBody" class="divide-y divide-gray-200">

                            <?php if (count($students) > 0): ?>
                                <?php foreach ($students as $student): ?>


                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-900"><?= $student['name'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $student['admission_number'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $student['class_name'] . $student['class_arm_name'] ?></td>

                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-3 py-1 <?= $student['status'] === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900' ?> rounded-full text-xs font-semibold capitalize"><?= $student['status'] ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 font-semibold">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>

                                <tr class="text-center py-8">
                                    <td colspan="6" class="px-6 py-8 text-gray-500">No student accounts created yet</td>
                                </tr>

                            <?php endif ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>


    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Success Message
        function showSuccessMessage() {
            const message = document.getElementById("successMessage");
            if (message) {
                message.classList.remove("hidden"); // show the message
                message.classList.add("flex"); // ensure it displays properly

                // Hide it after 5 seconds
                setTimeout(() => {
                    message.classList.add("hidden");
                    message.classList.remove("flex");
                }, 5000);
            }
        }


        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePassword.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        // Password strength checker
        const passwordField = document.getElementById('password');
        passwordField.addEventListener('input', () => {
            const password = passwordField.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            const strengthLevels = ['Weak', 'Fair', 'Good', 'Strong', 'Very Strong'];
            const strengthColors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500', 'bg-green-600'];

            for (let i = 1; i <= 4; i++) {
                const element = document.getElementById(`strength${i}`);
                if (i <= strength) {
                    element.className = `h-1 w-1/4 ${strengthColors[strength - 1]} rounded`;
                } else {
                    element.className = 'h-1 w-1/4 bg-gray-300 rounded';
                }
            }

            document.getElementById('strengthText').textContent = `Password strength: ${strengthLevels[strength - 1] || 'Weak'}`;
        });

        // Form validation and submission
        const studentForm = document.getElementById('studentForm');

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^\+?234\d{10}$|^\d{11}$/;
            return re.test(phone.replace(/\s/g, ''));
        }


        studentForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const admissionNumber = document.getElementById('admissionNumber').value.trim();
            const studentClass = document.getElementById('class').value;
            const dob = document.getElementById('dob').value;
            const gender = document.getElementById('gender').value;
            const guardian = document.getElementById('guardian').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
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


            if (password.length < 5) {
                document.getElementById('passwordError').textContent = 'Password must be at least 5 characters';
                document.getElementById('passwordError').classList.remove('hidden');
                isValid = false;
            }


            if (password !== confirmPassword) {
                document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                document.getElementById('confirmPasswordError').classList.remove('hidden');
                isValid = false;
            }


            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                studentForm.submit();
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    </script>
</body>

</html>