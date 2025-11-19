<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Excellence Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-900 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <img src="/placeholder.svg?height=50&width=50" alt="School Logo" class="h-12 w-12 rounded-full bg-white p-1">
                    <div>
                        <h1 class="text-xl font-bold">Excellence Academy</h1>
                        <p class="text-xs text-blue-200">Change Password</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-6">
                    <a href="user-profile.html" class="hover:text-blue-300 transition">Back to Profile</a>
                    <a href="../index.html" class="hover:text-blue-300 transition">Back to Site</a>
                </div>
                <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-blue-800 px-4 py-4 space-y-2">
            <a href="user-profile.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Back to Profile</a>
            <a href="../index.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Back to Site</a>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Change Your Password</h1>
            <p class="text-xl text-blue-200">Update your account password securely</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Password Security</h2>
                <p class="text-gray-600 mb-8">For your security, please provide your current password and then enter a new password.</p>
                
                <form id="changePasswordForm" class="space-y-6">
                    <!-- Current Password -->
                    <div>
                        <label for="currentPassword" class="block text-sm font-semibold text-gray-700 mb-2">Current Password *</label>
                        <div class="relative">
                            <input type="password" id="currentPassword" name="currentPassword" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter your current password">
                            <button type="button" class="toggle-password absolute right-3 top-2.5 text-gray-500" data-target="currentPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <span class="text-red-500 text-sm hidden" id="currentPasswordError"></span>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="newPassword" class="block text-sm font-semibold text-gray-700 mb-2">New Password *</label>
                        <div class="relative">
                            <input type="password" id="newPassword" name="newPassword" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter your new password">
                            <button type="button" class="toggle-password absolute right-3 top-2.5 text-gray-500" data-target="newPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <span class="text-red-500 text-sm hidden" id="newPasswordError"></span>

                        <!-- Password Strength Indicators -->
                        <div class="mt-4 space-y-2">
                            <div class="flex items-center gap-2">
                                <div id="length-check" class="w-3 h-3 rounded-full bg-gray-300"></div>
                                <span class="text-sm text-gray-600">At least 8 characters</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="uppercase-check" class="w-3 h-3 rounded-full bg-gray-300"></div>
                                <span class="text-sm text-gray-600">At least one uppercase letter</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="number-check" class="w-3 h-3 rounded-full bg-gray-300"></div>
                                <span class="text-sm text-gray-600">At least one number</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div id="special-check" class="w-3 h-3 rounded-full bg-gray-300"></div>
                                <span class="text-sm text-gray-600">At least one special character (!@#$%)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label for="confirmPassword" class="block text-sm font-semibold text-gray-700 mb-2">Confirm New Password *</label>
                        <div class="relative">
                            <input type="password" id="confirmPassword" name="confirmPassword" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Confirm your new password">
                            <button type="button" class="toggle-password absolute right-3 top-2.5 text-gray-500" data-target="confirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <span class="text-red-500 text-sm hidden" id="confirmPasswordError"></span>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                            <i class="fas fa-lock mr-2"></i>Change Password
                        </button>
                        <a href="user-profile.html" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Excellence Academy</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">Committed to providing quality education and nurturing future leaders.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="../index.html" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="user-profile.html" class="text-gray-400 hover:text-white transition">My Profile</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><i class="fas fa-map-marker-alt mr-2"></i>123 Education Street, City</li>
                        <li><i class="fas fa-phone mr-2"></i>+234 800 123 4567</li>
                        <li><i class="fas fa-envelope mr-2"></i>info@excellenceacademy.edu</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Follow Us</h3>
                    <div class="flex gap-4">
                        <a href="#" class="bg-blue-600 hover:bg-blue-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-blue-400 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-pink-600 hover:bg-pink-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2025 Excellence Academy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.getElementById(this.dataset.target);
                const icon = this.querySelector('i');
                if (target.type === 'password') {
                    target.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    target.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Password strength checker
        const newPasswordInput = document.getElementById('newPassword');
        
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            
            // Check length
            const lengthCheck = document.getElementById('length-check');
            if (password.length >= 8) {
                lengthCheck.classList.remove('bg-gray-300');
                lengthCheck.classList.add('bg-green-500');
            } else {
                lengthCheck.classList.add('bg-gray-300');
                lengthCheck.classList.remove('bg-green-500');
            }

            // Check uppercase
            const uppercaseCheck = document.getElementById('uppercase-check');
            if (/[A-Z]/.test(password)) {
                uppercaseCheck.classList.remove('bg-gray-300');
                uppercaseCheck.classList.add('bg-green-500');
            } else {
                uppercaseCheck.classList.add('bg-gray-300');
                uppercaseCheck.classList.remove('bg-green-500');
            }

            // Check number
            const numberCheck = document.getElementById('number-check');
            if (/\d/.test(password)) {
                numberCheck.classList.remove('bg-gray-300');
                numberCheck.classList.add('bg-green-500');
            } else {
                numberCheck.classList.add('bg-gray-300');
                numberCheck.classList.remove('bg-green-500');
            }

            // Check special character
            const specialCheck = document.getElementById('special-check');
            if (/[!@#$%^&*]/.test(password)) {
                specialCheck.classList.remove('bg-gray-300');
                specialCheck.classList.add('bg-green-500');
            } else {
                specialCheck.classList.add('bg-gray-300');
                specialCheck.classList.remove('bg-green-500');
            }
        });

        // Form submission
        const changePasswordForm = document.getElementById('changePasswordForm');

        changePasswordForm.addEventListener('submit', (e) => {
            e.preventDefault();

            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const currentPassword = document.getElementById('currentPassword').value;
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            let isValid = true;

            if (!currentPassword) {
                document.getElementById('currentPasswordError').textContent = 'Current password is required';
                document.getElementById('currentPasswordError').classList.remove('hidden');
                isValid = false;
            }

            if (newPassword.length < 8) {
                document.getElementById('newPasswordError').textContent = 'Password must be at least 8 characters';
                document.getElementById('newPasswordError').classList.remove('hidden');
                isValid = false;
            }

            if (!/[A-Z]/.test(newPassword) || !/\d/.test(newPassword) || !/[!@#$%^&*]/.test(newPassword)) {
                document.getElementById('newPasswordError').textContent = 'Password must contain uppercase, number, and special character';
                document.getElementById('newPasswordError').classList.remove('hidden');
                isValid = false;
            }

            if (newPassword !== confirmPassword) {
                document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                document.getElementById('confirmPasswordError').classList.remove('hidden');
                isValid = false;
            }

            if (isValid) {
                alert('Password changed successfully!');
                window.location.href = 'user-profile.html';
            }
        });
    </script>
</body>
</html>
