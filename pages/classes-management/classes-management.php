<?php

$title = "Classes Management";
include(__DIR__ . '/../../includes/header.php');

$statement = $connection->prepare("
    SELECT 
        sections.id AS section_id,
        sections.name AS section_name,
        head_teachers.id AS head_teacher_id,
        head_teachers.name AS head_teacher_name,

        classes.id AS class_id,
        classes.name AS class_name,
        class_teachers.id AS class_teacher_id,
        class_teachers.name AS class_teacher_name,

        class_arms.id AS arm_id,
        class_arms.name AS arm_name
    FROM sections
    LEFT JOIN teachers AS head_teachers ON sections.head_teacher_id = head_teachers.id
    LEFT JOIN classes ON classes.section_id = sections.id
    LEFT JOIN teachers AS class_teachers ON classes.teacher_id = class_teachers.id
    LEFT JOIN class_arms ON classes.class_arm_id = class_arms.id
");

$statement->execute();
$result = $statement->get_result();
$rows = $result->fetch_all(MYSQLI_ASSOC);


$sections = [];

foreach ($rows as $row) {
    $sectionId = $row['section_id'];

    if (!isset($sections[$sectionId])) {
        $sections[$sectionId] = [
            'section_id' => $row['section_id'],
            'section_name' => $row['section_name'],
            'head_teacher_name' => $row['head_teacher_name'],
            'classes' => []
        ];
    }

    if (!empty($row['class_id'])) {
        $sections[$sectionId]['classes'][] = [
            'class_id' => $row['class_id'],
            'class_name' => $row['class_name'],
            'class_teacher_name' => $row['class_teacher_name'],
            'arm_name' => $row['arm_name']
        ];
    }
}

$classesCount = countDataTotal('classes')['total'];
$armsCount = countDataTotal('class_arms')['total'];
$sectionsCount = countDataTotal('sections')['total'];
$studentsCount = countDataTotal('students')['total'];





?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/./includes/classes-management-nav.php');  ?>


    <!-- Page Header -->
    <section class="bg-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Classes by Section</h1>
            <p class="text-xl text-green-200">View all classes organized by educational sections with their arms</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="mb-8 bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="searchInput" class="block text-sm font-semibold text-gray-700 mb-2">Search Classes</label>
                        <input type="text" id="searchInput" placeholder="Search by class name, arm, or teacher..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                    </div>
                    <div class="flex-1">
                        <label for="sectionFilter" class="block text-sm font-semibold text-gray-700 mb-2">Filter by Section</label>
                        <select id="sectionFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                            <option value="">All Sections</option>
                            <?php foreach ($sections as $section) : ?>
                                <option value="<?= $section['section_name'] ?>"><?= $section['section_name'] ?></option>
                            <?php endforeach  ?>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <a href="class-management.html" class="w-full md:w-auto bg-green-900 hover:bg-green-800 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i> Create Class
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Classes</p>
                            <p class="text-3xl font-bold text-green-900"><?= $classesCount ?></p>
                        </div>
                        <i class="fas fa-chalkboard text-4xl text-green-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Arms</p>
                            <p class="text-3xl font-bold text-blue-900"><?= $armsCount ?></p>
                        </div>
                        <i class="fas fa-sitemap text-4xl text-blue-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between"> 
                        <div>
                            <p class="text-gray-600 text-sm">Total Students</p>
                            <p class="text-3xl font-bold text-purple-900"><?= $studentsCount ?></p>
                        </div>
                        <i class="fas fa-users text-4xl text-purple-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Sections</p>
                            <p class="text-3xl font-bold text-orange-900"><?= $sectionsCount ?></p>
                        </div>
                        <i class="fas fa-layer-group text-4xl text-orange-200"></i>
                    </div>
                </div>
            </div>

            <!-- Sections with Classes and Arms -->
            <div id="sectionsContainer" class="space-y-8">
                <?php foreach ($sections as $section): ?>
                    <div class="section-container bg-white rounded-lg shadow-lg overflow-hidden" data-section="<?= $section['section_name'] ?>">
                        <div class="bg-blue-900 text-white p-6 flex items-center gap-3">
                            <!-- <i class="fas fa-quran text-3xl opacity-80"></i> -->
                            <div>
                                <h2 class="text-2xl font-bold"><?= $section['section_name'] ?></h2>
                                <p class="text-sm opacity-90"><?= count($section['classes']) ?> classes</p>
                            </div>
                        </div>
                        <div class="p-6 space-y-6">
                            <?php foreach ($section['classes'] as $class) : ?>
                                <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="<?= $class['class_name'] ?>" data-teacher="<?= $class['class_teacher_name'] ?>" data-arms="<?= $class['arm_name'] ?>">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-gray-900 mb-2"><?= $class['class_name'] ?></h3>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                <div>
                                                    <p class="text-gray-600">Arm</p>
                                                    <p class="font-semibold text-gray-900"><?= $class['arm_name'] ?></p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-600">Teacher</p>
                                                    <p class="font-semibold text-gray-900"><?= $class['class_teacher_name'] ?></p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-600">Enrollment</p>
                                                    <p class="font-semibold text-gray-900">Not Provided yet</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-600">Capacity</p>
                                                    <p class="font-semibold text-gray-900">50</p>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="flex flex-col gap-2 md:w-auto">
                                            <a href="class-update.html?class=Tahfeez%201" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                                <i class="fas fa-edit"></i> Update
                                            </a>
                                            <a href="delete-confirmation.html?type=class&name=Tahfeez%201" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php');    ?>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        function filterClasses() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const selectedSection = document.getElementById('sectionFilter').value;

            const sections = document.querySelectorAll('.section-container');
            let visibleSections = 0;

            sections.forEach(section => {
                const sectionName = section.getAttribute('data-section');

                // Filter by section if selected
                if (selectedSection && selectedSection !== sectionName) {
                    section.style.display = 'none';
                    return;
                }

                const classItems = section.querySelectorAll('.class-item');
                let visibleClasses = 0;

                classItems.forEach(classItem => {
                    const className = classItem.getAttribute('data-class-name').toLowerCase();
                    const teacher = classItem.getAttribute('data-teacher').toLowerCase();
                    const arms = classItem.getAttribute('data-arms').toLowerCase();

                    const matches = className.includes(searchTerm) ||
                        teacher.includes(searchTerm) ||
                        arms.includes(searchTerm);

                    classItem.style.display = matches ? 'block' : 'none';
                    if (matches) visibleClasses++;
                });

                section.style.display = visibleClasses > 0 ? 'block' : 'none';
                if (visibleClasses > 0) visibleSections++;
            });

            // Show "no results" message if needed
            const container = document.getElementById('sectionsContainer');
            const noResults = container.querySelector('.no-results');
            if (visibleSections === 0) {
                if (!noResults) {
                    const noResultsDiv = document.createElement('div');
                    noResultsDiv.className = 'no-results bg-white rounded-lg shadow-lg p-12 text-center';
                    noResultsDiv.innerHTML = `
                        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                        <p class="text-xl text-gray-500">No classes found matching your search criteria</p>
                    `;
                    container.appendChild(noResultsDiv);
                }
            } else {
                if (noResults) noResults.remove();
            }
        }

        // Event listeners
        document.getElementById('searchInput').addEventListener('input', filterClasses);
        document.getElementById('sectionFilter').addEventListener('change', filterClasses);
    </script>
</body>

</html>