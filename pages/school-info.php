<?php 
include("../includes/header.php");
?>
<body class="bg-gray-50">
    <!-- Navigation -->
<?php include(__DIR__.'/../includes/nav.php') ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">School Information</h1>
            <p class="text-xl text-blue-200">Manage and Update School Details</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Form Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">School Details</h2>
                    <p class="text-gray-600">Update your school's basic information and settings</p>
                </div>

                <!-- Form -->
                <form id="schoolInfoForm" class="space-y-8">
                    <!-- Basic Information Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-900"></i>
                            Basic Information
                        </h3>

                        <!-- School Name -->
                        <div class="mb-6">
                            <label for="schoolName" class="block text-gray-700 font-semibold mb-2">
                                School Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="schoolName" name="schoolName" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter school name" required>
                        </div>

                        <!-- Address -->
                        <div class="mb-6">
                            <label for="address" class="block text-gray-700 font-semibold mb-2">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" name="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter complete school address" required></textarea>
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 font-semibold mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter school email" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="phoneNumber" class="block text-gray-700 font-semibold mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="phoneNumber" name="phoneNumber" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="+234 800 123 4567" required>
                            </div>

                            <!-- WhatsApp Number -->
                            <div>
                                <label for="whatsappNumber" class="block text-gray-700 font-semibold mb-2">
                                    WhatsApp Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="whatsappNumber" name="whatsappNumber" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="+234 800 123 4567" required>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-share-alt text-blue-900"></i>
                            Social Media Links
                        </h3>

                        <!-- Facebook -->
                        <div class="mb-6">
                            <label for="facebookLink" class="block text-gray-700 font-semibold mb-2">
                                <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook Link
                            </label>
                            <input type="url" id="facebookLink" name="facebookLink" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="https://facebook.com/excellenceacademy">
                        </div>

                        <!-- Twitter -->
                        <div class="mb-6">
                            <label for="twitterLink" class="block text-gray-700 font-semibold mb-2">
                                <i class="fab fa-twitter text-blue-400 mr-2"></i>Twitter Link
                            </label>
                            <input type="url" id="twitterLink" name="twitterLink" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="https://twitter.com/excellenceacademy">
                        </div>

                        <!-- Instagram -->
                        <div class="mb-6">
                            <label for="instagramLink" class="block text-gray-700 font-semibold mb-2">
                                <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram Link
                            </label>
                            <input type="url" id="instagramLink" name="instagramLink" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="https://instagram.com/excellenceacademy">
                        </div>
                    </div>

                    <!-- Logo Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-image text-blue-900"></i>
                            School Logo
                        </h3>

                        <div class="mb-6">
                            <label for="logoFile" class="block text-gray-700 font-semibold mb-2">
                                Logo File Path <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-4">
                                <input type="file" id="logoFile" name="logoFile" accept="image/*" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition" onclick="document.getElementById('logoFile').click()">
                                    <i class="fas fa-upload mr-2"></i>Choose File
                                </button>
                            </div>
                            <p class="text-gray-600 text-sm mt-2">Recommended size: 200x200px. Formats: PNG, JPG, GIF</p>
                        </div>

                        <!-- Logo Preview -->
                        <div class="bg-gray-100 p-6 rounded-lg text-center">
                            <img id="logoPreview" src="/placeholder.svg?height=150&width=150" alt="Logo Preview" class="h-32 w-32 mx-auto rounded-lg">
                            <p class="text-gray-600 text-sm mt-4">Logo Preview</p>
                        </div>
                    </div>

                    <!-- About Message Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-align-left text-blue-900"></i>
                            About Message
                        </h3>

                        <div class="mb-6">
                            <label for="aboutMessage" class="block text-gray-700 font-semibold mb-2">
                                About Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="aboutMessage" name="aboutMessage" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter a brief description about your school..." required></textarea>
                            <p class="text-gray-600 text-sm mt-2">Character count: <span id="aboutCharCount">0</span>/500</p>
                        </div>
                    </div>

                    <!-- Admission Procedure Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-clipboard-list text-blue-900"></i>
                            Admission Procedure
                        </h3>

                        <div class="mb-6">
                            <label for="admissionProcedure" class="block text-gray-700 font-semibold mb-2">
                                Admission Procedure <span class="text-red-500">*</span>
                            </label>
                            <textarea id="admissionProcedure" name="admissionProcedure" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Describe the step-by-step admission process..." required></textarea>
                            <p class="text-gray-600 text-sm mt-2">Character count: <span id="procedureCharCount">0</span>/500</p>
                        </div>
                    </div>

                    <!-- Admission Number Format Section -->
                    <div class="pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-hashtag text-blue-900"></i>
                            Admission Number Format
                        </h3>

                        <div class="mb-6">
                            <label for="admissionNumberFormat" class="block text-gray-700 font-semibold mb-2">
                                Admission Number Format <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="admissionNumberFormat" name="admissionNumberFormat" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="e.g., EA/2025/001 or ADM-2025-001" required>
                            <p class="text-gray-600 text-sm mt-2">Example format for admission numbers (e.g., EA/2025/001)</p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-4 pt-8 border-t">
                        <button type="submit" class="flex-1 bg-blue-900 hover:bg-blue-800 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                        <button type="reset" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-redo"></i>
                            Reset Form
                        </button>
                    </div>
                </form>

                <!-- Success Message -->
                <div id="successMessage" class="hidden mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>School information updated successfully!</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Excellence Academy</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Committed to providing quality education and nurturing future leaders through academic excellence and character development.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="../index.html" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="about.html" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="admissions.html" class="text-gray-400 hover:text-white transition">Admissions</a></li>
                        <li><a href="academics.html" class="text-gray-400 hover:text-white transition">Academics</a></li>
                        <li><a href="gallery.html" class="text-gray-400 hover:text-white transition">Gallery</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><i class="fas fa-map-marker-alt mr-2"></i>123 Education Street, City</li>
                        <li><i class="fas fa-phone mr-2"></i>+234 800 123 4567</li>
                        <li><i class="fas fa-envelope mr-2"></i>info@excellenceacademy.edu</li>
                        <li><i class="fab fa-whatsapp mr-2"></i>+234 800 123 4567</li>
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

        // Logo preview
        const logoFile = document.getElementById('logoFile');
        const logoPreview = document.getElementById('logoPreview');
        logoFile.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    logoPreview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Character count for About Message
        const aboutMessage = document.getElementById('aboutMessage');
        const aboutCharCount = document.getElementById('aboutCharCount');
        aboutMessage.addEventListener('input', () => {
            aboutCharCount.textContent = aboutMessage.value.length;
        });

        // Character count for Admission Procedure
        const admissionProcedure = document.getElementById('admissionProcedure');
        const procedureCharCount = document.getElementById('procedureCharCount');
        admissionProcedure.addEventListener('input', () => {
            procedureCharCount.textContent = admissionProcedure.value.length;
        });

        // Form submission
        const schoolInfoForm = document.getElementById('schoolInfoForm');
        const successMessage = document.getElementById('successMessage');
        schoolInfoForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Collect form data
            const formData = {
                schoolName: document.getElementById('schoolName').value,
                address: document.getElementById('address').value,
                email: document.getElementById('email').value,
                phoneNumber: document.getElementById('phoneNumber').value,
                whatsappNumber: document.getElementById('whatsappNumber').value,
                facebookLink: document.getElementById('facebookLink').value,
                twitterLink: document.getElementById('twitterLink').value,
                instagramLink: document.getElementById('instagramLink').value,
                aboutMessage: document.getElementById('aboutMessage').value,
                admissionProcedure: document.getElementById('admissionProcedure').value,
                admissionNumberFormat: document.getElementById('admissionNumberFormat').value
            };

            // Save to localStorage
            localStorage.setItem('schoolInfo', JSON.stringify(formData));
            
            // Show success message
            successMessage.classList.remove('hidden');
            setTimeout(() => {
                successMessage.classList.add('hidden');
            }, 3000);

            console.log('[v0] School information saved:', formData);
        });

        // Load saved data on page load
        window.addEventListener('load', () => {
            const savedData = localStorage.getItem('schoolInfo');
            if (savedData) {
                const data = JSON.parse(savedData);
                document.getElementById('schoolName').value = data.schoolName || '';
                document.getElementById('address').value = data.address || '';
                document.getElementById('email').value = data.email || '';
                document.getElementById('phoneNumber').value = data.phoneNumber || '';
                document.getElementById('whatsappNumber').value = data.whatsappNumber || '';
                document.getElementById('facebookLink').value = data.facebookLink || '';
                document.getElementById('twitterLink').value = data.twitterLink || '';
                document.getElementById('instagramLink').value = data.instagramLink || '';
                document.getElementById('aboutMessage').value = data.aboutMessage || '';
                document.getElementById('admissionProcedure').value = data.admissionProcedure || '';
                document.getElementById('admissionNumberFormat').value = data.admissionNumberFormat || '';
                
                // Update character counts
                aboutCharCount.textContent = data.aboutMessage?.length || 0;
                procedureCharCount.textContent = data.admissionProcedure?.length || 0;
            }
        });
    </script>
</body>
</html>
