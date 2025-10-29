<?php
$title = "Admin Dashboard";
include(__DIR__ . '/../../includes/header.php');

?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/./includes/admins-section-nav.php") ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Admin Dashboard</h1>
            <p class="text-xl text-blue-200">Welcome back! Manage your school operations</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Management Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- School Info Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-8 rounded-t-lg">
                        <i class="fas fa-school text-white text-5xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-white">School Information</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Manage school details, contact information, and general settings</p>
                        <div class="space-y-3">
                            <a href="<?= route('school-info') ?>" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-semibold">
                                <i class="fas fa-edit"></i>Edit School Info
                            </a>
                            <a href="<?= route('school-info') ?>" class="flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-semibold">
                                <i class="fas fa-eye"></i>View Details
                            </a>
                        </div>
                        <a href="<?= route('school-info') ?>">
                            <button class="w-full mt-6 bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>
                    </div>
                </div>

                <!-- User Management Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-8 rounded-t-lg">
                        <i class="fas fa-users text-white text-5xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-white">User Management</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Create and manage admins, teachers, guardians, and students</p>
                        <div class="space-y-3">
                            <a href="<?= route('users-management') ?>" class="flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                                <i class="fas fa-users-cog"></i>All Users
                            </a>
                            <a href="<?= route('admins-management') ?>" class="flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                                <i class="fas fa-crown"></i>Admins
                            </a>
                        </div>
                        <a href="<?= route('admins-management') ?>">
                            <button class="w-full mt-6 bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>

                    </div>
                </div>

                <!-- Classes Management Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 rounded-t-lg">
                        <i class="fas fa-book text-white text-5xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-white">Classes Management</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Manage classes, sections, arms, and class assignments</p>
                        <div class="space-y-3">
                            <a href="<?= route('classes-management') ?>" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold">
                                <i class="fas fa-list"></i>View Classes
                            </a>
                            <a href="<?= route('create-class') ?>" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold">
                                <i class="fas fa-plus"></i>Create Class
                            </a>
                        </div>
                        <a href="<?= route('classes-management') ?>">
                            <button class="w-full mt-6 bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Users</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">0</p>
                        </div>
                        <i class="fas fa-users text-4xl text-indigo-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Classes</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">16</p>
                        </div>
                        <i class="fas fa-book text-4xl text-purple-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Sections</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">5</p>
                        </div>
                        <i class="fas fa-layer-group text-4xl text-green-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Active Classes</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">16</p>
                        </div>
                        <i class="fas fa-check-circle text-4xl text-orange-200"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="<?= route('school-info') ?>" class="flex items-center gap-3 p-4 border-2 border-indigo-200 rounded-lg hover:bg-indigo-50 transition">
                        <i class="fas fa-edit text-indigo-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Edit School Info</p>
                            <p class="text-xs text-gray-600">Update school details</p>
                        </div>
                    </a>

                    <a href="<?= route('users-management') ?>" class="flex items-center gap-3 p-4 border-2 border-purple-200 rounded-lg hover:bg-purple-50 transition">
                        <i class="fas fa-users-cog text-purple-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Manage Users</p>
                            <p class="text-xs text-gray-600">Create & manage accounts</p>
                        </div>
                    </a>

                    <a href="<?= route('create-class') ?>" class="flex items-center gap-3 p-4 border-2 border-green-200 rounded-lg hover:bg-green-50 transition">
                        <i class="fas fa-plus text-green-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Create Class</p>
                            <p class="text-xs text-gray-600">Add new class</p>
                        </div>
                    </a>

                    <a href="<?= route('classes-management') ?>" class="flex items-center gap-3 p-4 border-2 border-orange-200 rounded-lg hover:bg-orange-50 transition">
                        <i class="fas fa-list text-orange-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">View Classes</p>
                            <p class="text-xs text-gray-600">Browse all classes</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../includes/footer.php"); ?>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>