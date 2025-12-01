<?php

$title = 'Profile';
include(__DIR__ . '/../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}


?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">My Profile</h1>
            <p class="text-xl text-blue-200">View and manage your personal information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-blue-900 to-blue-700 h-32"></div>

                <!-- Profile Content -->
                <div class="px-6 pb-6">
                    <!-- Profile Picture -->
                    <div class="flex flex-col md:flex-row gap-8 -mt-16 mb-8">
                        <div class="flex justify-center md:justify-start">
                            <img id="profilePic" src="/placeholder.svg?height=150&width=150" alt="Profile Picture" class="w-32 h-32 rounded-full border-4 border-white shadow-lg">
                        </div>

                        <!-- Basic Info -->
                        <div class="flex-1 pt-4">
                            <h2 id="fullName" class="text-3xl font-bold text-gray-900 mb-2"><?= $user['name'] ?></h2>
                            <p id="userType" class="text-lg text-gray-600 mb-4">
                                <span class="px-4 py-2 bg-blue-100 text-blue-900 rounded-full font-semibold"><?= ucwords($user_type) ?></span>
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Status</p>
                                    <p class="text-lg font-semibold text-gray-900"><?= ucwords($user['status']) ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Member Since</p>
                                    <p class="text-lg font-semibold text-gray-900"><?= date('Y', strtotime($user['created_at']))  ?> </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b border-gray-200">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Contact Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-600">Email Address</p>
                                    <p id="email" class="text-lg font-semibold text-gray-900"><?= $user['email'] != '' ? $user['email'] : 'Nill' ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Phone Number</p>
                                    <p id="phone" class="text-lg font-semibold text-gray-900"><?= $user['phone'] != '' ? $user['phone'] : 'Nill' ?></p>
                                </div>
                                <?php if ($user_type !== 'student') : ?>
                                    <div>
                                        <p class="text-sm text-gray-600">Address</p>
                                        <p id="phone" class="text-lg font-semibold text-gray-900"><?= $user['address'] != '' ? $user['address'] : 'Nill' ?></p>
                                    </div>
                                <?php endif ?>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Additional Information</h3>
                            <div class="space-y-4">
                                <?php if ($user_type === "admin" || $user_type === 'student'): ?>
                                    <div>
                                        <p class="text-sm text-gray-600">Class/Department</p>
                                        <p id="classInfo" class="text-lg font-semibold text-gray-900"><?= $user_type === 'student' ? $user['class_name'] . " " . $user['arm_name'] : $user['department'] ?></p>
                                    </div>
                                <?php endif ?>
                                <?php if ($user_type !== "guardian"): ?>

                                    <div>
                                        <p class="text-sm text-gray-600">User ID <?= $user_type === 'student' ? "Admission Number" : " Staff Id" ?></p>
                                        <p id="userId" class="text-lg font-semibold text-gray-900"><?= $user_type === 'student' ? $user['admission_number'] : $user['staff_no'] ?></p>
                                    </div>
                                <?php endif ?>

                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col md:flex-row gap-4">
                        <a href="<?= route('update-profile')  . '?id=' . $user['id'] . '&user_type=' . $user_type ?>" class="flex-1 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition text-center font-semibold">
                            <i class="fas fa-edit mr-2"></i>Update Profile
                        </a>
                        <a href="<?= route('update-profile-password')  . '?id=' . $user['id'] . '&user_type=' . $user_type ?>" class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition text-center font-semibold">
                            <i class="fas fa-lock mr-2"></i>Change Password
                        </a>
                        <a href="<?= route('home') ?>" class="flex-1 bg-gray-600 text-white py-3 rounded-lg hover:bg-gray-700 transition text-center font-semibold">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>
</body>

</html>