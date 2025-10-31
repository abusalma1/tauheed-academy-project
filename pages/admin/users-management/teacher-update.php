<?php
$title = "Create Teacher Account";
include(__DIR__ . '/../../../includes/header.php');


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>  window.addEventListener('DOMContentLoaded', () => showSuccessMessage());
            </script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SERVER['HTTP_REFERER'])) {
    $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'];
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $statement = $connection->prepare('SELECT * FROM teachers WHERE id=?');
    $statement->bind_param('i', $id);
    $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows > 0) {
        $teacher = $result->fetch_assoc();
    } else {
        header('Location: ' . $_SESSION['previous_page']);
    }
} else {
    header('Location: ' . $_SESSION['previous_page']);
}

// Count total teachers
$teachersCount =  countDataTotal('teachers', true);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (
        !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }


    $id = htmlspecialchars(trim($_POST['id'] ?? ''), ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars(trim($_POST['fullName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars(trim($_POST['address'] ?? ''), ENT_QUOTES, 'UTF-8');
    $staffNumber = htmlspecialchars(trim($_POST['staffNumber'] ?? ''), ENT_QUOTES, 'UTF-8');
    $qualification = htmlspecialchars(trim($_POST['qualification'] ?? ''), ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''), ENT_QUOTES, 'UTF-8');
    $password = trim($_POST['password'] ?? '');
    $confirmPassword = trim($_POST['confirmPassword'] ?? '');
    $status = htmlspecialchars(trim($_POST['status'] ?? 'inactive'), ENT_QUOTES, 'UTF-8');

    // validations...
    if (empty($name)) $errors['nameError'] = 'Full name is required';
    if (empty($email)) {
        $errors['emailError'] = 'Email is required';
    } elseif (!validateEmail($email)) {
        $errors['emailError'] = 'Invalid email format';
    } elseif (emailExist($email, 'teachers')) {
        $errors['emailError'] = 'Email already exists';
    }

    if (empty($phone)) $errors['phoneError'] = 'Phone number is required';
    if (empty($subject)) $errors['subjectError'] = 'Subject/Department is required';
    if (empty($address)) $errors['addressError'] = 'Address is required';
    if (empty($staffNumber)) {
        $errors['staffNumberError'] = 'Staff number is required';
    } elseif (staffNumberExist($staffNumber, 'teachers')) {
        $errors['staffNumberError'] = 'Staff No already exists';
    }
    if (empty($qualification)) $errors['qualificationError'] = 'Qualification is required';
    if (empty($password)) {
        $errors['passwordError'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['passwordError'] = 'Password must be at least 8 characters';
    } elseif ($password !== $confirmPassword) {
        $errors['confirmPasswordError'] = 'Passwords do not match';
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    if (empty($errors)) {
        $statement = $connection->prepare("INSERT teachers set name = ?, email = ?, phone = ?, address = ?, staff_no = ?, qualification = ?,  status = ?, where id = ?
        ");
        $statement->bind_param('sssssssi', $name, $email, $phone, $address, $staffNumber, $qualification, $status, $id);

        if ($statement->execute()) {
            header("Location: " . $_SESSION['previous_page'] . "?success=1");
            exit();
        } else {
            echo "<script>alert('Database error: " . $statement->error . "');</script>";
        }
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}

?>
<script>
    const teachers = <?= json_encode($teachers, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php')    ?>


    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Teacher Account</h1>
            <p class="text-xl text-blue-200">Edit teacher account information</p>
        </div>
    </section>


    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Teacher Information</h2>

                        <form id="updateTeacherForm" class="space-y-6" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="id" value="<?= $teacher['id'] ?>">


                            <!-- Error Message -->
                            <div id="errorMessage" class="hidden mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
                                <i class="fas fa-check-circle"></i>
                                <span>Check the form & make sure all requirments are satisfied</span>
                            </div>

                            <!-- Full Name -->
                            <div>
                                <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter full name" value="<?= $teacher['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="fullNameError"></span>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter email address" value="<?= $teacher['email'] ?>">
                                <span class=" text-red-500 text-sm hidden" id="emailError"></span>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter phone number" value="<?= $teacher['phone'] ?>">
                                <span class=" text-red-500 text-sm hidden" id="phoneError"></span>
                            </div>

                            <!-- Qualification -->
                            <div>
                                <label for="qualification" class="block text-sm font-semibold text-gray-700 mb-2">Qualification *</label>
                                <input type="text" id="qualification" name="qualification" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="e.g., B.Sc Education, M.A" value="<?= $teacher['qualification'] ?>">
                                <span class=" text-red-500 text-sm hidden" id="qualificationError"></span>
                            </div>

                            <!-- Staff Number -->
                            <div>
                                <label for="staffNumber" class="block text-sm font-semibold text-gray-700 mb-2">Staff ID Number *</label>
                                <input type="tel" id="staffNumber" name="staffNumber" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="Enter staff id number" value="<?= $teacher['staff_no'] ?>">
                                <span class="text-red-500 text-sm hidden" id="staffNumberError"></span>
                            </div>

                            <!-- Address -->
                            <div class="mb-6">
                                <label for="address" class="block text-gray-700 font-semibold mb-2">
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <textarea id="address" name="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter staff address"><?= $teacher['address'] ?></textarea>
                                <span class="text-red-500 text-sm hidden" id="addressError"></span>
                            </div>



                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Account Status</label>
                                <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                                    <option value="active" <?= $teacher['status'] === 'active' ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?= $teacher['status'] === 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" name="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Teacher Account
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
                                <span>Modify the details as needed</span>
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

        // Error Message
        function showErrorMessage() {
            const message = document.getElementById("errorMessage");
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


        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^\+?234\d{10}$|^\d{11}$/;
            return re.test(phone.replace(/\s/g, ''));
        }

        // Form validation and submission
        const updateTeacherForm = document.getElementById('updateTeacherForm');
        updateTeacherForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const qualification = document.getElementById('qualification').value.trim();
            const address = document.getElementById('address').value.trim();
            const staffNumber = document.getElementById('staffNumber').value;
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

            if (teachers.some(t => t.email === email)) {
                document.getElementById('emailError').textContent = 'Email already exists';
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            }

            if (!staffNumber) {
                document.getElementById('staffNumberError').textContent = 'Please insert staff ID number';
                document.getElementById('staffNumberError').classList.remove('hidden');
                isValid = false;
            }

            if (teachers.some(t => t.staff_no === staffNumber)) {
                document.getElementById('staffNumberError').textContent = 'Staff Number already exists';
                document.getElementById('staffNumberError').classList.remove('hidden');
                isValid = false;
            }


            if (!validatePhone(phone)) {
                document.getElementById('phoneError').textContent = 'Please enter a valid phone number';
                document.getElementById('phoneError').classList.remove('hidden');
                isValid = false;
            }


            if (!address) {
                document.getElementById('addressError').textContent = 'Please enter address';
                document.getElementById('addressError').classList.remove('hidden');
                isValid = false;
            }

            if (!qualification) {
                document.getElementById('qualificationError').textContent = 'Qualification is required';
                document.getElementById('qualificationError').classList.remove('hidden');
                isValid = false;
            }


            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                updateTeacherForm.submit();
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showErrorMessage()
            }
        });
    </script>
</body>

</html>