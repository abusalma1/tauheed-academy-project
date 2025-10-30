<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Teacher Account - Excellence Academy</title>
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
                        <p class="text-xs text-blue-200">Admin Panel</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-6">
                    <a href="teacher-management.html" class="hover:text-blue-300 transition">Back to Teachers</a>
                    <a href="../index.html" class="hover:text-blue-300 transition">Back to Site</a>
                </div>
                <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-blue-800 px-4 py-4 space-y-2">
            <a href="teacher-management.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Back to Teachers</a>
            <a href="../index.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Back to Site</a>
        </div>
    </nav>

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
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Teacher Information</h2>
                    
                    <form id="updateTeacherForm" class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                            <input type="text" id="fullName" name="fullName" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter full name">
                            <span class="text-red-500 text-sm hidden" id="fullNameError"></span>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter email address">
                            <span class="text-red-500 text-sm hidden" id="emailError"></span>
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter phone number">
                            <span class="text-red-500 text-sm hidden" id="phoneError"></span>
                        </div>

                        <!-- Subject/Department -->
                        <div>
                            <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject/Department *</label>
                            <input type="text" id="subject" name="subject" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="e.g., Mathematics, English, Science">
                            <span class="text-red-500 text-sm hidden" id="subjectError"></span>
                        </div>

                        <!-- Qualification -->
                        <div>
                            <label for="qualification" class="block text-sm font-semibold text-gray-700 mb-2">Qualification *</label>
                            <input type="text" id="qualification" name="qualification" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="e.g., B.Sc Education, M.A">
                            <span class="text-red-500 text-sm hidden" id="qualificationError"></span>
                        </div>

                        <!-- Years of Experience -->
                        <div>
                            <label for="experience" class="block text-sm font-semibold text-gray-700 mb-2">Years of Experience</label>
                            <input type="number" id="experience" name="experience" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter years of experience">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                            <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                                <i class="fas fa-save mr-2"></i>Update Teacher Account
                            </button>
                            <a href="teacher-management.html" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Excellence Academy</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Committed to providing quality education and nurturing future leaders.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="../index.html" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="teacher-management.html" class="text-gray-400 hover:text-white transition">Teacher Management</a></li>
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
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Form validation and submission
        const updateTeacherForm = document.getElementById('updateTeacherForm');
        const teacherIndex = new URLSearchParams(window.location.search).get('index');

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^\+?234\d{10}$|^\d{11}$/;
            return re.test(phone.replace(/\s/g, ''));
        }

        // Load teacher data if editing
        if (teacherIndex !== null) {
            const teachers = JSON.parse(localStorage.getItem('schoolTeachers')) || [];
            const teacher = teachers[teacherIndex];
            
            if (teacher) {
                document.getElementById('fullName').value = teacher.fullName;
                document.getElementById('email').value = teacher.email;
                document.getElementById('phone').value = teacher.phone;
                document.getElementById('subject').value = teacher.subject;
                document.getElementById('qualification').value = teacher.qualification;
                document.getElementById('experience').value = teacher.experience || '';
                document.getElementById('status').value = teacher.status;
            }
        }

        updateTeacherForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const qualification = document.getElementById('qualification').value.trim();
            const experience = document.getElementById('experience').value;
            const status = document.getElementById('status').value;

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

            if (!validatePhone(phone)) {
                document.getElementById('phoneError').textContent = 'Please enter a valid phone number';
                document.getElementById('phoneError').classList.remove('hidden');
                isValid = false;
            }

            if (!subject) {
                document.getElementById('subjectError').textContent = 'Subject/Department is required';
                document.getElementById('subjectError').classList.remove('hidden');
                isValid = false;
            }

            if (!qualification) {
                document.getElementById('qualificationError').textContent = 'Qualification is required';
                document.getElementById('qualificationError').classList.remove('hidden');
                isValid = false;
            }

            if (isValid) {
                const teachers = JSON.parse(localStorage.getItem('schoolTeachers')) || [];
                
                if (teacherIndex !== null) {
                    teachers[teacherIndex] = {
                        fullName,
                        email,
                        phone,
                        subject,
                        qualification,
                        experience: experience || '0',
                        status,
                        updatedAt: new Date().toLocaleDateString()
                    };
                    localStorage.setItem('schoolTeachers', JSON.stringify(teachers));
                    alert('Teacher account updated successfully!');
                }
                
                window.location.href = 'teacher-management.html';
            }
        });
    </script>
</body>
</html>
