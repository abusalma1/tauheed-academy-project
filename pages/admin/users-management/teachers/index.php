<?php
$title = 'Users Management';
include(__DIR__ . '/../../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

// Fetch data using helper functions (assuming they are PDO-based)
$teachers  = selectAllData('teachers');

$teachersCount  = countDataTotal('teachers', true);
?>


<body class="bg-gray-50">
    <?php include(__DIR__ . '/../../includes/admins-section-nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700   text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Teachers Management</h1>
            <p class="text-xl text-blue-200">Create and manage teacher accounts</p>

        </div>
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
                        <a id="createBtn" href="<?= route('teacher-create') ?>" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-center font-semibold">
                            <i class="fas fa-plus mr-2"></i>Create New
                        </a>
                    </div>
                </div>
            </div>
            <!-- Teachers Section -->
            <div id="teachers-section" class="user-section">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Teachers</h2>

                <!-- Teacher Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Total Teachers</p>
                        <p class="text-2xl font-bold text-blue-900"><?= $teachersCount['total'] ?></p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Active</p>
                        <p class="text-2xl font-bold text-green-600"><?= $teachersCount['active'] ?></p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Subjects</p>
                        <p class="text-2xl font-bold text-orange-600">nill</p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Departments</p>
                        <p class="text-2xl font-bold text-purple-600">nill</p>
                    </div>
                </div>

                <!-- Teachers Grid - Hardcoded HTML -->
                <div id="teachersContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <?php foreach ($teachers as $teacher) : ?>
                        <div class="teacher-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition" data-search="<?= $teacher['name'] . ' ' . $teacher['email']   ?>">
                            <div class="bg-gradient-to-r from-blue-900 to-blue-700 h-24"></div>
                            <div class="px-6 pb-6">
                                <div class="flex justify-center -mt-12 mb-4">
                                    <img src="/placeholder.svg?height=80&width=80" alt="<?= $teacher['name'] ?>" class="w-20 h-20 rounded-full border-4 border-white shadow-lg">
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 text-center mb-1"><?= $teacher['name'] ?></h3>
                                <p class="text-sm text-gray-600 text-center mb-4"><?= $teacher['email'] ?></p>

                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Subject:</span>
                                        <span class="font-semibold text-gray-900">Nill</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Qualification:</span>
                                        <span class="font-semibold text-gray-900"><?= $teacher['qualification'] ?></span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">Activity:</span>
                                        <span class="px-3 py-1 <?= $teacher['status'] === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900' ?> rounded-full text-xs font-semibold capitalize"><?= $teacher['status'] ?></span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-4">

                                    <a href="<?= route('teacher-update') . '?id=' . $teacher['id'] ?>" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-center text-sm font-semibold">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <a href="<?= route('update-user-password') . '?id=' . $teacher['id']  . '&user_type=teacher' ?>" class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition text-center font-semibold">
                                        <i class="fas fa-lock mr-2"></i>Edit Password
                                    </a>
                                    <a href="<?= route('delete-user') . '?id=' . $teacher['id'] ?>&table=teachers&type=Teacher" class="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition text-center text-sm font-semibold">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </a>

                                    <a href="<?= route('view-user-details') . '?id=' . $teacher['id'] . '&type=teacher' ?>"
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
            // Filter teachers
            document.querySelectorAll('.teacher-card').forEach(card => {
                const searchData = card.dataset.search.toLowerCase();
                card.style.display = searchData.includes(searchTerm) ? '' : 'none';
            });

        });
    </script>
</body>

</html>