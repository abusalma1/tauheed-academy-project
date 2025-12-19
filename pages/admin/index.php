<?php
$title = "Admin Dashboard";
include(__DIR__ . '/../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (!isset($user_type) || $user_type !== 'admin') {
    $_SESSION['failure'] = "Access denied! Only Admins are allowed.";
    header("Location: " . route('home'));
    exit();
}
?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/./includes/admins-section-nav.php") ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Admin Dashboard</h1>
            <p class="text-xl text-blue-200">Welcome back! Manage your school operations</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Management Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- School Info Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-8 rounded-t-lg">
                        <i class="fas fa-bullhorn text-white text-5xl mb-4"></i>
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
                            <a href="<?= route('users-management') ?>" class="flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                                <i class="fas fa-crown"></i>Admins
                            </a>
                        </div>
                        <a href="<?= route('users-management') ?>">
                            <button class="w-full mt-6 bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>

                    </div>
                </div>


                <!-- News Management Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-8 rounded-t-lg">
                        <i class="fas fa-newspaper text-white text-5xl mb-4" title="News"></i>
                        <h3 class="text-2xl font-bold text-white">News Management</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Publish and manage school news, announcements, and updates</p>
                        <div class="space-y-3">
                            <a href="<?= route('admin-news') ?>" class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold">
                                <i class="fas fa-list"></i>All News
                            </a>
                            <a href="<?= route('post-news') ?>" class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold">
                                <i class="fas fa-plus"></i>Create News
                            </a>
                        </div>
                        <a href="<?= route('admin-news') ?>">
                            <button class="w-full mt-6 bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>
                    </div>
                </div>

                <!-- Fees Management Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-8 rounded-t-lg">
                        <i class="fas fa-money-bill-wave text-white text-5xl mb-4" title="Fees"></i>
                        <h3 class="text-2xl font-bold text-white">Fees Management</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Manage school fees, payments, and financial records</p>
                        <div class="space-y-3">
                            <a href="<?= route('admin-fees') ?>" class="flex items-center gap-2 text-yellow-600 hover:text-yellow-700 font-semibold">
                                <i class="fas fa-list"></i>All Fees
                            </a>
                            <a href="<?= route('fees-assginment') ?>" class="flex items-center gap-2 text-yellow-600 hover:text-yellow-700 font-semibold">
                                <i class="fas fa-plus"></i>Create Fee
                            </a>
                        </div>
                        <a href="<?= route('fees-management') ?>">
                            <button class="w-full mt-6 bg-yellow-600 text-white py-3 rounded-lg font-semibold hover:bg-yellow-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <h1 class="text-3xl text-gray-600 font-bold py-5">General Studies Section</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Subjects Management Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 p-8 rounded-t-lg">
                        <i class="fas fa-book  text-white text-5xl mb-4" title="Subjects"></i>
                        <h3 class="text-2xl font-bold text-white">Subjects Management</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Create and manage Subjects for all classes</p>
                        <div class="space-y-3">
                            <a href="<?= route('subjects-management') ?>" class="flex items-center gap-2 text-pink-600 hover:text-pink-700 font-semibold">
                                <i class="fas fa-list" title="Subjects"></i>
                                All Subjects
                            </a>
                            <a href="<?= route('create-subject') ?>" class="flex items-center gap-2 text-pink-600 hover:text-pink-700 font-semibold">
                                <i class="fas fa-plus"></i>Create Subject
                            </a>
                        </div>
                        <a href="<?= route('subjects-management') ?>">
                            <button class="w-full mt-6 bg-pink-600 text-white py-3 rounded-lg font-semibold hover:bg-pink-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>

                    </div>
                </div>

                <!-- Classes Management Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 rounded-t-lg">
                        <!-- <i class="fas fa-book "></i> -->
                        <i class="fas fa-chalkboard-teacher text-white text-5xl mb-4" title="Classes"></i>

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
                        <a href="<?= route('class-arm-section-management') ?>">
                            <button class="w-full mt-6 bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>
                    </div>
                </div>

                <!-- Results Management Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-8 rounded-t-lg">
                        <i class="fas fa-clipboard-check text-white text-5xl mb-4" title="Results"></i>
                        <h3 class="text-2xl font-bold text-white">Results Management</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Record, update, and manage student results for all classes and terms</p>
                        <div class="space-y-3">
                            <a href="<?= route('admin-results-management') ?>" class="flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                                <i class="fas fa-list"></i>All Results
                            </a>
                            <a href="<?= route('admin-upload-results') ?>" class="flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                                <i class="fas fa-upload"></i>Upload Result
                            </a>

                        </div>
                        <a href="<?= route('admin-results-management') ?>">
                            <button class="w-full mt-6 bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>
                    </div>
                </div>

            </div>

            <h1 class="text-3xl text-gray-600 font-bold py-5">Qur’anic & Islamic Studies</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Subjects Management Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 p-8 rounded-t-lg">
                        <i class="fas fa-book  text-white text-5xl mb-4" title="Subjects"></i>
                        <h3 class="text-2xl font-bold text-white">Subjects Management</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Create and manage Subjects for all classes</p>
                        <div class="space-y-3">
                            <a href="<?= route('islamiyya-subjects-management') ?>" class="flex items-center gap-2 text-pink-600 hover:text-pink-700 font-semibold">
                                <i class="fas fa-list" title="Subjects"></i>
                                All Subjects
                            </a>
                            <a href="<?= route('create-islamiyya-subject') ?>" class="flex items-center gap-2 text-pink-600 hover:text-pink-700 font-semibold">
                                <i class="fas fa-plus"></i>Create Subject
                            </a>
                        </div>
                        <a href="<?= route('islamiyya-subjects-management') ?>">
                            <button class="w-full mt-6 bg-pink-600 text-white py-3 rounded-lg font-semibold hover:bg-pink-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>

                    </div>
                </div>

                <!-- Classes Management Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 rounded-t-lg">
                        <!-- <i class="fas fa-book "></i> -->
                        <i class="fas fa-chalkboard-teacher text-white text-5xl mb-4" title="Classes"></i>

                        <h3 class="text-2xl font-bold text-white">Classes Management</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Manage classes, sections, arms, and class assignments</p>
                        <div class="space-y-3">
                            <a href="<?= route('islamiyya-classes-management') ?>" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold">
                                <i class="fas fa-list"></i>View Classes
                            </a>
                            <a href="<?= route('create-islamiyya-class') ?>" class="flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold">
                                <i class="fas fa-plus"></i>Create Class
                            </a>
                        </div>
                        <a href="<?= route('islamiyya-class-arm-section-management') ?>">
                            <button class="w-full mt-6 bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>
                    </div>
                </div>

                <!-- Results Management Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-8 rounded-t-lg">
                        <i class="fas fa-clipboard-check text-white text-5xl mb-4" title="Results"></i>
                        <h3 class="text-2xl font-bold text-white">Results Management</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Record, update, and manage student results for all classes and terms</p>
                        <div class="space-y-3">
                            <a href="<?= route('admin-islamiyya-results-management') ?>" class="flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                                <i class="fas fa-list"></i>All Results
                            </a>
                            <a href="<?= route('admin-upload-islamiyya-results') ?>" class="flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold">
                                <i class="fas fa-upload"></i>Upload Result
                            </a>
                        </div>
                        <a href="<?= route('admin-islamiyya-results-management') ?>">
                            <button class="w-full mt-6 bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                                <i class="fas fa-arrow-right mr-2"></i>Manage
                            </button>
                        </a>
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

    </script>
</body>

</html>