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
                <a href="<?= route('about'); ?>" class="hover:text-blue-300 transition">About</a>
                <a href="<?= route('admission'); ?>" class="hover:text-blue-300 transition">Admissions</a>
                <a href="<?= route('fees'); ?>" class="hover:text-blue-300 transition">Fees</a>
                <a href="<?= route('timetable'); ?>" class="hover:text-blue-300 transition">Timetable</a>
                <a href="<?= route('academics'); ?>" class="hover:text-blue-300 transition">Academics</a>
                <a href="<?= route('staff'); ?>" class="hover:text-blue-300 transition">Staff</a>
                <a href="<?= route('uniform'); ?>" class="hover:text-blue-300 transition">Uniform</a>
                <a href="<?= route('gallery'); ?>" class="hover:text-blue-300 transition">Gallery</a>
                <a href="<?= route('upload-results'); ?>" class="hover:text-blue-300 transition">Results</a>

                <?php if (isset($_SESSION['user_session'])): ?>
                    <a href="<?= route('admin-section'); ?>" class="hover:text-blue-300 transition">Admin Section</a>
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
        <a href="<?= route('about'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">About</a>
        <a href="<?= route('admission'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Admissions</a>
        <a href="<?= route('fees'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Fees</a>
        <a href="<?= route('timetable'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Timetable</a>
        <a href="<?= route('academics'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Academics</a>
        <a href="<?= route('staff'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Staff</a>
        <a href="<?= route('uniform'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Uniform</a>
        <a href="<?= route('gallery'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Gallery</a>
        <a href="<?= route('uniform'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Uniform</a>
        <a href="<?= route('upload-results'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Results</a>


        

        <?php if (isset($_SESSION['user_session'])): ?>
            <a href="<?= route('admin-section'); ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Admin Section</a>

            <a href="<?= route('logout'); ?>"><button class="w-full text-left bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded-lg transition">Logout</button></a>
        <?php else: ?>
            <a href="<?= route('login'); ?>"><button class="w-full text-left bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded-lg transition">Login</button></a>

        <?php endif; ?>

    </div>
</nav>