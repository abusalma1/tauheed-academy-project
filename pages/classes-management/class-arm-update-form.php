<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Class Arm - Excellence Academy</title>
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
                    <a href="class-arm-management.html" class="hover:text-blue-300 transition">Back to Arms</a>
                    <a href="../index.html" class="hover:text-blue-300 transition">Back to Site</a>
                </div>
                <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-blue-800 px-4 py-4 space-y-2">
            <a href="class-arm-management.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Back to Arms</a>
            <a href="../index.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Back to Site</a>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-indigo-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Class Arm</h1>
            <p class="text-xl text-indigo-200">Edit class arm information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Update Arm Details</h2>
                        
                        <!-- Arm Selection -->
                        <div class="mb-8 p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                            <label for="armSelect" class="block text-sm font-semibold text-gray-700 mb-2">Select Arm to Update *</label>
                            <select id="armSelect" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900">
                                <option value="">-- Select an arm --</option>
                            </select>
                        </div>

                        <form id="updateArmForm" class="space-y-6">
                            <!-- Arm Name -->
                            <div>
                                <label for="armName" class="block text-sm font-semibold text-gray-700 mb-2">Arm Name/Code *</label>
                                <input type="text" id="armName" name="armName" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900" placeholder="e.g., A, B, C">
                                <span class="text-red-500 text-sm hidden" id="armNameError"></span>
                            </div>

                            <!-- Arm Description -->
                            <div>
                                <label for="armDescription" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea id="armDescription" name="armDescription" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900" placeholder="Optional: Describe this arm"></textarea>
                            </div>

                            <!-- Arm Color -->
                            <div>
                                <label for="armColor" class="block text-sm font-semibold text-gray-700 mb-2">Arm Color *</label>
                                <div class="flex gap-4 items-center">
                                    <input type="color" id="armColor" name="armColor" class="w-16 h-10 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" id="armColorHex" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900" readonly>
                                </div>
                            </div>

                            <!-- Capacity -->
                            <div>
                                <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-2">Capacity (students per arm) *</label>
                                <input type="number" id="capacity" name="capacity" required min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900" placeholder="e.g., 40">
                                <span class="text-red-500 text-sm hidden" id="capacityError"></span>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-indigo-900 text-white py-3 rounded-lg font-semibold hover:bg-indigo-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Arm
                                </button>
                                <a href="class-arm-management.html" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-indigo-50 rounded-lg shadow p-6 border-l-4 border-indigo-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-indigo-900 mr-2"></i>Update Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span>Select an arm from the dropdown</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span>Modify the details as needed</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span>Update color for visual identification</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span>Adjust capacity if needed</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span>Click Update to save changes</span>
                            </li>
                        </ul>
                    </div>
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
                        <li><a href="class-arm-management.html" class="text-gray-400 hover:text-white transition">Arms</a></li>
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

        // Color picker sync
        const armColor = document.getElementById('armColor');
        const armColorHex = document.getElementById('armColorHex');
        armColor.addEventListener('change', (e) => {
            armColorHex.value = e.target.value;
        });

        // Load arms and populate dropdown
        const armSelect = document.getElementById('armSelect');
        const updateArmForm = document.getElementById('updateArmForm');
        let arms = JSON.parse(localStorage.getItem('schoolArms')) || [];
        let selectedArmIndex = null;

        function populateArmSelect() {
            armSelect.innerHTML = '<option value="">-- Select an arm --</option>';
            arms.forEach((arm, index) => {
                const option = document.createElement('option');
                option.value = index;
                option.textContent = arm.armName;
                armSelect.appendChild(option);
            });
        }

        armSelect.addEventListener('change', (e) => {
            if (e.target.value === '') {
                updateArmForm.reset();
                selectedArmIndex = null;
                return;
            }

            selectedArmIndex = parseInt(e.target.value);
            const arm = arms[selectedArmIndex];

            document.getElementById('armName').value = arm.armName;
            document.getElementById('armDescription').value = arm.armDescription || '';
            document.getElementById('armColor').value = arm.armColor;
            document.getElementById('armColorHex').value = arm.armColor;
            document.getElementById('capacity').value = arm.capacity;
            document.getElementById('status').value = arm.status;
        });

        updateArmForm.addEventListener('submit', (e) => {
            e.preventDefault();

            if (selectedArmIndex === null) {
                alert('Please select an arm to update');
                return;
            }

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const armName = document.getElementById('armName').value.trim();
            const armDescription = document.getElementById('armDescription').value.trim();
            const armColor = document.getElementById('armColor').value;
            const capacity = parseInt(document.getElementById('capacity').value);
            const status = document.getElementById('status').value;

            let isValid = true;

            if (!armName) {
                document.getElementById('armNameError').textContent = 'Arm name is required';
                document.getElementById('armNameError').classList.remove('hidden');
                isValid = false;
            }

            if (!capacity || capacity < 1) {
                document.getElementById('capacityError').textContent = 'Please enter a valid capacity';
                document.getElementById('capacityError').classList.remove('hidden');
                isValid = false;
            }

            if (isValid) {
                arms[selectedArmIndex] = {
                    armName,
                    armDescription,
                    armColor,
                    capacity,
                    status,
                    createdAt: arms[selectedArmIndex].createdAt,
                    updatedAt: new Date().toLocaleDateString()
                };

                localStorage.setItem('schoolArms', JSON.stringify(arms));
                alert('Class arm updated successfully!');
                window.location.href = 'class-arm-management.html';
            }
        });

        // Initial render
        populateArmSelect();
    </script>
</body>
</html>
