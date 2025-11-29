<?php
$title = 'Session & Terms Transitions';

include __DIR__ . '/../../includes/header.php';

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

$stmt = $conn->prepare("
    SELECT 
        terms.*,
        sessions.name AS session_name
    FROM terms
    LEFT JOIN sessions 
        ON terms.session_id = sessions.id
        AND sessions.deleted_at IS NULL   -- only include non-deleted sessions
    WHERE terms.deleted_at IS NULL        -- only include non-deleted terms
    ORDER BY sessions.name ASC, terms.name ASC
");

$stmt->execute();
$terms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


$active = 'ongoing';

$stmt = $conn->prepare("
    SELECT 
        terms.*,
        sessions.name AS session_name
    FROM terms
    LEFT JOIN sessions 
        ON terms.session_id = sessions.id
        AND sessions.deleted_at IS NULL   -- only include non-deleted sessions
    WHERE terms.status = ? 
      AND terms.deleted_at IS NULL        -- only include non-deleted terms
    LIMIT 1
");

$stmt->bind_param('s', $active);
$stmt->execute();
$current_term = $stmt->get_result()->fetch_assoc();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $term_id = intval($_POST['term_id']);
    $allow_demotion = isset($_POST['allow_demotion']);
    $required_average = isset($_POST['required_average']) ? floatval($_POST['required_average']) : 0;

    // Get new term details
    $stmt = $conn->prepare("SELECT * FROM terms WHERE id = ?");
    $stmt->bind_param("i", $term_id);
    $stmt->execute();
    $new_term = $stmt->get_result()->fetch_assoc();

    $new_session_id = $new_term['session_id'];

    // Get current active term
    $status_ongoing = "ongoing";
    $stmt = $conn->prepare("SELECT * FROM terms WHERE status = ? LIMIT 1");
    $stmt->bind_param("s", $status_ongoing);
    $stmt->execute();
    $old_term = $stmt->get_result()->fetch_assoc();

    $old_session_id = $old_term ? $old_term['session_id'] : null;

    // Begin transaction
    $conn->begin_transaction();

    try {

        if ($action === "activate") {

            /** ===========================
             * 1. Activate new term
             * =========================== */
            $stmt = $conn->prepare("UPDATE terms SET status = 'ongoing' WHERE id = ?");
            $stmt->bind_param("i", $term_id);
            $stmt->execute();

            // Deactivate others
            $stmt = $conn->prepare("UPDATE terms SET status = 'finished' WHERE id != ? and status = 
            'ongoing' ");
            $stmt->bind_param("i", $term_id);
            $stmt->execute();


            /** =========================================================
             * CASE A: SESSION CHANGED → RUN PROMOTION ROUTINE
             * ========================================================= */
            if ($old_session_id != $new_session_id && $old_session_id !== null) {

                // Fetch all students with class records in the old session
                $stmt = $conn->prepare("
                    SELECT scr.*, s.class_id, s.arm_id
                    FROM student_class_records scr
                    JOIN students s ON scr.student_id = s.id
                    WHERE scr.session_id = ?
                ");
                $stmt->bind_param("i", $old_session_id);
                $stmt->execute();
                $records = $stmt->get_result();

                while ($rec = $records->fetch_assoc()) {
                    $student_id = $rec['student_id'];
                    $old_class_id = $rec['class_id'];
                    $old_arm_id = $rec['arm_id'];
                    $overall_average = floatval($rec['overall_average']);

                    /** LOAD CURRENT CLASS LEVEL */
                    $stmt2 = $conn->prepare("SELECT * FROM classes WHERE id = ?");
                    $stmt2->bind_param("i", $old_class_id);
                    $stmt2->execute();
                    $class = $stmt2->get_result()->fetch_assoc();

                    /** ==========================
                     *  DEMOTION CHECK
                     * ========================== */
                    if ($allow_demotion && $overall_average < $required_average) {
                        // Demoted → remain in same class but new session
                        $new_class_id = $old_class_id;
                        $new_arm_id = $old_arm_id;
                        $promotion_status = "repeat";
                    } else {
                        /** ==========================
                         *  NORMAL PROMOTION
                         * ========================== */
                        $next_level = $class['level'] + 1;

                        // Check if next class exists
                        $stmt2 = $conn->prepare("SELECT * FROM classes WHERE level = ?");
                        $stmt2->bind_param("i", $next_level);
                        $stmt2->execute();
                        $next_class = $stmt2->get_result()->fetch_assoc();

                        if ($next_class) {
                            // Promote
                            $new_class_id = $next_class['id'];
                            $new_arm_id = $old_arm_id;
                            $promotion_status = "promoted";
                        } else {
                            // Graduate student
                            $new_class_id = null;
                            $new_arm_id = null;
                            $promotion_status = "promoted";

                            // Mark student inactive
                            $stmt3 = $conn->prepare("UPDATE students SET status='inactive' WHERE id=?");
                            $stmt3->bind_param("i", $student_id);
                            $stmt3->execute();
                        }
                    }

                    /** ==========================
                     *  UPDATE OLD CLASS RECORD
                     * ========================== */
                    $stmt2 = $conn->prepare("
                        UPDATE student_class_records 
                        SET promotion_status=?
                        WHERE student_id=? AND session_id=?
                    ");
                    $stmt2->bind_param("sii", $promotion_status, $student_id, $old_session_id);
                    $stmt2->execute();


                    /** ==========================
                     *  UPDATE STUDENT TABLE
                     * ========================== */
                    $stmt2 = $conn->prepare("
                        UPDATE students SET class_id=?, arm_id=?, term_id=? WHERE id=?
                    ");
                    $stmt2->bind_param("iiii", $new_class_id, $new_arm_id, $term_id, $student_id);
                    $stmt2->execute();


                    /** ==========================
                     *  CREATE NEW student_class_records (NO DUPLICATE)
                     * ========================== */
                    if ($new_class_id !== null) {
                        $stmt2 = $conn->prepare("
                            INSERT IGNORE INTO student_class_records
                            (student_id, session_id, class_id, arm_id)
                            VALUES (?, ?, ?, ?)
                        ");
                        $stmt2->bind_param("iiii", $student_id, $new_session_id, $new_class_id, $new_arm_id);
                        $stmt2->execute();

                        // Get new record ID
                        $new_class_record_id = $conn->insert_id;

                        /** CREATE student_term_records FOR NEW TERM */
                        $stmt2 = $conn->prepare("
                            INSERT IGNORE INTO student_term_records
                            (student_class_record_id, term_id)
                            VALUES (?, ?)
                        ");
                        $stmt2->bind_param("ii", $new_class_record_id, $term_id);
                        $stmt2->execute();
                    }
                }
            }


            /** =========================================================
             * CASE B: SAME SESSION → ONLY CREATE TERM RECORDS
             * ========================================================= */
            else {
                // Load all working class_records for this session
                $stmt = $conn->prepare("SELECT id FROM student_class_records WHERE session_id=?");
                $stmt->bind_param("i", $new_session_id);
                $stmt->execute();
                $classRecords = $stmt->get_result();

                while ($cr = $classRecords->fetch_assoc()) {
                    $class_record_id = $cr['id'];

                    // Create missing term record
                    $stmt2 = $conn->prepare("
                        INSERT IGNORE INTO student_term_records (student_class_record_id, term_id)
                        VALUES (?, ?)
                    ");
                    $stmt2->bind_param("ii", $class_record_id, $term_id);
                    $stmt2->execute();
                }
            }
        }


        /** ============================
         *  DEACTIVATE TERM
         * ============================ */
        if ($action === "deactivate") {
            $stmt = $conn->prepare("UPDATE terms SET status='finished' WHERE id=?");
            $stmt->bind_param("i", $term_id);
            $stmt->execute();
        }


        $conn->commit();
        $_SESSION['success'] = "Term updated successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['failure'] = "Error: " . $e->getMessage();
    }

    header("Location: " . route('promotion'));
    exit();
}

?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/./includes/admins-section-nav.php") ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Term & Session Transition</h1>
            <p class="text-xl text-blue-200">Manage academic calendar transitions and student promotions</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Current Academic Session -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <?php if ($current_term) : ?>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Current Academic Session</h2>

                        <div class="space-y-4 mb-6">
                            <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-900">
                                <p class="text-sm text-gray-900">Session</p>
                                <p class="text-xl font-bold text-blue-900"><?= $current_term['session_name'] ?></p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-900">
                                <p class="text-sm text-gray-900">Current Term</p>
                                <p class="text-xl font-bold text-blue-900"><?= $current_term['name'] ?></p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-900">
                                <p class="text-sm text-gray-900">Status</p>
                                <p class="text-xl font-bold text-green-900">Active</p>
                            </div>
                        </div>
                    <?php else : ?>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">No Academic Session Is Active</h2>
                    <?php endif ?>
                </div>


            </div>

            <!-- Academic Calendar Timeline -->
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Academic Calendar Timeline</h2>

                <div class="space-y-6">
                    <?php foreach ($terms as $term) : ?>
                        <div class="border-l-4
                                    <?php if ($term['status'] === 'ongoing') : ?>
                                    border-blue-600 
                                <?php elseif ($term['status'] === 'finished') : ?> 
                                    border-green-600
                                <?php elseif ($term['status'] === 'pending') : ?> 
                                    border-gray-400
                                <?php endif; ?> 
                                pl-6">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900"><?= $term['session_name'] ?> - <?= $term['name'] ?></h3>
                                    <p class="text-gray-900"><?= date('M , Y', strtotime($term['start_date'])) ?> - <?= $term['end_date'] ?></p>
                                </div>
                                <?php if ($term['status'] === 'ongoing') :  ?>
                                    <span class="px-4 py-2 bg-blue-100 text-blue-900 rounded-full text-sm font-semibold">Active</span>
                                <?php elseif ($term['status'] === 'finished') :  ?>
                                    <span class="px-4 py-2 bg-green-100 text-green-900 rounded-full text-sm font-semibold">Completed</span>
                                <?php elseif ($term['status'] === 'pending') :  ?>
                                    <span class="px-4 py-2 bg-gray-100 text-gray-900 rounded-full text-sm font-semibold">Pending</span>
                                <?php endif;  ?>

                            </div>
                            <?php if ($term['status'] === 'finished') : ?>
                                <div class="bg-blue-50 p-4 rounded-lg text-sm text-blue-900">
                                    <p><i class="fas fa-check mr-2"></i>72 students enrolled</p>
                                </div>
                            <?php endif ?>

                            <div class="flex gap-3">
                                <?php if ($term['status'] === 'pending') :  ?>
                                    <form method="POST" class="flex flex-col gap-3">
                                        <input type="hidden" name="action" value="activate">
                                        <input type="hidden" name="term_id" value="<?= $term['id'] ?>">

                                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 mb-3">
                                            <input type="checkbox" class="w-4 h-4 text-blue-900" name="allow_demotion" value="1">
                                            <span class="ml-3 text-gray-700">Allow Demotion (for previou session)</span>
                                        </label>



                                        <label for="average_required" class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50 mb-3">
                                            <input
                                                type="number"
                                                id="average_required"
                                                name="average_required"
                                                value="0.00"
                                                class="w-20 h-10 text-blue-900 border border-gray-200 rounded-md px-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            <span class="ml-3 text-gray-700">Minimum Average Required for Promotion</span>
                                        </label>


                                        <div class="flex flex-col gap-3">
                                            <span class="text-sm text-gray-600 font-semibold">
                                                Activating this term will automatically close the current active term and process student demotion (if enabled).
                                            </span>

                                            <!-- Confirmation Checkbox -->
                                            <div class="mb-6">
                                                <label class="flex items-center gap-3 cursor-pointer">
                                                    <input type="checkbox" id="confirmCheckbox" class="w-4 h-4 text-red-600 rounded focus:ring-2 focus:ring-red-500">
                                                    <span class="text-sm text-gray-700">I understand this action is permanent and cannot be reversed.</span>
                                                </label>
                                            </div>

                                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition text-sm  disabled:opacity-50 disabled:cursor-not-allowed" id="submitBtn" disabled>
                                                <i class="fas fa-play mr-1"></i>Activate
                                            </button>
                                        </div>
                                    </form>
                                <?php endif;  ?>

                            </div>

                        </div>
                    <?php endforeach ?>

                </div>
            </div>

            <!-- Transition Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">End of Term Actions</h3>

                    <div class="space-y-3">
                        <button class="w-full flex items-center gap-3 p-4 border-2 border-blue-200 rounded-lg hover:bg-blue-50 transition text-left">
                            <i class="fas fa-graduation-cap text-blue-900 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Finalize Results</p>
                                <p class="text-xs text-gray-900">Lock all grades and results</p>
                            </div>
                        </button>

                        <button class="w-full flex items-center gap-3 p-4 border-2 border-orange-200 rounded-lg hover:bg-orange-50 transition text-left">
                            <i class="fas fa-exchange-alt text-orange-900 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Process Promotions</p>
                                <p class="text-xs text-gray-900">Promote/retain/demote students</p>
                            </div>
                        </button>

                        <button class="w-full flex items-center gap-3 p-4 border-2 border-green-200 rounded-lg hover:bg-green-50 transition text-left">
                            <i class="fas fa-certificate text-green-900 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Generate Report Cards</p>
                                <p class="text-xs text-gray-900">Print and export report cards</p>
                            </div>
                        </button>

                        <button class="w-full flex items-center gap-3 p-4 border-2 border-blue-200 rounded-lg hover:bg-blue-50 transition text-left">
                            <i class="fas fa-archive text-blue-900 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Archive Term Data</p>
                                <p class="text-xs text-gray-900">Backup current term information</p>
                            </div>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Next Term Setup</h3>

                    <div class="space-y-3">
                        <button class="w-full flex items-center gap-3 p-4 border-2 border-blue-200 rounded-lg hover:bg-blue-50 transition text-left">
                            <i class="fas fa-users text-blue-900 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Assign New Classes</p>
                                <p class="text-xs text-gray-900">Assign students to new classes</p>
                            </div>
                        </button>

                        <button class="w-full flex items-center gap-3 p-4 border-2 border-indigo-200 rounded-lg hover:bg-indigo-50 transition text-left">
                            <i class="fas fa-chalkboard-teacher text-indigo-900 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Assign Class Teachers</p>
                                <p class="text-xs text-gray-900">Assign teachers to new classes</p>
                            </div>
                        </button>

                        <button class="w-full flex items-center gap-3 p-4 border-2 border-pink-200 rounded-lg hover:bg-pink-50 transition text-left">
                            <i class="fas fa-clock text-pink-900 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Set Timetables</p>
                                <p class="text-xs text-gray-900">Create new class timetables</p>
                            </div>
                        </button>

                        <button class="w-full flex items-center gap-3 p-4 border-2 border-cyan-200 rounded-lg hover:bg-cyan-50 transition text-left">
                            <i class="fas fa-sync text-cyan-900 text-xl"></i>
                            <div>
                                <p class="font-semibold text-gray-900">Initialize New Term</p>
                                <p class="text-xs text-gray-900">Activate new academic term</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../includes/footer.php"); ?>

    <script>
        // Confirmation checkbox
        const confirmCheckbox = document.getElementById('confirmCheckbox');
        const deleteBtn = document.getElementById('submitBtn');

        confirmCheckbox.addEventListener('change', () => {
            deleteBtn.disabled = !confirmCheckbox.checked;
        });


        // Term/Session form submission
        const termSessionForm = document.getElementById('termSessionForm');
        termSessionForm.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('New term/session created successfully!');
            termSessionForm.reset();
        });
    </script>
</body>

</html>