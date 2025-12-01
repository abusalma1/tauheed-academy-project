<?php
$title = "Login";
include(__DIR__ . "/./includes/non-auth-header.php");
$error = '';
if (isset($_SESSION['user_session'])) {
    header('Location: ' . route('home'));
} else {
    if (isset($_POST['submit'])) {
        $email =  trim($_POST['email']);
        $password = trim($_POST['password']);
        $user_type = trim($_POST['user_type']);

        if (!empty($email) && !empty($password) && !empty($user_type)) {

            if ($user_type === 'student') {
                // Allow login using either email OR admission_number
                $stmt = $pdo->prepare("SELECT * FROM students WHERE email = ? OR admission_number = ?");
                $stmt->execute([$email, $email]);
            } else if ($user_type === 'teacher') {
                $stmt = $pdo->prepare("SELECT * FROM teachers WHERE email = ? OR staff_no = ?");
                $stmt->execute([$email, $email]);
            } else if ($user_type === 'guardian') {
                $stmt = $pdo->prepare("SELECT * FROM guardians WHERE email = ?");
                $stmt->execute([$email]);
            } else if ($user_type === 'admin') {
                $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ? OR staff_no = ?");
                $stmt->execute([$email, $email]);
            }

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($result) == 1) {
                $user = $result[0];

                if (password_verify($password, $user["password"])) {
                    session_regenerate_id(true);
                    $_SESSION["user_session"] = [
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'user_type' => $user_type
                    ];

                    $_SESSION['success'] = "Logged in successfully!";
                    header('Location: ' . route('home'));
                    exit;
                } else {
                    $error = "Incorrect email or password";
                }
            } else {
                $error = "Account does not exist";
            }
        } else {
            $error = 'All fields are required!';
        }
    }
}
?>


<body class="bg-gray-50">

    <!-- Login Section -->
    <section class="py-16 bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full"> <!-- Login Card -->
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
                    <!-- Error Message -->
                    <?php if (!empty($error)): ?>
                        <div class="mt-4 p-3 rounded-lg bg-red-100 border border-red-300 text-red-700 text-sm font-medium flex items-center gap-2">
                            <i class="fas fa-exclamation-circle text-red-600"></i>
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>
                    <!-- User Type Selection -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-users mr-2 text-blue-900"></i>I am a:
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="relative">
                                <input type="radio" name="user_type" value="student" class="peer sr-only" required>
                                <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-900 peer-checked:bg-blue-50 transition text-center">
                                    <i class="fas fa-user-graduate text-2xl text-blue-900 mb-2"></i>
                                    <p class="font-semibold text-sm">Student</p>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="user_type" value="guardian" class="peer sr-only">
                                <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-900 peer-checked:bg-blue-50 transition text-center">
                                    <i class="fas fa-user-friends text-2xl text-blue-900 mb-2"></i>
                                    <p class="font-semibold text-sm">Guardian</p>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="user_type" value="teacher" class="peer sr-only">
                                <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-900 peer-checked:bg-blue-50 transition text-center">
                                    <i class="fas fa-chalkboard-teacher text-2xl text-blue-900 mb-2"></i>
                                    <p class="font-semibold text-sm">Teacher</p>
                                </div>
                            </label>
                            <label class="relative">
                                <input type="radio" name="user_type" value="admin" class="peer sr-only">
                                <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-900 peer-checked:bg-blue-50 transition text-center">
                                    <i class="fas fa-crown text-2xl text-blue-900 mb-2"></i>
                                    <p class="font-semibold text-sm">Admin</p>
                                </div>
                            </label>
                        </div>
                    </div>
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

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" class="w-4 h-4 text-blue-900 border-gray-300 rounded focus:ring-blue-900">
                            <span class="ml-2 text-sm text-gray-700">Remember me</span>
                        </label>
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
                        <span class="px-4 bg-white text-gray-500">Or</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-gray-600">
                        Don't have an account?
                        <a href="<?= route('register') ?>" class="text-blue-900 hover:text-blue-700 font-semibold">
                            Create Account
                        </a>
                    </p>
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
        // Password Toggle
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