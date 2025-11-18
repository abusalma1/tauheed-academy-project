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
                        <img src="/placeholder.svg?height=80&width=80" alt="<?= $admin['name'] ?>" class="w-20 h-20 rounded-full border-4 border-white shadow-lg">
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
                        <a href="<?= route('admin-update')  . '?id=' . $admin['id']  ?>" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-center text-sm font-semibold">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                       
                                <a href="<?= route('update-user-password') . '?id=' . $admin['id']  . '&user_type=admin'?>" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-center text-sm font-semibold">
                                                            <i class="fas fa-edit mr-1"></i>Edit Password
                        </a>

                        <a href="" class="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition text-center text-sm font-semibold">
                            <i class="fas fa-trash mr-1"></i>Delete
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>
</div>