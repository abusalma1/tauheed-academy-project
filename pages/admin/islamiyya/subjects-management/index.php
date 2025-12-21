<?php
$title = "Islamiyya Subjects Management";
include(__DIR__ . '/../../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

$stmt = $pdo->prepare("
    SELECT 
        islamiyya_classes.id AS class_id,
        islamiyya_classes.name AS class_name,
        islamiyya_subjects.id AS subject_id,
        islamiyya_subjects.name AS subject_name,
        teachers.id AS teacher_id,
        teachers.name AS teacher_name,
        islamiyya_sections.name AS section_name,
        islamiyya_class_subjects.id AS class_subject_id 
    FROM islamiyya_classes
    LEFT JOIN islamiyya_class_subjects 
           ON islamiyya_classes.id = islamiyya_class_subjects.class_id
    LEFT JOIN islamiyya_subjects 
           ON islamiyya_class_subjects.subject_id = islamiyya_subjects.id
    LEFT JOIN teachers 
           ON islamiyya_class_subjects.teacher_id = teachers.id
    LEFT JOIN islamiyya_sections 
           ON islamiyya_classes.section_id = islamiyya_sections.id
    ORDER BY islamiyya_classes.level, islamiyya_subjects.name
");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$classes = [];

foreach ($rows as $row) {
    $classId = $row['class_id'];

    if (!isset($classes[$classId])) {
        $classes[$classId] = [
            'id'           => $row['class_id'],
            'name'         => $row['class_name'],
            'section_name' => $row['section_name'],
            'subjects'     => []
        ];
    }

    if (!empty($row['subject_id'])) {
        $classes[$classId]['subjects'][] = [
            'class_subject_id' => $row['class_subject_id'],
            'id'               => $row['subject_id'],
            'name'             => $row['subject_name'],
            'teacher'          => $row['teacher_name'] ?: 'No teacher assigned'
        ];
    }
}

// Reindex classes by numeric index
$classes = array_values($classes);

// Fetch classes for filter (assuming selectAllData is already PDO-based)
$classesForFilter = selectAllData('islamiyya_classes');

// Handle filters/search
$selectedClass = isset($_GET['class']) ? intval($_GET['class']) : null;
$searchTerm    = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Calculate statistics (assuming countDataTotal is already PDO-based)
$totalSubjects = countDataTotal('islamiyya_subjects')['total'];
$totalStudents = countDataTotal('students')['total']; // shared
$totalSections = countDataTotal('islamiyya_sections')['total'];
$totalClasses  = countDataTotal('islamiyya_classes')['total'];

$totalCapacity = 0;
?>



<body class="bg-slate-50">
    <!-- Navigation Bar -->
    <?php include(__DIR__ . '/../../includes/admins-section-nav.php') ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Islamiyya Subjects By Classes Management</h1>
            <p class="text-xl text-purple-200">Create and manage Islamiyya Subjects</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Subjects</p>
                            <p class="text-3xl font-bold text-green-900"><?= $totalSubjects ?></p>
                        </div>
                        <i class="fas fa-chalkboard text-4xl text-green-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Classes</p>
                            <p class="text-3xl font-bold text-blue-900"><?= $totalClasses ?></p>
                        </div>
                        <i class="fas fa-sitemap text-4xl text-blue-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Students</p>
                            <p class="text-3xl font-bold text-purple-900"><?= $totalStudents ?></p>
                        </div>
                        <i class="fas fa-users text-4xl text-purple-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Sections</p>
                            <p class="text-3xl font-bold text-orange-900"><?= $totalSections ?></p>
                        </div>
                        <i class="fas fa-layer-group text-4xl text-orange-200"></i>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="mb-8 bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="searchInput" class="block text-sm font-semibold text-gray-700 mb-2">Search Subject</label>
                        <input type="text" id="searchInput" placeholder="Search by subject name or teacher..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                    </div>
                    <div class="flex-1">
                        <label for="subjectFilter" class="block text-sm font-semibold text-gray-700 mb-2">Filter by Classes</label>
                        <select id="subjectFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                            <option value="">All Classes</option>
                            <?php foreach ($classesForFilter as $class) : ?>
                                <option value="<?= $class['name'] ?>"><?= $class['name'] ?></option>
                            <?php endforeach  ?>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <a href="<?= route('create-islamiyya-subject') ?>" class="bg-gradient-to-r from-blue-900 to-blue-700 hover:from-blue-700 hover:to-blue-700 text-white font-medium px-8 py-2 rounded-lg transition shadow-md">
                            <i class="fas fa-plus"></i> Create Subject
                        </a>
                    </div>
                </div>
            </div>

            <div id="noResults" class="hidden bg-white rounded-lg shadow-md p-12 text-center">
                <p class="text-slate-500 text-lg mb-2">No matching subjects found.</p>
                <p class="text-slate-400 text-sm">Try adjusting your search or filter criteria.</p>
            </div>

            <!-- Subjects by Class -->
            <?php foreach ($classes as $class):            ?>
                <div class="mb-8 class-group" data-class-name="<?= strtolower($class['name']) ?>">
                    <div class="mb-8">
                        <!-- Class Header -->
                        <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-t-lg p-6 mb-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-2xl font-bold"><?= $class['name']; ?></h2>
                                    <p class="text-blue-100 text-sm mt-1"><?= $class['section_name']; ?> • <?= count($class['subjects']); ?> subjects</p>
                                </div>
                            </div>
                        </div>

                        <!-- Subjects Table -->
                        <div class="bg-white rounded-b-lg shadow-md overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Subject Name</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Teacher</th>
                                        <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($class['subjects'] as $subject) :   ?>
                                        <tr
                                            class="border-b border-slate-100 hover:bg-blue-50 transition subject-row"
                                            data-subject-name="<?= strtolower($subject['name']); ?>"
                                            data-teacher-name="<?= strtolower($subject['teacher']); ?>"
                                            data-class-name="<?= strtolower($class['name']); ?>">

                                            <td class="px-6 py-4 text-sm font-medium text-slate-900"><?= $subject['name']; ?></td>
                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">
                                                    <?= $subject['teacher']; ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                <div class="flex items-center justify-center gap-4">
                                                    <a href="<?= route('assing-islamiyya-subject-teacher') . '?id=' . $subject['class_subject_id'] ?>">
                                                        <button class="text-blue-600 hover:text-blue-900 font-semibold flex items-center gap-1">
                                                            <i class="fas fa-user-plus"></i> Add/Edit Teacher
                                                        </button>
                                                    </a>
                                                    <a href="<?= route('update-islamiyya-subject') . '?id=' . $subject['id'] ?>">
                                                        <button class="text-blue-600 hover:text-blue-900 font-semibold flex items-center gap-1">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </a>
                                                    <a href="<?= route('delete-islamiyya-subject') ?>?id=<?= $subject['id'] ?>">
                                                        <button class="text-red-600 hover:text-red-900 font-semibold flex items-center gap-1">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </a>
                                                </div>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../../includes/footer.php') ?>

    <script>
        function filterSubjects() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const selectedClass = document.getElementById('subjectFilter').value.toLowerCase();

            const classGroups = document.querySelectorAll('.class-group');
            let anyGroupVisible = false;

            classGroups.forEach(group => {
                const className = group.getAttribute('data-class-name');
                const subjectRows = group.querySelectorAll('.subject-row');
                let groupHasVisibleSubject = false;

                subjectRows.forEach(row => {
                    const subjectName = row.getAttribute('data-subject-name');
                    const teacherName = row.getAttribute('data-teacher-name');

                    const matchesSearch = subjectName.includes(searchTerm) || teacherName.includes(searchTerm);
                    const matchesClass = selectedClass === '' || className === selectedClass;

                    if (matchesSearch && matchesClass) {
                        row.style.display = '';
                        groupHasVisibleSubject = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show or hide entire class group
                if (groupHasVisibleSubject) {
                    group.style.display = '';
                    anyGroupVisible = true;
                } else {
                    group.style.display = 'none';
                }
            });

            // Handle global no results state
            const emptyState = document.getElementById('noResults');
            if (!anyGroupVisible) {
                emptyState.classList.remove('hidden');
            } else {
                emptyState.classList.add('hidden');
            }
        }

        // Attach listeners
        document.getElementById('searchInput').addEventListener('input', filterSubjects);
        document.getElementById('subjectFilter').addEventListener('change', filterSubjects);
    </script>
</body>

</html>