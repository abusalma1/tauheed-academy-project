<?php
$title = "Update User Password";
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if (isset($_GET['id'])  && isset($_GET['user_type'])) {
    $id = $_GET['id'];
    $user_type = $_GET['user_type'];
    if ($user_type === 'admin') {
        $query = "SELECT id, name FROM admins WHERE id=?";
    } elseif ($user_type === 'teacher') {
        $query = "SELECT id, name FROM teachers WHERE id=?";
    } elseif ($user_type === 'guardian') {
        $query = "SELECT id, name FROM guardians WHERE id=?";
    } elseif ($user_type === 'student') {
        $query = "SELECT id, name FROM students WHERE id=?";
    }
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        header('Location: ' .  route('back'));
    }
} else {
    $_SESSION['failure'] = "User and user type are required";
    header('Location: ' .  route('back'));
}


$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $id = htmlspecialchars(trim($_POST['id'] ?? ''), ENT_QUOTES, 'UTF-8');

    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirmPassword'] ?? '');

    if (empty($password)) {

        $errors['passwordError'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['passwordError'] = 'Password must be at least 8 characters';
    } elseif ($password !== $confirmPassword) {
        $errors['confirmPasswordError'] = 'Passwords do not match';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    if (empty($errors)) {
        if ($user_type === 'admin') {
            $query = "UPDATE admins SET password = ? WHERE id = ?";
        } elseif ($user_type === 'teacher') {
            $query = "UPDATE teachers SET password = ? WHERE id = ?";
        } elseif ($user_type === 'guardian') {
            $query = "UPDATE guardians SET password = ? WHERE id = ?";
        } elseif ($user_type === 'student') {
            $query = "UPDATE students SET password = ? WHERE id = ?";
        }

        $stmt = $conn->prepare($query);
        $stmt->bind_param('si',  $hashed_password, $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "User Password Reset successfully!";
            header("Location: " .  route('back'));
            exit();
        } else {
            echo "<script>alert('Database error: " . $stmt->error . "');</script>";
        }
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}

?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php') ?>


    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Teacher Account</h1>
            <p class="text-xl text-blue-200">Edit teacher account information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Reset Users Password</h2>
                        <form id="updatePasswordForm" class="space-y-6" method="POST">

                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">


                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>
                            <!-- Full Name -->
                            <div>
                                <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name <small>(Read Only)</small>*</label>
                                <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter full name" value="<?= $user['name'] ?>">
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter password">
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
                                <input type="password" id="confirmPassword" name="confirmPassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Confirm password">
                                <span class="text-red-500 text-sm hidden" id="confirmPasswordError"></span>
                            </div>



                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update User Account Password
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
                    <div class="bg-blue-50 rounded-lg shadow p-6 border-l-4 border-blue-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-blue-900 mr-2"></i>Teacher Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Provide valid teaching qualification</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Subject field is mandatory</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Password must be 8+ characters</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Email must be unique</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Experience field is optional</span>
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
        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePassword.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        // Password strength checker
        // Password strength checker
        const passwordField = document.getElementById("password");
        passwordField.addEventListener("input", () => {
            const password = passwordField.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            const strengthLevels = [
                "Weak",
                "Fair",
                "Good",
                "Strong",
                "Very Strong",
            ];
            const strengthColors = [
                "bg-red-500",
                "bg-orange-500",
                "bg-yellow-500",
                "bg-green-500",
                "bg-green-600",
            ];

            for (let i = 1; i <= 4; i++) {
                const element = document.getElementById(`strength${i}`);
                if (i <= strength) {
                    element.className = `h-1 w-1/4 ${
              strengthColors[strength - 1]
            } rounded`;
                } else {
                    element.className = "h-1 w-1/4 bg-gray-300 rounded";
                }
            }

            document.getElementById(
                "strengthText"
            ).textContent = `Password strength: ${
          strengthLevels[strength - 1] || "Weak"
        }`;
        });

        // Form validation and submission
        const updatePasswordForm = document.getElementById('updatePasswordForm');
        updatePasswordForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            let isValid = true;


            if (password.length < 8) {
                document.getElementById('passwordError').textContent = 'Password must be at least 8 characters';
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
                showLoader();
                updatePasswordForm.submit();
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