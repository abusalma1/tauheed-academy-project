<?php

$title = "Classes Management";
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

$stmt = $conn->prepare("SELECT 
        sections.id AS section_id,
        sections.name AS section_name,
        head_teachers.id AS head_teacher_id,
        head_teachers.name AS head_teacher_name,

        classes.id AS class_id,
        classes.name AS class_name,
        class_teachers.id AS class_teacher_id,
        class_teachers.name AS class_teacher_name,
        classes.level AS class_level,

        class_arms.id AS arm_id,
        class_arms.name AS arm_name
    FROM sections
    LEFT JOIN teachers AS head_teachers ON sections.head_teacher_id = head_teachers.id
    LEFT JOIN classes ON classes.section_id = sections.id
    LEFT JOIN class_class_arms ON class_class_arms.class_id = classes.id
    LEFT JOIN teachers AS class_teachers ON class_class_arms.teacher_id = class_teachers.id
    LEFT JOIN class_arms ON class_class_arms.arm_id = class_arms.id
    where classes.deleted_at is null
    and sections.deleted_at is null
    ORDER BY classes.level ASC, class_arms.name ASC
");

$stmt->execute();
$result = $stmt->get_result();
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
            'arm_name' => $row['arm_name'],
            'arm_id' => $row['arm_id']

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
    <?php include(__DIR__ . '/../includes/admins-section-nav.php');  ?>


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
                        <a href="<?= route('create-class') ?>" class="w-full md:w-auto bg-green-900 hover:bg-green-800 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i> Create Class
                        </a>
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


                        <div class="bg-white rounded-b-lg shadow-md overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Class</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Teacher</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Enrollment</th>
                                        <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($section['classes'] as $class) :   ?>
                                        <tr
                                            class="class-item border-b border-slate-100 hover:bg-blue-50 transition subject-row whitespace-nowrap"
                                            data-class-name="<?= $class['class_name'] ?>"
                                            data-teacher="<?= $class['class_teacher_name'] ?>"
                                            data-arms="<?= $class['arm_name'] ?>">

                                            <td class="px-6 py-4 text-sm font-medium text-slate-900"><?= $class['class_name'] . ' ' . $class['arm_name'] ?></td>
                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xm font-medium">
                                                    <?= $class['class_teacher_name'] ?? 'No teacher assigned' ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                <span class="font-semibold text-gray-900">
                                                    Not Provided yet
                                                </span>
                                            </td>

                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                <div class="flex items-center justify-center gap-4">
                                                    <a href="<?= route('assing-class-teacher') . '?class_id=' . $class['class_id'] . '&arm_id=' .  $class['arm_id']; ?>">

                                                        <button class="text-blue-600 hover:text-blue-900 font-semibold flex items-center gap-1">
                                                            <i class="fas fa-user-plus"></i> Add/Edit Teacher
                                                        </button>
                                                    </a>
                                                    <a href="<?= route('update-class') . '?id=' . $class['class_id'] ?>">
                                                        <button class="text-blue-600 hover:text-blue-900 font-semibold flex items-center gap-1">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </a>
                                                    <a href="<?= route('delete-class') ?>?id=<?= $class['class_id'] ?>">
                                                        <button class="text-red-600 hover:text-red-900 font-semibold flex items-center gap-1">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </a>
                                                </div v>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../includes/footer.php');    ?>

    <script>
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
                    classItem.style.display = matches ? 'table-row' : 'none';

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