<!-- Navigation -->
<nav class="bg-blue-900 text-white sticky top-0 z-50 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center gap-3">
                <img src="/placeholder.svg?height=50&width=50" alt="School Logo" class="h-12 w-12 rounded-full bg-white p-1">
                <div>
                    <h1 class="text-xl font-bold"><?= $school['name'] ?? 'Tauheed Academy' ?></h1>
                    <p class="text-xs text-blue-200"><?= $school['motto']; ?></p>

                </div>
            </div>
            <div class="hidden md:flex items-center gap-6">
                <a href="<?= route('admin-section'); ?>" class="hover:text-blue-300 transition">Admin Dashboard</a>
                <a href="<?= route('term-session-management'); ?>" class="hover:text-blue-300 transition">Terms & Sessions</a>
                <a href="<?= route('promotion'); ?>" class="hover:text-blue-300 transition">Promotion</a>
                <a href="<?= route('school-info') ?>" class="hover:text-blue-300 transition">School Info</a>
                <a href="<?= route('subjects-management') ?>" class="hover:text-blue-300 transition">Subjects</a>
                <a href="<?= route('users-management') ?>" class="hover:text-blue-300 transition">Users</a>
                <a href="<?= route('class-arm-section-management') ?>" class="hover:text-blue-300 transition">Classes</a>
                <a href="<?= route('home') ?>" class="hover:text-blue-300 transition">back to Site</a>
                <a href="<?= route('logout') ?>"> <button class="bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-lg transition">Logout</button></a>

            </div>
            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-blue-800 px-4 py-4 space-y-2">
        <a href="<?= route('admin-section') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Admin Dashboard</a>
        <a href="<?= route('term-session-management') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Terms & Sessions</a>
        <a href="<?= route('school-info') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Manage Schoool Info</a>
        <a href="<?= route('subjects-management') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Manage Subjects</a>
        <a href="<?= route('users-management') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Manage Users</a>
        <a href="<?= route('class-arm-section-management') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Manage Classes</a>

        <a href="<?= route('home') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">back to Site</a>
        <a href="<?= route('logout') ?>"><button class="w-full text-left bg-blue-700 hover:bg-blue-800 px-3 py-2 rounded-lg transition">Logout</button></a>

    </div>
</nav>