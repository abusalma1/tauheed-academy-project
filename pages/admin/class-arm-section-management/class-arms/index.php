<?php
$title = "Sections Management";
include(__DIR__ . '/../../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}


$arms = selectAllData('class_arms');

$armsCount = countDataTotal('class_arms')['total'];
$classesCount = countDataTotal('classes')['total'];
$studentsCount = countDataTotal('students')['total'];

?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php') ?>



    <!-- Page Header -->
    <section class="bg-amber-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">View Class Arms</h1>
                    <p class="text-xl text-amber-200">Browse and manage all class divisions</p>
                </div>
                <a href="<?= route('create-class-arm') ?>" class="bg-white text-amber-900 px-6 py-3 rounded-lg font-semibold hover:bg-amber-100 transition">
                    <i class="fas fa-plus mr-2"></i>Create Arm
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Arms</p>
                            <p class="text-3xl font-bold text-amber-900" id="totalArms"><?= $armsCount ?></p>
                        </div>
                        <i class="fas fa-sitemap text-4xl text-amber-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Classes</p>
                            <p class="text-3xl font-bold text-green-600" id="totalClasses"><?= $classesCount ?></p>
                        </div>
                        <i class="fas fa-book text-4xl text-green-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Students</p>
                            <p class="text-3xl font-bold text-blue-600" id="totalStudents"><?= $studentsCount ?></p>
                        </div>
                        <i class="fas fa-users text-4xl text-blue-200"></i>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search by Arm Name</label>
                        <input type="text" id="searchInput" placeholder="Enter arm name..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-900">
                    </div>
                    <div class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Filter by Status</label>
                        <select id="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-900">
                            <option value="">All Status</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Class Arms Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-amber-900 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Arm Name</th>
                            <th class="px-6 py-4 text-left font-semibold">Description</th>
                            <th class="px-6 py-4 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="armsTableBody" class="divide-y divide-gray-200">
                        <?php foreach ($arms as $arm) : ?>
                            <tr class="hover:bg-gray-50 transition arm-row" data-name="<?= $arm['name'] ?>" data-status="active">
                                <td class="px-6 py-4 font-semibold text-gray-900">Arm <?= $arm['name'] ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= $arm['description'] ?></td>


                                <td class="px-6 py-4 text-center">
                                    <a href="<?= route('update-class-arm') ?>?id=<?= $arm['id'] ?>">
                                        <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </a>
                                    <a href="<?= route('delete-class-arm') ?>?id=<?= $arm['id'] ?>">
                                        <button class="text-red-600 hover:text-red-900 font-semibold">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../../includes/footer.php'); ?>


    <script>
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const armRows = document.querySelectorAll('.arm-row');

        function filterArms() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;

            armRows.forEach(row => {
                const name = row.getAttribute('data-name').toLowerCase();
                const status = row.getAttribute('data-status');

                const matchesSearch = name.includes(searchTerm);
                const matchesStatus = !statusValue || status === statusValue;

                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterArms);
        statusFilter.addEventListener('change', filterArms);
    </script>
</body>

</html>