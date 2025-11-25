<?php
$title = "Fees Assignment";
include(__DIR__ . '/../../../includes/header.php');

$stmt = $conn->prepare("SELECT 
        sections.id AS section_id,
        sections.name AS section_name,

        classes.id AS class_id,
        classes.name AS class_name,

        classes.level AS class_level


    FROM sections
    LEFT JOIN classes ON classes.section_id = sections.id

    ORDER BY classes.level ASC
");

$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_all(MYSQLI_ASSOC);


$sections = [];

foreach ($rows as $row) {
    $sectionId = $row['section_id'];

    if (!isset($sections[$sectionId])) {
        $sections[$sectionId] = [
            'section_id' => $row['section_id'],
            'section_name' => $row['section_name'],
            'classes' => []
        ];
    }

    if (!empty($row['class_id'])) {
        $sections[$sectionId]['classes'][] = [
            'class_id' => $row['class_id'],
            'class_name' => $row['class_name']
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    try {
        $feesData = json_decode($_POST['fees'], true);

        foreach ($feesData as $classId => $fee) {
            $stmt = $conn->prepare("SELECT id FROM fees WHERE class_id = ?");
            $stmt->bind_param("i", $classId);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->close();
                $update = $conn->prepare("UPDATE fees 
                    SET first_term=?, second_term=?, third_term=?, uniform=?, transport=?, materials=?, updated_at=NOW()
                    WHERE class_id=?");
                $update->bind_param(
                    "ddddddi",
                    $fee['first_term'],
                    $fee['second_term'],
                    $fee['third_term'],
                    $fee['uniform'],
                    $fee['transport'],
                    $fee['materials'],
                    $classId
                );
                $update->execute();
                $update->close();
            } else {
                $stmt->close();
                $insert = $conn->prepare("INSERT INTO fees 
                    (class_id, first_term, second_term, third_term, uniform, transport, materials) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                $insert->bind_param(
                    "idddddd",
                    $classId,
                    $fee['first_term'],
                    $fee['second_term'],
                    $fee['third_term'],
                    $fee['uniform'],
                    $fee['transport'],
                    $fee['materials']
                );
                $insert->execute();
                $insert->close();
            }
        }

        echo json_encode(["status" => "success"]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }

    exit; // IMPORTANT!!!
}

?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/../includes/admins-section-nav.php") ?>



    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Fees Assignment</h1>
            <p class="text-xl text-orange-100">Assign annual fees for all classes in one place</p>
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


                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Uniform</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Books & Materials</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Transport</th>

                                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-900">Total Annual Fee</th>
                                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-900">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php foreach ($section['classes'] as $class) : ?>
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 font-semibold text-gray-900"><?= $class['class_name'] ?></td>
                                            <td class="px-6 py-4"><input type="number" class="first-term w-24 px-2 py-1 border border-gray-300 rounded focus:outline-none" placeholder="0" data-class="<?= $class['class_name'] ?>" data-class-id="<?= $class['class_id'] ?>"></td>
                                            <td class=" px-6 py-4"><input type="number" class="second-term w-24 px-2 py-1 border border-gray-300 rounded focus:outline-none" placeholder="0" data-class="<?= $class['class_name'] ?>" data-class-id="<?= $class['class_id'] ?>"></td>
                                            <td class="px-6 py-4"><input type="number" class="third-term w-24 px-2 py-1 border border-gray-300 rounded focus:outline-none" placeholder="0" data-class="<?= $class['class_name'] ?>" data-class-id="<?= $class['class_id'] ?>"></td>
                                            <td class="px-6 py-4"><input type="number" class="uniform w-24 px-2 py-1 border border-gray-300 rounded focus:outline-none" placeholder="0" data-class="<?= $class['class_name'] ?>" data-class-id="<?= $class['class_id'] ?>"></td>
                                            <td class="px-6 py-4"><input type="number" class="materials w-24 px-2 py-1 border border-gray-300 rounded focus:outline-none" placeholder="0" data-class="<?= $class['class_name'] ?>" data-class-id="<?= $class['class_id'] ?>"></td>

                                            <td class="px-6 py-4"><input type="number" class="transport w-24 px-2 py-1 border border-gray-300 rounded focus:outline-none" placeholder="0" data-class="<?= $class['class_name'] ?>" data-class-id="<?= $class['class_id'] ?>"></td>
                                            <td class="px-6 py-4 text-right"><span class="total font-bold text-orange-600">₦0</span></td>
                                            <td class="px-6 py-4 text-center"><button onclick="updateRowTotal(this)" class="text-blue-600 hover:text-blue-900"><i class="fas fa-calculator"></i></button></td>
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
                <button onclick="saveAllFees()" class="bg-orange-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                    <i class="fas fa-save mr-2"></i>Save All Fees
                </button>
                <button onclick="resetForm()" class="bg-gray-300 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                    <i class="fas fa-redo mr-2"></i>Reset
                </button>
            </div>
        </div>

        <!-- Loader Modal -->
        <div id="loaderModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg p-6 flex flex-col items-center">
                <div class="loader border-4 border-t-4 border-gray-200 rounded-full w-12 h-12 animate-spin border-t-orange-600"></div>
                <p class="mt-4 text-gray-700 font-semibold">Submitting fees...</p>
            </div>
        </div>

        <!-- Result Modal -->
        <div id="resultModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-lg p-6 text-center">
                <p id="resultMessage" class="text-lg font-semibold"></p>
                <button onclick="closeResultModal()" class="mt-4 bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700">OK</button>
            </div>
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
        function saveAllFees() {
            const fees = {};

            document.querySelectorAll('table tbody tr').forEach(row => {
                const classId = row.querySelector('.first-term').dataset.classId;

                fees[classId] = {
                    first_term: parseFloat(row.querySelector('.first-term').value) || 0,
                    second_term: parseFloat(row.querySelector('.second-term').value) || 0,
                    third_term: parseFloat(row.querySelector('.third-term').value) || 0,
                    uniform: parseFloat(row.querySelector('.uniform').value) || 0,
                    materials: parseFloat(row.querySelector('.materials').value) || 0,
                    transport: parseFloat(row.querySelector('.transport').value) || 0
                };
            });

            document.getElementById('loaderModal').classList.remove('hidden');

            fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'fees=' + encodeURIComponent(JSON.stringify(fees))
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('loaderModal').classList.add('hidden');

                    const resultModal = document.getElementById('resultModal');
                    const resultMessage = document.getElementById('resultMessage');

                    if (data.status === "success") {
                        resultMessage.textContent = "✅ Fees saved successfully!";
                        setTimeout(() => {
                            window.location.href = "fees-list.php";
                        }, 1500);
                    } else {
                        resultMessage.textContent = "❌ Error saving fees.";
                    }

                    resultModal.classList.remove('hidden');
                })
                .catch(err => {
                    console.log("FETCH ERROR:", err);
                    document.getElementById('loaderModal').classList.add('hidden');
                    document.getElementById('resultMessage').textContent = "❌ Network error.";
                    document.getElementById('resultModal').classList.remove('hidden');
                });
        }

        function closeResultModal() {
            document.getElementById('resultModal').classList.add('hidden');
        }



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

        function updateRowTotal(inputElement) {
            // Get the row of the changed input
            const row = inputElement.closest("tr");

            // Get all inputs inside the row
            const inputs = row.querySelectorAll("input[type='number']");

            let total = 0;

            inputs.forEach(input => {
                total += Number(input.value) || 0;
            });

            // Update total in the last column
            const totalCell = row.querySelector(".total");
            totalCell.textContent = "₦" + total.toLocaleString();
        }
    </script>

</body>

</html>