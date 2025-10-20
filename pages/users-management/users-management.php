<?php
$title = 'Users Management';
include(__DIR__ . '/../../includes/header.php');

?>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/./includes/users-management-nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">User Management</h1>
            <p class="text-xl text-blue-200">Manage all user accounts and roles</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- User Type Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Admins Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-100 p-4 rounded-lg">
                            <i class="fas fa-crown text-purple-600 text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-purple-600" id="adminCount">0</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Admins & Super Users</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage administrator accounts</p>
                    <a href="<?= route('admins-management') ?>" class="inline-block w-full text-center bg-purple-600 text-white py-2 rounded-lg font-semibold hover:bg-purple-700 transition">
                        <i class="fas fa-arrow-right mr-2"></i>Manage
                    </a>
                </div>

                <!-- Teachers Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-100 p-4 rounded-lg">
                            <i class="fas fa-chalkboard-user text-blue-600 text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-blue-600" id="teacherCount">0</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Teachers</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage teacher accounts</p>
                    <a href="<?= route('teachers-management') ?>" class="inline-block w-full text-center bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        <i class="fas fa-arrow-right mr-2"></i>Manage
                    </a>
                </div>

                <!-- Guardians Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 p-4 rounded-lg">
                            <i class="fas fa-users text-green-600 text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-green-600" id="guardianCount">0</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Guardians</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage guardian accounts</p>
                    <a href="<?= route('gurdians-management') ?>" class="inline-block w-full text-center bg-green-600 text-white py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                        <i class="fas fa-arrow-right mr-2"></i>Manage
                    </a>
                </div>

                <!-- Students Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-orange-100 p-4 rounded-lg">
                            <i class="fas fa-graduation-cap text-orange-600 text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-orange-600" id="studentCount">0</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Students</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage student accounts</p>
                    <a href="<?= route(name: 'students-management') ?>" class="inline-block w-full text-center bg-orange-600 text-white py-2 rounded-lg font-semibold hover:bg-orange-700 transition">
                        <i class="fas fa-arrow-right mr-2"></i>Manage
                    </a>
                </div>
            </div>

            <!-- Overall Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="totalUsers">0</p>
                        </div>
                        <i class="fas fa-users text-4xl text-blue-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Active Users</p>
                            <p class="text-3xl font-bold text-green-600 mt-2" id="activeUsers">0</p>
                        </div>
                        <i class="fas fa-check-circle text-4xl text-green-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Inactive Users</p>
                            <p class="text-3xl font-bold text-red-600 mt-2" id="inactiveUsers">0</p>
                        </div>
                        <i class="fas fa-times-circle text-4xl text-red-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Last Updated</p>
                            <p class="text-lg font-bold text-gray-900 mt-2" id="lastUpdated">Today</p>
                        </div>
                        <i class="fas fa-calendar text-4xl text-purple-200"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="<?= route('admins-management') ?>" class="flex items-center gap-3 p-4 border-2 border-purple-200 rounded-lg hover:bg-purple-50 transition">
                        <i class="fas fa-plus text-purple-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Create Admin</p>
                            <p class="text-xs text-gray-600">Add new administrator</p>
                        </div>
                    </a>

                    <a href="<?= route('teachers-management') ?>" class="flex items-center gap-3 p-4 border-2 border-blue-200 rounded-lg hover:bg-blue-50 transition">
                        <i class="fas fa-plus text-blue-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Create Teacher</p>
                            <p class="text-xs text-gray-600">Add new teacher</p>
                        </div>
                    </a>

                    <a href="<?= route('gurdians-management') ?>" class="flex items-center gap-3 p-4 border-2 border-green-200 rounded-lg hover:bg-green-50 transition">
                        <i class="fas fa-plus text-green-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Create Guardian</p>
                            <p class="text-xs text-gray-600">Add new guardian</p>
                        </div>
                    </a>

                    <a href="<?= route('students-management') ?>" class="flex items-center gap-3 p-4 border-2 border-orange-200 rounded-lg hover:bg-orange-50 transition">
                        <i class="fas fa-plus text-orange-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Create Student</p>
                            <p class="text-xs text-gray-600">Add new student</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../../includes/footer.php'); ?>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Update statistics
        function updateStats() {
            const admins = JSON.parse(localStorage.getItem('schoolAdmins')) || [];
            const teachers = JSON.parse(localStorage.getItem('schoolTeachers')) || [];
            const guardians = JSON.parse(localStorage.getItem('schoolGuardians')) || [];
            const students = JSON.parse(localStorage.getItem('schoolStudents')) || [];

            const allUsers = [...admins, ...teachers, ...guardians, ...students];
            const activeUsers = allUsers.filter(u => u.status === 'active').length;
            const inactiveUsers = allUsers.filter(u => u.status === 'inactive').length;

            document.getElementById('adminCount').textContent = admins.length;
            document.getElementById('teacherCount').textContent = teachers.length;
            document.getElementById('guardianCount').textContent = guardians.length;
            document.getElementById('studentCount').textContent = students.length;
            document.getElementById('totalUsers').textContent = allUsers.length;
            document.getElementById('activeUsers').textContent = activeUsers;
            document.getElementById('inactiveUsers').textContent = inactiveUsers;
            document.getElementById('lastUpdated').textContent = new Date().toLocaleDateString();
        }

        // Initial update
        updateStats();

        // Refresh stats every 5 seconds
        setInterval(updateStats, 5000);
    </script>
</body>

</html>