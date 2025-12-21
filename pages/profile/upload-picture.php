<?php
$title = "Upload Profile Picture";
include(__DIR__ . '/../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

// Ensure CSRF token exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Detect user type and ID
if (isset($_GET['id'], $_GET['user_type'])) {
    $id        = (int) $_GET['id'];
    $user_type = strtolower($_GET['user_type']);

    // Allowed tables
    $allowed_types = [
        'admin'   => 'admins',
        'teacher' => 'teachers',
        'guardian' => 'guardians',
        'student' => 'students'
    ];

    if (!array_key_exists($user_type, $allowed_types)) {
        $_SESSION['failure'] = "Invalid user type";
        header('Location: ' . route('back'));
        exit();
    }

    $table = $allowed_types[$user_type];

    // Fetch user
    $stmt = $pdo->prepare("SELECT picture_path, id FROM $table WHERE id = ? ");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header('Location: ' . route('back'));
        exit();
    }
} else {
    header('Location: ' . route('back'));
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_SESSION['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    } else {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $errors = [];

    if (!isset($_FILES['avatarFile']) || $_FILES['avatarFile']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "No file uploaded or upload error.";
    } else {
        $file = $_FILES['avatarFile'];


        // Validate size (max 5MB)
        if (isset($file['size']) && (int)$file['size'] > 5 * 1024 * 1024) {
            $errors[] = "File size exceeds 5MB limit.";
        }

        // Validate type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            $errors[] = "Invalid file type. Only JPG, PNG, GIF, WebP allowed.";
        }
    }

    if (empty($errors)) {
        try {
            // Generate unique filename
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($ext, $allowedExts)) {
                $errors[] = "Invalid file extension.";
            } else {
                $newFileName = $user_type . '_' . $id . '_' . time() . '.' . $ext;

                // Dedicated folder per user type
                $uploadDir = __DIR__ . "/../../static/uploads/{$user_type}s/avatars/";
                $uploadPath = $uploadDir . $newFileName;

                if (!is_dir($uploadDir)) {
                    if (!mkdir($uploadDir, 0755, true)) {
                        throw new RuntimeException("Failed to create upload directory.");
                    }
                }

                if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    $relativePath = "/uploads/{$user_type}s/avatars/" . $newFileName;

                    // Delete old avatar if exists
                    if (!empty($user['picture_path']) && $user['picture_path'] !== '/images/avatar.png') {
                        $oldFile = __DIR__ . '/../../../../static' . $user['picture_path'];
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }

                    // Update DB
                    $stmt = $pdo->prepare("UPDATE $table SET picture_path = :path WHERE id = :id");
                    $stmt->execute([
                        ':path' => $relativePath,
                        ':id'   => $id
                    ]);

                    $_SESSION['success'] = "Profile picture updated successfully!";
                    header("Location: " . route('back'));
                    exit();
                } else {
                    $errors[] = "Failed to move uploaded file.";
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . htmlspecialchars($e->getMessage());
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
        }
    }

    foreach ($errors as $error) {
        echo "<p class='text-red-600 font-semibold'>$error</p>";
    }
}
?>


