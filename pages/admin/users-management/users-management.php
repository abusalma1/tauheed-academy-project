<?php
$title = 'Users Management';
include(__DIR__ . '/../../../includes/header.php');

$admins = selectAllData('admins');
$guardians = selectAllData('guardians');
$teachers = selectAllData('teachers');


$adminsCount =  countDataTotal('admins', true);
$teachersCount =  countDataTotal('teachers', true);
$guardiansCount =  countDataTotal('guardians', true);
$studentsCount =  countDataTotal('students', true);


$totalUsers = $adminsCount['total'] + $teachersCount['total'] + $guardiansCount['total'] + $studentsCount['total'];
$totalActiveUsers = $adminsCount['active'] + $teachersCount['active'] + $guardiansCount['active'] + $studentsCount['active'];
$totalInactiveUsers = $adminsCount['inactive'] + $teachersCount['inactive'] + $guardiansCount['inactive'] + $studentsCount['inactive'];


$statement = $connection->prepare("
    SELECT 
        sections.id AS section_id,
        sections.name AS section_name,
        head_teachers.id AS head_teacher_id,
        head_teachers.name AS head_teacher_name,

        classes.id AS class_id,
        classes.name AS class_name,

        class_arms.id AS arm_id,
        class_arms.name AS arm_name,

        students.id AS student_id,
        students.name AS student_name,
        students.admission_number,
        students.gender,
        students.status


    FROM sections
    LEFT JOIN teachers AS head_teachers 
        ON sections.head_teacher_id = head_teachers.id
    LEFT JOIN classes 
        ON classes.section_id = sections.id
    LEFT JOIN class_arms 
        ON classes.class_arm_id = class_arms.id
    LEFT JOIN students 
        ON students.class_id = classes.id
");


$statement->execute();
$result = $statement->get_result();
$rows = $result->fetch_all(MYSQLI_ASSOC);

$sections = [];

foreach ($rows as $row) {
    $sectionId = $row['section_id'];

    // Create section entry if not yet created
    if (!isset($sections[$sectionId])) {
        $sections[$sectionId] = [
            'section_id' => $row['section_id'],
            'section_name' => $row['section_name'],
            'head_teacher_name' => $row['head_teacher_name'],
            'students' => []
        ];
    }

    // Add students belonging to that section
    if (!empty($row['student_id'])) {
        $sections[$sectionId]['students'][] = [
            'student_id' => $row['student_id'],
            'student_name' => $row['student_name'],
            'gender' => $row['gender'],
            'status' => $row['status'],
            'admission_number' => $row['admission_number'],
            'class_name' => $row['class_name'],
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
    <?php include(__DIR__ . '/../includes/admins-section-nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-purple-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">All Users Management</h1>
            <p class="text-xl text-purple-200">Manage all users across the school system</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- User Type Tabs -->
            <div class="flex flex-wrap gap-2 mb-8 bg-white rounded-lg shadow p-4">
                <button class="user-type-btn active px-6 py-2 rounded-lg font-semibold transition bg-purple-900 text-white" data-type="admins">
                    <i class="fas fa-crown mr-2"></i>Admins
                </button>
                <button class="user-type-btn px-6 py-2 rounded-lg font-semibold transition bg-gray-200 text-gray-700" data-type="teachers">
                    <i class="fas fa-chalkboard-user mr-2"></i>Teachers
                </button>
                <button class="user-type-btn px-6 py-2 rounded-lg font-semibold transition bg-gray-200 text-gray-700" data-type="guardians">
                    <i class="fas fa-users mr-2"></i>Guardians
                </button>
                <button class="user-type-btn px-6 py-2 rounded-lg font-semibold transition bg-gray-200 text-gray-700" data-type="students">
                    <i class="fas fa-graduation-cap mr-2"></i>Students
                </button>
            </div>

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
            <?php include(__DIR__ . '/./components/admins-management-component.php'); ?>

            <!-- Teachers Section -->
            <?php include(__DIR__ . '/./components/teachers-management-component.php'); ?>


            <!-- Guardians Section -->
            <?php include(__DIR__ . '/./components/guardians-management-component.php'); ?>


            <!-- Students Section -->
            <?php include(__DIR__ . '/./components/students-management-component.php'); ?>


        </div>
    </section>

    <?php include(__DIR__ . '/../../../includes/footer.php'); ?>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        document.querySelectorAll('.user-type-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.user-type-btn').forEach(b => {
                    b.classList.remove('active', 'bg-purple-900', 'text-white');
                    b.classList.add('bg-gray-200', 'text-gray-700');
                });
                btn.classList.add('active', 'bg-purple-900', 'text-white');
                btn.classList.remove('bg-gray-200', 'text-gray-700');

                document.querySelectorAll('.user-section').forEach(s => s.classList.add('hidden'));
                const userType = btn.dataset.type;
                document.getElementById(`${userType}-section`).classList.remove('hidden');

                updateCreateButton(userType);
            });
        });

        function updateCreateButton(userType) {
            const createBtn = document.getElementById('createBtn');
            const links = {
                admins: '<?= route('admin-create') ?>',
                teachers: '<?= route('teacher-create') ?>',
                guardians: '<?= route('guardian-create') ?>',
                students: '<?= route('student-create') ?>'
            };
            createBtn.href = links[userType];
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            // Filter admins
            document.querySelectorAll('.admin-card').forEach(card => {
                const searchData = card.dataset.search.toLowerCase();
                card.style.display = searchData.includes(searchTerm) ? '' : 'none';
            });

            // Filter teachers
            document.querySelectorAll('.teacher-card').forEach(card => {
                const searchData = card.dataset.search.toLowerCase();
                card.style.display = searchData.includes(searchTerm) ? '' : 'none';
            });

            // Filter guardians
            document.querySelectorAll('.guardian-card').forEach(card => {
                const searchData = card.dataset.search.toLowerCase();
                card.style.display = searchData.includes(searchTerm) ? '' : 'none';
            });

            // Filter students
            document.querySelectorAll('.student-row').forEach(row => {
                const searchData = row.dataset.search.toLowerCase();
                row.style.display = searchData.includes(searchTerm) ? '' : 'none';
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

        document.getElementById('sectionFilter').addEventListener('change', function() {
            const selectedSection = this.value.toLowerCase().replace(/\s+/g, '-');
            const groups = document.querySelectorAll('.student-section-group');

            groups.forEach(group => {
                const groupSection = group.dataset.section;
                if (selectedSection === '' || groupSection === selectedSection) {
                    group.style.display = '';
                } else {
                    group.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>