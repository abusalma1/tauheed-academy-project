<?php
$title = 'Users Management';
include(__DIR__ . '/../../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

$admins    = selectAllData('admins');

$adminsCount    = countDataTotal('admins', true);

?>


<body class="bg-gray-50">
    <?php include(__DIR__ . '/../../includes/admins-section-nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-purple-900 to-purple-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Admin & Super User Management</h1>
            <p class="text-xl text-purple-200">Create and manage administrator accounts</p>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Search and Filter -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                        <input type="text" id="searchInput" placeholder="Search by name or email..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
                    </div>
                    <div id="filterContainer"></div>
                    <div class="flex items-end">
                        <a id="createBtn" href="<?= route('admin-create') ?>" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-center font-semibold">
                            <i class="fas fa-plus mr-2"></i>Create New
                        </a>
                    </div>
                </div>
            </div>

            <!-- Admins Section -->
            <div id="admins-section" class="user-section">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Administrators</h2>

                <!-- Admin Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Total Admins</p>
                        <p class="text-2xl font-bold text-purple-900"><?= $adminsCount['total'] ?></p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Super Admins</p>
                        <p class="text-2xl font-bold text-blue-600"><?= $adminsCount['superadmin'] ?></p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Regular Admins</p>
                        <p class="text-2xl font-bold text-green-600"><?= $adminsCount['admin'] ?></p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Active</p>
                        <p class="text-2xl font-bold text-orange-600"><?= $adminsCount['active'] ?></p>
                    </div>
                </div>

                <!-- Admin Role Filter -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Filter by Role</label>
                    <div class="flex gap-2">
                        <button class="admin-role-filter px-4 py-2 rounded-lg border-2 border-purple-900 text-purple-900 font-semibold" data-role="all">All</button>
                        <button class="admin-role-filter px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-700 font-semibold" data-role="superAdmin">Super Admin</button>
                        <button class="admin-role-filter px-4 py-2 rounded-lg border-2 border-gray-300 text-gray-700 font-semibold" data-role="admin">Admin</button>
                    </div>
                </div>

                <!-- Admins Grid - Hardcoded HTML -->
                <div id="adminsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <?php foreach ($admins as $admin) : ?>
                        <div class="admin-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition" data-role="<?= $admin['type'] ?>" data-search="<?= $admin['name'] . ' ' . $admin['email'] ?>">
                            <div class="bg-gradient-to-r from-purple-900 to-purple-700 h-24"></div>
                            <div class="px-6 pb-6">
                                <div class="flex justify-center -mt-12 mb-4">
                                    <img src="<?= !empty($admin['picture_path']) ? asset($admin['picture_path']) : asset('/images/avatar.png') ?>" alt="<?= $admin['name'] ?>" class="w-20 h-20 rounded-full border-4 border-white shadow-lg object-cover">
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 text-center mb-1"><?= $admin['name'] ?></h3>
                                <p class="text-sm text-gray-600 text-center mb-4"><?= $admin['email'] ?></p>

                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Phone:</span>
                                        <span class="font-semibold text-gray-900"><?= $admin['phone'] ?></span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Role:</span>
                                        <span class="px-3 py-1 bg-purple-100 text-purple-900 rounded-full text-xs font-semibold"><?= $admin['type'] ?></span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Department:</span>
                                        <span class="font-semibold text-gray-900"><?= $admin['department'] ?></span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Activity:</span>
                                        <span class="px-3 py-1 <?= $admin['status'] === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900' ?> rounded-full text-xs font-semibold capitalize"><?= $admin['status'] ?></span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-4">
                                    <!-- Edit -->
                                    <a href="<?= route('admin-update')  . '?id=' . $admin['id']  ?>"
                                        class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-center text-sm font-semibold">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>

                                    <a href="<?= route('upload-admin-picture')  . '?id=' . $admin['id']  ?>"
                                        class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-center text-sm font-semibold">
                                        <i class="fas fa-upload mr-1"></i>Upload Picture
                                    </a>

                                    <!-- Edit Password -->
                                    <a href="<?= route('update-user-password') . '?id=' . $admin['id']  . '&user_type=admin' ?>"
                                        class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-center font-semibold">
                                        <i class="fas fa-lock mr-2"></i>Edit Password
                                    </a>

                                    <!-- Delete -->
                                    <a href="<?= route('delete-user') . '?id=' . $admin['id'] ?>&table=admins&type=Admin"
                                        class="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition text-center text-sm font-semibold">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </a>

                                    <!-- View Details -->
                                    <a href="<?= route('view-user-details') . '?id=' . $admin['id'] . '&type=admin' ?>"
                                        class="flex-1 bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition text-center text-sm font-semibold">
                                        <i class="fas fa-eye mr-1"></i>View Details
                                    </a>
                                </div>

                            </div>
                        </div>
                    <?php endforeach ?>

                </div>
            </div>

        </div>
    </section>

    <?php include(__DIR__ . '/../../../../includes/footer.php'); ?>

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            // Filter admins
            document.querySelectorAll('.admin-card').forEach(card => {
                const searchData = card.dataset.search.toLowerCase();
                card.style.display = searchData.includes(searchTerm) ? '' : 'none';
            });

        });

        document.querySelectorAll('.admin-role-filter').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.admin-role-filter').forEach(b => {
                    b.classList.remove('border-purple-900', 'text-purple-900');
                    b.classList.add('border-gray-300', 'text-gray-700');
                });
                btn.classList.add('border-purple-900', 'text-purple-900');
                btn.classList.remove('border-gray-300', 'text-gray-700');

                const selectedRole = btn.dataset.role;
                document.querySelectorAll('.admin-card').forEach(card => {
                    if (selectedRole === 'all' || card.dataset.role === selectedRole) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>

</html>