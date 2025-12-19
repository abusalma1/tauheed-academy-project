<?php

$title = 'Update Guardian Account';
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
   FETCH GUARDIAN TO UPDATE
------------------------------ */

if (!isset($_GET['id'])) {
    header('Location: ' . route('back'));
    exit();
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT *
    FROM guardians
    WHERE id = ? AND deleted_at IS NULL
");
$stmt->execute([$id]);
$guardian = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$guardian) {
    $_SESSION['failure'] = "Guardian not found!";
    header('Location: ' . route('back'));
    exit();
}

/* ------------------------------
   FORM PROCESSING
------------------------------ */

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ------------------------------
       CSRF VALIDATION
    ------------------------------ */
    if (
        !isset($_POST['csrf_token']) ||
        !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    // Regenerate token after validation
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    /* ------------------------------
       SANITIZE INPUT
    ------------------------------ */
    $id           = (int) ($_POST['id'] ?? 0);
    $name         = htmlspecialchars(trim($_POST['fullName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email        = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone        = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8');
    $address      = htmlspecialchars(trim($_POST['address'] ?? ''), ENT_QUOTES, 'UTF-8');
    $relationship = htmlspecialchars(trim($_POST['relationship'] ?? ''), ENT_QUOTES, 'UTF-8');
    $occupation   = htmlspecialchars(trim($_POST['occupation'] ?? ''), ENT_QUOTES, 'UTF-8');
    $status       = htmlspecialchars(trim($_POST['status'] ?? 'inactive'), ENT_QUOTES, 'UTF-8');
    $gender       = trim($_POST['gender'] ?? '');

    /* ------------------------------
       VALIDATION
    ------------------------------ */

    if ($name === '') {
        $errors['nameError'] = 'Full name is required';
    }

    if ($email === '') {
        $errors['emailError'] = 'Email is required';
    } elseif (!validateEmail($email)) {
        $errors['emailError'] = 'Please enter a valid email address';
    } elseif (emailExist($email, 'guardians', $id)) { // true = ignore soft-deleted
        $errors['emailError'] = "Email already exists!";
    }

    if ($phone === '') {
        $errors['phoneError'] = 'Phone number is required';
    }

    if ($gender === '') {
        $errors['genderError'] = "Gender is required.";
    }

    if ($relationship === '') {
        $errors['relationshipError'] = 'Relationship is required';
    }

    if ($status === '') {
        $errors['statusError'] = "Status is required";
    }

    /* ------------------------------
       UPDATE GUARDIAN
    ------------------------------ */

    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                UPDATE guardians 
                SET name = ?, email = ?, phone = ?, occupation = ?, address = ?, 
                    relationship = ?, status = ?, gender = ?, updated_at = NOW()
                WHERE id = ? AND deleted_at IS NULL
            ");

            $success = $stmt->execute([
                $name,
                $email,
                $phone,
                $occupation,
                $address,
                $relationship,
                $status,
                $gender,
                $id
            ]);

            if ($success) {
                $pdo->commit();
                $_SESSION['success'] = "Guardian account updated successfully!";
                header("Location: " . route('back'));
                exit();
            }

            $pdo->rollBack();
            echo "<script>alert('Failed to update guardian account');</script>";
        } catch (PDOException $e) {
            $pdo->rollBack();
            echo "<script>alert('Database error: " . htmlspecialchars($e->getMessage()) . "');</script>";
        }
    }

    /* ------------------------------
       DISPLAY ERRORS
    ------------------------------ */
    foreach ($errors as $error) {
        echo "<p class='text-red-600 font-semibold'>{$error}</p>";
    }
}

?>



