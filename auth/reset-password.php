<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Excellence Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
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
                                placeholder="Enter new password"
                            >
                            <button 
                                type="button" 
                                id="toggle-password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            >
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
                                placeholder="Confirm new password"
                            >
                            <button 
                                type="button" 
                                id="toggle-confirm-password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700"
                            >
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
                        class="w-full bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow-lg hover:shadow-xl"
                    >
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
                    <a href="login.html" class="inline-flex items-center text-blue-900 hover:text-blue-700 font-semibold">
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

        // Confirm Password Toggle
        const toggleConfirmPassword = document.getElementById('toggle-confirm-password');
        const confirmPasswordInput = document.getElementById('confirm_password');
        const eyeIconConfirm = document.getElementById('eye-icon-confirm');

        toggleConfirmPassword.addEventListener('click', () => {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            eyeIconConfirm.classList.toggle('fa-eye');
            eyeIconConfirm.classList.toggle('fa-eye-slash');
        });

        // Password Validation
        passwordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            
            // Check length
            const reqLength = document.getElementById('req-length');
            if (password.length >= 8) {
                reqLength.classList.add('text-green-600');
                reqLength.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                reqLength.classList.remove('text-green-600');
                reqLength.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }
            
            // Check uppercase
            const reqUppercase = document.getElementById('req-uppercase');
            if (/[A-Z]/.test(password)) {
                reqUppercase.classList.add('text-green-600');
                reqUppercase.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                reqUppercase.classList.remove('text-green-600');
                reqUppercase.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }
            
            // Check lowercase
            const reqLowercase = document.getElementById('req-lowercase');
            if (/[a-z]/.test(password)) {
                reqLowercase.classList.add('text-green-600');
                reqLowercase.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                reqLowercase.classList.remove('text-green-600');
                reqLowercase.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }
            
            // Check number
            const reqNumber = document.getElementById('req-number');
            if (/[0-9]/.test(password)) {
                reqNumber.classList.add('text-green-600');
                reqNumber.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                reqNumber.classList.remove('text-green-600');
                reqNumber.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }
        });

        // Password Match Check
        confirmPasswordInput.addEventListener('input', () => {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const matchDiv = document.getElementById('password-match');
            const matchMessage = document.getElementById('match-message');
            
            if (confirmPassword.length > 0) {
                matchDiv.classList.remove('hidden');
                if (password === confirmPassword) {
                    matchMessage.innerHTML = '<i class="fas fa-check-circle text-green-600 mr-2"></i><span class="text-green-600">Passwords match!</span>';
                } else {
                    matchMessage.innerHTML = '<i class="fas fa-times-circle text-red-600 mr-2"></i><span class="text-red-600">Passwords do not match</span>';
                }
            } else {
                matchDiv.classList.add('hidden');
            }
        });

        // Form Submission
        const resetPasswordForm = document.getElementById('reset-password-form');
        const successMessage = document.getElementById('success-message');

        resetPasswordForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            
            // Validate password requirements
            if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
                alert('Please meet all password requirements!');
                return;
            }
            
            // Check if passwords match
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }
            
            // Show success message
            successMessage.classList.remove('hidden');
            
            // Hide form
            resetPasswordForm.style.display = 'none';
            
            // Add your password reset logic here
        });
    </script>
</body>
</html>
