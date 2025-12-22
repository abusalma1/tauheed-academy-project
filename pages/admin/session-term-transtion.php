<?php
$title = 'Session & Terms Transitions';
include __DIR__ . '/../../includes/header.php';

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
// Fetch all terms with session names
$stmt = $pdo->prepare("
    SELECT terms.*, sessions.name AS session_name
    FROM terms
    LEFT JOIN sessions ON terms.session_id = sessions.id
    ORDER BY sessions.name ASC, terms.name ASC
");
$stmt->execute();
$terms = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch current active term
$active = 'ongoing';
$stmt = $pdo->prepare("
    SELECT terms.*, sessions.name AS session_name
    FROM terms
    LEFT JOIN sessions ON terms.session_id = sessions.id
    WHERE terms.status = ?
    LIMIT 1
");
$stmt->execute([$active]);
$current_term = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $term_id = (int) $_POST['term_id'];
    $allow_demotion = isset($_POST['allow_demotion']);
    $required_average = isset($_POST['required_average']) ? (float) $_POST['required_average'] : 0;

    // Get new term details
    $stmt = $pdo->prepare("SELECT * FROM terms WHERE id = ?");
    $stmt->execute([$term_id]);
    $new_term = $stmt->fetch(PDO::FETCH_ASSOC);
    $new_session_id = $new_term['session_id'];

    // Get current active term
    $stmt = $pdo->prepare("SELECT * FROM terms WHERE status = ? LIMIT 1");
    $stmt->execute(["ongoing"]);
    $old_term = $stmt->fetch(PDO::FETCH_ASSOC);
    $old_session_id = $old_term ? $old_term['session_id'] : null;

    $pdo->beginTransaction();
    try {
        if ($action === "activate") {
            // Activate new term
            $pdo->prepare("UPDATE terms SET status='ongoing' WHERE id=?")->execute([$term_id]);
            $pdo->prepare("UPDATE terms SET status='finished' WHERE id!=? AND status='ongoing'")->execute([$term_id]);

            // === GENERAL STUDIES PROMOTION ===
            if ($old_session_id != $new_session_id && $old_session_id !== null) {
                $stmt = $pdo->prepare("
                    SELECT scr.*, s.class_id, s.arm_id
                    FROM student_class_records scr
                    JOIN students s ON scr.student_id = s.id
                    WHERE scr.session_id = ?
                ");
                $stmt->execute([$old_session_id]);
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($records as $rec) {
                    $student_id = $rec['student_id'];
                    $old_class_id = $rec['class_id'];
                    $overall_average = (float) $rec['overall_average'];

                    // Load current islamiyya class level
                    $stmt2 = $pdo->prepare("SELECT * FROM classes WHERE id=?");
                    $stmt2->execute([$old_class_id]);
                    $class = $stmt2->fetch(PDO::FETCH_ASSOC);

                    if ($allow_demotion && $overall_average < $required_average) {
                        $new_class_id = $old_class_id;
                        $promotion_status = "repeat";
                    } else {
                        // Current level
                        $current_level = $class['level'];

                        // Find the next possible level greater than current
                        $stmt2 = $pdo->prepare("SELECT * FROM classes WHERE level > ? ORDER BY level ASC LIMIT 1");
                        $stmt2->execute([$current_level]);

                        // Fetch the next class
                        $next_class = $stmt2->fetch(PDO::FETCH_ASSOC);


                        if ($next_class) {
                            $new_class_id = $next_class['id'];
                            $promotion_status = "promoted";
                        } else {
                            $new_class_id = null;
                            $promotion_status = "promoted";
                            $pdo->prepare("UPDATE students SET status='inactive' WHERE id=?")->execute([$student_id]);
                        }
                    }

                    // Update old islamiyya record
                    $pdo->prepare("UPDATE islamiyya_student_class_records SET promotion_status=? WHERE student_id=? AND session_id=?")
                        ->execute([$promotion_status, $student_id, $old_session_id]);

                    // Update student table
                    $pdo->prepare("UPDATE students SET islamiyya_class_id=?, term_id=? WHERE id=?")
                        ->execute([$new_class_id, $term_id, $student_id]);

                    // Create new islamiyya records
                    if ($new_class_id !== null) {
                        $pdo->prepare("INSERT IGNORE INTO islamiyya_student_class_records (student_id, session_id, class_id) VALUES (?, ?, ?)")
                            ->execute([$student_id, $new_session_id, $new_class_id]);

                        $new_class_record_id = $pdo->lastInsertId();
                        $pdo->prepare("INSERT IGNORE INTO islamiyya_student_term_records (student_class_record_id, term_id) VALUES (?, ?)")
                            ->execute([$new_class_record_id, $term_id]);
                    }
                }
            } else {
                // Same session → only create term records
                $stmt = $pdo->prepare("SELECT id FROM student_class_records WHERE session_id=?");
                $stmt->execute([$new_session_id]);
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $cr) {
                    $pdo->prepare("INSERT IGNORE INTO student_term_records (student_class_record_id, term_id) VALUES (?, ?)")
                        ->execute([$cr['id'], $term_id]);
                }
            }

            // === ISLAMIYYA PROMOTION ===
            if ($old_session_id != $new_session_id && $old_session_id !== null) {
                $stmt = $pdo->prepare("
                    SELECT scr.*, s.islamiyya_class_id
                    FROM islamiyya_student_class_records scr
                    JOIN students s ON scr.student_id = s.id
                    WHERE scr.session_id = ?
                ");
                $stmt->execute([$old_session_id]);
                $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($records as $rec) {
                    $student_id = $rec['student_id'];
                    $old_class_id = $rec['islamiyya_class_id'];
                    $overall_average = (float) $rec['overall_average'];

                    // Load current islamiyya class level
                    $stmt2 = $pdo->prepare("SELECT * FROM islamiyya_classes WHERE id=?");
                    $stmt2->execute([$old_class_id]);
                    $class = $stmt2->fetch(PDO::FETCH_ASSOC);

                    if ($allow_demotion && $overall_average < $required_average) {
                        $new_class_id = $old_class_id;
                        $promotion_status = "repeat";
                    } else {
                        $current_level = $class['level'];
                        $stmt2 = $pdo->prepare("SELECT * FROM islamiyya_classes WHERE level > ? ORDER BY level ASC LIMIT 1");
                        $stmt2->execute([$current_level]);
                        $next_class = $stmt2->fetch(PDO::FETCH_ASSOC);

                        if ($next_class) {
                            $new_class_id = $next_class['id'];
                            $promotion_status = "promoted";
                        } else {
                            $new_class_id = null;
                            $promotion_status = "promoted";
                            $pdo->prepare("UPDATE students SET status='inactive' WHERE id=?")->execute([$student_id]);
                        }
                    }

                    // Update old islamiyya record
                    $pdo->prepare("UPDATE islamiyya_student_class_records SET promotion_status=? WHERE student_id=? AND session_id=?")
                        ->execute([$promotion_status, $student_id, $old_session_id]);

                    // Update student table
                    $pdo->prepare("UPDATE students SET islamiyya_class_id=?, term_id=? WHERE id=?")
                        ->execute([$new_class_id, $term_id, $student_id]);

                    // Create new islamiyya records
                    if ($new_class_id !== null) {
                        $pdo->prepare("INSERT IGNORE INTO islamiyya_student_class_records (student_id, session_id, class_id) VALUES (?, ?, ?)")
                            ->execute([$student_id, $new_session_id, $new_class_id]);

                        $new_class_record_id = $pdo->lastInsertId();
                        $pdo->prepare("INSERT IGNORE INTO islamiyya_student_term_records (student_class_record_id, term_id) VALUES (?, ?)")
                            ->execute([$new_class_record_id, $term_id]);
                    }
                }
            } else {
                // Same session → only create islamiyya term records
                $stmt = $pdo->prepare("SELECT id FROM islamiyya_student_class_records WHERE session_id=?");
                $stmt->execute([$new_session_id]);
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $cr) {
                    $pdo->prepare("INSERT IGNORE INTO islamiyya_student_term_records (student_class_record_id, term_id) VALUES (?, ?)")
                        ->execute([$cr['id'], $term_id]);
                }
            }
        }

        if ($action === "deactivate") {
            $pdo->prepare("UPDATE terms SET status='finished' WHERE id=?")->execute([$term_id]);
        }

        $pdo->commit();
        $_SESSION['success'] = "Term updated successfully!";
    } catch (Exception $e) {
        $pdo->rollBack();
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
            <div class="grid grid-cols-1 md:grid-cols-1 gap-8 mb-12">
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
                                            <span class="ml-3 text-gray-700">Allow Demotion (for previous session), Note: Demotion only works for session</span>
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
                                                <br>! All (Promoted (if demotion is allowed)) students will move to next class automatically
                                            </span>

                                            <!-- Confirmation Checkbox -->
                                            <div class="mb-6">
                                                <label class="flex items-center gap-3 cursor-pointer">
                                                    <input type="checkbox" id="confirmCheckbox" class="confirmCheckbox w-4 h-4 text-red-600 rounded focus:ring-2 focus:ring-red-500">
                                                    <span class="text-sm text-gray-700">I understand this action is permanent and cannot be reversed.</span>
                                                </label>
                                            </div>

                                            <button type="submit" class="submitBtn px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition text-sm  disabled:opacity-50 disabled:cursor-not-allowed" id="submitBtn" disabled>
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
        const confirmCheckbox = document.getElementsByClassName('confirmCheckbox');
        const deleteBtn = document.getElementsByClassName('submitBtn');

        for (let i = 0; i < confirmCheckbox.length; i++) {
            confirmCheckbox[i].addEventListener('change', function() {
                // Use confirmCheckbox[i] instead of confirmCheckbox
                deleteBtn[i].disabled = !confirmCheckbox[i].checked;
            });
        }




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