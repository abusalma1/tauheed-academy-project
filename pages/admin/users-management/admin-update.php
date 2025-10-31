<?php

$title = "Update Admins & Super Users";
include(__DIR__ . '/../../../includes/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SERVER['HTTP_REFERER'])) {
    $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'];
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $statement = $connection->prepare('SELECT * FROM admins WHERE id=?');
    $statement->bind_param('i', $id);
    $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
    } else {
        header('Location: ' . $_SESSION['previous_page']);
    }
} else {
    header('Location: ' . $_SESSION['previous_page']);
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>  window.addEventListener('DOMContentLoaded', () => showSuccessMessage());
            </script>";
}

$statement = $connection->prepare("SELECT * FROM admins where id != ?");
$statement->bind_param('i', $id);
$statement->execute();
$result = $statement->get_result();
$admins = $result->fetch_all(MYSQLI_ASSOC);

// Count total admins
$adminsCount =  countDataTotal('admins', true);


$name =  $email  = $phone  =  $address = $staffNumber  = $status =  $roleTypeError = $department = '';
$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $name = htmlspecialchars(trim($_POST['fullName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $id = htmlspecialchars(trim($_POST['id'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars(trim($_POST['address'] ?? ''), ENT_QUOTES, 'UTF-8');
    $staffNumber = htmlspecialchars(trim($_POST['staffNumber'] ?? ''), ENT_QUOTES, 'UTF-8');
    $roleType = htmlspecialchars(trim($_POST['roleType'] ?? ''), ENT_QUOTES, 'UTF-8');
    $department = htmlspecialchars(trim($_POST['department'] ?? ''), ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars(trim($_POST['status'] ?? 'inactive'), ENT_QUOTES, 'UTF-8');


    if (empty($name)) {
        $errors['nameError'] = 'Full name is required';
    }

    if (empty($email)) {

        $errors['emailError'] = 'Email is required';
    } else {
        if (!validateEmail($email)) {
            $errors['emailError'] = 'Please enter a valid email address';
        } else {
            if (emailExist($email, 'admins', $id)) {
                $errors['emailError'] = "Email already exists!";
            }
        }
    }

    if (empty($phone)) {
        $errors['phoneError'] =  'Phone number is required';
    }

    if (empty($roleType)) {
        $errors['roleTypeError'] =  'Subject/Department is required';
    }

    if (empty($address)) {
        $errors['addressError']  = 'Please enter address';
    }

    if (empty($staffNumber)) {
        $errors['staffNumberError'] = 'Please insert staff ID number';
    } else {
        if (staffNumberExist($staffNumber, 'admins', $id)) {
            $errors['staffNumberError'] = "Staff No already exists!";
        }
    }

    if (empty($department)) {
        $errors['departmentError'] = 'Qualification is required';
    }

    if (empty($status)) {
        $errors['statusError'] = "Status is required";
    }

    if (empty($errors)) {

        $statement = $connection->prepare("UPDATE admins set name = ?, email = ?, phone = ?, department = ?, address = ?, staff_no = ?, status = ?, type = ? where id = ? ");
        $statement->bind_param('sssssssss', $name, $email, $phone, $department, $address, $staffNumber, $status, $roleType, $id);
        if ($statement->execute()) {
            header("Location: " . $_SESSION['previous_page']);
            exit();
        } else {
            echo "<script>alert('Failed to create admin/super user account: " . $statement->error . "');</script>";
        }
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}
?>


<script>
    const admins = <?= json_encode($admins, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/../includes/admins-section-nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-purple-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Admin Account</h1>
            <p class="text-xl text-purple-200">Edit administrator account information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Admin Information</h2>

                        <form id="updateAdminForm" class="space-y-6" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="id" value="<?= $admin['id'] ?>">




                            <!-- Success Message -->
                            <div id="successMessage" class="hidden mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                <span>User is Updated successfully!</span>
                            </div>


                            <!-- Full Name -->
                            <div>
                                <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="Enter full name" value="<?= $admin['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="fullNameError"></span>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="Enter email address" value="<?= $admin['email'] ?>">
                                <span class="text-red-500 text-sm hidden" id="emailError"></span>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="Enter phone number" value="<?= $admin['phone'] ?>">
                                <span class="text-red-500 text-sm hidden" id="phoneError"></span>
                            </div>

                            <!-- Staff Number -->
                            <div>
                                <label for="staffNumber" class="block text-sm font-semibold text-gray-700 mb-2">Staff ID Number *</label>
                                <input type="tel" id="staffNumber" name="staffNumber" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="Enter staff id number" value="<?= $admin['staff_no'] ?>">
                                <span class="text-red-500 text-sm hidden" id="staffNumberError"></span>
                            </div>

                            <!-- Address -->
                            <div class="mb-6">
                                <label for="address" class="block text-gray-700 font-semibold mb-2">
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <textarea id="address" name="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter staff address"><?= $admin['address'] ?></textarea>
                                <span class="text-red-500 text-sm hidden" id="addressError"></span>
                            </div>

                            <!-- Role Type -->
                            <div>
                                <label for="roleType" class="block text-sm font-semibold text-gray-700 mb-2">Role Type *</label>
                                <select id="roleType" name="roleType" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
                                    <option value="">Select role type</option>
                                    <option value="superAdmin" <?= $admin['type'] === 'superAdmin' ? 'selected' : '' ?>>Super Admin</option>
                                    <option value="admin" <?= $admin['type'] === 'admin' ?  'selected' : '' ?>>Admin</option>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="roleTypeError"></span>
                            </div>

                            <!-- Department -->
                            <div>
                                <label for="department" class="block text-sm font-semibold text-gray-700 mb-2">Department/Area</label>
                                <input type="text" id="department" name="department" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="e.g., Academic, Finance, Operations" value="<?= $admin['department'] ?>">
                                <span class="text-red-500 text-sm hidden" id="departmentError"></span>

                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
                                    <option value="active" <?= $admin['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $admin['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-purple-900 text-white py-3 rounded-lg font-semibold hover:bg-purple-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Admin Account
                                </button>
                                <a href="admin-management.html" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-purple-50 rounded-lg shadow p-6 border-l-4 border-purple-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-purple-900 mr-2"></i>Admin Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span><strong>Super Admin:</strong> Full system access</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span><strong>Admin:</strong> Limited management access</span>
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
        const updateAdminForm = document.getElementById('updateAdminForm');

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^\+?234\d{10}$|^\d{11}$/;
            return re.test(phone.replace(/\s/g, ''));
        }



        updateAdminForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const roleType = document.getElementById('roleType').value;
            const department = document.getElementById('department').value.trim();
            const status = document.getElementById('status').value;
            const address = document.getElementById('address').value;
            const staffNumber = document.getElementById('staffNumber').value;


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

            if (admins.some(a => a.email === email)) {
                document.getElementById('emailError').textContent = 'Email already exists';
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            }


            if (!validatePhone(phone)) {
                document.getElementById('phoneError').textContent = 'Please enter a valid phone number';
                document.getElementById('phoneError').classList.remove('hidden');
                isValid = false;
            }

            if (!roleType) {
                document.getElementById('roleTypeError').textContent = 'Please select a role type';
                document.getElementById('roleTypeError').classList.remove('hidden');
                isValid = false;
            }

            if (!address) {
                document.getElementById('addressError').textContent = 'Please enter address';
                document.getElementById('addressError').classList.remove('hidden');
                isValid = false;
            }
            if (!staffNumber) {
                document.getElementById('staffNumberError').textContent = 'Please insert staff ID number';
                document.getElementById('staffNumberError').classList.remove('hidden');
                isValid = false;
            }

            if (!department) {
                document.getElementById('departmentError').textContent = 'Please enter Department';
                document.getElementById('departmentError').classList.remove('hidden');
                isValid = false;
            }
            if (admins.some(a => a.staff_no === staffNumber)) {
                document.getElementById('staffNumberError').textContent = 'Staff Number already exists';
                document.getElementById('staffNumberError').classList.remove('hidden');
                isValid = false;
            }

            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                updateAdminForm.submit();
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