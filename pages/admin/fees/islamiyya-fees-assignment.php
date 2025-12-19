<?php
<<<<<<< HEAD

$title = "Islamiyya Fees Assignment";
include(__DIR__ . '/../../../includes/header.php');

/* ------------------------------
   CSRF TOKEN
------------------------------ */

=======
$title = "Islamiyya Fees Assignment";
include(__DIR__ . '/../../../includes/header.php');

>>>>>>> 271894334d344b716e30670c3770b73d583f3916
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

<<<<<<< HEAD
/* ------------------------------
   AUTHENTICATION & ACCESS CHECKS
------------------------------ */

=======
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
if (!isset($user_type) || $user_type !== 'admin') {
    $_SESSION['failure'] = "Access denied! Only Admins are allowed.";
    header("Location: " . route('home'));
    exit();
}

<<<<<<< HEAD
/* ------------------------------
   FETCH ACTIVE ISLAMIYYA SECTIONS + CLASSES
------------------------------ */

=======

// Fetch Islamiyya sections and classes
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
$stmt = $pdo->prepare("
    SELECT 
        islamiyya_sections.id AS section_id,
        islamiyya_sections.name AS section_name,
<<<<<<< HEAD

        islamiyya_classes.id AS class_id,
        islamiyya_classes.name AS class_name,
        islamiyya_classes.level AS class_level

    FROM islamiyya_sections

    LEFT JOIN islamiyya_classes 
        ON islamiyya_classes.section_id = islamiyya_sections.id
        AND islamiyya_classes.deleted_at IS NULL

    WHERE islamiyya_sections.deleted_at IS NULL
    ORDER BY islamiyya_classes.level ASC
");

=======
        islamiyya_classes.id AS class_id,
        islamiyya_classes.name AS class_name,
        islamiyya_classes.level AS class_level
    FROM islamiyya_sections
    LEFT JOIN islamiyya_classes ON islamiyya_classes.section_id = islamiyya_sections.id
    ORDER BY islamiyya_classes.level ASC
");
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sections = [];
<<<<<<< HEAD
$classFees = [];

/* ------------------------------
   GROUP CLASSES BY SECTION
------------------------------ */
=======
$classFees = []; // to store existing islamiyya fees
>>>>>>> 271894334d344b716e30670c3770b73d583f3916

foreach ($rows as $row) {
    $sectionId = $row['section_id'];

    if (!isset($sections[$sectionId])) {
        $sections[$sectionId] = [
            'section_id'   => $row['section_id'],
            'section_name' => $row['section_name'],
            'classes'      => []
        ];
    }

    if (!empty($row['class_id'])) {
        $sections[$sectionId]['classes'][] = [
            'class_id'   => $row['class_id'],
            'class_name' => $row['class_name']
        ];
    }
}

<<<<<<< HEAD
/* ------------------------------
   FETCH ACTIVE ISLAMIYYA FEES
------------------------------ */

$feeStmt = $pdo->prepare("
    SELECT * 
    FROM islamiyya_fees 
    WHERE deleted_at IS NULL
");
$feeStmt->execute();
$feeRows = $feeStmt->fetchAll(PDO::FETCH_ASSOC);

=======
// Fetch existing islamiyya fees for all classes
$feeStmt = $pdo->prepare("SELECT * FROM islamiyya_fees");
$feeStmt->execute();
$feeRows = $feeStmt->fetchAll(PDO::FETCH_ASSOC);
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
foreach ($feeRows as $feeRow) {
    $classFees[$feeRow['islamiyya_class_id']] = $feeRow;
}

<<<<<<< HEAD
/* ------------------------------
   FORM PROCESSING
------------------------------ */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ------------------------------
       CSRF VALIDATION
    ------------------------------ */
=======
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    }

<<<<<<< HEAD
    // Regenerate token after validation
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    /* ------------------------------
       PROCESS FEES FOR EACH CLASS
    ------------------------------ */

    foreach ($_POST['fees'] as $classId => $fee) {

=======
    foreach ($_POST['fees'] as $classId => $fee) {
        // sanitize to avoid null numeric fields
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
        $first     = $fee['first_term'] ?? 0;
        $second    = $fee['second_term'] ?? 0;
        $third     = $fee['third_term'] ?? 0;
        $materials = $fee['materials'] ?? 0;

        if (isset($classFees[$classId])) {
<<<<<<< HEAD

            /* ------------------------------
               UPDATE EXISTING FEE RECORD
            ------------------------------ */

            $update = $pdo->prepare("
                UPDATE islamiyya_fees 
                SET 
                    first_term = ?, 
                    second_term = ?, 
                    third_term = ?, 
                    materials = ?, 
                    updated_at = NOW()
                WHERE islamiyya_class_id = ? 
                  AND deleted_at IS NULL
            ");

=======
            // Update existing
            $update = $pdo->prepare("
                UPDATE islamiyya_fees 
                SET first_term=?, second_term=?, third_term=?, materials=?, updated_at=NOW()
                WHERE islamiyya_class_id=?
            ");
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
            $update->execute([
                $first,
                $second,
                $third,
                $materials,
                $classId
            ]);
        } else {
<<<<<<< HEAD

            /* ------------------------------
               INSERT NEW FEE RECORD
            ------------------------------ */

            $insert = $pdo->prepare("
                INSERT INTO islamiyya_fees
                (islamiyya_class_id, first_term, second_term, third_term, materials, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, NOW(), NOW())
            ");

=======
            // Insert new
            $insert = $pdo->prepare("
                INSERT INTO islamiyya_fees
                (islamiyya_class_id, first_term, second_term, third_term, materials)
                VALUES (?, ?, ?, ?, ?)
            ");
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
            $insert->execute([
                $classId,
                $first,
                $second,
                $third,
                $materials
            ]);
        }
    }

    $_SESSION['success'] = "Islamiyya fees saved successfully!";
    header("Location: " . route('back'));
<<<<<<< HEAD
    exit();
}

=======
    exit;
}
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
?>



<<<<<<< HEAD
=======

>>>>>>> 271894334d344b716e30670c3770b73d583f3916
<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/../includes/admins-section-nav.php") ?>



    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Islamiyya Fees Assignment</h1>
            <p class="text-xl text-orange-100">Assign annual fees for all islamiyya classes in one place</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search Class</label>
                        <input type="text" id="searchInput" placeholder="Search by class name..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Filter by Section</label>
                        <select id="sectionFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-600">
                            <option value="">All Sections</option>
                            <?php foreach ($sections as $section): ?>
                                <option value="<?= $section['section_name'] ?>"><?= $section['section_name'] ?></option>
                            <?php endforeach ?>

                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button onclick="saveAllFees()" class="flex-1 bg-orange-600 text-white py-2 rounded-lg font-semibold hover:bg-orange-700 transition">
                            <i class="fas fa-save mr-2"></i>Save All Changes
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Classes</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="totalClassesStat">16</p>
                        </div>
                        <i class="fas fa-book text-4xl text-orange-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Fees Assigned</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="feesAssignedStat">0</p>
                        </div>
                        <i class="fas fa-check-circle text-4xl text-green-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Average Annual Fee</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2" id="avgFeeStat">₦0</p>
                        </div>
                        <i class="fas fa-money-bill text-4xl text-blue-200"></i>
                    </div>
                </div>
            </div>
            <form method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                <!-- Fees Table by Sections -->
                <div class="space-y-8 text-nowrap">

                    <?php foreach ($sections as $section): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-900 to-blue-700 px-6 py-4">
                                <h3 class="text-xl font-bold text-white"><?= $section['section_name'] ?> Section</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-100 border-b-2 border-gray-300">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Class Name</th>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">First Term</th>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Second Term</th>
                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Third Term</th>

                                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Books & Materials</th>

                                            <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900">Total Annual Fee</th>

                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <?php foreach ($section['classes'] as $class) : ?>

                                            <?php
                                            // Load existing fees if they exist
                                            $fee = $classFees[$class['class_id']] ?? [
                                                'first_term' => '',
                                                'second_term' => '',
                                                'third_term' => '',

                                                'materials' => '',


                                            ];
                                            ?>
                                            <tr class="hover:bg-gray-50" data-class-id="<?= $class['class_id'] ?>">


                                                <!-- CLASS NAME -->
                                                <td class="px-6 py-4 font-semibold text-gray-900">
                                                    <?= $class['class_name'] ?>
                                                </td>

                                                <!-- FIRST TERM -->
                                                <td class="px-6 py-4">
                                                    <input type="number"
                                                        name="fees[<?= $class['class_id'] ?>][first_term]"
                                                        value="<?= $fee['first_term'] ?>"
                                                        data-type="first_term"
                                                        class="w-24 px-2 py-1 border border-gray-300 rounded focus:outline-none fee-input"
                                                        placeholder="0">
                                                </td>

                                                <!-- SECOND TERM -->
                                                <td class="px-6 py-4">
                                                    <input type="number"
                                                        name="fees[<?= $class['class_id'] ?>][second_term]"
                                                        value="<?= $fee['second_term'] ?>"
                                                        data-type="second_term"

                                                        class="w-24 px-2 py-1 border border-gray-300 rounded focus:outline-none fee-input"
                                                        placeholder="0">
                                                </td>

                                                <!-- THIRD TERM -->
                                                <td class="px-6 py-4">
                                                    <input type="number"
                                                        name="fees[<?= $class['class_id'] ?>][third_term]"
                                                        value="<?= $fee['third_term'] ?>"
                                                        data-type="third_term"

                                                        class="w-24 px-2 py-1 border border-gray-300 rounded focus:outline-none fee-input"
                                                        placeholder="0">
                                                </td>

                                                <!-- MATERIALS -->
                                                <td class="px-6 py-4">
                                                    <input type="number"
                                                        name="fees[<?= $class['class_id'] ?>][materials]"
                                                        value="<?= $fee['materials'] ?>"
                                                        data-type="materials"

                                                        class="w-24 px-2 py-1 border border-gray-300 rounded focus:outline-none fee-input"
                                                        placeholder="0">
                                                </td>



                                                <!-- TOTAL (STATIC – NO JS) -->
                                                <td class="px-6 py-4 text-right">
                                                    <span class="font-bold text-orange-600 total-fee">
                                                        ₦<?=
                                                            array_sum([
                                                                $fee['first_term'] ?? 0,
                                                                $fee['second_term'] ?? 0,
                                                                $fee['third_term'] ?? 0,

                                                                $fee['materials'] ?? 0,


                                                            ]);
                                                            ?>
                                                    </span>
                                                </td>

                                            </tr>

                                        <?php endforeach ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>

                <!-- Save Button -->
                <div class="mt-8 flex justify-center gap-4">
                    <button type="submit" class="bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                        <i class="fas fa-save mr-2"></i>Save All Fees
                    </button>
                    <button onclick="resetForm()" class="bg-gray-300 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </button>
                </div>
            </form>
        </div>

        <style>
            .animate-spin {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>

    </section>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../../includes/footer.php"); ?>

    <script>
        // Filter by section
        document.getElementById('sectionFilter').addEventListener('change', (e) => {
            const section = e.target.value;
            document.querySelectorAll('.bg-white.rounded-lg.shadow-lg.overflow-hidden').forEach(table => {
                if (section === '') {
                    table.style.display = '';
                } else {
                    const sectionText = table.querySelector('h3').textContent;
                    table.style.display = sectionText.includes(section) ? '' : 'none';
                }
            });
        });


        // Listen for changes in all input fields
        document.addEventListener("input", function(e) {
            if (e.target.matches("input[type='number']")) {
                updateRowTotal(e.target);
            }
        });

        function updateRowTotal(input) {
            const row = input.closest('tr');
            const inputs = row.querySelectorAll('.fee-input');
            let total = 0;
            inputs.forEach(inp => {
                total += parseFloat(inp.value) || 0;
            });

            // Update the total in the table
            const totalSpan = row.querySelector('.total-fee');
            totalSpan.textContent = '₦' + total.toLocaleString();

            // Update statistics
            updateStatistics();
        }

        function updateStatistics() {
            const rows = document.querySelectorAll('tr[data-class-id]');
            let totalClasses = rows.length;
            let feesAssigned = 0;
            let sumAnnual = 0;

            rows.forEach(row => {
                const inputs = row.querySelectorAll('.fee-input');
                let rowTotal = 0;
                inputs.forEach(inp => {
                    const val = parseFloat(inp.value) || 0;
                    if (val > 0) feesAssigned++;
                    rowTotal += val;
                });
                sumAnnual += rowTotal;
            });

            // Update stat cards
            document.getElementById('totalClassesStat').textContent = totalClasses;
            document.getElementById('feesAssignedStat').textContent = feesAssigned; // number of fields filled
            document.getElementById('avgFeeStat').textContent = '₦' + Math.round(sumAnnual / totalClasses).toLocaleString();
        }

        // Initialize stats on page load
        document.addEventListener('DOMContentLoaded', () => {
            updateStatistics();
        });
    </script>

</body>

</html>