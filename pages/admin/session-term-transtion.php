<?php
$title = 'Session & Terms Transitions';

include __DIR__ . '/../../includes/header.php';

$stmt = $conn->prepare("SELECT terms.*, sessions.name session_name FROM terms left join sessions on terms.session_id = sessions.id ORDER BY sessions.name ASC ,  terms.name ASC");
$stmt->execute();
$terms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$active = 'ongoing';
$stmt = $conn->prepare("SELECT terms.*, sessions.name session_name FROM terms left join sessions on terms.session_id = sessions.id where terms.status = ? LIMIT 1");
$stmt->bind_param('s', $active);
$stmt->execute();
$current_term = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD']  === 'POST') {
    $action = $_POST['action'];
    $term_id = $_POST['term_id'];
    $ongoing = 'ongoing';
    $finished = 'finished';


    if ($action === 'activate') {

        $stmt = $conn->prepare("UPDATE terms set status = ? where id = ?");
        $stmt->bind_param('si', $ongoing, $term_id);
        $stmt->execute();

        $stmt = $conn->prepare("UPDATE terms set status = ? where status = ? and id != ?");
        $stmt->bind_param('ssi', $finished, $ongoing, $term_id);
        $stmt->execute();
    } elseif ($action === 'deactivate') {

        $stmt = $conn->prepare("UPDATE terms set status = ? where id = ?");
        $stmt->bind_param('si', $finished, $term_id);
        $stmt->execute();
    }

    $_SESSION['success'] = "Term status updated successfully!";
    header("Location:  " . route('promotion'));
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

                <!-- Promotion Rules -->
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Promotion Rules</h2>

                    <form action="" method="get">
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-blue-50">
                                <input type="checkbox" class="w-4 h-4 text-blue-900" name="repetition">
                                <span class="ml-3 text-gray-700">Enable Class Repetition</span>
                            </label>

                        </div>

                        <button type="submit" class="w-full mt-6 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Save Rules
                        </button>
                    </form>
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
                                <?php if ($term['status'] === 'ongoing') :  ?>
                                    <form method="POST">
                                        <input type="hidden" name="action" value="deactivate">
                                        <input type="hidden" name="term_id" value="<?= $term['id'] ?>">


                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition text-sm">
                                            <i class="fas fa-lock mr-1"></i>Close
                                        </button>
                                    </form>
                                <?php elseif ($term['status'] === 'pending') :  ?>
                                    <form method="POST">
                                        <input type="hidden" name="action" value="activate">
                                        <input type="hidden" name="term_id" value="<?= $term['id'] ?>">


                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition text-sm">
                                            <i class="fas fa-play mr-1"></i>Activate
                                        </button>
                                    </form>
                                <?php endif;  ?>

                                <?php if ($term['status'] !== 'finished') :  ?>
                                    <button class="px-4 py-2 bg-gray-300 text-gray-900 rounded-lg font-semibold hover:bg-gray-400 transition text-sm">
                                        Edit
                                    </button>
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