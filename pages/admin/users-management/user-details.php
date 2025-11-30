<?php
$title = 'View Users Profile';
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    $type_table = $type . 's';
    $stmt = $conn->prepare("SELECT * FROM `$type_table` WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        header('Location: ' .  route('back'));
    }
} else {
    header('Location: ' .  route('back'));
}

if ($type === 'student') {
    $stmt = $conn->prepare("SELECT name from classes where id = ?");
    $stmt->bind_param('i', $user['class_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $class = $result->fetch_assoc();
    $user['class'] = $class['name'];

    $stmt = $conn->prepare("SELECT name from class_arms where id = ?");
    $stmt->bind_param('i', $user['arm_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $arm = $result->fetch_assoc();
    $user['arm'] = $arm['name'];

    $stmt = $conn->prepare("SELECT * from guardians where id = ?");
    $stmt->bind_param('i', $user['guardian_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $guardian = $result->fetch_assoc();
    $user['guardian'] = $guardian['name'];
    $user['address'] = $guardian['address'];
} else if ($type === 'guardian') {
    $stmt = $conn->prepare("SELECT students.name, students.admission_number, classes.name as class, class_arms.name as arm from students left join classes on students.class_id = classes.id  left join class_arms on students.arm_id = class_arms.id where guardian_id = ?");
    $stmt->bind_param('i', $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $children = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">User Profile</h1>
            <p class="text-xl text-blue-200">View complete user information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-indigo-900 to-indigo-700 h-32"></div>

                <!-- Profile Content -->
                <div class="px-6 pb-6">
                    <!-- Profile Picture -->
                    <div class="flex flex-col md:flex-row gap-8 -mt-16 mb-8">
                        <div class="flex justify-center md:justify-start">
                            <img id="profilePic" src="/placeholder.svg?height=150&width=150" alt="User Profile" class="w-32 h-32 rounded-full border-4 border-white shadow-lg">
                        </div>

                        <!-- Basic Info -->
                        <div class="flex-1 pt-4">
                            <h2 id="fullName" class="text-3xl font-bold text-gray-900 mb-2"><?= $user['name'] ?? ' Loading...' ?></h2>
                            <p id="userType" class="text-lg text-gray-600 mb-4">
                                <span class="px-4 py-2 bg-indigo-100 text-indigo-900 rounded-full font-semibold"><?= ucwords($type) ?? 'User' ?></span>
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Gender</p>
                                    <p id="createdAt" class="text-lg font-semibold text-gray-900"><?= ucwords($user['gender'])  ?? '-' ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Status</p>
                                    <p id="status" class="text-lg font-semibold text-gray-900"><?= ucwords($user['status']) ?? '-' ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Created</p>
                                    <p id="createdAt" class="text-lg font-semibold text-gray-900"><?= date('D d M, Y', strtotime($user['created_at']))  ?? '-' ?></p>
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
                                    <p id="email" class="text-lg font-semibold text-gray-900"><?= $user['email'] ?? '-' ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Phone Number</p>
                                    <p id="phone" class="text-lg font-semibold text-gray-900"><?= $user['phone'] ?? '-' ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Address</p>
                                    <p id="address" class="text-lg font-semibold text-gray-900"><?= $user['address'] ?? '-' ?></p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Additional Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <?php if ($type === 'student') : ?>
                                        <p class="text-sm text-gray-600">Class</p>
                                        <p id="department" class="text-lg font-semibold text-gray-900"><?= $user['class'] . ' ' . $user['arm'] ?></p>
                                    <?php elseif ($type === 'admin') : ?>
                                        <p class="text-sm text-gray-600">Department/Role/Posistion</p>

                                        <p id="department" class="text-lg font-semibold text-gray-900"><?= $user['department'] ?></p>

                                    <?php elseif ($type === 'guardian') : ?>
                                        <p class="text-sm text-gray-600">Relationship To Student</p>

                                        <p id="department" class="text-lg font-semibold text-gray-900"><?= ucwords($user['relationship']) ?></p>
                                    <?php endif  ?>


                                </div>

                                <div>
                                    <?php if ($type === 'admin') : ?>
                                        <p class="text-sm text-gray-600">Admin Type</p>

                                        <p id="department" class="text-lg font-semibold text-gray-900"><?= ucwords($user['type']) ?></p>

                                    <?php endif  ?>
                                </div>

                                <div>
                                    <?php if ($type !== 'guardian') : ?>
                                        <?php if ($type === 'student') : ?>
                                            <p class="text-sm text-gray-600">Admission Number</p>
                                            <p id="userId" class="text-lg font-semibold text-gray-900"><?= $user['admission_number'] ?></p>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-600">User ID</p>
                                            <p id="userId" class="text-lg font-semibold text-gray-900"><?= $user['staff_no'] ?></p>
                                        <?php endif ?>
                                    <?php endif ?>

                                </div>
                            </div>
                        </div>

                        <?php if ($type === 'admin' || $type === 'teacher') : ?>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Academics Information</h3>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Qualification</p>
                                        <p id="email" class="text-lg font-semibold text-gray-900"><?= $user['qualification'] ?? '-' ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Experience</p>
                                        <p id="phone" class="text-lg font-semibold text-gray-900"><?= $user['experience'] ?? '-' ?></p>
                                    </div>

                                </div>
                            </div>
                        <?php endif ?>

                        <?php if ($type == 'student') : ?>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Guardian Information</h3>
                                <div class="space-y-4">

                                    <div>
                                        <p class="text-sm text-gray-600">Guaridan Name</p>
                                        <p id="email" class="text-lg font-semibold text-gray-900"><?= $guardian['gender'] == 'male' ? 'Mr. ' : 'Mrs. ' ?><?= $guardian['name'] ?? '-' ?></p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-600">Guaridan Relationship</p>
                                        <p id="email" class="text-lg font-semibold text-gray-900"><?= ucwords($guardian['relationship']) ?? '-' ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Guardian Phone Number</p>
                                        <p id="phone" class="text-lg font-semibold text-gray-900"><?= $guardian['phone'] ?? '-' ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Guardian Email</p>
                                        <p id="address" class="text-lg font-semibold text-gray-900"><?= $guardian['email'] ?? '-' ?></p>
                                    </div>

                                    <div>
                                        <p class="text-sm text-gray-600">Guardian Occupation</p>
                                        <p id="address" class="text-lg font-semibold text-gray-900"><?= $guardian['occupation'] ?? '-' ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="py-4">
                        <?php if ($type == 'guardian') : ?>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Childrens Information (<?= count($children) ?>)</h3>
                                <div class="space-y-4">
                                    <div class="overflow-x-auto">
                                        <table class="w-full">
                                            <thead class="bg-gray-100 border-b">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Class</th>
                                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Admission Number</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($children as $child): ?>
                                                    <tr class="border-b hover:bg-gray-50 student-row">
                                                        <td class="px-6 py-4 text-sm text-gray-900"><?= $child['name'] ?></td>
                                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $child['class'] . ' ' . $child['arm'] ?></td>

                                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $child['admission_number'] ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <br> <br>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col md:flex-row gap-4">
                        <a
                            <?php if ($type === 'admin') : ?>
                            href="<?= route('admin-update') ?>?id=<?= $user['id'] ?>"
                            <?php elseif ($type === 'teacher') : ?>
                            href="<?= route('teacher-update') ?>?id=<?= $user['id'] ?>"
                            <?php elseif ($type === 'guardian') : ?>
                            href="<?= route('guardian-update') ?>?id=<?= $user['id'] ?>"
                            <?php elseif ($type === 'student') : ?>
                            href="<?= route('student-update') ?>?id=<?= $user['id'] ?>"
                            <?php endif ?>

                            class="flex flex-1">
                            <button class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                                <i class="fas fa-edit mr-2"></i>Edit User
                            </button>
                        </a>
                        <a
                            href="<?= route('back') ?>"
                            class="flex flex-1">
                            <button class="flex-1 bg-gray-600 text-white py-3 rounded-lg hover:bg-gray-700 transition text-center font-semibold">
                                <i class="fas fa-arrow-left mr-2"></i>Back to List
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../includes/footer.php'); ?>


</body>

</html>