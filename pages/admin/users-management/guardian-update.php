<?php

$title = 'Update Guardian Account';
include(__DIR__ . '/../../../includes/header.php');


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $statement = $connection->prepare('SELECT * FROM guardians WHERE id=?');
    $statement->bind_param('i', $id);
    $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows > 0) {
        $guardian = $result->fetch_assoc();
    } else {
        header('Location: ' .  route('back'));
    }
} else {
    header('Location: ' .  route('back'));
}

$guardians = selectAllData('guardians', null, $id);


$name = $email = $phone = $address = $occupation = $relationship = $status = $confirmPassword = $password = $hashed_password = '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    }
    echo "<script>alert('hello')</script>";

    $id = htmlspecialchars(trim($_POST['id'] ?? ''), ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars(trim($_POST['fullName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars(trim($_POST['address'] ?? ''), ENT_QUOTES, 'UTF-8');
    $relationship = htmlspecialchars(trim($_POST['relationship'] ?? ''), ENT_QUOTES, 'UTF-8');
    $occupation = htmlspecialchars(trim($_POST['occupation'] ?? ''), ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars(trim($_POST['status'] ?? 'inactive'), ENT_QUOTES, 'UTF-8');

    if (empty($name)) $errors['nameError'] = 'Full name is required';


    if (empty($email)) {
        $errors['emailError'] = 'Email is required ';
    } elseif (!validateEmail($email)) {
        $errors['emailError '] = 'Please enter a valid email address';
    } elseif (emailExist($email, 'guardians', $id)) {
        $errors['emailError'] = "Email already exists!";
    }
    if (empty($phone)) $errors['phoneError'] = 'Phone number is required';
    if (empty($relationship)) $errors['relationshipError'] = 'Relationship is required ';
    if (empty($status)) $errors['statusError'] = "Status is required";

    if (empty($errors)) {
        $statement = $connection->prepare(
            "UPDATE guardians  SET name = ?, email = ? , phone = ? , occupation = ?, address = ?, relationship = ?, status = ? WHERE id = ?"
        );
        $statement->bind_param('sssssssi', $name, $email, $phone, $occupation, $address, $relationship, $status, $id);

        if ($statement->execute()) {
            header("Location: " .  route('back') . "?success=1");
            exit();
        } else {
            echo "<script>
                alert('Failed to create guardian user account: " . $statement->error . "');
            </scrip>";
        }
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}

?>


<script>
    const guardians = <?= json_encode($guardians, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>



<body class="bg-gray-50">
    <?php include(__DIR__ . '/../includes/admins-section-nav.php')  ?>

    <!-- Page Header -->
    <section class="bg-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Guardian Account</h1>
            <p class="text-xl text-green-200">Edit guardian account information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Guardian Information</h2>

                        <form id="updateGuardianForm" class="space-y-6" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="id" value="<?= $guardian['id'] ?>">



                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>



                            <!-- Full Name -->
                            <div>
                                <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter full name" value="<?= $guardian['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="fullNameError"></span>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter email address" value="<?= $guardian['email'] ?>">
                                <span class="text-red-500 text-sm hidden" id="emailError"></span>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter phone number" value="<?= $guardian['phone'] ?>">
                                <span class="text-red-500 text-sm hidden" id="phoneError"></span>
                            </div>

                            <!-- Relationship -->
                            <div>
                                <label for="relationship" class="block text-sm font-semibold text-gray-700 mb-2">Relationship to Student *</label>
                                <select id="relationship" name="relationship" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="">Select relationship</option>
                                    <option value="father" <?= $guardian['relationship'] === 'father' ? 'selected' : '' ?>>Father</option>
                                    <option value="mother" <?= $guardian['relationship'] === 'mother' ? 'selected' : '' ?>>Mother</option>
                                    <option value="guardian" <?= $guardian['relationship'] === 'guardian' ? 'selected' : '' ?>>Guardian</option>
                                    <option value="uncle" <?= $guardian['relationship'] === 'uncle' ? 'selected' : '' ?>>Uncle</option>
                                    <option value="aunt" <?= $guardian['relationship'] === 'aunt' ? 'selected' : '' ?>>Aunt</option>
                                    <option value="grandparent" <?= $guardian['relationship'] === 'grandparent' ? 'selected' : '' ?>>Grandparent</option>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="relationshipError"></span>
                            </div>

                            <!-- Occupation -->
                            <div>
                                <label for="occupation" class="block text-sm font-semibold text-gray-700 mb-2">Occupation *</label>
                                <input type="text" id="occupation" name="occupation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., Engineer, Teacher, Business Owner" value="<?= $guardian['occupation'] ?>">
                                <span class="text-red-500 text-sm hidden" id="occupationError"></span>

                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Address *</label>
                                <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter residential address"><?= $guardian['address'] ?></textarea>
                                <span class="text-red-500 text-sm hidden" id="addressError"></span>

                            </div>


                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="active" <?= $guardian['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $guardian['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-green-900 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Guardian Account
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
                    <div class="bg-green-50 rounded-lg shadow p-6 border-l-4 border-green-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-green-900 mr-2"></i>Guardian Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Specify relationship to student</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Modify the details as needed</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Email must be unique</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Phone format: +234XXXXXXXXXX</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>All fields are required</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>


        </div>
    </section>


    <!-- Footer -->
    <?php include(__DIR__ . '/../../../includes/footer.php'); ?>


    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Form validation and submission
        const updateGuardianForm = document.getElementById('updateGuardianForm');

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^\+?234\d{10}$|^\d{11}$/;
            return re.test(phone.replace(/\s/g, ''));
        }

        updateGuardianForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const relationship = document.getElementById('relationship').value;
            const occupation = document.getElementById('occupation').value.trim();
            const address = document.getElementById('address').value.trim();
            const status = document.getElementById('status').value;
            let isValid = true;

            if (!fullName) {
                document.getElementById('fullNameError').textContent = 'Full name is required';
                document.getElementById('fullNameError').classList.remove('hidden');
                isValid = false;
            }

            if (!validateEmail(email)) {
                document.getElementById('emailError').textContent = 'Please enter a valid email address';
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            }

            if (guardians.some(g => g.email === email)) {
                document.getElementById('emailError').textContent = 'Email already exists';
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            }

            if (!validatePhone(phone)) {
                document.getElementById('phoneError').textContent = 'Please enter a valid phone number';
                document.getElementById('phoneError').classList.remove('hidden');
                isValid = false;
            }

            if (!relationship) {
                document.getElementById('relationshipError').textContent = 'Please select a relationship';
                document.getElementById('relationshipError').classList.remove('hidden');
                isValid = false;
            }

            if (!occupation) {
                document.getElementById('occupationError').textContent = 'Please enter occupation';
                document.getElementById('occupationError').classList.remove('hidden');
                isValid = false;
            }

            if (!address) {
                document.getElementById('addressError').textContent = 'Please enter address';
                document.getElementById('addressError').classList.remove('hidden');
                isValid = false;
            }

            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                updateGuardianForm.submit();
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