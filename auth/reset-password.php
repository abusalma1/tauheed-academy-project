<?php

$title = "Reset Password";

include(__DIR__ . '/./includes/non-auth-header.php');

?>



<body class="bg-gray-50">


    <!-- Reset Password Section  -->
    <section class="py-16 bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <!-- Reset Password Card  -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <!-- Header  -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-900 rounded-full mb-4">
                        <i class="fas fa-lock text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
                    <p class="text-gray-600 mt-2">Create a new secure password</p>
                </div>

                <!-- Success Message (Hidden by default)  -->
                <div id="success-message" class="hidden mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-0.5"></i>
                        <div>
                            <h3 class="font-semibold text-green-900">Password Reset Successful!</h3>
                            <p class="text-sm text-green-700 mt-1">
                                Your password has been successfully reset. You can now login with your new password.
                            </p>
                            <a href="login.html" class="inline-block mt-3 text-sm font-semibold text-green-900 hover:text-green-700">
                                Go to Login <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reset Password Form  -->
                <form id="reset-password-form" class="space-y-6">
                    <!-- Password Requirements Info  -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="font-semibold text-blue-900 text-sm mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Password Requirements:
                        </h3>
                        <ul class="text-xs text-blue-800 space-y-1">
                            <li id="req-length" class="flex items-center">
                                <i class="fas fa-circle text-xs mr-2"></i>At least 8 characters long
                            </li>
                            <li id="req-uppercase" class="flex items-center">
                                <i class="fas fa-circle text-xs mr-2"></i>Contains uppercase letter
                            </li>
                            <li id="req-lowercase" class="flex items-center">
                                <i class="fas fa-circle text-xs mr-2"></i>Contains lowercase letter
                            </li>
                            <li id="req-number" class="flex items-center">
                                <i class="fas fa-circle text-xs mr-2"></i>Contains a number
                            </li>
                        </ul>
                    </div>

                    <!-- New Password  -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-900"></i>New Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                                placeholder="Enter new password">
                            <button
                                type="button"
                                id="toggle-password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm Password  -->
                    <div>
                        <label for="confirm_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-900"></i>Confirm New Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="confirm_password"
                                name="confirm_password"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                                placeholder="Confirm new password">
                            <button
                                type="button"
                                id="toggle-confirm-password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-eye" id="eye-icon-confirm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Password Match Indicator  -->
                    <div id="password-match" class="hidden text-sm">
                        <p id="match-message"></p>
                    </div>

                    <!-- Submit Button  -->
                    <button
                        type="submit"
                        class="w-full bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow-lg hover:shadow-xl">
                        <i class="fas fa-check mr-2"></i>Reset Password
                    </button>
                </form>

                <!-- Divider  -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white text-gray-500">Or</span>
                    </div>
                </div>

                <!-- Back to Login  -->
                <div class="text-center">
                    <a href="<?= route('login') ?>" class="inline-flex items-center text-blue-900 hover:text-blue-700 font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Login
                    </a>
                </div>
            </div>

            <!-- Security Notice  -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    <i class="fas fa-shield-alt mr-2 text-blue-900"></i>
                    Your password is encrypted and secure
                </p>
            </div>
        </div>
    </section>

    <!-- Scripts  -->
    <script>

    </script>
</body>

</html>