<?php
$title = "Login";
include(__DIR__ . "/./includes/non-auth-header.php");

$error = '';

// ✅ Redirect if already logged in
if (isset($_SESSION['user_session'])) {
    header('Location: ' . route('home'));
    exit();
}

// ✅ Generate CSRF token if missing
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// ✅ Handle login submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // ✅ CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    } else {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // regenerate after validation
    }

    $emailOrId = trim($_POST['email'] ?? '');
    $password  = trim($_POST['password'] ?? '');

    if (!empty($emailOrId) && !empty($password)) {
        try {
            // ✅ Start transaction
            $pdo->beginTransaction();

            // ✅ Define user sources
            $sources = [
                'student'  => ["SELECT * FROM students WHERE email = ? OR admission_number = ?", [$emailOrId, $emailOrId]],
                'teacher'  => ["SELECT * FROM teachers WHERE email = ? OR staff_no = ?", [$emailOrId, $emailOrId]],
                'guardian' => ["SELECT * FROM guardians WHERE email = ?", [$emailOrId]],
                'admin'    => ["SELECT * FROM admins WHERE email = ? OR staff_no = ?", [$emailOrId, $emailOrId]],
            ];

            $user = null;
            $user_type = null;

            // ✅ Try each source
            foreach ($sources as $type => [$query, $params]) {
                $stmt = $pdo->prepare($query);
                $stmt->execute($params);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    $user = $result;
                    $user_type = $type;
                    break;
                }
            }

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);
                $_SESSION['user_session'] = [
                    'id'        => $user['id'],
                    'email'     => $user['email'],
                    'user_type' => $user_type
                ];

                $_SESSION['success'] = "Logged in successfully!";
                $pdo->commit();
                header('Location: ' . route('home'));
                exit();
            } else {
                $pdo->rollBack();
                $error = $user ? "Incorrect password" : "Account not found";
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error = "Login error: " . htmlspecialchars($e->getMessage());
        }
    } else {
        $error = 'Both fields are required!';
    }
}
?>


<body class="bg-gray-50">
    <!-- Login Section -->
    <section class="py-16 bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-900 rounded-full mb-4">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Welcome back</h2>
                    <p class="text-gray-600 mt-2">Sign in to access your account</p>
                </div>

                <!-- Login Form -->
                <form class="space-y-6" method="post" action="">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                    <?php if (!empty($error)): ?>
                        <div class="mt-4 p-3 rounded-lg bg-red-100 border border-red-300 text-red-700 text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Email/Username -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-900"></i>Email, Admission No. or Staff ID No.
                        </label>
                        <input
                            type="text"
                            id="email"
                            name="email"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                            placeholder="Enter your email or username">
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-900"></i>Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                                placeholder="Enter your password">
                            <button
                                type="button"
                                id="toggle-password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-4 bg-white text-gray-500"></span>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-end">

                        <a href="<?= route('forgot-password') ?>" class="text-sm text-blue-900 hover:text-blue-700 font-semibold">
                            Forgot Password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        name="submit"
                        class="w-full bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow-lg hover:shadow-xl">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500"></span>
                    </div>
                </div>


            </div>

            <!-- Additional Info -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    <i class="fas fa-shield-alt mr-2 text-blue-900"></i>
                    Your information is secure and protected
                </p>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script>
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (togglePassword) {
            togglePassword.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                eyeIcon.classList.toggle('fa-eye');
                eyeIcon.classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>


</html>