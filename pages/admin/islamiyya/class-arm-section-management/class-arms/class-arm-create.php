<?php

$title = "Create Islamiyya Class Arm";
include(__DIR__ . '/../../../../../includes/header.php');

// Access control: only logged-in admins allowed
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

// CSRF token setup
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch latest Islamiyya class arms (only active ones)
$stmt = $pdo->prepare("
    SELECT * 
    FROM islamiyya_class_arms 
    ORDER BY updated_at DESC 
    LIMIT 10
");
$stmt->execute();
$class_arms_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$class_arms   = selectAllData('islamiyya_class_arms');
$armsCount    = countDataTotal('islamiyya_class_arms')['total'];

$name = $description = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $name        = htmlspecialchars(trim($_POST['armName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars(trim($_POST['armDescription'] ?? ''), ENT_QUOTES, 'UTF-8');

    if (empty($name)) {
        $errors['nameError'] = "Name is required";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO islamiyya_class_arms (name, description) VALUES (?, ?)");
        $success = $stmt->execute([$name, $description]);

        if ($success) {
            $_SESSION['success'] = "Islamiyya Class Arm created successfully!";
            header("Location: " . route('back'));
            exit();
        } else {
            echo "<script>alert('Failed to create Islamiyya class arm');</script>";
        }
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}
?>


<script>
    const class_arms = <?= json_encode($class_arms, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../../includes/admins-section-nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-indigo-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Create Isamiyya Class Arm</h1>
            <p class="text-xl text-indigo-200">Customize and manage class divisions/arms for your Islamiyya section</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Add New Class Arm</h2>

                        <form id="armForm" class="space-y-6" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                            <?php include(__DIR__ . '/../../../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../../../includes/components/form-loader.php'); ?>


                            <!-- Arm Name -->
                            <div>
                                <label for="armName" class="block text-sm font-semibold text-gray-700 mb-2">Arm Name/Code *</label>
                                <input type="text" id="armName" name="armName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900" placeholder="e.g., A, B, C or Gold, Silver, Diamond or Orange, Blue, Red">
                                <span class="text-red-500 text-sm hidden" id="armNameError"></span>
                            </div>

                            <!-- Arm Description -->
                            <div>
                                <label for="armDescription" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea id="armDescription" name="armDescription" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900" placeholder="Optional: Describe this arm (e.g., Science stream, Arts stream)"></textarea>
                            </div>


                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-indigo-900 text-white py-3 rounded-lg font-semibold hover:bg-indigo-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Add Arm
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
                    <div class="bg-indigo-50 rounded-lg shadow p-6 border-l-4 border-indigo-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-indigo-900 mr-2"></i>Arm Examples
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span><strong>Alphabetic:</strong> A, B, C, D</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span><strong>Precious Metals:</strong> Gold, Silver, Bronze</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span><strong>Colors:</strong> Red, Blue, Green, Yellow</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span><strong>Streams:</strong> Science, Arts, Commerce</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span><strong>Numbers:</strong> 1, 2, 3, 4</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Statistics -->
                    <div class="mt-6 bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Arm Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Total Arms</span>
                                <span class="text-2xl font-bold text-indigo-900" id="totalArms"><?= $armsCount ?></span>
                            </div>
                            <!-- <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Active</span>
                                <span class="text-2xl font-bold text-indigo-600" id="activeArms">0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Capacity</span>
                                <span class="text-2xl font-bold text-blue-600" id="totalCapacity">0</span>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Arms Table -->
            <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">All Class Arms</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-indigo-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Arm Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Description</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="armsTableBody" class="divide-y divide-gray-200">
                            <?php if (count($class_arms_list) > 0) : ?>
                                <?php foreach ($class_arms_list as $arm) : ?>

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900"><?= $arm['name'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $arm['description']  ?></td>

                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <a href="<?= route('update-islamiyya-class-arm') ?>?id=<?= $arm['id'] ?>">
                                                <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            </a>
                                            <a href="<?= route('delete-islamiyya-class-arm') ?>?id=<?= $arm['id'] ?>">
                                                <button class="text-red-600 hover:text-red-900 font-semibold">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>

                                <tr class="text-center py-8">
                                    <td colspan="6" class="px-6 py-8 text-gray-500">No arms created yet</td>
                                </tr>
                            <?php endif ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../../../includes/footer.php') ?>

    <script>
        // Form validation and submission
        const armForm = document.getElementById('armForm');



        armForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const armName = document.getElementById('armName').value.trim();
            const armDescription = document.getElementById('armDescription').value.trim();


            let isValid = true;

            if (!armName) {
                document.getElementById('armNameError').textContent = 'Arm name is required';
                document.getElementById('armNameError').classList.remove('hidden');
                isValid = false;
            }

            if (class_arms.some(a => a.name.toLowerCase() === armName.toLowerCase())) {
                document.getElementById('armNameError').textContent = 'Arm name already exists';
                document.getElementById('armNameError').classList.remove('hidden');
                isValid = false;
            }


            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                armForm.submit();

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