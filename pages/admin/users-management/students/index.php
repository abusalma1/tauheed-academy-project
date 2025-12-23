<?php
$title = 'Students Management';
include(__DIR__ . '/../../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (!isset($user_type) || $user_type !== 'admin') {
    $_SESSION['failure'] = "Access denied! Only Admins are allowed.";
    header("Location: " . route('home'));
    exit();
}

$studentsCount  = countDataTotal('students', true);


//  PDO query for students with classes and arms
$stmt = $pdo->prepare("
    SELECT 
        sessions.id AS session_id,
        sessions.name AS session_name,
        classes.id AS class_id,
        classes.name AS class_name,
        class_arms.id AS arm_id,
        class_arms.name AS arm_name,
        students.id AS student_id,
        students.name AS student_name,
        students.admission_number,
        students.gender,
        students.status,
        student_class_records.promotion_status,
        student_class_records.overall_average,
        student_class_records.overall_position
    FROM students
    LEFT JOIN student_class_records 
        ON students.id = student_class_records.student_id
    LEFT JOIN sessions 
        ON sessions.id = student_class_records.session_id
    LEFT JOIN classes 
        ON classes.id = student_class_records.class_id
    LEFT JOIN class_arms 
        ON class_arms.id = student_class_records.arm_id
    ORDER BY sessions.id DESC, classes.id, class_arms.id, students.name
");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


$sessions = [];

foreach ($rows as $row) {
    // Normalize IDs to avoid null keys
    $sessionId   = $row['session_id'] ?? 'none';
    $sessionName = $row['session_name'] ?? 'No Session';
    $classId     = $row['class_id'] ?? 'none';
    $className   = $row['class_name'] ?? 'No Class';

    // Create session bucket if not exists
    if (!isset($sessions[$sessionId])) {
        $sessions[$sessionId] = [
            'session_id'   => $sessionId,
            'session_name' => $sessionName,
            'classes'      => []
        ];
    }

    // Create class bucket inside session if not exists
    if (!isset($sessions[$sessionId]['classes'][$classId])) {
        $sessions[$sessionId]['classes'][$classId] = [
            'class_id'   => $classId,
            'class_name' => $className,
            'students'   => []
        ];
    }

    // Add student to class inside session
    if (!empty($row['student_id'])) {
        $sessions[$sessionId]['classes'][$classId]['students'][] = [
            'student_id'        => $row['student_id'],
            'student_name'      => $row['student_name'],
            'gender'            => $row['gender'],
            'status'            => $row['status'],
            'admission_number'  => $row['admission_number'],
            'arm_name'          => $row['arm_name'] ?? 'No Arm'
        ];
    }
}



// Other counts
$classesCount        = countDataTotal('classes')['total'];
$armsCount           = countDataTotal('class_arms')['total'];
$sectionsCount       = countDataTotal('sections')['total'];
$studentsCountList   = countDataTotal('students', true);
$studentsCount       = $studentsCountList['total'];
$totalActiveStudents = $studentsCountList['active'];
$academicSessions = selectAllData('sessions');
$terms = selectAllData('terms');
$classesFilterList = selectAllData('classes');


$currentSession = null;

foreach ($terms as $term) {
    if ($term['status'] === 'ongoing') {
        // Find the session linked to this term
        foreach ($academicSessions as $session) {
            if ($session['id'] == $term['session_id']) {
                $currentSession = $session;
                break 2; // stop both loops once we find the first ongoing session
            }
        }
    }
}


?>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/../../includes/admins-section-nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-orange-900 to-orange-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Students Management</h1>
            <p class="text-xl text-purple-200">Manage students across the school system</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div id="students-section" class="user-section ">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Students</h2>

                <!-- Student Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Total Students</p>
                        <p class="text-2xl font-bold text-indigo-900"><?= $studentsCount ?></p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Active</p>
                        <p class="text-2xl font-bold text-green-600"><?= $totalActiveStudents ?></p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Classes</p>
                        <p class="text-2xl font-bold text-orange-600"><?= $classesCount ?></p>
                    </div>
                    <div class="bg-white rounded-lg shadow p-4">
                        <p class="text-gray-600 text-sm">Arms</p>
                        <p class="text-2xl font-bold text-pink-600"><?= $armsCount ?></p>
                    </div>
                </div>
            </div>
            <!-- Search and Filter -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                        <input type="text" id="searchInput" placeholder="Search by name or email..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
                    </div>
                    <!-- Class Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Filter by Class</label>
                        <select id="classFilter" class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
                            <option value="">All Classes</option>
                            <?php foreach ($classesFilterList as $class): ?>
                                <option value="<?= $class['id'] ?>">
                                    <?= $class['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- session Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Academic Session (Filter)</label>
                        <select id="sessionFilter" class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
                            <option value="">All sessions</option>
                            <?php foreach ($academicSessions  as $session): ?>
                                <option value="<?= $session['id'] ?>" <?= $currentSession['id'] === $session['id'] ? "selected" : '' ?>>
                                    <?= $session['name'] ?> <?= $currentSession['id'] === $session['id'] ? "(Current)" : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex items-center">
                        <a id="createBtn" href="<?= route('student-create') ?>" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-center font-semibold">
                            <i class="fas fa-plus mr-2"></i>Create New
                        </a>
                    </div>
                </div>
            </div>




            <!-- Students by Class -->
            <div id="studentsByClassContainer" class="space-y-8">
                <?php foreach ($sessions as $session): ?>
                    <div class="student-session-group space-y-8" data-session="<?= $session['session_id'] ?>">
                        <?php foreach ($session['classes'] as $class): ?>

                            <div class="student-class-group bg-white rounded-lg shadow-lg overflow-hidden" data-id="<?= $class['class_id'] ?>">

                                <div class="bg-gradient-to-r from-orange-900 to-orange-700 text-white p-6">
                                    <h3 class="text-2xl font-bold"><?= $class['class_name'] ?> class Of <?= htmlspecialchars($session['session_name']) ?></h3>
                                    <p class="text-sm opacity-90"><?= count($class['students']) ?> students</p>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gray-100 border-b">
                                            <tr>
                                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Name</th>
                                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Admission #</th>
                                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Arm</th>
                                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Status</th>
                                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($class['students'] as $student): ?>
                                                <tr class="border-b hover:bg-gray-50 student-row" data-search="<?= $student['student_name'] . ' ' . $student['admission_number'] ?>">
                                                    <td class="px-6 py-4 text-sm text-gray-900"><?= $student['student_name'] ?></td>
                                                    <td class="px-6 py-4 text-sm text-gray-600"><?= $student['admission_number'] ?></td>
                                                    <td class="px-6 py-4 text-sm"><span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold"><?= $student['arm_name'] ?></span></td>
                                                    <td class="px-6 py-4 text-sm">
                                                        <span class="px-3 py-1 <?= $student['status'] === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900' ?> rounded-full text-xs font-semibold capitalize"><?= $student['status'] ?></span>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm space-x-2">
                                                        <!-- Details link stays separate -->
                                                        <a href="<?= route('view-user-details') . '?id=' . $student['student_id'] . '&type=student' ?>"
                                                            class="text-purple-600 hover:text-green-800 font-semibold">
                                                            <i class="fas fa-eye"></i> View Details
                                                        </a>

                                                        <!-- Edit dropdown -->
                                                        <div class="relative inline-block text-left">
                                                            <!-- Trigger link -->
                                                            <a href="#"
                                                                onclick="toggleResultsDropdown(event)"
                                                                class="resultsTrigger text-green-600 hover:text-green-800 font-semibold flex items-center">
                                                                <i class="fas fa-edit mr-2"></i> Manage Account
                                                                <svg class="ml-1 h-4 w-4 text-green-600 hover:text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </a>

                                                            <!-- Dropdown menu -->
                                                            <div class="resultsDropdown absolute mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 scale-95 pointer-events-none transition-all duration-200 ease-out z-10">
                                                                <div class="py-2">
                                                                    <a href="<?= route('update-user-password') . '?id=' . $student['student_id'] . '&user_type=student' ?>"
                                                                        class="block px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 hover:text-blue-800 font-semibold">
                                                                        <i class="fas fa-lock mr-2"></i> Edit Password
                                                                    </a>
                                                                    <a href="<?= route('student-update') . '?id=' . $student['student_id'] ?>"
                                                                        class="block px-4 py-2 text-sm text-green-600 hover:bg-gray-100 hover:text-green-800 font-semibold">
                                                                        <i class="fas fa-edit mr-2"></i> Edit Profile
                                                                    </a>
                                                                    <a href="<?= route('upload-student-picture') . '?id=' . $student['student_id'] ?>"
                                                                        class="block px-4 py-2 text-sm text-green-600 hover:bg-gray-100 hover:text-green-800 font-semibold">
                                                                        <i class="fas fa-upload mr-2"></i> Upload Picture
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Results dropdown (unchanged) -->
                                                        <div class="relative inline-block text-left">
                                                            <a href="#"
                                                                onclick="toggleResultsDropdown(event)"
                                                                class="resultsTrigger text-purple-600 hover:text-green-800 font-semibold flex items-center">
                                                                <i class="fas fa-eye mr-2"></i> View Results
                                                                <svg class="ml-1 h-4 w-4 text-purple-600 hover:text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </a>

                                                            <div class="resultsDropdown absolute mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 scale-95 pointer-events-none transition-all duration-200 ease-out z-10">
                                                                <div class="py-2">
                                                                    <a href="<?= route('admin-student-result') . '?id=' . $student['student_id'] ?>"
                                                                        class="block px-4 py-2 text-sm text-purple-600 hover:bg-gray-100 hover:text-green-800 font-semibold">
                                                                        <i class="fas fa-list mr-2"></i> General Result History
                                                                    </a>
                                                                    <a href="<?= route('admin-student-islamiyya-result') . '?id=' . $student['student_id'] ?>"
                                                                        class="block px-4 py-2 text-sm text-purple-600 hover:bg-gray-100 hover:text-green-800 font-semibold">
                                                                        <i class="fas fa-book-quran mr-2"></i> Islamiyya Result History
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Delete link -->
                                                        <a href="<?= route('delete-user') . '?id=' . $student['student_id'] ?>&table=students&type=Student"
                                                            class="text-red-600 hover:text-red-800 font-semibold">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </a>
                                                    </td>

                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>


        </div>



    </section>

    <?php include(__DIR__ . '/../../../../includes/footer.php'); ?>

    <script>
        function toggleResultsDropdown(e) {
            e.preventDefault();
            const trigger = e.currentTarget;
            const parent = trigger.closest('.relative'); // the wrapper div
            const dropdown = parent.querySelector('.resultsDropdown'); // find dropdown inside

            const isOpen = !dropdown.classList.contains('pointer-events-none');

            if (isOpen) {
                closeResultsDropdown(dropdown);
            } else {
                // Close all other dropdowns first
                document.querySelectorAll('.resultsDropdown').forEach(dd => closeResultsDropdown(dd));

                dropdown.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
                dropdown.classList.add('opacity-100', 'scale-100');

                // 🔹 Smoothly scroll the dropdown into view
                dropdown.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest' // or 'center' if you want it centered in viewport
                });
            }
        }

        function closeResultsDropdown(dropdown) {
            dropdown.classList.remove('opacity-100', 'scale-100');
            dropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
        }

        // Close when clicking outside
        document.addEventListener('click', function(event) {
            const insideDropdown = event.target.closest('.resultsDropdown');
            const trigger = event.target.closest('.resultsTrigger');

            if (!insideDropdown && !trigger) {
                document.querySelectorAll('.resultsDropdown').forEach(dd => closeResultsDropdown(dd));
            }
        });


        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            // Filter students
            document.querySelectorAll('.student-row').forEach(row => {
                const searchData = row.dataset.search.toLowerCase();
                row.style.display = searchData.includes(searchTerm) ? '' : 'none';
            });
        });


        document.getElementById('classFilter').addEventListener('change', function() {
            const selectedClass = this.value.toLowerCase().replace(/\s+/g, '-');
            const groups = document.querySelectorAll('.student-class-group');

            groups.forEach(group => {
                const groupClass = group.dataset.id;
                if (selectedClass === '' || groupClass === selectedClass) {
                    group.style.display = '';
                } else {
                    group.style.display = 'none';
                }
            });
        });

        const sessionFilter = document.getElementById('sessionFilter');

        function applySessionFilter() {
            const selectedSession = sessionFilter.value.toLowerCase().replace(/\s+/g, '-');
            const groups = document.querySelectorAll('.student-session-group');

            groups.forEach(group => {
                const groupSession = group.dataset.session;
                if (selectedSession === '' || groupSession === selectedSession) {
                    group.style.display = '';
                } else {
                    group.style.display = 'none';
                }
            });
        }

        sessionFilter.addEventListener('change', applySessionFilter);

        // run once on page load so default selection is applied
        applySessionFilter();
    </script>
</body>

</html>