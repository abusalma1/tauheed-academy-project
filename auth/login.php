<?php
@session_start();
$title = "Login";
include(__DIR__ . "/./includes/non-auth-header.php");


$error = '';
if (isset($_POST['submit'])) {
    $email =  trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $statement = $connection->prepare("SELECT * from users where email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_email"] = $user["email"];

                header('Location: ../index.php');
            } else {
                $error = "Incorrect Email Or password";
            }
        } else {
            $error = "Account Does Not Exist";
        }
    } else {
        $error = 'All Fields Are Required!';
    }
}

?>


<body class="bg-gray-50">

    <!-- Login Section -->
    <section class="py-16 bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-900 rounded-full mb-4">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Welcome Back</h2>
                    <p class="text-gray-600 mt-2">Sign in to access your account</p>
                </div>

                <!-- Login Form -->
                <form id="login-form" class="space-y-6">
                    <!-- Email/Username -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-900"></i>Email or Username
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
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Password Toggle
        const togglePassword = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });

        // Form Submission
        const loginForm = document.getElementById('login-form');
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            // Add your login logic here
            alert('Login functionality will be implemented with backend integration');
        });
    </script>
</body>

</html>