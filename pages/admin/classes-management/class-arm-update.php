<?php

$title = "Classe Update Form";
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare('SELECT * FROM class_arms WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $arm = $result->fetch_assoc();
    }
} else {
    header('Location: ' .  route('back'));
}

$stmt = $conn->prepare("SELECT * FROM class_arms WHERE id != ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$class_arms = $result->fetch_all(MYSQLI_ASSOC);

$armsCount = countDataTotal('class_arms')['total'];


$name = $description = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $name = htmlspecialchars(trim($_POST['armName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $id = htmlspecialchars(trim($_POST['armId'] ?? ''), ENT_QUOTES, 'UTF-8');
    $description = filter_var(trim($_POST['armDescription'] ?? ''), ENT_QUOTES);


    if (empty($name)) {
        $errors['nameError'] = "Name is required";
    }


    if (empty($errors)) {
        $stmt = $conn->prepare(
            "UPDATE class_arms SET name = ?, description = ? WHERE id = ? "
        );
        $stmt->bind_param('ssi', $name, $description, $id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Arm Updated successfully!";
            header("Location: " .  route('back'));
            exit();
        } else {
            echo "<script>alert('Failed to create class arm : " . $stmt->error . "');</script>";
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
    <?php include(__DIR__ . '/../includes/admins-section-nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-indigo-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Class Arm</h1>
            <p class="text-xl text-indigo-200">Edit class arm information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Update Arm Details</h2>
                        <form id="updateArmForm" class="space-y-6" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="armId" value="<?= htmlspecialchars($arm['id']); ?>">


                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>


                            <!-- Arm Name -->
                            <div>
                                <label for="armName" class="block text-sm font-semibold text-gray-700 mb-2">Arm Name/Code *</label>
                                <input type="text" id="armName" name="armName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900" placeholder="e.g., A, B, C or Gold, Silver, Diamond or Orange, Blue, Red" value="<?= $arm['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="armNameError"></span>
                            </div>

                            <!-- Arm Description -->
                            <div>
                                <label for="armDescription" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea id="armDescription" name="armDescription" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-900" placeholder="Optional: Describe this arm (e.g., Science stream, Arts stream)"><?= $arm['description'] ?></textarea>
                            </div>


                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-indigo-900 text-white py-3 rounded-lg font-semibold hover:bg-indigo-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Arm
                                </button>
                                <a href="<?= route('back') ?>" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-indigo-50 rounded-lg shadow p-6 border-l-4 border-indigo-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-indigo-900 mr-2"></i>Update Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">

                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span>Modify the details as needed</span>
                            </li>


                            <li class="flex gap-2">
                                <i class="fas fa-check text-indigo-600 mt-1"></i>
                                <span>Click Update to save changes</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../includes/footer.php');  ?>


    <script>
        const updateArmForm = document.getElementById('updateArmForm');

        updateArmForm.addEventListener('submit', (e) => {
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
                updateArmForm.submit();
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