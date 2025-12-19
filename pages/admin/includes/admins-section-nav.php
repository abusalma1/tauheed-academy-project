<!-- Navigation -->

<nav class="bg-gradient-to-r from-blue-900 to-blue-800 text-white sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo + Title -->
            <div class="flex items-center gap-3">
                <img src="<?= asset('images/logo.png') ?>" alt="School Logo" class="h-12 w-12 rounded-full bg-white p-1">
                <div>
                    <h1 class="text-xl font-bold"><?= $school['name'] ?? 'Tauheed Academy' ?></h1>
                    <p class="text-xs text-blue-200">Admin Section</p>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-6 text-sm">
                <a href="<?= route('admin-section'); ?>" class="hover:text-blue-300 transition">Admin Dashboard</a>

                <!-- General Studies -->
                <div class="relative">
                    <button class="dropdown-btn flex items-center gap-1 hover:text-blue-300 transition">
                        General Stu. <span class="text-sm">▾</span>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-60 bg-blue-800 rounded-lg shadow-lg hidden">
                        <ul class="flex flex-col py-2">
                            <li><a href="<?= route('subjects-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Subjects</a></li>
                            <li><a href="<?= route('class-arm-section-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Classes</a></li>
                            <li><a href="<?= route('admin-results-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Results Management</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Islamiyya -->
                <div class="relative">
                    <button class="dropdown-btn flex items-center gap-1 hover:text-blue-300 transition">
                        Islamiyya <span class="text-sm">▾</span>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-60 bg-blue-800 rounded-lg shadow-lg hidden">
                        <ul class="flex flex-col py-2">
                            <li><a href="<?= route('islamiyya-subjects-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Subjects</a></li>
                            <li><a href="<?= route('islamiyya-class-arm-section-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Classes</a></li>
                            <li><a href="<?= route('admin-islamiyya-results-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Results Management</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Finance -->
                <div class="relative">
                    <button class="dropdown-btn flex items-center gap-1 hover:text-blue-300 transition">
                        Finance <span class="text-sm">▾</span>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-blue-800 rounded-lg shadow-lg hidden">
                        <ul class="flex flex-col py-2">
                            <li><a href="<?= route('fees-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Fees</a></li>
                        </ul>
                    </div>
                </div>

                <!-- School Management -->
                <div class="relative">
                    <button class="dropdown-btn flex items-center gap-1 hover:text-blue-300 transition">
                        School Management <span class="text-sm">▾</span>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-blue-800 rounded-lg shadow-lg hidden">
                        <ul class="flex flex-col py-2">
                            <li><a href="<?= route('users-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Users</a></li>
                            <li><a href="<?= route('school-info'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">School Info</a></li>
                            <li><a href="<?= route('admin-news'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">News</a></li>
                            <li><a href="<?= route('term-session-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Terms & Sessions</a></li>
                            <li><a href="<?= route('promotion'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Promotion</a></li>
                        </ul>
                    </div>
                </div>

                <a href="<?= route('home') ?>" class="hover:text-blue-300 transition">Back to Site</a>
                <a href="<?= route('logout') ?>">
                    <button class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg transition">Logout</button>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-blue-800 px-4 py-4 space-y-2">
        <a href="<?= route('admin-section') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Admin Dashboard</a>

        <div class="py-2 px-3 rounded bg-blue-800">
            <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                <span>General Stu.</span>
                <span>▾</span>
            </button>

            <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                <a href="<?= route('subjects-management'); ?>" class="block px-4 py-2 hover:bg-blue-600">Subjects</a>
                <a href="<?= route('class-arm-section-management'); ?>" class="block px-4 py-2 hover:bg-blue-600">Classes</a>
                <a href="<?= route('admin-results-management'); ?>" class="block px-4 py-2 hover:bg-blue-600"> Results Management</a>
            </div>
        </div>

        <div class="py-2 px-3 rounded bg-blue-800">
            <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                <span>Islamiyya</span>
                <span>▾</span>
            </button>

            <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                <a href="<?= route('islamiyya-subjects-management'); ?>" class="block px-4 py-2 hover:bg-blue-600">Subjects</a>
                <a href="<?= route('islamiyya-class-arm-section-management'); ?>" class="block px-4 py-2 hover:bg-blue-600">Classes</a>
                <a href="<?= route('admin-islamiyya-results-management'); ?>" class="block px-4 py-2 hover:bg-blue-600"> Results Management</a>
            </div>
        </div>

        <div class="py-2 px-3 rounded bg-blue-800">
            <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                <span>Finance</span>
                <span>▾</span>
            </button>

            <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                <a href="<?= route('fees-management'); ?>" class="block px-4 py-2 hover:bg-blue-600">Fees</a>

            </div>
        </div>

        <div class="py-2 px-3 rounded bg-blue-800">
            <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                <span>School Management</span>
                <span>▾</span>
            </button>

            <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                <a href="<?= route('users-management'); ?>" class="block px-4 py-2 hover:bg-blue-600">Users</a>
                <a href="<?= route('school-info'); ?>" class="block px-4 py-2 hover:bg-blue-600">School Info</a>
                <a href="<?= route('admin-news'); ?>" class="block px-4 py-2 hover:bg-blue-600"> News</a>
                <a href="<?= route('term-session-management'); ?>" class="block px-4 py-2 hover:bg-blue-600"> Terms & Sessions</a>

                <a href="<?= route('promotion'); ?>" class="block px-4 py-2 hover:bg-blue-600"> Promotion(Term/Sesssion Transition)</a>
            </div>
        </div>

        <a href="<?= route('home') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">back to Site</a>
        <a href="<?= route('logout') ?>"><button class="w-full text-left bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded-lg transition">Logout</button></a>

    </div>
</nav>

<?php
include(__DIR__ . '/../../../includes/components/success-notification.php');
include(__DIR__ . '/../../../includes/components/failure-notification.php');
