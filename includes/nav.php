<!-- Navigation -->
<nav class="bg-blue-900 text-white sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo and School Name -->
            <div class="flex items-center gap-3">
                <img src="/placeholder.svg?height=50&width=50" alt="School Logo" class="h-12 w-12 rounded-full bg-white p-1">
                <div>
                    <h1 class="text-xl font-bold"><?= $school['name'] ?? 'Tauheed Academy' ?></h1>
                    <p class="text-xs text-blue-200"><?= $school['motto'] ?? '' ?></p>
                </div>
            </div>
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-6">
                <a href="<?= route('home') ?>" class="hover:text-blue-300 transition">Home</a>

                <div class="relative group">
                    <!-- Hover Button -->
                    <div class="hover:text-blue-300 transition flex items-center gap-1">
                        School Info
                        <span class="text-sm">▾</span>
                    </div>

                    <!-- Dropdown Menu -->
                    <div class="absolute left-0 mt-2 w-48 bg-blue-800 rounded-lg shadow-lg opacity-0 invisible 
                                group-hover:opacity-100 group-hover:visible transition-all duration-200">

                        <ul class="flex flex-col py-2">
                            <li> <a href="<?= route('about'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded"> About </a> </li>
                            <li> <a href="<?= route('admission'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded"> Admissions </a> </li>
                            <li> <a href="<?= route('fees'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded"> Fees </a> </li>
                            <li> <a href="<?= route('uniform'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded"> Uniform </a> </li>
                            <li> <a href="<?= route('gallery'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded"> Gallery </a> </li>
                        </ul>
                    </div>
                </div>
                <div class="relative group">
                    <!-- Hover Button -->
                    <div class="hover:text-blue-300 transition flex items-center gap-1">
                        Academics
                        <span class="text-sm">▾</span>
                    </div>

                    <!-- Dropdown Menu -->
                    <div class="absolute left-0 mt-2 w-48 bg-blue-800 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">

                        <ul class="flex flex-col py-2">
                            <li> <a href="<?= route('timetable'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded"> Timetable </a> </li>
                            <li> <a href="<?= route('academics'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded"> Academics </a> </li>
                            <li> <a href="<?= route('staff'); ?>" class="block px-4 py-2 hover:bg-blue-700 rounded"> Staff </a> </li>

                        </ul>
                    </div>
                </div>




                <?php if ($is_logged_in): ?>
                    <?php if ($user_type === 'teacher') : ?>
                        <a href="<?= route('upload-results'); ?>" class="hover:text-blue-300 transition">Results</a>
                    <?php elseif ($user_type === 'student') : ?>
                        <a href="<?= route('student-result'); ?>" class="hover:text-blue-300 transition">My Result</a>
                    <?php elseif ($user_type === 'guardian') : ?>
                        <a href="" class="hover:text-blue-300 transition">My Children</a>
                    <?php elseif ($user_type === 'admin'): ?>
                        <a href="<?= route('admin-section'); ?>" class="hover:text-blue-300 transition">Admin Section</a>
                    <?php endif ?>

                    <a href="<?= route('logout'); ?>"> <button class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg transition">Logout</button></a>
                <?php else: ?>
                    <a href="<?= route('login'); ?>"> <button class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg transition">Login</button></a>
                <?php endif ?>


            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-blue-800 px-4 py-4 space-y-2">
        <a href="<?= route('home'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Home</a>

        <!-- School Info Mobile -->
        <div class="py-2 px-3 rounded bg-blue-800">
            <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                <span>School Info</span>
                <span>▾</span>
            </button>

            <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                <a href="<?= route('about'); ?>" class="block px-4 py-2 hover:bg-blue-600">About</a>
                <a href="<?= route('admission'); ?>" class="block px-4 py-2 hover:bg-blue-600">Admissions</a>
                <a href="<?= route('fees'); ?>" class="block px-4 py-2 hover:bg-blue-600">Fees</a>
                <a href="<?= route('uniform'); ?>" class="block px-4 py-2 hover:bg-blue-600">Uniform</a>
                <a href="<?= route('gallery'); ?>" class="block px-4 py-2 hover:bg-blue-600">Gallery</a>
            </div>
        </div>
        <div class="py-2 px-3 rounded bg-blue-800">
            <button class="w-full flex justify-between items-center mobile-dropdown-btn">
                <span>Academics</span>
                <span>▾</span>
            </button>

            <div class="mobile-dropdown hidden flex-col mt-2 bg-blue-700 rounded-lg">
                <a href="<?= route('timetable'); ?>" class="block px-4 py-2 hover:bg-blue-600">Timetable</a>
                <a href="<?= route('academics'); ?>" class="block px-4 py-2 hover:bg-blue-600">Academics</a>
                <a href="<?= route('staff'); ?>" class="block px-4 py-2 hover:bg-blue-600">Staff</a>
            </div>
        </div>



        <?php if ($is_logged_in): ?>
            <?php if ($user_type === 'student') : ?>
                <a href="<?= route('student-result'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">My Results</a>
            <?php elseif ($user_type === 'teacher'): ?>
                <a href="<?= route('upload-results'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Results</a>
            <?php elseif ($user_type === 'guardian'): ?>
                <a href="" class="block py-2 hover:bg-blue-700 px-3 rounded">My Children</a>
            <?php elseif ($user_type === 'admin'): ?>
                <a href="<?= route('admin-section'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Admin Section</a>
            <?php endif; ?>
            <a href="<?= route('logout'); ?>"><button class="w-full text-left bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded-lg transition">Logout</button></a>
        <?php else: ?>
            <a href="<?= route('login'); ?>"><button class="w-full text-left bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded-lg transition">Login</button></a>

        <?php endif; ?>

    </div>
</nav>

