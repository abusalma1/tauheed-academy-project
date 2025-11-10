<?php
$title = 'Classes, Sections & Arms Management';
include(__DIR__ . '/../../../includes/header.php');


$armsCount = countDataTotal('class_arms')['total'];
$classesCount = countDataTotal('classes')['total'];
$studentsCount = countDataTotal('students')['total'];
$sectionsCount = countDataTotal('sections')['total'];



?>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/../includes/admins-section-nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Classes, Sections & Arms Management</h1>
            <p class="text-xl text-blue-200">Manage school structure, sections, and class divisions</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Management Type Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <!-- Classes Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-indigo-100 p-4 rounded-lg">
                            <i class="fas fa-book text-indigo-600 text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-indigo-600" id="classCount"><?= $classesCount ?></span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Classes</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage all classes in the school</p>
                    <a href="<?= route('classes-management') ?>" class="inline-block w-full text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                        <i class="fas fa-arrow-right mr-2"></i>Manage
                    </a>
                </div>

                <!-- Sections Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-cyan-100 p-4 rounded-lg">
                            <i class="fas fa-layer-group text-cyan-600 text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-cyan-600" id="sectionCount"><?= $sectionsCount ?></span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Sections</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage educational sections</p>
                    <a href="<?= route('sections-management') ?>" class="inline-block w-full text-center bg-cyan-600 text-white py-2 rounded-lg font-semibold hover:bg-cyan-700 transition">
                        <i class="fas fa-arrow-right mr-2"></i>Manage
                    </a>
                </div>

                <!-- Arms Card -->
                <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-teal-100 p-4 rounded-lg">
                            <i class="fas fa-sitemap text-teal-600 text-2xl"></i>
                        </div>
                        <span class="text-3xl font-bold text-teal-600" id="armCount"><?= $armsCount ?></span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Class Arms</h3>
                    <p class="text-sm text-gray-600 mb-4">Manage class divisions (A, B, C...)</p>
                    <a href="<?= route('arms-management') ?>" class="inline-block w-full text-center bg-teal-600 text-white py-2 rounded-lg font-semibold hover:bg-teal-700 transition">
                        <i class="fas fa-arrow-right mr-2"></i>Manage
                    </a>
                </div>
            </div>

            <!-- Overall Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Classes</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="totalClasses"><?= $classesCount ?></p>
                        </div>
                        <i class="fas fa-book text-4xl text-indigo-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Students</p>
                            <p class="text-3xl font-bold text-cyan-600 mt-2" id="totalStudentsEnrolled"><?= $studentsCount ?></p>
                        </div>
                        <i class="fas fa-users text-4xl text-cyan-200"></i>
                    </div>
                </div>

                <!-- <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Capacity</p>
                            <p class="text-3xl font-bold text-teal-600 mt-2" id="totalCapacity">0</p>
                        </div>
                        <i class="fas fa-chair text-4xl text-teal-200"></i>
                    </div>
                </div> -->
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="<?= route('create-class') ?>" class="flex items-center gap-3 p-4 border-2 border-indigo-200 rounded-lg hover:bg-indigo-50 transition">
                        <i class="fas fa-plus text-indigo-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Create Class</p>
                            <p class="text-xs text-gray-600">Add new class</p>
                        </div>
                    </a>

                    <a href="<?= route('create-section') ?>" class="flex items-center gap-3 p-4 border-2 border-cyan-200 rounded-lg hover:bg-cyan-50 transition">
                        <i class="fas fa-plus text-cyan-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Create Section</p>
                            <p class="text-xs text-gray-600">Add new section</p>
                        </div>
                    </a>

                    <a href="<?= route('create-class-arm') ?>" class="flex items-center gap-3 p-4 border-2 border-teal-200 rounded-lg hover:bg-teal-50 transition">
                        <i class="fas fa-plus text-teal-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Create Class Arm</p>
                            <p class="text-xs text-gray-600">Add new class division</p>
                        </div>
                    </a>

                    <a href="<?= route('classes-management') ?>" class="flex items-center gap-3 p-4 border-2 border-indigo-200 rounded-lg hover:bg-indigo-50 transition">
                        <i class="fas fa-eye text-indigo-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">View Classes</p>
                            <p class="text-xs text-gray-600">View all classes by section</p>
                        </div>
                    </a>

                    <a href="<?= route('users-management') ?>" class="flex items-center gap-3 p-4 border-2 border-cyan-200 rounded-lg hover:bg-cyan-50 transition">
                        <i class="fas fa-eye text-cyan-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">View Teachers</p>
                            <p class="text-xs text-gray-600">View teachers by section</p>
                        </div>
                    </a>

                    <a href="<?= route('users-management') ?>" class="flex items-center gap-3 p-4 border-2 border-teal-200 rounded-lg hover:bg-teal-50 transition">
                        <i class="fas fa-eye text-teal-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">View Students</p>
                            <p class="text-xs text-gray-600">View students by class</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../../../includes/footer.php'); ?>

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