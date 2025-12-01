<?php

$title = "Create Section";
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch sections with head teachers
$stmt = $pdo->prepare("
    SELECT 
        sections.id AS section_id,
        sections.name AS section_name,
        sections.description,
        teachers.id AS teacher_id,
        teachers.name AS head_teacher_name
    FROM sections
    LEFT JOIN teachers 
      ON sections.head_teacher_id = teachers.id
    WHERE sections.deleted_at IS NULL
");
$stmt->execute();
$sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch teachers
$stmt = $pdo->prepare("SELECT * FROM teachers");
$stmt->execute();
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$classesCount   = countDataTotal('classes')['total'];
$sectionsCount  = countDataTotal('sections')['total'];

$name = $description = $headTeacher = '';
$nameError = $descriptionError = $headTeacherError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $name        = htmlspecialchars(trim($_POST['sectionName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars(trim($_POST['sectionDescription'] ?? ''), ENT_QUOTES);
    $headTeacher = (int) htmlspecialchars(trim($_POST['sectionHead'] ?? ''), ENT_QUOTES, 'UTF-8');

    if (empty($name)) {
        $nameError = "Name is required";
    }

    if (empty($description)) {
        $descriptionError = "Description is required";
    }

    if (empty($headTeacher)) {
        $headTeacherError = "Head Teacher is required";
    }

    if (empty($nameError) && empty($descriptionError) && empty($headTeacherError)) {
        $stmt = $pdo->prepare("INSERT INTO sections (name, description, head_teacher_id) VALUES (?, ?, ?)");
        $success = $stmt->execute([$name, $description, $headTeacher]);

        if ($success) {
            $_SESSION['success'] = "Section created successfully!";
            header("Location: " . route('back'));
            exit();
        } else {
            echo "<script>alert('Failed to create section');</script>";
        }
    }
}
?>



<script>
    const sections = <?= json_encode($sections, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-purple-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Section Management</h1>
            <p class="text-xl text-purple-200">Create and manage school sections</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Add New Section</h2>

                        <form id="sectionForm" class="space-y-6" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>

                            <!-- Section Name -->
                            <div>
                                <label for="sectionName" class="block text-sm font-semibold text-gray-700 mb-2">Section Name *</label>
                                <input type="text" id="sectionName" name="sectionName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="e.g., Tahfeez, Nursery, Primary">
                                <span class="text-red-500 text-sm hidden" id="sectionNameError"></span>
                            </div>

                            <!-- Section Description -->
                            <div>
                                <label for="sectionDescription" class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                                <textarea id="sectionDescription" name="sectionDescription" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="Describe the section and its purpose"></textarea>
                                <span class="text-red-500 text-sm hidden" id="sectionDescriptionError"></span>
                            </div>


                            <!-- Section Head -->
                            <div>
                                <label for="sectionHead" class="block text-sm font-semibold text-gray-700 mb-2">Section Head/Coordinator</label>
                                <span class="text-gray-500 text-sm">Click Here to <a href="<?= route('teacher-create') ?>" class="text-blue-700 font-bold underline cursor-pointer">Create Teacher Account</a></span>

                                <select type="text" id="sectionHead" name="sectionHead" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
                                    <option value="">-- Select Section Head --</option>
                                    <?php if ($teachers <= 0) : ?>
                                        <option value="">-- You Must add teacher first --</option>
                                    <?php else : ?>
                                        <?php foreach ($teachers as $teacher) : ?>
                                            <option value="<?= $teacher['id'] ?>"><?= $teacher['name']; ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="sectionHeadError"></span>

                            </div>


                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-purple-900 text-white py-3 rounded-lg font-semibold hover:bg-purple-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Add Section
                                </button>
                                <button type="reset" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                                    Clear Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-purple-50 rounded-lg shadow p-6 border-l-4 border-purple-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-purple-900 mr-2"></i>Section Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-purple-600 mt-1"></i>
                                <span>Section name must be unique</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-purple-600 mt-1"></i>
                                <span>Provide clear section description</span>
                            </li>

                            <li class="flex gap-2">
                                <i class="fas fa-check text-purple-600 mt-1"></i>
                                <span>Assign a section coordinator</span>
                            </li>

                        </ul>
                    </div>

                    <!-- Statistics -->
                    <div class="mt-6 bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Section Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Total Sections</span>
                                <span class="text-2xl font-bold text-purple-900" id="totalSections"><?= $sectionsCount ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Classes</span>
                                <span class="text-2xl font-bold text-blue-600" id="totalClasses"><?= $classesCount ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sections Table -->
            <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">All Sections</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-purple-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Section Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Head</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sectionsTableBody" class="divide-y divide-gray-200">
                            <?php if (count($sections) > 0): ?>
                                <?php foreach ($sections as $section) : ?>

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900"><?= $section['section_name'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $section['head_teacher_name'] ?></td>

                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <a href="<?= route('update-section') ?>?id=<?= $section['section_id'] ?>">
                                                <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            </a>
                                            <a href="<?= route('delete-section') ?>?id=<?= $section['section_id'] ?>">
                                                <button class="text-red-600 hover:text-red-900 font-semibold">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>

                                <tr class="text-center py-8">
                                    <td colspan="6" class="px-6 py-8 text-gray-500">No sections created yet</td>
                                </tr>
                            <?php endif ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../includes/footer.php');  ?>
    <script>
        // Form validation and submission
        const sectionForm = document.getElementById('sectionForm');

        sectionForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const sectionName = document.getElementById('sectionName').value.trim();
            const sectionDescription = document.getElementById('sectionDescription').value.trim();
            const sectionHead = document.getElementById('sectionHead').value;


            let isValid = true;

            if (!sectionName) {
                document.getElementById('sectionNameError').textContent = 'Section name is required';
                document.getElementById('sectionNameError').classList.remove('hidden');
                isValid = false;
            }

            if (sections.some(s => s.section_name === sectionName)) {
                document.getElementById('sectionNameError').textContent = 'Section name already exists';
                document.getElementById('sectionNameError').classList.remove('hidden');
                isValid = false;
            }

            if (!sectionDescription) {
                document.getElementById('sectionDescriptionError').textContent = 'Description is required';
                document.getElementById('sectionDescriptionError').classList.remove('hidden');
                isValid = false;
            }

            if (!sectionHead) {
                document.getElementById('sectionHeadError').textContent = 'Please Select section head';
                document.getElementById('sectionHeadError').classList.remove('hidden');
                isValid = false;
            }
            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                sectionForm.submit();
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showErrorMessage();
            }
        });
    </script>
</body>

</html>