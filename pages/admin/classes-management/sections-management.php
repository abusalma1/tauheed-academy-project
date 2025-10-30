<?php
$title = "Sections Management";
include(__DIR__ . '/../../../includes/header.php');

$statement = $connection->prepare("
    SELECT 
        sections.id AS section_id,
        sections.name AS section_name,
        sections.description,
        teachers.id AS teacher_id,
        teachers.name AS head_teacher_name,
        COUNT(classes.id) AS class_count
    FROM sections
    LEFT JOIN teachers 
        ON sections.head_teacher_id = teachers.id
    LEFT JOIN classes 
        ON classes.section_id = sections.id
    GROUP BY 
        sections.id, 
        sections.name, 
        sections.description,
        teachers.id, 
        teachers.name
");

$statement->execute();
$result = $statement->get_result();
$sections = $result->fetch_all(MYSQLI_ASSOC);

$classesCount = countDataTotal('classes')['total'];
$sectionsCount = countDataTotal('sections')['total'];
$studentsCount = countDataTotal('students')['total'];


?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php') ?>


    <!-- Page Header -->
    <section class="bg-indigo-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">View Sections</h1>
                    <p class="text-xl text-indigo-200">Browse and manage all school sections</p>
                </div>
                <a href="<?= route('create-section') ?>" class="bg-white text-indigo-900 px-6 py-3 rounded-lg font-semibold hover:bg-indigo-100 transition">
                    <i class="fas fa-plus mr-2"></i>Create Section
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
                            <p class="text-gray-600 text-sm">Total Sections</p>
                            <p class="text-3xl font-bold text-indigo-900" id="totalSections"><?= $sectionsCount ?></p>
                        </div>
                        <i class="fas fa-layer-group text-4xl text-indigo-200"></i>
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
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search by Section Name</label>
                        <input type="text" id="searchInput" placeholder="Enter section name..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900">
                    </div>
                    <div class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Filter by Status</label>
                        <select id="statusFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900">
                            <option value="">All Status</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Sections Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-indigo-900 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold">Section Name</th>
                            <th class="px-6 py-4 text-left font-semibold">Head Teacher</th>
                            <th class="px-6 py-4 text-left font-semibold">Classes</th>
                            <th class="px-6 py-4 text-center font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sectionsTableBody" class="divide-y divide-gray-200">
                        <?php foreach ($sections as $section) : ?>
                            <tr class="hover:bg-gray-50 transition section-row" data-name="<?= $section['section_name'] ?>" data-status="active">
                                <td class="px-6 py-4 font-semibold text-gray-900"><?= $section['section_name'] ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= $section['head_teacher_name'] ?></td>
                                <td class="px-6 py-4 text-gray-600"><?= $section['class_count'] ?></td>


                                <td class="px-6 py-4 text-center">
                                    <a href="<?= route('update-section') ?>?id=<?= $section['section_id'] ?>">
                                        <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                    </a>
                                    <button class="text-red-600 hover:text-red-900 font-semibold">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../includes/footer.php'); ?>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const sectionRows = document.querySelectorAll('.section-row');

        function filterSections() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;

            sectionRows.forEach(row => {
                const name = row.getAttribute('data-name').toLowerCase();
                const status = row.getAttribute('data-status');

                const matchesSearch = name.includes(searchTerm);
                const matchesStatus = !statusValue || status === statusValue;

                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterSections);
        statusFilter.addEventListener('change', filterSections);
    </script>
</body>

</html>