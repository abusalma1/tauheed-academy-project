<?php

$title = 'Update Profile';
include(__DIR__ . '/../../includes/header.php');

if ($is_logged_in === false) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if (isset($_GET['id'])  && isset($_GET['user_type'])) {
    $id = $_GET['id'];
    $user_type = $_GET['user_type'];
    if ($user_type === 'admin') {
        $query = "SELECT id, name, email, phone, address FROM admins WHERE id=?";
    } elseif ($user_type === 'teacher') {
        $query = "SELECT id, name,email, phone, address FROM teachers WHERE id=?";
    } elseif ($user_type === 'guardian') {
        $query = "SELECT id, name, email, phone, address FROM guardians WHERE id=?";
    } elseif ($user_type === 'student') {
        $query = "SELECT id, name, email, phone FROM students WHERE id=?";
    }
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        header('Location: ' .  route('back'));
    }
} else {
    $_SESSION['failure'] = "User and user type are required";
    header('Location: ' .  route('back'));
}

if ($user_type === 'admin') {
    $users = selectAllData('admins', null, $user['id']);
} elseif ($user_type === 'teacher') {
    $users = selectAllData('teachers', null, $user['id']);
} elseif ($user_type === 'guardian') {
    $users = selectAllData('guardians', null, $user['id']);
} elseif ($user_type === 'student') {
    $users = selectAllData('students', null, $user['id']);
}

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



    if ($user_type !==  'student') {
        $address = htmlspecialchars(trim($_POST['address'] ?? ''), ENT_QUOTES, 'UTF-8');

        if (empty($address)) {
            $errors['addressError']  = 'Please enter address';
        }
    }




    if (empty($errors)) {

        if ($user_type === 'admin') {
            $stmt = $conn->prepare("UPDATE admins set name = ?, email = ?, phone = ?, address = ?  where id = ? ");
        } elseif ($user_type === 'teacher') {
            $stmt = $conn->prepare("UPDATE teachers set name = ?, email = ?, phone = ?,  address = ? where id = ? ");
        } elseif ($user_type === 'guardian') {
            $stmt = $conn->prepare("UPDATE guardians set name = ?, email = ?, phone = ?,  address = ? where id = ? ");
        }

        if ($user_type === 'student') {
            $stmt = $conn->prepare("UPDATE students set name = ?, email = ?, phone = ?  where id = ? ");
            $stmt->bind_param('sssi', $name, $email, $phone, $id);
        } else {
            $stmt->bind_param('ssssi', $name, $email, $phone, $address, $id);
        }


        if ($stmt->execute()) {
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: " .  route('back'));
            exit();
        } else {
            echo "<script>alert('Failed to create admin/super user account: " . $stmt->error . "');</script>";
        }
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}

?>
<script>
    const users = <?= json_encode($users, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Your Profile</h1>
            <p class="text-xl text-blue-200">Edit your personal information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Profile Information</h2>

                <form id="updateProfileForm" class="space-y-6" method="post">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="hidden" name="id" value="<?= $user['id'] ?>">


                    <?php include(__DIR__ . '/../../includes/components/success-message.php'); ?>
                    <?php include(__DIR__ . '/../../includes/components/error-message.php'); ?>
                    <?php include(__DIR__ . '/../../includes/components/form-loader.php'); ?>
                    <!-- Full Name -->
                    <div>
                        <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Full Name *</label>
                        <input type="text" id="fullName" name="fullName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter your full name" value="<?= $user['name'] ?>">
                        <span class="text-red-500 text-sm hidden" id="fullNameError"></span>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address *</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter your email" value="<?= $user['email'] ?> ">
                        <span class="text-red-500 text-sm hidden" id="emailError"></span>
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter your phone number" value="<?= $user['phone'] ?>">
                        <span class="text-red-500 text-sm hidden" id="phoneError"></span>
                    </div>

                    <?php if ($user_type !== 'student'): ?>
                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">Address</label>
                            <textarea id="address" name="address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter your address"><?= $user['address'] ?></textarea>
                        </div>
                    <?php endif; ?>
                    <!-- Profile Picture -->
                    <div>
                        <label for="profilePic" class="block text-sm font-semibold text-gray-700 mb-2">Profile Picture</label>
                        <div class="flex items-center gap-4">
                            <img id="profilePreview" src="/placeholder.svg?height=100&width=100" alt="Profile Preview" class="w-24 h-24 rounded-lg border-2 border-gray-300">
                            <input type="file" id="profilePic" name="profilePic" accept="image/*" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                            <i class="fas fa-save mr-2"></i>Update Profile
                        </button>
                        <a href="<?= route('back'); ?> ?>" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>


    <script>
        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function validatePhone(phone) {
            const re = /^\+?234\d{10}$|^\d{11}$/;
            return re.test(phone.replace(/\s/g, ''));
        }

        const updateProfileForm = document.getElementById('updateProfileForm');
        const profilePicInput = document.getElementById('profilePic');
        const profilePreview = document.getElementById('profilePreview');

        profilePicInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    profilePreview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        updateProfileForm.addEventListener('submit', (e) => {
            e.preventDefault();

            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
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

            if (users.some(a => a.email === email)) {
                document.getElementById('emailError').textContent = 'Email already exists';
                document.getElementById('emailError').classList.remove('hidden');
                isValid = false;
            }

            if (!validatePhone(phone)) {
                document.getElementById('phoneError').textContent = 'Please enter a valid phone number';
                document.getElementById('phoneError').classList.remove('hidden');
                isValid = false;

            }

            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                updateProfileForm.submit();
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