<script>
    const guardians = <?= json_encode($guardians, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>



<body class="bg-gray-50">
    <?php include(__DIR__ . '/../../includes/admins-section-nav.php')  ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-green-900 to-green-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Guardian Account</h1>
            <p class="text-xl text-green-200">Edit guardian account information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Guardian Information</h2>

                        <form id="updateGuardianForm" class="space-y-6" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="id" value="<?= $guardian['id'] ?>">



                            <?php include(__DIR__ . '/../../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../../includes/components/form-loader.php'); ?>




                            <!-- Full Name -->
                            <div>
                                <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter full name" value="<?= $guardian['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="fullNameError"></span>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter email address" value="<?= $guardian['email'] ?>">
                                <span class="text-red-500 text-sm hidden" id="emailError"></span>
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-semibold text-gray-700 mb-2">Gender *</label>
                                <select id="gender" name="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-900">
                                    <option value="">Select gender</option>
                                    <option value="male" <?= $guardian['gender'] === 'male' ? 'selected'  : '' ?>>Male</option>
                                    <option value="female" <?= $guardian['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="genderError"></span>
                            </div>


                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter phone number" value="<?= $guardian['phone'] ?>">
                                <span class="text-red-500 text-sm hidden" id="phoneError"></span>
                            </div>

                            <!-- Relationship -->
                            <div>
                                <label for="relationship" class="block text-sm font-semibold text-gray-700 mb-2">Relationship to Student *</label>
                                <select id="relationship" name="relationship" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="">Select relationship</option>
                                    <option value="father" <?= $guardian['relationship'] === 'father' ? 'selected' : '' ?>>Father</option>
                                    <option value="mother" <?= $guardian['relationship'] === 'mother' ? 'selected' : '' ?>>Mother</option>
                                    <option value="guardian" <?= $guardian['relationship'] === 'guardian' ? 'selected' : '' ?>>Guardian</option>
                                    <option value="uncle" <?= $guardian['relationship'] === 'uncle' ? 'selected' : '' ?>>Uncle</option>
                                    <option value="aunt" <?= $guardian['relationship'] === 'aunt' ? 'selected' : '' ?>>Aunt</option>
                                    <option value="grandparent" <?= $guardian['relationship'] === 'grandparent' ? 'selected' : '' ?>>Grandparent</option>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="relationshipError"></span>
                            </div>

                            <!-- Occupation -->
                            <div>
                                <label for="occupation" class="block text-sm font-semibold text-gray-700 mb-2">Occupation *</label>
                                <input type="text" id="occupation" name="occupation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., Engineer, Teacher, Business Owner" value="<?= $guardian['occupation'] ?>">
                                <span class="text-red-500 text-sm hidden" id="occupationError"></span>

                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Address *</label>
                                <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter residential address"><?= $guardian['address'] ?></textarea>
                                <span class="text-red-500 text-sm hidden" id="addressError"></span>

                            </div>


                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="active" <?= $guardian['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $guardian['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-green-900 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Guardian Account
                                </button>
                                <a type="button" onclick="window.history.back()" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-green-50 rounded-lg shadow p-6 border-l-4 border-green-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-green-900 mr-2"></i>Guardian Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Specify relationship to student</span>
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
                                <span>Phone format: +234XXXXXXXXXX</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>All fields are required</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>


        </div>
    </section>


    <!-- Footer -->
    <?php include(__DIR__ . '/../../../../includes/footer.php'); ?>


    <script>
        // Form validation and submission
        const updateGuardianForm = document.getElementById('updateGuardianForm');

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^\+?234\d{10}$|^\d{11}$/;
            return re.test(phone.replace(/\s/g, ''));
        }

        updateGuardianForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const relationship = document.getElementById('relationship').value;
            const occupation = document.getElementById('occupation').value.trim();
            const address = document.getElementById('address').value.trim();
            const status = document.getElementById('status').value;
            const gender = document.getElementById('gender').value;

            let isValid = true;

            if (!fullName) {
                document.getElementById('fullNameError').textContent = 'Full name is required';
                document.getElementById('fullNameError').classList.remove('hidden');
                isValid = false;
            }

            if (!validateEmail(email)) {
                document.getElementById('emailError').textContent = 'Please enter a valid email address';
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            }

            if (guardians.some(g => g.email === email)) {
                document.getElementById('emailError').textContent = 'Email already exists';
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            }

            if (!validatePhone(phone)) {
                document.getElementById('phoneError').textContent = 'Please enter a valid phone number';
                document.getElementById('phoneError').classList.remove('hidden');
                isValid = false;
            }
            if (!gender) {
                document.getElementById('genderError').textContent = 'Please select a gender';
                document.getElementById('genderError').classList.remove('hidden');
                isValid = false;
            }

            if (!relationship) {
                document.getElementById('relationshipError').textContent = 'Please select a relationship';
                document.getElementById('relationshipError').classList.remove('hidden');
                isValid = false;
            }

            if (!occupation) {
                document.getElementById('occupationError').textContent = 'Please enter occupation';
                document.getElementById('occupationError').classList.remove('hidden');
                isValid = false;
            }

            if (!address) {
                document.getElementById('addressError').textContent = 'Please enter address';
                document.getElementById('addressError').classList.remove('hidden');
                isValid = false;
            }

            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                updateGuardianForm.submit();
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