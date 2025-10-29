<?php

$title = 'Guardians Management';
include(__DIR__ . '/../../../includes/header.php');


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>  window.addEventListener('DOMContentLoaded', () => showSuccessMessage());
            </script>";
}

$statement = $connection->prepare("SELECT * FROM guardians");
$statement->execute();
$result = $statement->get_result();
$guardians = $result->fetch_all(MYSQLI_ASSOC);


// Count total guardians
$guardiansCount =  countDataTotal('guardians', true);


$name =  $email  = $phone  =  $address = $occupation  = $relationship = $status  = $confirmPassword = $password = $hashed_password = '';
$nameError =  $emailError  = $phoneError  =  $addressError = $occupationError  = $statusError  = $relationshipError =  $roleTypeError = $passwordError = $confirmPasswordError = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $name = htmlspecialchars(trim($_POST['fullName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars(trim($_POST['address'] ?? ''), ENT_QUOTES, 'UTF-8');
    $relationship = htmlspecialchars(trim($_POST['relationship'] ?? ''), ENT_QUOTES, 'UTF-8');
    $occupation = htmlspecialchars(trim($_POST['occupation'] ?? ''), ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars(trim($_POST['password'] ?? ''), ENT_QUOTES, 'UTF-8');
    $confirmPassword = htmlspecialchars(trim($_POST['confirmPassword'] ?? ''), ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars(trim($_POST['status'] ?? 'inactive'), ENT_QUOTES, 'UTF-8');

    if (empty($name)) $nameError = 'Full name is required';

    if (empty($email)) {
        $emailError = 'Email is required';
    } elseif (!validateEmail($email)) {
        $emailError = 'Please enter a valid email address';
    } elseif (emailExist($connection, $email, 'guardians')) {
        $emailError = "Email already exists!";
    }

    if (empty($phone)) $phoneError = 'Phone number is required';
    if (empty($relationship)) $relationshipError = 'Relationship is required';

    if (empty($password)) {
        $passwordError = "Password field is required";
    } elseif (strlen($password) < 8) {
        $passwordError = 'Password must be at least 8 characters';
    } elseif ($password !== $confirmPassword) {
        $confirmPasswordError = 'Passwords do not match';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    if (empty($status)) $statusError = "Status is required";

    if (
        empty($nameError) && empty($emailError) && empty($phoneError) && empty($relationshipError)
        && empty($passwordError) && empty($confirmPasswordError) && empty($statusError)
    ) {
        $statement = $connection->prepare(
            "INSERT INTO guardians (name, email, phone, occupation, address, relationship, status, password)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $statement->bind_param('ssssssss', $name, $email, $phone, $occupation, $address, $relationship, $status, $hashed_password);

        if ($statement->execute()) {
            header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
            exit();
        } else {
            echo "<script>alert('Failed to create guardian user account: " . $statement->error . "');</script>";
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
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Guardian Management</h1>
            <p class="text-xl text-green-200">Create and manage guardian/parent accounts</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Create New Guardian Account</h2>

                        <form id="guardianForm" class="space-y-6" method="post">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">


                            <!-- Success Message -->
                            <div id="successMessage" class="hidden mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                <span>User is created successfully!</span>
                            </div>


                            <!-- Full Name -->
                            <div>
                                <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter full name">
                                <span class="text-red-500 text-sm hidden" id="fullNameError"></span>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter email address">
                                <span class="text-red-500 text-sm hidden" id="emailError"></span>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter phone number">
                                <span class="text-red-500 text-sm hidden" id="phoneError"></span>
                            </div>

                            <!-- Relationship -->
                            <div>
                                <label for="relationship" class="block text-sm font-semibold text-gray-700 mb-2">Relationship to Student *</label>
                                <select id="relationship" name="relationship" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="">Select relationship</option>
                                    <option value="father">Father</option>
                                    <option value="mother">Mother</option>
                                    <option value="guardian">Guardian</option>
                                    <option value="uncle">Uncle</option>
                                    <option value="aunt">Aunt</option>
                                    <option value="grandparent">Grandparent</option>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="relationshipError"></span>
                            </div>

                            <!-- Occupation -->
                            <div>
                                <label for="occupation" class="block text-sm font-semibold text-gray-700 mb-2">Occupation *</label>
                                <input type="text" id="occupation" name="occupation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="e.g., Engineer, Teacher, Business Owner">
                                <span class="text-red-500 text-sm hidden" id="occupationError"></span>

                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Address *</label>
                                <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter residential address"></textarea>
                                <span class="text-red-500 text-sm hidden" id="addressError"></span>

                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Enter password">
                                    <button type="button" id="togglePassword" class="absolute right-3 top-2.5 text-gray-600">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div id="passwordStrength" class="mt-2 space-y-1">
                                    <div class="flex gap-1">
                                        <div id="strength1" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                                        <div id="strength2" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                                        <div id="strength3" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                                        <div id="strength4" class="h-1 w-1/4 bg-gray-300 rounded"></div>
                                    </div>
                                    <p id="strengthText" class="text-xs text-gray-600">Password strength: Weak</p>
                                </div>
                                <span class="text-red-500 text-sm hidden" id="passwordError"></span>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="confirmPassword" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password *</label>
                                <input type="password" id="confirmPassword" name="confirmPassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900" placeholder="Confirm password">
                                <span class="text-red-500 text-sm hidden" id="confirmPasswordError"></span>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-green-900 text-white py-3 rounded-lg font-semibold hover:bg-green-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Create
                                </button>
                                <button type="reset" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                                    Clear
                                </button>
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
                                <span>Password must be 8+ characters</span>
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

                    <!-- Statistics -->
                    <div class="mt-6 bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Guardian Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Total Guardians</span>
                                <span class="text-2xl font-bold text-green-900" id="totalGuardians"><?= $guardiansCount['total'] ?></span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Active</span>
                                <span class="text-2xl font-bold text-green-600" id="activeGuardians"><?= $guardiansCount['active'] ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Inactive</span>
                                <span class="text-2xl font-bold text-red-600" id="inactiveGuardians"><?= $guardiansCount['inactive'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guardians Table -->
            <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">Guardian Accounts</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-green-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Phone</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Relationship</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="guardiansTableBody" class="divide-y divide-gray-200">

                            <?php if (count($guardians) > 0) : ?>
                                <?php foreach ($guardians as $key => $guardian) : ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-900"><?= $guardian['name'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $guardian['email'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $guardian['phone'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600 capitalize"><?= $guardian['relationship'] ?></td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-3 py-1  <?= $guardian['status'] === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900' ?> rounded-full text-xs font-semibold capitalize"><?= $guardian['status'] ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 font-semibold">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>

                            <?php else : ?>
                                <tr class="text-center py-8">
                                    <td colspan="6" class="px-6 py-8 text-gray-500">No guardian accounts created yet</td>
                                </tr>

                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../../../includes/footer.php'); ?>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Success Message
        function showSuccessMessage() {
            const message = document.getElementById("successMessage");
            if (message) {
                message.classList.remove("hidden"); // show the message
                message.classList.add("flex"); // ensure it displays properly

                // Hide it after 5 seconds
                setTimeout(() => {
                    message.classList.add("hidden");
                    message.classList.remove("flex");
                }, 5000);
            }
        }



        // Password visibility toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePassword.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });

        // Password strength checker
        const passwordField = document.getElementById('password');
        passwordField.addEventListener('input', () => {
            const password = passwordField.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            const strengthLevels = ['Weak', 'Fair', 'Good', 'Strong', 'Very Strong'];
            const strengthColors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-green-500', 'bg-green-600'];

            for (let i = 1; i <= 4; i++) {
                const element = document.getElementById(`strength${i}`);
                if (i <= strength) {
                    element.className = `h-1 w-1/4 ${strengthColors[strength - 1]} rounded`;
                } else {
                    element.className = 'h-1 w-1/4 bg-gray-300 rounded';
                }
            }

            document.getElementById('strengthText').textContent = `Password strength: ${strengthLevels[strength - 1] || 'Weak'}`;
        });

        // Form validation and submission
        const guardianForm = document.getElementById('guardianForm');


        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^\+?234\d{10}$|^\d{11}$/;
            return re.test(phone.replace(/\s/g, ''));
        }


        guardianForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const relationship = document.getElementById('relationship').value;
            const occupation = document.getElementById('occupation').value.trim();
            const address = document.getElementById('address').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
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

            if (password.length < 8) {
                document.getElementById('passwordError').textContent = 'Password must be at least 8 characters';
                document.getElementById('passwordError').classList.remove('hidden');
                isValid = false;
            }

            if (password !== confirmPassword) {
                document.getElementById('confirmPasswordError').textContent = 'Passwords do not match';
                document.getElementById('confirmPasswordError').classList.remove('hidden');
                isValid = false;
            }

            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                guardianForm.submit();
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    </script>
</body>

</html>