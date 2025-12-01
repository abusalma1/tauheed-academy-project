<?php
$title = "Manage Subject";
include(__DIR__ . '/../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

//  Use PDO instead of MySQLi
$stmt = $pdo->prepare("
    SELECT 
        classes.id AS class_id,
        classes.name AS class_name,
        subjects.id AS subject_id,
        subjects.name AS subject_name,
        teachers.id AS teacher_id,
        teachers.name AS teacher_name,
        sections.name AS section_name,
        class_subjects.id AS class_subject_id 
    FROM classes
    LEFT JOIN class_subjects 
        ON classes.id = class_subjects.class_id
    LEFT JOIN subjects 
        ON class_subjects.subject_id = subjects.id 
        AND subjects.deleted_at IS NULL
    LEFT JOIN teachers 
        ON class_subjects.teacher_id = teachers.id
    LEFT JOIN sections 
        ON classes.section_id = sections.id
    WHERE classes.deleted_at IS NULL 
      AND sections.deleted_at IS NULL
    ORDER BY classes.level, subjects.name
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

//  Fetch all classes
$stmt = $pdo->prepare("SELECT * FROM classes WHERE deleted_at IS NULL ORDER BY level ASC");
$stmt->execute();
$allClasses = $stmt->fetchAll(PDO::FETCH_ASSOC);

//  Fetch terms and sessions
$terms    = selectAllData('terms');
$sessions = selectAllData('sessions');

//  Fetch current term
$stmt = $pdo->prepare("SELECT * FROM terms WHERE deleted_at IS NULL AND status = ?");
$stmt->execute(['ongoing']);
$current_term = $stmt->fetch(PDO::FETCH_ASSOC);

//  Handle missing selection
if (isset($_POST['missing_selection'])) {
    $_SESSION['failure'] = "Please select a session and a term before creating or updating results.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php'); ?>


    <!-- Page Header -->
    <section
        class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                Manage Subjects Results
            </h1>
            <p class="text-xl text-blue-200">
                Create and update student results by subject
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters Section -->
            <div
                class="bg-gradient-to-r from-indigo-900 to-indigo-700 text-white rounded-lg shadow-lg p-6 mb-8">
                <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                    <i class="fas fa-filter"></i>Filter Results
                </h2>
                <div class="grid md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Session</label>
                        <select
                            id="sessionSelect"
                            class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <option value="">-- Select Session --</option>
                            <?php foreach ($sessions as $session): ?>
                                <option value="<?= $session['id'] ?>" <?= $current_term['session_id'] === $session['id'] ? "selected" : '' ?>><?= $session['name'] ?> <?= $current_term['session_id'] === $session['id'] ? "(Current)" : '' ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Term</label>
                        <select
                            id="termSelect"
                            class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-400" disabled>
                            <option value="">-- Select Term --</option>
                            <?php foreach ($terms as $term) : ?>
                                <option value="<?= $term['id'] ?>" data-session="<?= $term['session_id'] ?>" <?= $current_term['id'] === $term['id'] ? "selected" : '' ?>>
                                    <?= $term['name'] ?>
                                    <?= $current_term['id'] === $term['id'] ? "(Current)" : '' ?>
                                </option>

                            <?php endforeach ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2">Search Subject</label>
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Search subjects..."
                            class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Filter by Classes</label>
                        <select
                            id="classFilter"
                            class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            <option value="">All Classes</option>

                            <?php foreach ($allClasses as $class) : ?>
                                <option value="<?= $class['name'] ?>"><?= $class['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div
                    class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Subjects</p>
                            <p class="text-3xl font-bold text-blue-900">24</p>
                        </div>
                        <i class="fas fa-book text-4xl text-blue-200"></i>
                    </div>
                </div>
                <div
                    class="bg-white rounded-lg shadow p-4 border-l-4 border-green-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Results Uploaded</p>
                            <p class="text-3xl font-bold text-green-600">18</p>
                        </div>
                        <i class="fas fa-check-circle text-4xl text-green-200"></i>
                    </div>
                </div>
                <div
                    class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Pending</p>
                            <p class="text-3xl font-bold text-yellow-600">6</p>
                        </div>
                        <i class="fas fa-hourglass-half text-4xl text-yellow-200"></i>
                    </div>
                </div>
                <div
                    class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Current Session</p>
                            <p class="text-2xl font-bold text-purple-600">2024/2025</p>
                        </div>
                        <i class="fas fa-calendar text-4xl text-purple-200"></i>
                    </div>
                </div>
            </div>

            <!-- Sections with Subjects -->
            <div id="sectionsContainer" class="space-y-8">
                <?php foreach ($classes as $class) : ?>
                    <div
                        class="section-container bg-white rounded-lg shadow-lg overflow-hidden"
                        data-class="<?= $class['name'] ?>">
                        <div class="bg-yellow-900 text-white p-6 flex items-center gap-3">
                            <i class="fas fa-book text-3xl opacity-80"></i>
                            <div>
                                <h2 class="text-2xl font-bold"><?= $class['name'] ?></h2>
                                <p class="text-sm opacity-90"><?= count($class['subjects']) ?> subjects</p>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">

                            <?php foreach ($class['subjects'] as $subject) : ?>
                                <div
                                    class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
                                    data-subject="<?= $subject['name'] ?>"
                                    data-class="<?= $class['name'] ?>">
                                    <div
                                        class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold text-gray-900 mb-2">
                                                <?= $subject['name'] ?>
                                            </h3>
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">

                                                <div>
                                                    <p class="text-gray-600">Students</p>
                                                    <p class="font-semibold text-gray-900">218</p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-600">Status</p>
                                                    <span
                                                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                                                </div>
                                                <div>
                                                    <p class="text-gray-600">Last Updated</p>
                                                    <p class="font-semibold text-gray-900">Nov 10, 2025</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col gap-2 md:w-auto">
                                            <a
                                                href="<?= route('upload-results') . '?subject_id=' . $subject['id'] . '&class_id=' . $class['id'] ?>"
                                                class="createResultBtn bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                                <i class="fas fa-upload"></i> Upload Results
                                            </a>

                                            <a
                                                href="<?= route('view-subject-result') . '?subject_id=' . $subject['id'] . '&class_id=' . $class['id'] ?>"
                                                class="updateResultBtn bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                                <i class="fas fa-eye"></i> View Results
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
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>

    <form id="failureForm" action="" method="POST" class="hidden">
        <input type="hidden" name="missing_selection" value="1">
    </form>


    <script>
        // Term selection after session 
        const sessionSelect = document.getElementById('sessionSelect');
        const termSelect = document.getElementById('termSelect');

        sessionSelect.addEventListener('change', function() {
            const selectedSessionId = this.value;
            const allTerms = termSelect.querySelectorAll('option');

            if (selectedSessionId === '') {
                // No session selected → disable term dropdown
                termSelect.disabled = true;
                termSelect.value = '';
                return;
            }

            // Enable term dropdown
            termSelect.disabled = false;

            // Filter terms
            allTerms.forEach(termOption => {
                const sessionId = termOption.getAttribute('data-session');
                if (!sessionId) return; // skip the first "Select term" option

                if (sessionId === selectedSessionId) {
                    termOption.style.display = ''; // show
                } else {
                    termOption.style.display = 'none'; // hide
                }
            });

            // Reset term selection
            termSelect.value = '';
        });

        function filterSubjects() {
            const searchTerm = document
                .getElementById("searchInput")
                .value.toLowerCase();
            const selectedClass = document.getElementById("classFilter").value;

            const sections = document.querySelectorAll(".section-container");
            let visibleSections = 0;

            sections.forEach((section) => {
                const sectionName = section.getAttribute("data-class");

                if (selectedClass && selectedClass !== sectionName) {
                    section.style.display = "none";
                    return;
                }

                const subjectItems = section.querySelectorAll(".subject-item");
                let visibleSubjects = 0;

                subjectItems.forEach((subjectItem) => {
                    const subjectName = subjectItem
                        .getAttribute("data-subject")
                        .toLowerCase();
                    const matches = subjectName.includes(searchTerm);

                    subjectItem.style.display = matches ? "block" : "none";
                    if (matches) visibleSubjects++;
                });

                section.style.display = visibleSubjects > 0 ? "block" : "none";
                if (visibleSubjects > 0) visibleSections++;
            });
        }

        document
            .getElementById("searchInput")
            .addEventListener("input", filterSubjects);
        document
            .getElementById("classFilter")
            .addEventListener("change", filterSubjects);


        function attachSessionTermToLinks() {
            const sessionId = document.getElementById("sessionSelect").value;
            const termId = document.getElementById("termSelect").value;

            document.querySelectorAll(".createResultBtn, .updateResultBtn").forEach(btn => {
                let url = new URL(btn.href);

                // remove old values if they exist
                url.searchParams.delete("session_id");
                url.searchParams.delete("term_id");

                // add new values if selected
                if (sessionId) url.searchParams.append("session_id", sessionId);
                if (termId) url.searchParams.append("term_id", termId);

                btn.href = url.toString();
            });
        }

        // Re-attach whenever user changes session or term
        document.getElementById("sessionSelect").addEventListener("change", attachSessionTermToLinks);
        document.getElementById("termSelect").addEventListener("change", attachSessionTermToLinks);

        // Run once when page loads
        attachSessionTermToLinks();

        document.querySelectorAll(".createResultBtn, .updateResultBtn").forEach(btn => {
            btn.addEventListener("click", function(event) {
                const sessionId = document.getElementById("sessionSelect").value;
                const termId = document.getElementById("termSelect").value;

                // If user has NOT selected session/term
                if (!sessionId || !termId) {
                    event.preventDefault();

                    // Send the failure back to PHP
                    const form = document.getElementById("failureForm");
                    form.submit();

                    return false;
                }
            });
        });
    </script>
</body>

</html>