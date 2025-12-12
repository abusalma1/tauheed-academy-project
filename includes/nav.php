<!-- Navigation -->
<nav class="bg-gradient-to-r from-blue-900 to-blue-800 text-white sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo and School Name -->
            <div class="flex items-center gap-3">
                <img src="<?= asset('images/logo.png') ?>" alt="School Logo" class="h-12 w-12 rounded-full bg-white p-1">


                <div>
                    <h1 class="text-xl font-bold"><?= $school['name'] ?? 'Tauheed Academy' ?></h1>
                    <p class="text-xs text-blue-200"><?= $school['motto'] ?? '' ?></p>
                </div>
            </div>
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-6 text-sm">
                <a href="<?= route('home') ?>" class="hover:text-blue-300 transition">Home</a>
                <a href="<?= route('news') ?>" class="hover:text-blue-300 transition">News</a>

                <!-- School Info Dropdown -->
                <div class="relative">
                    <button class="dropdown-btn flex items-center gap-1 hover:text-blue-300 transition">
                        School Info <span class="text-sm">▾</span>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-blue-800 rounded-lg shadow-lg hidden">
                        <ul class="flex flex-col py-2">
                            <li><a href="<?= route('about'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">About</a></li>
                            <li><a href="<?= route('contact'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Contact Us</a></li>
                            <li><a href="<?= route('admission'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Admissions</a></li>
                            <li><a href="<?= route('fees'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Fees</a></li>
                            <li><a href="<?= route('gallery'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Gallery</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Academics Dropdown -->
                <div class="relative">
                    <button class="dropdown-btn flex items-center gap-1 hover:text-blue-300 transition">
                        Academics <span class="text-sm">▾</span>
                    </button>
                    <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-blue-800 rounded-lg shadow-lg hidden">
                        <ul class="flex flex-col py-2">
                            <li><a href="<?= route('academics'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Academics</a></li>
                            <li><a href="<?= route('staff'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Staff</a></li>
                        </ul>
                    </div>
                </div>

                <?php if ($is_logged_in): ?>
                    <a href="<?= route('profile') ?>" class="hover:text-blue-300 transition">Profile</a>

                    <?php if ($user_type === 'teacher') : ?>
                        <!-- Teacher Dropdowns -->
                        <div class="relative">
                            <button class="dropdown-btn flex items-center gap-1 hover:text-blue-300 transition">
                                My Class <span class="text-sm">▾</span>
                            </button>
                            <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-blue-800 rounded-lg shadow-lg hidden">
                                <ul class="flex flex-col py-2">
                                    <li><a href="<?= route('my-class'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">General Studies</a></li>
                                    <li><a href="<?= route('my-islamiyya-class'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Qur'anic & Islamic Studies</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="relative">
                            <button class="dropdown-btn flex items-center gap-1 hover:text-blue-300 transition">
                                Upload Results <span class="text-sm">▾</span>
                            </button>
                            <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-blue-800 rounded-lg shadow-lg hidden">
                                <ul class="flex flex-col py-2">
                                    <li><a href="<?= route('results-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">General Studies</a></li>
                                    <li><a href="<?= route('islamiyya-results-management'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Qur'anic & Islamic Studies</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php elseif ($user_type === 'student') : ?>
                        <div class="relative">
                            <button class="dropdown-btn flex items-center gap-1 hover:text-blue-300 transition">
                                My Results <span class="text-sm">▾</span>
                            </button>
                            <div class="dropdown-menu absolute left-0 mt-2 w-48 bg-blue-800 rounded-lg shadow-lg hidden">
                                <ul class="flex flex-col py-2">
                                    <li><a href="<?= route('student-result'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">General Studies</a></li>
                                    <li><a href="<?= route('student-islamiyya-result'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded">Qur'anic & Islamic Studies</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php elseif ($user_type === 'guardian') : ?>
                        <a href="<?= route('my-children') ?>" class="hover:text-blue-300 transition">Me & My Children</a>
                    <?php elseif ($user_type === 'admin'): ?>
                        <a href="<?= route('admin-section'); ?>" class="hover:text-blue-300 transition">Admin Section</a>
                    <?php endif ?>

                    <a href="<?= route('logout'); ?>">
                        <button class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg transition">Logout</button>
                    </a>
                <?php else: ?>
                    <a href="<?= route('login'); ?>">
                        <button class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg transition">Login</button>
                    </a>
                <?php endif ?>
            </div>


            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-blue-800 px-4 py-4 space-y-2 text-sm">
        <a href="<?= route('home'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Home</a>
        <a href="<?= route('news'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">News</a>


        <!-- School Info Mobile -->
        <div class="py-2 px-3 rounded bg-blue-800">
            <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                <span>School Info</span>
                <span>▾</span>
            </button>

            <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                <a href="<?= route('about'); ?>" class="block px-4 py-2 hover:bg-blue-600">About</a>
                <a href="<?= route('contact'); ?>" class="block px-4 py-2 hover:bg-blue-600">Contact Us</a>
                <a href="<?= route('admission'); ?>" class="block px-4 py-2 hover:bg-blue-600">Admissions</a>
                <a href="<?= route('fees'); ?>" class="block px-4 py-2 hover:bg-blue-600">Fees</a>
                <a href="<?= route('gallery'); ?>" class="block px-4 py-2 hover:bg-blue-600">Gallery</a>
            </div>
        </div>
        <div class="py-2 px-3 rounded bg-blue-800">
            <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                <span>Academics</span>
                <span>▾</span>
            </button>

            <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                <a href="<?= route('academics'); ?>" class="block px-4 py-2 hover:bg-blue-600">Academics</a>
                <a href="<?= route('staff'); ?>" class="block px-4 py-2 hover:bg-blue-600">Staff</a>
            </div>
        </div>



        <?php if ($is_logged_in): ?>
            <a href="<?= route('profile'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Profile</a>

            <?php if ($user_type === 'student') : ?>
                <div class="py-2 px-3 rounded bg-blue-800">
                    <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                        <span>My Results</span>
                        <span>▾</span>
                    </button>

                    <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                        <a href="<?= route('student-result'); ?>" class="block px-4 py-2 hover:bg-blue-600">General Studies</a>
                        <a href="<?= route('student-islamiyya-result'); ?>" class="block px-4 py-2 hover:bg-blue-600">Qur'anic & Islamic Studies</a>
                    </div>
                </div>
            <?php elseif ($user_type === 'teacher'): ?>
                <div class="py-2 px-3 rounded bg-blue-800">
                    <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                        <span>My Class</span>
                        <span>▾</span>
                    </button>

                    <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                        <a href="<?= route('my-class'); ?>" class="block px-4 py-2 hover:bg-blue-600">General Studies</a>
                        <a href="<?= route('my-islamiyya-class'); ?>" class="block px-4 py-2 hover:bg-blue-600">Qur'anic & Islamic Studies</a>
                    </div>
                </div>
                <div class="py-2 px-3 rounded bg-blue-800">
                    <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                        <span>Upload Results</span>
                        <span>▾</span>
                    </button>

                    <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                        <a href="<?= route('results-management'); ?>" class="block px-4 py-2 hover:bg-blue-600">General Studies</a>
                        <a href="<?= route('islamiyya-results-management'); ?>" class="block px-4 py-2 hover:bg-blue-600">Qur'anic & Islamic Studies</a>
                    </div>
                </div>
            <?php elseif ($user_type === 'guardian'): ?>
                <a href="<?= route('my-children') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Me & My Children</a>
            <?php elseif ($user_type === 'admin'): ?>
                <a href="<?= route('admin-section'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Admin Section</a>
            <?php endif; ?>
            <a href="<?= route('logout'); ?>"><button class="w-full text-left bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded-lg transition">Logout</button></a>
        <?php else: ?>
            <a href="<?= route('login'); ?>"><button class="w-full text-left bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded-lg transition">Login</button></a>

        <?php endif; ?>

    </div>
</nav>

<?php
include(__DIR__ . '/./components/success-notification.php');
include(__DIR__ . '/./components/failure-notification.php');
