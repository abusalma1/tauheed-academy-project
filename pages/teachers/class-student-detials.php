<?php
$title = 'View Student Details';
include(__DIR__ . '/../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // ✅ Fetch student
    $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        header('Location: ' . route('back'));
        exit();
    }
} else {
    header('Location: ' . route('back'));
    exit();
}

// ✅ Fetch class
$stmt = $pdo->prepare("SELECT name FROM classes WHERE id = ?");
$stmt->execute([$student['class_id']]);
$class = $stmt->fetch(PDO::FETCH_ASSOC);
$student['class'] = $class['name'] ?? null;

// ✅ Fetch arm
$stmt = $pdo->prepare("SELECT name FROM class_arms WHERE id = ?");
$stmt->execute([$student['arm_id']]);
$arm = $stmt->fetch(PDO::FETCH_ASSOC);
$student['arm'] = $arm['name'] ?? null;

// ✅ Fetch guardian
$stmt = $pdo->prepare("SELECT * FROM guardians WHERE id = ?");
$stmt->execute([$student['guardian_id']]);
$guardian = $stmt->fetch(PDO::FETCH_ASSOC);

if ($guardian) {
    $student['guardian'] = $guardian['name'];
    $student['address']  = $guardian['address'];
}
?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php'); ?>



    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Student Profile</h1>
            <p class="text-xl text-blue-200">View complete student information</p>
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
                            <img id="profilePic" src="/placeholder.svg?height=150&width=150" alt="Student Profile" class="w-32 h-32 rounded-full border-4 border-white shadow-lg">
                        </div>

                        <!-- Basic Info -->
                        <div class="flex-1 pt-4">
                            <h2 id="fullName" class="text-3xl font-bold text-gray-900 mb-2"><?= $student['name'] ?? ' Loading...' ?></h2>
                            <p id="userType" class="text-lg text-gray-600 mb-4">
                                <span class="px-4 py-2 bg-indigo-100 text-indigo-900 rounded-full font-semibold">Student</span>
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Gender</p>
                                    <p id="createdAt" class="text-lg font-semibold text-gray-900"><?= ucwords($student['gender'])  ?? '-' ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Status</p>
                                    <p id="status" class="text-lg font-semibold text-gray-900"><?= ucwords($student['status']) ?? '-' ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Created</p>
                                    <p id="createdAt" class="text-lg font-semibold text-gray-900"><?= date('D d M, Y', strtotime($student['created_at']))  ?? '-' ?></p>
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
                                    <p id="email" class="text-lg font-semibold text-gray-900"><?= $student['email'] ?? '---' ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Phone Number</p>
                                    <p id="phone" class="text-lg font-semibold text-gray-900"><?= $student['phone'] ?? '---' ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Address</p>
                                    <p id="address" class="text-lg font-semibold text-gray-900"><?= $student['address'] ?? '---' ?></p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Additional Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-600">Class</p>
                                    <p id="department" class="text-lg font-semibold text-gray-900"><?= $student['class'] . ' ' . $student['arm'] ?></p>

                                </div>


                                <div>
                                    <p class="text-sm text-gray-600">Admission Number</p>
                                    <p id="userId" class="text-lg font-semibold text-gray-900"><?= $student['admission_number'] ?></p>
                                </div>
                            </div>
                        </div>


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
                    </div>


                    <!-- Action Buttons -->
                    <div class="flex flex-col md:flex-row gap-4">
                        <a
                            href="<?= route('update-class-student-password') ?>?id=<?= $student['id'] ?>"
                            class="flex flex-1">
                            <button class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                                <i class="fas fa-edit mr-2"></i>Edit Password
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
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>


</body>

</html>