<body class="bg-gray-50">

    <?php include(__DIR__ . '/../../includes/nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Upload Your Avatar</h1>
            <p class="text-xl text-blue-200">Update your profile picture across all platforms</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class=" py-12 bg-gray-50">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Avatar Management</h2>

                <form id="avatarForm" class="space-y-8" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">


                    <!-- Current Avatar Display -->
                    <div class="bg-gray-50 rounded-lg p-8 border-2 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Current Avatar</h3>
                        <div class="flex flex-col items-center gap-6">
                            <div class="relative">

                                <img id="currentAvatar"
                                    src="<?= !empty($user['picture_path']) ? asset($user['picture_path']) : asset('/images/avatar.png') ?>"
                                    alt="Current Avatar" class="w-48 h-48 rounded-full border-4 border-blue-900 shadow-lg object-cover">
                                <div class="absolute bottom-0 right-0 bg-green-500 w-8 h-8 rounded-full border-2 border-white flex items-center justify-center">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-600">Last Updated: <span id="lastUpdated" class="font-semibold">Not set</span></p>
                                <p class="text-xs text-gray-500 mt-2">Size: 200 x 200 px</p>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Section -->
                    <div class="border-2 border-dashed border-blue-300 rounded-lg p-8 bg-blue-50">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload New Avatar</h3>

                        <div class="mb-6">
                            <label for="avatarFile" class="block mb-4">
                                <div class="flex flex-col items-center justify-center cursor-pointer hover:bg-blue-100 transition rounded-lg p-8">
                                    <i class="fas fa-cloud-upload-alt text-5xl text-blue-900 mb-4"></i>
                                    <p class="text-lg font-semibold text-gray-900 mb-2">Choose or drop image here</p>
                                    <p class="text-sm text-gray-600">Supported formats: JPG, PNG, GIF, WebP (Max 5MB)</p>
                                </div>
                                <input
                                    type="file"
                                    id="avatarFile"
                                    name="avatarFile"
                                    accept="image/jpeg,image/png,image/gif,image/webp"
                                    class="sr-only"
                                    required>

                            </label>
                            <span class="text-red-500 text-sm hidden" id="fileError"></span>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div id="previewSection" class="hidden bg-gray-50 rounded-lg p-8 border-2 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Preview</h3>
                        <div class="flex flex-col md:flex-row gap-8 items-center">
                            <!-- Preview Image -->
                            <div class="flex-1 flex justify-center">
                                <div class="relative">
                                    <img id="previewAvatar" src="/placeholder.svg" alt="Preview Avatar" class="w-48 h-48 rounded-full border-4 border-orange-500 shadow-lg object-cover">
                                    <div class="absolute bottom-0 right-0 bg-orange-500 w-8 h-8 rounded-full border-2 border-white flex items-center justify-center">
                                        <i class="fas fa-eye text-white text-sm"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Info -->
                            <div class="flex-1 space-y-4">
                                <div>
                                    <p class="text-sm text-gray-600 mb-2">File Name</p>
                                    <p id="fileName" class="text-lg font-semibold text-gray-900">-</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-2">File Size</p>
                                    <p id="fileSize" class="text-lg font-semibold text-gray-900">-</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 mb-2">Dimensions</p>
                                    <p id="fileDimensions" class="text-lg font-semibold text-gray-900">-</p>
                                </div>
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-6">
                                    <p class="text-sm text-green-700"><i class="fas fa-check-circle mr-2"></i>Image is ready to upload</p>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Action Buttons -->
                    <div class="flex flex-col md:flex-row gap-4 pt-4 border-t border-gray-200">
                        <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                            <i class="fas fa-upload mr-2"></i>Upload & Apply Avatar
                        </button>
                        <a href="user-profile.html" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                            <i class="fas fa-times mr-2"></i>Cancel
                        </a>
                    </div>

                    <!-- Terms -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-xs text-gray-600">By uploading an avatar, you agree that the image is yours or you have permission to use it. The image will be processed and stored securely.</p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../../includes/footer.php'); ?>

    <script>
        // Elements
        const avatarFile = document.getElementById('avatarFile');
        const previewSection = document.getElementById('previewSection');
        const previewAvatar = document.getElementById('previewAvatar');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileDimensions = document.getElementById('fileDimensions');
        const fileError = document.getElementById('fileError');

        // When user selects a file
        avatarFile.addEventListener('change', (e) => {
            const file = e.target.files[0];
            fileError.classList.add('hidden');

            if (!file) return;

            // Validate size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                fileError.textContent = 'File size exceeds 5MB limit';
                fileError.classList.remove('hidden');
                previewSection.classList.add('hidden');
                return;
            }

            // Validate type
            if (!['image/jpeg', 'image/png', 'image/gif', 'image/webp'].includes(file.type)) {
                fileError.textContent = 'Invalid file type. Only JPG, PNG, GIF, WebP allowed.';
                fileError.classList.remove('hidden');
                previewSection.classList.add('hidden');
                return;
            }

            // Read file and show preview
            const reader = new FileReader();
            reader.onload = (event) => {
                const img = new Image();
                img.onload = () => {
                    previewAvatar.src = event.target.result;
                    fileName.textContent = file.name;
                    fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';
                    fileDimensions.textContent = img.width + ' x ' + img.height + ' px';
                    previewSection.classList.remove('hidden');
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });
    </script>

</body>

</html>