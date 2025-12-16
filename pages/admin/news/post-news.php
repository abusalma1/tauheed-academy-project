<?php
$title = "Post News";
include(__DIR__ . '/../../../includes/header.php');

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

// Fetch latest news
$stmt = $pdo->prepare("SELECT * FROM news WHERE deleted_at IS NULL ORDER BY updated_at DESC LIMIT 10");
$stmt->execute();
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    } else {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $errors = [];
    $picturePath = null; // default

    // ✅ Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $file = $_FILES['image'];

        // ✅ Validate size (max 5MB)
        if ($file['size'] > 5 * 1024 * 1024) {
            $errors[] = "Image size exceeds 5MB limit.";
        }

        // ✅ Validate MIME type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            $errors[] = "Invalid image type. Only JPG, PNG, GIF, WebP allowed.";
        }

        // ✅ Validate extension
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($ext, $allowedExts)) {
            $errors[] = "Invalid image extension.";
        }

        // ✅ If no errors, process upload
        if (empty($errors)) {

            // ✅ Generate unique filename
            $newFileName = 'news_' . time() . '_' . bin2hex(random_bytes(5)) . '.' . $ext;

            // ✅ Upload directory
            $uploadDir = __DIR__ . "/../../../static/uploads/news/";
            $uploadPath = $uploadDir . $newFileName;

            // ✅ Create folder if missing
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0755, true)) {
                    $errors[] = "Failed to create upload directory.";
                }
            }

            // ✅ Move uploaded file
            if (empty($errors) && move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // ✅ Path stored in DB
                $picturePath = "/uploads/news/" . $newFileName;
            } else {
                $errors[] = "Failed to upload image.";
            }
        }
    }

    // ✅ Continue with your existing validation
    $newsTitle        = trim($_POST['title'] ?? '');
    $category         = trim($_POST['category'] ?? '');
    $content          = trim($_POST['content'] ?? '');
    $status           = trim($_POST['status'] ?? '');
    $publication_date = trim($_POST['date'] ?? '');

    if (empty($newsTitle))        $errors['titleError'] = "Title is required";
    if (empty($category))         $errors['categoryError'] = "Category is required";
    if (empty($content))          $errors['contentError'] = "Content is required";
    if (empty($status))           $errors['statusError'] = "Status is required";
    if (empty($publication_date)) $errors['publicationDateError'] = "Publication Date is required";

    // ✅ If no errors, insert into DB
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO news (title, category, content, status, publication_date, picture_path)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            $success = $stmt->execute([
                $newsTitle,
                $category,
                $content,
                $status,
                $publication_date,
                $picturePath // ✅ NULL if no image uploaded
            ]);

            if ($success) {
                $_SESSION['success'] = "News Posted successfully!";
                header("Location: " . route('back'));
                exit();
            } else {
                echo "<script>alert('Failed to create news');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . htmlspecialchars($e->getMessage()) . "');</script>";
        }
    }

    // ✅ Show errors
    foreach ($errors as $error) {
        echo "<p class='text-red-600 font-semibold'>$error</p>";
    }
}

