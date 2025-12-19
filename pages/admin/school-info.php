<?php
$title = "School Information";
include(__DIR__ . "/../../includes/header.php");

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (!isset($user_type) || $user_type !== 'admin') {
    $_SESSION['failure'] = "Access denied! Only Admins are allowed.";
    header("Location: " . route('home'));
    exit();
}
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $id = (int) $_POST['id'];

    $stmt = $pdo->prepare("
        UPDATE schools 
        SET name = ?, motto = ?, address = ?, email = ?, welcome_message = ?, about_message = ?, 
            phone = ?, whatsapp_number = ?, facebook = ?, instagram = ?, twitter = ?, 
            admission_number_format = ?, admission_number_format_description = ?, 
            updated_at = NOW()
        WHERE id = ?
    ");

    $success = $stmt->execute([
        $_POST['name'],
        $_POST['motto'],
        $_POST['address'],
        $_POST['email'],
        $_POST['welcomeMessage'],
        $_POST['aboutMessage'],
        $_POST['phone'],
        $_POST['whatsapp_number'],
        $_POST['facebook'],
        $_POST['instagram'],
        $_POST['twitter'],
        $_POST['admissionNumberFormat'],
        $_POST['admissionNumberFormatDescription'],
        $id
    ]);

    if ($success) {
        $_SESSION['success'] = "School info updated successfully!";
        header("Location: " . route('back'));
        exit();
    } else {
        echo "<script>alert('Failed to update school info');</script>";
    }
}
?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/./includes/admins-section-nav.php') ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">School Information</h1>
            <p class="text-xl text-blue-200">Manage and Update School Details</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Form Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">School Details</h2>
                    <p class="text-gray-600">Update your school's basic information and settings</p>
                </div>

                <!-- Form -->
                <form id="schoolInfoForm" class="space-y-8" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($school['id']); ?>">


                    <?php include(__DIR__ . '/../../includes/components/form-loader.php'); ?>

                    <input type="text" value="<?= htmlspecialchars($school['id']) ?>" hidden>
                    <!-- Basic Information Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-900"></i>
                            Basic Information
                        </h3>

                        <!-- School Name -->
                        <div class="mb-6">
                            <label for="name" class="block text-gray-700 font-semibold mb-2">
                                School Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter school name" value="<?= htmlspecialchars($school['name'] ?? '') ?>">
                        </div>

                        <!-- School Motto -->
                        <div class="mb-6">
                            <label for="motto" class="block text-gray-700 font-semibold mb-2">
                                School Motto <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="motto" name="motto" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter school motto" value="<?= htmlspecialchars($school['motto'] ?? '') ?>">
                        </div>

                        <!-- Address -->
                        <div class="mb-6">
                            <label for="address" class="block text-gray-700 font-semibold mb-2">
                                Address <span class="text-red-500">*</span>
                            </label>
                            <textarea id="address" name="address" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter complete school address"><?= htmlspecialchars($school['address'] ?? '') ?></textarea>
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block text-gray-700 font-semibold mb-2">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter school email" value="<?= htmlspecialchars($school['email'] ?? '') ?>">
                        </div>

                        <!-- Phone Number -->
                        <div class="grid md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="phone" class="block text-gray-700 font-semibold mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="+234 800 123 4567" value="<?= htmlspecialchars($school['phone'] ?? '') ?>">
                            </div>

                            <!-- WhatsApp Number -->
                            <div>
                                <label for="whatsapp_number" class="block text-gray-700 font-semibold mb-2">
                                    WhatsApp Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" id="whatsapp_number" name="whatsapp_number" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="+234 800 123 4567" value="<?= htmlspecialchars($school['whatsapp_number'] ?? '') ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-share-alt text-blue-900"></i>
                            Social Media Links
                        </h3>

                        <!-- Facebook -->
                        <div class="mb-6">
                            <label for="facebook" class="block text-gray-700 font-semibold mb-2">
                                <i class="fab fa-facebook text-blue-600 mr-2"></i>Facebook Link
                            </label>
                            <input type="url" id="facebook" name="facebook" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="https://facebook.com/schoolname" value="<?= htmlspecialchars($school['facebook'] ?? '') ?>">
                        </div>

                        <!-- Twitter -->
                        <div class="mb-6">
                            <label for="twitter" class="block text-gray-700 font-semibold mb-2">
                                <i class="fab fa-x-twitter text-black-400 mr-2"></i>Twitter Link
                            </label>
                            <input type="url" id="twitter" name="twitter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="https://twitter.com/schoolname" value="<?= htmlspecialchars($school['twitter'] ?? '') ?>">
                        </div>

                        <!-- Instagram -->
                        <div class="mb-6">
                            <label for="instagram" class="block text-gray-700 font-semibold mb-2">
                                <i class="fab fa-instagram text-pink-600 mr-2"></i>Instagram Link
                            </label>
                            <input type="url" id="instagram" name="instagram" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="https://instagram.com/schoolname" value="<?= htmlspecialchars($school['instagram'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Welcom Message Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-align-left text-blue-900"></i>
                            Welcome Message
                        </h3>

                        <div class="mb-6">
                            <label for="welcomeMessage" class="block text-gray-700 font-semibold mb-2">
                                Welcome Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="welcomeMessage" name="welcomeMessage" rows="7" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter a formal welcome message, written in clear English with proper grammar and paragraph structure..."><?= htmlspecialchars($school['welcome_message'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <!-- About Message Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-align-left text-blue-900"></i>
                            About Message
                        </h3>

                        <div class="mb-6">
                            <label for="aboutMessage" class="block text-gray-700 font-semibold mb-2">
                                About Message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="aboutMessage" name="aboutMessage" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter a formal description about your school, written in clear English with proper grammar and paragraph structure..."><?= htmlspecialchars($school['about_message'] ?? '') ?></textarea>
                        </div>
                    </div>


                    <!-- Admission Number Format Section -->
                    <div class="pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-hashtag text-blue-900"></i>
                            Admission Number Format
                        </h3>

                        <div class="mb-6">
                            <label for="admissionNumberFormat" class="block text-gray-700 font-semibold mb-2">
                                Admission Number Format <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="admissionNumberFormat" name="admissionNumberFormat" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="e.g., EA/2025/001 or ADM-2025-001" value="<?= htmlspecialchars($school['admission_number_format'] ?? '') ?>">
                            <p class="text-gray-600 text-sm mt-2">Example format for admission numbers (e.g., EA/2025/001)</p>
                        </div>

                        <div class="mb-6">
                            <label for="admissionNumberFormatDescription" class="block text-gray-700 font-semibold mb-2">
                                Admission Number Format Description <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="admissionNumberFormatDescription" name="admissionNumberFormatDescription" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="e.g., ADMISSION/YEAR/SERIAL" value="<?= htmlspecialchars($school['admission_number_format_description'] ?? '') ?>">
                            <p class="text-gray-600 text-sm mt-2">Description format for admission numbers (e.g., Admmisson/Year/Serial)</p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-4 pt-8 border-t">
                        <button type="submit" name="submit" class="flex-1 bg-blue-900 hover:bg-blue-800 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                        <button type="reset" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-redo"></i>
                            Reset Form
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </section>

    <?php include(__DIR__  . '/../../includes/footer.php') ?>
</body>

</html>