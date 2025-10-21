<?php


$title = "Teachers Users Managment";
include(__DIR__ . '/../../includes/header.php');


$statement = $connection->prepare("SELECT * FROM teachers");
$statement->execute();
$result = $statement->get_result();
$teachers = $result->fetch_all(MYSQLI_ASSOC);


// Count total admins
$totalQuery = $connection->query("SELECT COUNT(*) AS total FROM teachers");
$total = $totalQuery->fetch_assoc()['total'];

// Count active admins
$activeQuery = $connection->query("SELECT COUNT(*) AS active FROM teachers WHERE status = 'active'");
$active = $activeQuery->fetch_assoc()['active'];

// Count inactive admins
$inactiveQuery = $connection->query("SELECT COUNT(*) AS inactive FROM teachers WHERE status = 'inactive'");
$inactive = $inactiveQuery->fetch_assoc()['inactive'];

$name =  $email  = $phone  = $subject =  $address = $staffNumber  = $status  = $qualification =  $subject = $hashed_password = '';
$nameError =  $emailError  = $phoneError  = $subjectError =  $addressError = $staffNumberError  = $statusError  = $qualificationError =  $subjectError = $passwordError = $confirmPasswordError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['fullName'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $staffNumber = $_POST['staffNumber'] ?? '';
    $qualification = $_POST['staffNumber'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';
    $status = $_POST['status'] ?? 'inactive';



    if (empty($name)) {
        $nameError = 'Full name is required';
        $name = '';
    }

    if (empty($email)) {
        $emailError = 'Email is required';
        $email = '';
    } else {
        if (!validateEmail($email)) {
            $emailError = 'Please enter a valid email address';
            $email = '';
        } else {
            if (emailExist($connection, $email, 'teachers')) {
                $emailError = "Email already exists!";
                $email = '';
            }
        }
    }


    if (empty($phone)) {
        $phoneError =  'Phone nnumber is required';
        $phone = '';
    }

    if (empty($subject)) {
        $subjectError =  'Subject/Department is required';
        $subject = '';
    }

    if (empty($address)) {
        $addressError = 'Please enter address';
        $address = '';
    }

    if (empty($staffNumber)) {
        $staffNumberError = 'Please insert staff ID number';
        $staffNumber = '';
    } else {
        if (staffNumberExist($connection, $staffNumber, 'teachers')) {
            $staffNumberError = "Staff No already exists!";
            $staffNumber = '';
        }
    }

    if (empty($qualification)) {
        $qualificationError = 'Qualification is required';
        $qualification = '';
    }

    if (empty($password)) {
        $passwordError = "Password field is required";
        $password = '';
    } else {
        if (strlen($password) < 8) {
            $passwordError = 'Password must be at least 8 characters';
            $password = '';
        } else {
            if ($password !== $confirmPassword) {
                $confirmPasswordError = 'Passwords do not match';
                $confirmPassword = '';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            }
        }
    }


    if (empty($status)) {
        $statusError = "Status is required";
    }

    if ($name && $email && $phone && $subject && $address && $staffNumber && $status && $qualification && $subject && $hashed_password) {
        $statement = $connection->prepare("INSERT INTO teachers (name, email, phone, address, staff_no, status, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $statement->bind_param('sssssss', $name, $email, $phone, $address, $staffNumber, $status, $hashed_password);

        if ($statement->execute()) {
            echo "<script>  window.addEventListener('DOMContentLoaded', () => showSuccessMessage());
            </script>";


            $statement = $connection->prepare("SELECT * FROM teachers");
            $statement->execute();
            $result = $statement->get_result();
            $teachers = $result->fetch_all(MYSQLI_ASSOC);

            // Count total admins
            $totalQuery = $connection->query("SELECT COUNT(*) AS total FROM teachers");
            $total = $totalQuery->fetch_assoc()['total'];

            // Count active admins
            $activeQuery = $connection->query("SELECT COUNT(*) AS active FROM teachers WHERE status = 'active'");
            $active = $activeQuery->fetch_assoc()['active'];

            // Count inactive admins
            $inactiveQuery = $connection->query("SELECT COUNT(*) AS inactive FROM teachers WHERE status = 'inactive'");
            $inactive = $inactiveQuery->fetch_assoc()['inactive'];
        } else {
            header('Location: ' . route('teachers-management'));
            echo "<script>alert('Failed to create teacher account: " . $statement->error . "');</script>";
        }
    }
}


?>

<script>
    const teachers = <?= json_encode($teachers, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/./includes/users-management-nav.php')  ?>


    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Teacher Management</h1>
            <p class="text-xl text-blue-200">Create and manage teacher accounts</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Create New Teacher Account</h2>

                        <form id="teacherForm" class="space-y-6" method="post">

                            <!-- Success Message -->
                            <div id="successMessage" class="hidden mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                <span>User is created successfully!</span>
                            </div>


                            <!-- Full Name -->
                            <div>
                                <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter full name" value="<?= $name ?? '' ?>">
                                <span class="text-red-500 text-sm <?= empty($nameError) ? "hidden" : '' ?>" id=" fullNameError"><?= $nameError ?></span>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter email address" <?= $email ?? '' ?>>
                                <span class="text-red-500 text-sm <?= empty($emailError) ? "hidden" : '' ?>" id="emailError"><?= $emailError ?></span>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter phone number" value="<?= $phone ?? '' ?>">
                                <span class="text-red-500 text-sm <?= empty($phoneError) ? "hidden" : '' ?>" id="phoneError"><?= $phoneError ?></span>
                            </div>

                            <!-- Address -->
                            <div class="mb-6">
                                <label for="address" class="block text-gray-700 font-semibold mb-2">
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <textarea id="address" name="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter staff address"><?= $address ?? ''  ?></textarea>
                                <span class="text-red-500 text-sm <?= empty($addressError) ? "hidden" : '' ?>" id="addressError"><?= $addressError ?></span>
                            </div>


                            <!-- Subject/Department -->
                            <div>
                                <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subject/Department *</label>
                                <input type="text" id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="e.g., Mathematics, English, Science" value="<?= $subject ?? '' ?>">
                                <span class="text-red-500 text-sm <?= empty($subjectError) ? "hidden" : '' ?>" id="subjectError"><?= $subjectError ?></span>
                            </div>

                            <!-- Qualification -->
                            <div>
                                <label for="qualification" class="block text-sm font-semibold text-gray-700 mb-2">Qualification *</label>
                                <input type="text" id="qualification" name="qualification" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="e.g., B.Sc Education, M.A" value="<?= $qualification ?? '' ?>">
                                <span class="text-red-500 text-sm <?= empty($qualificationError) ? "hidden" : '' ?>" id="qualificationError"><?= $qualificationError ?></span>
                            </div>

                            <!-- Staff Number -->
                            <div>
                                <label for="staffNumber" class="block text-sm font-semibold text-gray-700 mb-2">Staff ID Number *</label>
                                <input type="tel" id="staffNumber" name="staffNumber" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="Enter staff id number" value="<?= $staffNumber ?? '' ?>">
                                <span class="text-red-500 text-sm <?= empty($staffNumberError) ? "hidden" : '' ?>" id="staffNumberError"><?= $staffNumberError ?></span>
                            </div>


                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password *</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter password">
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
                                <span class="text-red-500 text-sm <?= empty($passwordError) ? "hidden" : '' ?>" id="passwordError"><?= $passwordError ?></span>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="confirmPassword" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password *</label>
                                <input type="password" id="confirmPassword" name="confirmPassword" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Confirm password">
                                <span class="text-red-500 text-sm <?= empty($confirmPasswordError) ? "hidden" : '' ?>" id="confirmPasswordError"><?= $confirmPasswordError ?></span>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" name="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Create Teacher Account
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
                    <div class="bg-blue-50 rounded-lg shadow p-6 border-l-4 border-blue-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-blue-900 mr-2"></i>Teacher Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Provide valid teaching qualification</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Subject field is mandatory</span>
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
                                <span>Experience field is optional</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Statistics -->
                    <div class="mt-6 bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Teacher Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Total Teachers</span>
                                <span class="text-2xl font-bold text-blue-900" id="totalTeachers"><?= $total ?></span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Active</span>
                                <span class="text-2xl font-bold text-green-600" id="activeTeachers"><?= $active ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Inactive</span>
                                <span class="text-2xl font-bold text-red-600" id="inactiveTeachers"><?= $inactive ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Teachers Table -->
            <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">Teacher Accounts</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-blue-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">staff No.</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Qualification</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="teachersTableBody" class="divide-y divide-gray-200">
                            <?php if ($total > 0): ?>
                                <?php foreach ($teachers as $teacher): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-900"><?= $teacher['name'] ?? '' ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $teacher['email'] ?? '' ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $teacher['staff_no'] ?? '' ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $teacher['Qualifications'] ?? '' ?></td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-3 py-1 <?= $teacher['status'] === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900' ?> rounded-full text-xs font-semibold capitalize"><?= $teacher['status'] ?></span>
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
                                    <td colspan="6" class="px-6 py-8 text-gray-500">No teacher accounts created yet</td>
                                </tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../../includes/footer.php'); ?>


    <script>
        //  Mobile Menu Script
        const mobileMenuBtn = document.getElementById("mobile-menu-btn");
        const mobileMenu = document.getElementById("mobile-menu");

        mobileMenuBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
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
    </script>
</body>

</html>