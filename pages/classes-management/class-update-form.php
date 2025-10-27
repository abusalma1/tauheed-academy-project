<?php

$title = "Classe Update Form";
include(__DIR__ . '/../../includes/header.php');

?>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/./includes/classes-management-nav.php') ?>
    <!-- Page Header -->
    <!-- Page Header -->
    <section class="bg-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Class Information</h1>
            <p class="text-xl text-green-200">Modify class details and settings</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Class Details</h2>

                    <form id="updateClassForm" class="space-y-6">
                        <!-- Class Name -->
                        <div>
                            <label for="className" class="block text-sm font-semibold text-gray-700 mb-2">Class Name *</label>
                            <input type="text" id="className" name="className" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., JSS 1A">
                            <span class="text-red-500 text-sm hidden" id="classNameError"></span>
                        </div>

                        <!-- Class Level -->
                        <div>
                            <label for="classLevel" class="block text-sm font-semibold text-gray-700 mb-2">Class Level *</label>
                            <select id="classLevel" name="classLevel" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                <option value="">Select class level</option>
                                <option value="JSS 1">JSS 1</option>
                                <option value="JSS 2">JSS 2</option>
                                <option value="JSS 3">JSS 3</option>
                                <option value="SSS 1">SSS 1</option>
                                <option value="SSS 2">SSS 2</option>
                                <option value="SSS 3">SSS 3</option>
                            </select>
                        </div>

                        <!-- Class Section -->
                        <div>
                            <label for="classSection" class="block text-sm font-semibold text-gray-700 mb-2">Section/Arm *</label>
                            <input type="text" id="classSection" name="classSection" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., A, B, C">
                        </div>

                        <!-- Class Teacher -->
                        <div>
                            <label for="classTeacher" class="block text-sm font-semibold text-gray-700 mb-2">Class Teacher *</label>
                            <input type="text" id="classTeacher" name="classTeacher" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter teacher name">
                        </div>

                        <!-- Capacity -->
                        <div>
                            <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-2">Class Capacity *</label>
                            <input type="number" id="capacity" name="capacity" required min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., 40">
                            <span class="text-red-500 text-sm hidden" id="capacityError"></span>
                        </div>

                        <!-- Current Enrollment -->
                        <div>
                            <label for="enrollment" class="block text-sm font-semibold text-gray-700 mb-2">Current Enrollment</label>
                            <input type="number" id="enrollment" name="enrollment" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., 35">
                        </div>

                        <!-- Room Number -->
                        <div>
                            <label for="roomNumber" class="block text-sm font-semibold text-gray-700 mb-2">Room Number</label>
                            <input type="text" id="roomNumber" name="roomNumber" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., Block A, Room 101">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                            <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="flex-1 bg-green-900 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                                <i class="fas fa-save mr-2"></i>Update Class
                            </button>
                            <a href="class-management.html" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                <i class="fas fa-arrow-left mr-2"></i>Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

 <?php include(__DIR__ . '/../../includes/footer.php');    ?>


        <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        });

        // Get class ID from URL
        const urlParams = new URLSearchParams(window.location.search);
        const classId = urlParams.get('id');

        const updateClassForm = document.getElementById('updateClassForm');
        let classes = JSON.parse(localStorage.getItem('schoolClasses')) || [];

        // Load class data if editing
        if (classId) {
        const classIndex = parseInt(classId);
        if (classIndex >= 0 && classIndex < classes.length) {
            const cls=classes[classIndex];
            document.getElementById('className').value=cls.className;
            document.getElementById('classLevel').value=cls.classLevel;
            document.getElementById('classSection').value=cls.classSection;
            document.getElementById('classTeacher').value=cls.classTeacher;
            document.getElementById('capacity').value=cls.capacity;
            document.getElementById('enrollment').value=cls.enrollment || 0;
            document.getElementById('roomNumber').value=cls.roomNumber || '' ;
            document.getElementById('status').value=cls.status;
            }
            }

            updateClassForm.addEventListener('submit', (e)=> {
            e.preventDefault();

            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const className = document.getElementById('className').value.trim();
            const classLevel = document.getElementById('classLevel').value;
            const classSection = document.getElementById('classSection').value.trim();
            const classTeacher = document.getElementById('classTeacher').value.trim();
            const capacity = parseInt(document.getElementById('capacity').value);
            const enrollment = parseInt(document.getElementById('enrollment').value) || 0;
            const roomNumber = document.getElementById('roomNumber').value.trim();
            const status = document.getElementById('status').value;

            let isValid = true;

            if (!className) {
            document.getElementById('classNameError').textContent = 'Class name is required';
            document.getElementById('classNameError').classList.remove('hidden');
            isValid = false;
            }

            if (!capacity || capacity < 1) {
                document.getElementById('capacityError').textContent='Please enter a valid capacity' ;
                document.getElementById('capacityError').classList.remove('hidden');
                isValid=false;
                }

                if (enrollment> capacity) {
                document.getElementById('capacityError').textContent = 'Enrollment cannot exceed capacity';
                document.getElementById('capacityError').classList.remove('hidden');
                isValid = false;
                }

                if (isValid) {
                const classIndex = parseInt(classId);
                if (classIndex >= 0 && classIndex < classes.length) {
                    classes[classIndex]={
                    className,
                    classLevel,
                    classSection,
                    classTeacher,
                    capacity,
                    enrollment,
                    roomNumber,
                    status,
                    createdAt: classes[classIndex].createdAt,
                    updatedAt: new Date().toLocaleDateString()
                    };

                    localStorage.setItem('schoolClasses', JSON.stringify(classes));
                    alert('Class updated successfully!');
                    window.location.href='class-management.html' ;
                    }
                    }
                    });
                    </script>
</body>

</html>