?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/../includes/admins-section-nav.php") ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Post School News</h1>
            <p class="text-xl text-blue-200">Share important announcements and updates with the school community</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <form id="newsForm" class="space-y-6" method="post" enctype="multipart/form-data">

                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                    <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                    <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                    <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>



                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-gray-700 font-semibold mb-2">News Title <span class="text-red-600">*</span></label>
                        <input type="text" id="title" name="title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter news title">
                        <span class="text-red-500 text-sm hidden" id="titleError"></span>

                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-gray-700 font-semibold mb-2">Category <span class="text-red-600">*</span></label>
                        <select id="category" name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                            <option value="">Select Category</option>
                            <option value="announcement">Announcement</option>
                            <option value="event">Event</option>
                            <option value="achievement">Achievement</option>
                            <option value="update">Update</option>
                        </select>
                        <span class="text-red-500 text-sm hidden" id="categoryError"></span>

                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-gray-700 font-semibold mb-2">Content <span class="text-red-600">*</span></label>
                        <textarea id="content" name="content" rows="8" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter news content..."></textarea>
                        <p class="text-sm text-gray-500 mt-2"><span id="charCount">0</span>/500 characters</p>
                        <span class="text-red-500 text-sm hidden" id="contentError"></span>

                    </div>

                    <!-- Upload Section -->
                    <div class="border-2 border-dashed border-blue-300 rounded-lg p-8 bg-blue-50">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Featured Image</h3>

                        <div class="mb-6">
                            <label for="image" class="block mb-4">
                                <div class="flex flex-col items-center justify-center cursor-pointer hover:bg-blue-100 transition rounded-lg p-8">
                                    <i class="fas fa-cloud-upload-alt text-5xl text-blue-900 mb-4"></i>
                                    <p class="text-lg font-semibold text-gray-900 mb-2">Choose or drop image here</p>
                                    <p class="text-sm text-gray-600">Supported formats: JPG, PNG, GIF, WebP (Max 5MB)</p>
                                </div>

                                <!-- ✅ Correct field name -->
                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    accept="image/jpeg,image/png,image/gif,image/webp"
                                    class="sr-only">
                            </label>

                            <span class="text-red-500 text-sm hidden" id="fileError"></span>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div id="previewSection" class="hidden bg-gray-50 rounded-lg p-8 border-2 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Preview</h3>

                        <div class="flex flex-col md:flex-row gap-8 items-center">

                            <!-- ✅ Rectangular preview for news -->
                            <div class="flex-1 flex justify-center">
                                <div class="relative">
                                    <img id="previewImage" src="/placeholder.svg"
                                        alt="Preview Image"
                                        class="w-64 h-40 rounded-lg border-4 border-orange-500 shadow-lg object-cover">
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
                                    <p class="text-sm text-green-700">
                                        <i class="fas fa-check-circle mr-2"></i>Image is ready to upload
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Publication Date -->
                    <div>
                        <label for="date" class="block text-gray-700 font-semibold mb-2">Publication Date <span class="text-red-600">*</span></label>
                        <input type="date" id="date" name="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                        <span class="text-red-500 text-sm hidden" id="publicationDateError">cpntent</span>

                    </div>


                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
                            <option value="published">Publish</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>


                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6 border-t">
                        <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>Post News
                        </button>
                        <a type="button" onclick="window.history.back()" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 transition flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Recent News Posted -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Recently Posted News</h2>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-blue-900 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left font-semibold">Title</th>
                                <th class="px-6 py-4 text-left font-semibold">Category</th>
                                <th class="px-6 py-4 text-left font-semibold">Date</th>
                                <th class="px-6 py-4 text-left font-semibold">Status</th>
                                <th class="px-6 py-4 text-left font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="newsTable">
                            <?php foreach ($news as $story) : ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4"><?= $story['title'] ?></td>
                                    <td class="px-6 py-4">
                                        <?php if ($story['category'] === 'event'): ?>
                                            <span class=" bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm"><?= ucwords($story['category']) ?></span>
                                        <?php elseif ($story['category'] === 'achievement'): ?>
                                            <span class=" bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm"><?= ucwords($story['category']) ?></span>
                                        <?php elseif ($story['category'] === 'announcement'): ?>
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm"><?= ucwords($story['category']) ?></span>
                                        <?php elseif ($story['category'] === 'update'): ?>
                                            <span class=" bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm"><?= ucwords($story['category']) ?></span>
                                        <?php endif ?>

                                    </td>
                                    <td class="px-6 py-4"><?= date('D d M, Y', strtotime($story['created_at'])); ?></td>
                                    <td class="px-6 py-4"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm"><?= ucwords($story['status']) ?></span></td>
                                    <td class="px-6 py-4">
                                        <a href="<?= route('update-news-post') ?>?id=<?= $story['id'] ?>" class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></a>
                                        <a href="<?= route('delete-news-post') ?>?id=<?= $story['id'] ?>"
                                            class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../../includes/footer.php"); ?>

    <script>
        // ============================
        // IMAGE UPLOAD + PREVIEW
        // ============================

        const imageInput = document.getElementById('image');
        const previewSection = document.getElementById('previewSection');
        const previewImage = document.getElementById('previewImage');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const fileDimensions = document.getElementById('fileDimensions');
        const fileError = document.getElementById('fileError');

        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            fileError.classList.add('hidden');

            if (!file) return;

            // ✅ Validate size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                fileError.textContent = 'File size exceeds 5MB limit';
                fileError.classList.remove('hidden');
                previewSection.classList.add('hidden');
                return;
            }

            // ✅ Validate type
            if (!['image/jpeg', 'image/png', 'image/gif', 'image/webp'].includes(file.type)) {
                fileError.textContent = 'Invalid file type. Only JPG, PNG, GIF, WebP allowed.';
                fileError.classList.remove('hidden');
                previewSection.classList.add('hidden');
                return;
            }

            // ✅ Read file and show preview
            const reader = new FileReader();
            reader.onload = (event) => {
                const img = new Image();
                img.onload = () => {
                    previewImage.src = event.target.result;
                    fileName.textContent = file.name;
                    fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';
                    fileDimensions.textContent = img.width + ' x ' + img.height + ' px';
                    previewSection.classList.remove('hidden');
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        });

        function clearImage() {
            imageInput.value = '';
            previewSection.classList.add('hidden');
        }

        // ============================
        // CHARACTER COUNTER
        // ============================

        const contentInput = document.getElementById('content');
        const charCount = document.getElementById('charCount');

        contentInput.addEventListener('input', () => {
            charCount.textContent = contentInput.value.length;
        });

        // ============================
        // SET TODAY'S DATE
        // ============================

        document.getElementById('date').valueAsDate = new Date();

        // ============================
        // FORM VALIDATION
        // ============================

        const newsForm = document.getElementById('newsForm');

        newsForm.addEventListener('submit', (e) => {
            e.preventDefault();

            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const title = document.getElementById('title').value.trim();
            const category = document.getElementById('category').value.trim();
            const status = document.getElementById('status').value.trim();
            const publicationDate = document.getElementById('date').value.trim();
            const content = document.getElementById('content').value.trim();

            let isValid = true;

            if (!title) {
                document.getElementById('titleError').textContent = 'Title is required';
                document.getElementById('titleError').classList.remove('hidden');
                isValid = false;
            }

            if (!category) {
                document.getElementById('categoryError').textContent = 'Category is required';
                document.getElementById('categoryError').classList.remove('hidden');
                isValid = false;
            }

            if (!content) {
                document.getElementById('contentError').textContent = 'Content is required';
                document.getElementById('contentError').classList.remove('hidden');
                isValid = false;
            }

            if (!publicationDate) {
                document.getElementById('publicationDateError').textContent = 'Publication Date is required';
                document.getElementById('publicationDateError').classList.remove('hidden');
                isValid = false;
            }

            if (!status) {
                document.getElementById('statusError').textContent = 'Status is required';
                document.getElementById('statusError').classList.remove('hidden');
                isValid = false;
            }

            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                newsForm.submit();
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showErrorMessage();
            }
        });
    </script>

</body>

</html>