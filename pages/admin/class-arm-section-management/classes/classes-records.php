<?php
$title = "Class Records";
include(__DIR__ . '/../../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (!isset($_GET['class_id'])) {
    $_SESSION['failure'] = "Class not specified";
    header("Location: " . route('back'));
    exit();
}

$class_id = (int) $_GET['class_id'];

// Get class info
$stmt = $pdo->prepare("SELECT id, name, level FROM classes WHERE id = ?");
$stmt->execute([$class_id]);
$class = $stmt->fetch(PDO::FETCH_ASSOC);

// Get arms for this class
$stmt = $pdo->prepare("
    SELECT ca.id, ca.name
    FROM class_class_arms cca
    JOIN class_arms ca ON ca.id = cca.arm_id
    WHERE cca.class_id = ?
");
$stmt->execute([$class_id]);
$arms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get sessions where this class has records
$stmt = $pdo->prepare("
    SELECT DISTINCT scr.session_id, s.name AS session_name, s.start_date, s.end_date
    FROM student_class_records scr
    JOIN sessions s ON scr.session_id = s.id
    WHERE scr.class_id = ?
    ORDER BY s.start_date DESC
");
$stmt->execute([$class_id]);
$sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// For each session, get terms
$session_terms = [];
foreach ($sessions as $sess) {
    $stmt = $pdo->prepare("SELECT id, name FROM terms WHERE session_id = ? ORDER BY start_date");
    $stmt->execute([$sess['session_id']]);
    $session_terms[$sess['session_id']] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/../../includes/admins-section-nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <?= htmlspecialchars($class['name']) ?> Records
            </h1>
            <p class="text-xl text-blue-200">View sessions, terms, and arms for this class</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Arms -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Class Arms</h2>
                <div class="flex flex-wrap gap-4">
                    <?php foreach ($arms as $arm): ?>
                        <span class="bg-blue-50 border border-blue-200 px-4 py-2 rounded-lg text-blue-900 font-semibold">
                            <?= htmlspecialchars($arm['name']) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Sessions -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Available Sessions</h2>
                <?php foreach ($sessions as $sess): ?>
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-xl font-semibold text-blue-900 mb-4">
                            <?= htmlspecialchars($sess['session_name']) ?>
                            <span class="text-gray-500 text-sm">(<?= $sess['start_date'] ?> - <?= $sess['end_date'] ?>)</span>
                        </h3>

                        <!-- Terms -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <?php foreach ($session_terms[$sess['session_id']] as $term): ?>
                                <a href="<?= route('class-broadsheet-by-term') ?>?class_id=<?= $class_id ?>&session_id=<?= $sess['session_id'] ?>&term_id=<?= $term['id'] ?>"
                                    class="bg-gradient-to-br from-blue-900 to-blue-700 text-white rounded-lg p-6 shadow-md hover:shadow-lg transition transform hover:scale-105 text-center">
                                    <i class="fas fa-calendar text-3xl mb-2 opacity-80"></i>
                                    <h4 class="text-lg font-bold"><?= htmlspecialchars($term['name']) ?></h4>
                                    <p class="text-blue-100 text-sm">View results for all arms</p>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../../../../includes/footer.php'); ?>
</body>