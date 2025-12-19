<?php
$title = "Students Create Form";
include(__DIR__ . '/../../../../includes/header.php');

/* ------------------------------
   AUTHENTICATION CHECKS
------------------------------ */

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

/* ------------------------------
   CSRF TOKEN
------------------------------ */

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* ------------------------------
   CURRENT TERM
------------------------------ */

$stmt = $pdo->prepare("
    SELECT *
    FROM terms
    WHERE deleted_at IS NULL
      AND status = 'ongoing'
    LIMIT 1
");
$stmt->execute();
$current_term = $stmt->fetch(PDO::FETCH_ASSOC);

/* ------------------------------
   LAST ADMISSION NUMBER
------------------------------ */

$stmt = $pdo->prepare("
    SELECT admission_number
    FROM students
    WHERE deleted_at IS NULL
    ORDER BY id DESC
    LIMIT 1
");
$stmt->execute();
$lastAdmissionNumberRow = $stmt->fetch(PDO::FETCH_ASSOC);

$lastAdmissionNumber = $lastAdmissionNumberRow
    ? $lastAdmissionNumberRow['admission_number']
    : 'No student account exists.';

/* ------------------------------
   STUDENTS LIST
------------------------------ */

$stmt = $pdo->prepare("
    SELECT 
        s.id,
        s.name,
        s.admission_number,
        s.status,
        c.id AS class_id,
        c.name AS class_name,
        a.name AS class_arm_name
    FROM students s
    LEFT JOIN classes c ON s.class_id = c.id
    LEFT JOIN class_arms a ON s.arm_id = a.id
    WHERE s.deleted_at IS NULL
    ORDER BY s.name ASC
");
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ------------------------------
   ACTIVE GUARDIANS
------------------------------ */

$guardians = selectAllData('guardians', true);

/* ------------------------------
   FETCH CLASSES
------------------------------ */

$stmt = $pdo->prepare("
    SELECT 
        c.id AS class_id,
        c.name AS class_name,
        c.level AS level,
        t.id AS teacher_id,
        t.name AS teacher_name,
        s.id AS section_id,
        s.name AS section_name,
        a.id AS arm_id,
        a.name AS arm_name
    FROM classes c
    LEFT JOIN class_class_arms cca ON cca.class_id = c.id
    LEFT JOIN teachers t ON cca.teacher_id = t.id
    LEFT JOIN sections s ON c.section_id = s.id
    LEFT JOIN class_arms a ON cca.arm_id = a.id
    WHERE c.deleted_at IS NULL
      AND a.deleted_at IS NULL
      AND s.deleted_at IS NULL
    ORDER BY c.level, a.name
");
$stmt->execute();
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ------------------------------
   FETCH ISLAMIYYA CLASSES
------------------------------ */

$stmt = $pdo->prepare("
    SELECT 
        ic.id AS class_id,
        ic.name AS class_name,
        ic.level AS level,
        t.id AS teacher_id,
        t.name AS teacher_name,
        isec.id AS section_id,
        isec.name AS section_name,
        ia.id AS arm_id,
        ia.name AS arm_name
    FROM islamiyya_classes ic
    LEFT JOIN islamiyya_class_class_arms icca ON icca.class_id = ic.id
    LEFT JOIN teachers t ON icca.teacher_id = t.id
    LEFT JOIN islamiyya_sections isec ON ic.section_id = isec.id
    LEFT JOIN islamiyya_class_arms ia ON icca.arm_id = ia.id
    WHERE ic.deleted_at IS NULL
      AND ia.deleted_at IS NULL
      AND isec.deleted_at IS NULL
    ORDER BY ic.level, ia.name
");
$stmt->execute();
$islamiyya_classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ------------------------------
   TERMS & SESSIONS (ACTIVE ONLY)
------------------------------ */

$terms    = selectAllData('terms', true);
$sessions = selectAllData('sessions', true);

/* ------------------------------
   STUDENT COUNT
------------------------------ */

$studentsCount = countDataTotal('students', true)['total'];


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        /* ------------------------------
       CSRF VALIDATION
    ------------------------------ */
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Invalid CSRF token.");
        }

        // Regenerate CSRF token after successful validation
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        /* ------------------------------
       COLLECT & SANITIZE INPUT
    ------------------------------ */

        $name            = trim($_POST['fullName'] ?? '');
        $email           = trim($_POST['email'] ?? '');
        $phone           = trim($_POST['phone'] ?? '');
        $admissionNumber = trim($_POST['admissionNumber'] ?? '');
        $class           = trim($_POST['class'] ?? '');
        $term            = trim($_POST['term'] ?? '');
        $session         = trim($_POST['session'] ?? '');
        $dob             = trim($_POST['dob'] ?? '');
        $gender          = trim($_POST['gender'] ?? '');
        $guardian        = trim($_POST['guardian'] ?? '');
        $password        = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';
        $status          = trim($_POST['status'] ?? 'inactive');
        $islamiyyaClass  = trim($_POST['islamiyyaClass'] ?? '');

        // Normalize / sanitize for DB
        $name            = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
        $phone           = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
        $admissionNumber = htmlspecialchars($admissionNumber, ENT_QUOTES, 'UTF-8');
        $status          = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');

        $errors = [];

        /* ------------------------------
       PARSE CLASS & ISLAMIYYA CLASS
    ------------------------------ */

        $class_id = $arm_id = null;
        if (!empty($class)) {
            $parts = explode('|', $class);
            if (count($parts) === 2) {
                $class_id = (int) $parts[0];
                $arm_id   = (int) $parts[1];
            } else {
                $errors['class'] = "Invalid class selection.";
            }
        }

        $islamiyya_class_id = $islamiyya_arm_id = null;
        if (!empty($islamiyyaClass)) {
            $parts = explode('|', $islamiyyaClass);
            if (count($parts) === 2) {
                $islamiyya_class_id = (int) $parts[0];
                $islamiyya_arm_id   = (int) $parts[1];
            } else {
                $errors['islamiyyaClass'] = "Invalid Islamiyya class selection.";
            }
        }

        $term_id    = (int) $term;
        $session_id = (int) $session;
        $guardian_id = (int) $guardian;

        /* ------------------------------
       VALIDATION RULES
    ------------------------------ */

        if ($name === '') {
            $errors['name'] = "Full name is required.";
        }

        if ($admissionNumber === '') {
            $errors['admissionNumber'] = "Admission number is required.";
        }

        if (empty($class_id) && empty($islamiyya_class_id)) {
            $errors['class'] = "Please select either a General Studies class or an Islamiyya class.";
        }

        if (empty($term_id)) {
            $errors['term'] = "Please select a term.";
        }

        if (empty($session_id)) {
            $errors['session'] = "Please select a session.";
        }

        if ($dob === '') {
            $errors['dob'] = "Date of birth is required.";
        } else {
            $dobObj = DateTime::createFromFormat('Y-m-d', $dob);
            $dobErrors = DateTime::getLastErrors();
            if (!$dobObj || !empty($dobErrors['warning_count']) || !empty($dobErrors['error_count'])) {
                $errors['dob'] = "Invalid date of birth format.";
            }
        }

        if ($gender === '') {
            $errors['gender'] = "Gender is required.";
        }

        if (empty($guardian_id)) {
            $errors['guardian'] = "Guardian is required.";
        }

        // Password rules
        if ($password !== '') {
            if (strlen($password) < 8) {
                $errors['password'] = "Password must be at least 8 characters long.";
            }
            if ($password !== $confirmPassword) {
                $errors['confirmPassword'] = "Passwords do not match.";
            }
        } else {
            // Default password = admission number
            if ($admissionNumber === '') {
                $errors['password'] = "Password or admission number is required to generate a default password.";
            } else {
                $password = $admissionNumber;
            }
        }

        // Email format & uniqueness
        if ($email !== '') {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !validateEmail($email)) {
                $errors['email'] = "Please enter a valid email address.";
            } elseif (emailExist($email, 'students', null)) { // true = ignore soft-deleted
                $errors['email'] = "Email already exists.";
            }
        }

        // Phone format
        if ($phone !== '' && !preg_match('/^[0-9+\s-]{7,15}$/', $phone)) {
            $errors['phone'] = "Invalid phone number format.";
        }

        // Admission number uniqueness (ignore soft-deleted)
        if ($admissionNumber !== '') {
            $stmt = $pdo->prepare("
            SELECT id 
            FROM students 
            WHERE admission_number = ? AND deleted_at IS NULL
        ");
            $stmt->execute([$admissionNumber]);
            if ($stmt->fetch()) {
                $errors['admissionNumber'] = "Admission number already exists.";
            }
        }

        // Validate foreign keys exist and are active (term, session, guardian, classes)
        if (empty($errors)) {
            // Term
            $stmt = $pdo->prepare("SELECT id FROM terms WHERE id = ? AND deleted_at IS NULL");
            $stmt->execute([$term_id]);
            if (!$stmt->fetch()) {
                $errors['term'] = "Selected term is invalid.";
            }

            // Session
            $stmt = $pdo->prepare("SELECT id FROM sessions WHERE id = ? AND deleted_at IS NULL");
            $stmt->execute([$session_id]);
            if (!$stmt->fetch()) {
                $errors['session'] = "Selected session is invalid.";
            }

            // Guardian
            $stmt = $pdo->prepare("SELECT id FROM guardians WHERE id = ? AND deleted_at IS NULL");
            $stmt->execute([$guardian_id]);
            if (!$stmt->fetch()) {
                $errors['guardian'] = "Selected guardian is invalid.";
            }

            // General class & arm
            if (!empty($class_id) && !empty($arm_id)) {
                $stmt = $pdo->prepare("
                SELECT c.id 
                FROM classes c
                WHERE c.id = ? AND c.deleted_at IS NULL
            ");
                $stmt->execute([$class_id]);
                if (!$stmt->fetch()) {
                    $errors['class'] = "Selected class is invalid.";
                }

                $stmt = $pdo->prepare("
                SELECT ca.id 
                FROM class_arms ca
                WHERE ca.id = ? AND ca.deleted_at IS NULL
            ");
                $stmt->execute([$arm_id]);
                if (!$stmt->fetch()) {
                    $errors['class'] = "Selected class arm is invalid.";
                }
            }

            // Islamiyya class & arm
            if (!empty($islamiyya_class_id) && !empty($islamiyya_arm_id)) {
                $stmt = $pdo->prepare("
                SELECT ic.id 
                FROM islamiyya_classes ic
                WHERE ic.id = ? AND ic.deleted_at IS NULL
            ");
                $stmt->execute([$islamiyya_class_id]);
                if (!$stmt->fetch()) {
                    $errors['islamiyyaClass'] = "Selected Islamiyya class is invalid.";
                }

                $stmt = $pdo->prepare("
                SELECT ia.id 
                FROM islamiyya_class_arms ia
                WHERE ia.id = ? AND ia.deleted_at IS NULL
            ");
                $stmt->execute([$islamiyya_arm_id]);
                if (!$stmt->fetch()) {
                    $errors['islamiyyaClass'] = "Selected Islamiyya class arm is invalid.";
                }
            }
        }

        /* ------------------------------
       FINAL DECISION
    ------------------------------ */

        if (empty($errors)) {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            try {
                $pdo->beginTransaction();

                // Insert student
                $stmt = $pdo->prepare("
                INSERT INTO students 
                    (name, email, phone, admission_number, dob, gender, password, status, 
                     class_id, arm_id, term_id, guardian_id, islamiyya_class_id, islamiyya_arm_id,
                     session_id, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");

                $stmt->execute([
                    $name,
                    $email ?: null,
                    $phone ?: null,
                    $admissionNumber,
                    $dob,
                    $gender,
                    $hashed_password,
                    $status,
                    $class_id,
                    $arm_id,
                    $term_id,
                    $guardian_id,
                    $islamiyya_class_id,
                    $islamiyya_arm_id,
                    $session_id
                ]);

                $student_id = (int) $pdo->lastInsertId();

                // General class records
                if (!empty($class_id) && !empty($arm_id)) {
                    $stmt2 = $pdo->prepare("
                    INSERT INTO student_class_records (student_id, class_id, arm_id, session_id, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, NOW(), NOW())
                ");
                    $stmt2->execute([$student_id, $class_id, $arm_id, $session_id]);
                    $student_class_record_id = (int) $pdo->lastInsertId();

                    $stmt3 = $pdo->prepare("
                    INSERT INTO student_term_records (student_class_record_id, term_id, created_at, updated_at) 
                    VALUES (?, ?, NOW(), NOW())
                ");
                    $stmt3->execute([$student_class_record_id, $term_id]);
                }

                // Islamiyya class records
                if (!empty($islamiyya_class_id) && !empty($islamiyya_arm_id)) {
                    $stmtIslamiyya = $pdo->prepare("
                    INSERT INTO islamiyya_student_class_records (student_id, class_id, arm_id, session_id, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, NOW(), NOW())
                ");
                    $stmtIslamiyya->execute([$student_id, $islamiyya_class_id, $islamiyya_arm_id, $session_id]);
                    $islamiyya_class_record_id = (int) $pdo->lastInsertId();

                    $stmtIslamiyyaTerm = $pdo->prepare("
                    INSERT INTO islamiyya_student_term_records (student_class_record_id, term_id, created_at, updated_at) 
                    VALUES (?, ? , NOW(), NOW())
                ");
                    $stmtIslamiyyaTerm->execute([$islamiyya_class_record_id, $term_id]);
                }

                $pdo->commit();

                $_SESSION['success'] = "Student account created successfully!";
                header("Location: " . route('back'));
                exit();
            } catch (PDOException $e) {
                $pdo->rollBack();
                echo "<p class='text-red-500'>Error inserting record: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
            }
        } else {
            foreach ($errors as $field => $error) {
                echo "<p class='text-red-600 font-semibold'>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</p>";
            }
        }
    }

    ?>


<script>
    const students = <?= json_encode($students, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/../../includes/admins-section-nav.php')  ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-orange-900 to-orange-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Create Student Account</h1>
            <p class="text-xl text-orange-200">Create student accounts</p>
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

                            <?php include(__DIR__ . '/../../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../../includes/components/form-loader.php'); ?>


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
                                <span class="text-gray-500 text-sm">Last Admission Number Given: <span class="font-bold"><?= $lastAdmissionNumber ?></span></span>
                                <input type="text" id="admissionNumber" name="admissionNumber" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900" placeholder="e.g., EA/2025/001">
                                <span class="text-red-500 text-sm hidden" id="admissionNumberError"></span>
                            </div>

                            <!-- Class -->
                            <div class="flex gap-4 pt-4 w-full justify-center">
                                <div class="flex-1 max-w-md">
                                    <label for="class" class="block text-sm font-semibold text-gray-700 mb-2">General Studies Class *</label>
                                    <span class="text-gray-500 text-sm">Click Here to <a href="<?= route('create-class') ?>" class="text-blue-700 font-bold underline cursor-pointer">Create Class</a></span>

                                    <select id="class" name="class" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                        <option value="">Select class</option>
                                        <?php foreach ($classes as $class): ?>
                                            <option value="<?= $class['class_id']  . '|' . $class['arm_id'] ?>"><?= $class['class_name'] . $class['arm_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="text-red-500 text-sm hidden" id="classError"></span>
                                </div>

                                <div class="flex-1 max-w-md">
                                    <label for="islamiyyaClass" class="block text-sm font-semibold text-gray-700 mb-2">Islamiyya Class *</label>
                                    <span class="text-gray-500 text-sm">Click Here to <a href="<?= route('create-islamiyya-class') ?>" class="text-blue-700 font-bold underline cursor-pointer">Create Islamiyya Class</a></span>

                                    <select id="islamiyyaClass" name="islamiyyaClass" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                        <option value="">Select class</option>
                                        <?php foreach ($islamiyya_classes as $class): ?>
                                            <option value="<?= $class['class_id']  . '|' . $class['arm_id'] ?>"><?= $class['class_name'] . ' ' . $class['arm_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="text-red-500 text-sm hidden" id="islamiyyaClassError"></span>
                                </div>
                            </div>


                            <!-- Term & Session -->
                            <div class="flex gap-4 pt-4 w-full justify-center">
                                <!-- session -->
                                <div class="flex-1 max-w-md">
                                    <label for="session" class="block text-sm font-semibold text-gray-700 mb-2">Session *</label>
                                    <span class="text-gray-500 text-sm">Click Here to <a href="<?= route('create-session') ?>" class="text-blue-700 font-bold underline cursor-pointer">Create Session</a></span>

                                    <select id="session" name="session" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                        <option value="">Select session</option>
                                        <?php foreach ($sessions as $session): ?>
                                            <option value="<?= $session['id'] ?>">
                                                <?= $session['name'] ?>
                                                <?= $current_term['session_id'] === $session['id'] ? "(Current)" : '' ?></option>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="text-red-500 text-sm hidden" id="sessionError"></span>
                                </div>

                                <!-- term -->
                                <div class="flex-1 max-w-md">
                                    <label for="term" class="block text-sm font-semibold text-gray-700 mb-2">Term *</label>
                                    <span class="text-gray-500 text-sm">Click Here to <a href="<?= route('term-session-management') ?>" class="text-blue-700 font-bold underline cursor-pointer">Create Term</a></span>

                                    <select id="term" name="term" disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                        <option value="">Select term</option>
                                        <?php foreach ($terms as $term): ?>
                                            <option value="<?= $term['id'] ?>" data-session="<?= $term['session_id'] ?>">
                                                <?= $term['name'] ?>
                                                <?= $current_term['id'] === $term['id'] ? "(Current)" : '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="text-red-500 text-sm hidden" id="termError"></span>
                                </div>


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
                                <span class="text-gray-500 text-sm">Click Here to <a href="<?= route('guardian-create') ?>" class="text-blue-700 font-bold underline cursor-pointer">Create Guardian account</a></span>
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
                                <span class="text-gray-500 text-sm">Leave blank to use admission number as the default password. It can be changed later.</span>

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
                                            <a href="<?= route('student-update') . '?id=' . $student['id'] ?>">
                                                <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            </a>
                                            <a href="<?= route('delete-user') . '?id=' . $student['id'] ?>&table=students&type=Student">
                                                <button class="text-red-600 hover:text-red-900 font-semibold">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </a>
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
    <?php include(__DIR__ . '/../../../../includes/footer.php'); ?>


    <script>
        // Term selection after session 
        const sessionSelect = document.getElementById('session');
        const termSelect = document.getElementById('term');

        sessionSelect.addEventListener('change', function() {
            const selectedSessionId = this.value;
            const allTerms = termSelect.querySelectorAll('option');

            if (selectedSessionId === '') {
                // No session selected → disable term dropdown
                termSelect.disabled = true;
                termSelect.value = '';
                return;
            }

            // Enable term dropdown
            termSelect.disabled = false;

            // Filter terms
            allTerms.forEach(termOption => {
                const sessionId = termOption.getAttribute('data-session');
                if (!sessionId) return; // skip the first "Select term" option

                if (sessionId === selectedSessionId) {
                    termOption.style.display = ''; // show
                } else {
                    termOption.style.display = 'none'; // hide
                }
            });

            // Reset term selection
            termSelect.value = '';
        });


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
            const islamiyyaClass = document.getElementById('islamiyyaClass').value;
            const studentTerm = document.getElementById('term').value;
            const studentSession = document.getElementById('session').value;
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


            if (students.some(s => s.admission_number === admissionNumber)) {
                document.getElementById('admissionNumberError').textContent = 'Admission number already exists';
                document.getElementById('admissionNumberError').classList.remove('hidden');
                isValid = false;
            }

            islamiyyaClass

            if (!studentClass) {
                document.getElementById('classError').textContent = 'Please select a class';
                document.getElementById('classError').classList.remove('hidden');
                isValid = false;
            }
            if (!islamiyyaClass) {
                document.getElementById('islamiyyaClassError').textContent = 'Please select a islamiyya class';
                document.getElementById('islamiyyaClassError').classList.remove('hidden');
                isValid = false;
            }

            if (!studentSession) {
                document.getElementById('sessionError').textContent = 'Please select a session';
                document.getElementById('sessionError').classList.remove('hidden');
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

            if (password) {
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
            }

            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                studentForm.submit();
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