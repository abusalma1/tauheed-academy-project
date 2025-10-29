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
                <a href="<?= route('school-info') ?>" class="hover:text-blue-300 transition">Manage School Info</a>
                <a href="<?= route('users-management') ?>" class="hover:text-blue-300 transition">Manage Users</a>

                <a href="<?= route('class-arm-section-management') ?>" class="hover:text-blue-300 transition">Manage Classes</a>
                <a href="<?= route('home') ?>" class="hover:text-blue-300 transition">Back to Site</a>
                <a href="<?= route('logout') ?>" class="hover:text-blue-300 transition">Logout</a>

            </div>
            <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-blue-800 px-4 py-4 space-y-2">
        <a href="<?= route('school-info') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Manage Schoool Info</a>
        <a href="<?= route('users-management') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Manage Users</a>
        <a href="<?= route('classes-management') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Manage Classes</a>

        <a href="<?= route('home') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Back to Site</a>
        <a href="<?= route('logout') ?>" class="block py-2 hover:bg-blue-700 px-3 rounded">Logout</a>

    </div>
</nav>