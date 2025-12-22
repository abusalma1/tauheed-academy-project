<?php

$title = "Terms & Sessions";
include(__DIR__ . '/../../../includes/header.php');

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


$stmt = $pdo->prepare("
    SELECT 
        sessions.id AS session_id,
        sessions.name AS session_name,
        sessions.start_date AS session_start_date,
        sessions.end_date AS session_end_date,

        terms.id AS term_id,
        terms.name AS term_name,
        terms.status AS term_status,

        terms.start_date AS term_start_date,
        terms.end_date AS term_end_date

    FROM sessions
    LEFT JOIN terms 
        ON sessions.id = terms.session_id 
    ORDER BY sessions.created_at DESC
");
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sessions = [];

foreach ($rows as $row) {
    $sessionId = $row['session_id'];

    if (!isset($sessions[$sessionId])) {
        $sessions[$sessionId] = [
            'session_id'        => $row['session_id'],
            'session_name'      => $row['session_name'],
            'session_start_date' => $row['session_start_date'],
            'session_end_date'  => $row['session_end_date'],
            'terms'             => []
        ];
    }

    if (!empty($row['term_id'])) {
        $sessions[$sessionId]['terms'][] = [
            'term_id'        => $row['term_id'],
            'term_name'      => $row['term_name'],
            'term_start_date' => $row['term_start_date'],
            'term_end_date'  => $row['term_end_date'],
            'term_status' => $row['term_status']
        ];
    }
}

// Statistics (assuming countDataTotal is already PDO-based)
$sessionsCount = countDataTotal('sessions')['total'];
$termsCount    = countDataTotal('terms')['total'];

?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php');  ?>


    <!-- Page Header -->
    <section class="bg-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Terms & Sessions</h1>
            <p class="text-xl text-green-200">View & manage all terms organized by academeic sessions</p>
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
                            <p class="text-gray-600 text-sm">Total Terms</p>
                            <p class="text-3xl font-bold text-green-900"><?= $termsCount ?></p>
                        </div>
                        <i class="fas fa-chalkboard text-4xl text-green-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Sessions</p>
                            <p class="text-3xl font-bold text-blue-900"><?= $sessionsCount ?></p>
                        </div>
                        <i class="fas fa-sitemap text-4xl text-blue-200"></i>
                    </div>
                </div>

            </div>

            <!-- Search Bar -->
            <div class="mb-8 bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="searchInput" class="block text-sm font-semibold text-gray-700 mb-2">Search Terms</label>
                        <input type="text" id="searchInput" placeholder="Search by class name, arm, or teacher..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                    </div>
                    <div class="flex-1">
                        <label for="sectionFilter" class="block text-sm font-semibold text-gray-700 mb-2">Filter by Sessions</label>
                        <select id="sectionFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                            <option value="">All sessions</option>
                            <?php foreach ($sessions as $session) : ?>
                                <option value="<?= $session['session_name'] ?>"><?= $session['session_name'] ?></option>
                            <?php endforeach  ?>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <a href="<?= route('create-session') ?>" class="w-full md:w-auto bg-green-900 hover:bg-green-800 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i> Create Session
                        </a>
                    </div>
                </div>
            </div>

            <!-- sessions with Classes and Arms -->
            <div id="sessionsContainer" class="space-y-8">
                <?php foreach ($sessions as $session): ?>
                    <div class="session-container bg-white rounded-lg shadow-lg overflow-hidden" data-section="<?= $session['session_name'] ?>">
                        <div class="bg-blue-900 text-white p-4 flex items-center gap-3 flex items-center justify-between mb-4">
                            <!-- <i class="fas fa-quran text-3xl opacity-80"></i> -->
                            <div>
                                <h2 class="text-2xl font-bold"><small>Session: </small><?= $session['session_name'] ?></h2>
                                <p> <span class="text-sm opacity-90"> Start Date:</span> <span class=""><?= date('D d M, Y', strtotime($session['session_start_date']))  ?> </span></p>
                                <p><span class="text-sm opacity-90"> End Date: </span> <span class=""><?= date('D d M, Y', strtotime($session['session_end_date'])) ?></span></p>

                            </div>
                            <div class="flex flex-col items-center gap-3">
                                <a href="<?= route('create-term') . '?id=' . $session['session_id'] ?>" class="bg-white text-indigo-900 px-4 py-1 rounded-lg font-semibold hover:bg-indigo-100 transition">
                                    <i class="fas fa-plus mr-2"></i>Create Term
                                </a>
                                <a href="<?= route('update-session'); ?>?id=<?= $session['session_id'] ?>" class="bg-white text-indigo-900 px-4 py-1 rounded-lg font-semibold hover:bg-indigo-100 transition">
                                    <i class="fas fa-pen mr-2"></i>Edit Session
                                </a>
                                <a href="<?= route('delete-session') . '?id=' . $session['session_id'] ?>" class="bg-white text-indigo-900 px-4 py-1 rounded-lg font-semibold hover:bg-indigo-100 transition">
                                    <i class="fas fa-trash mr-2"></i>Delete Term
                                </a>
                            </div>
                        </div>


                        <div class="bg-white rounded-b-lg shadow-md overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-100 border-b">
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Term name</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Term Status</th>

                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Start Date</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">End Date</th>
                                        <th class="px-6 py-3 text-center text-sm font-semibold text-slate-700">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($session['terms'] as $term) :   ?>
                                        <tr
                                            class="class-item border-b border-slate-100 hover:bg-blue-50 transition subject-row whitespace-nowrap"
                                            data-class-name="<?= $term['term_name'] ?>">

                                            <td class="px-6 py-4 text-sm font-medium text-slate-900"><?= $term['term_name'] ?></td>
                                            <td class="px-6 py-4 text-sm font-medium text-slate-900"><?= ucwords    ($term['term_status']) ?></td>


                                            <td class="px-6 py-4 text-sm font-medium text-slate-900"><?= date('D d M, Y', strtotime($term['term_start_date'])) ?></td>

                                            <td class="px-6 py-4 text-sm font-medium text-slate-900"><?= date('D d M, Y', strtotime($term['term_end_date'])) ?></td>


                                            <td class="px-6 py-4 text-sm text-slate-600">
                                                <div class="flex items-center justify-center gap-4">
                                                    <a href="<?= route('update-term') . '?id=' . $term['term_id'] ?>">
                                                        <button class="text-blue-600 hover:text-blue-900 font-semibold flex items-center gap-1">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                    </a>
                                                    <a href="<?= route('update-term-status') . '?id=' . $term['term_id'] ?>">
                                                        <button class="text-blue-600 hover:text-blue-900 font-semibold flex items-center gap-1">
                                                            <i class="fas fa-edit"></i> Update Status
                                                        </button>
                                                    </a>
                                                    <a href="<?= route('delete-term') ?>?id=<?= $term['term_id'] ?>">

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

            const sessions = document.querySelectorAll('.session-container');
            let visiblesessions = 0;

            sessions.forEach(section => {
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
                if (visibleClasses > 0) visiblesessions++;
            });

            // Show "no results" message if needed
            const container = document.getElementById('sessionsContainer');
            const noResults = container.querySelector('.no-results');
            if (visiblesessions === 0) {
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