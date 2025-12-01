<?php
$title = "Update News Post";
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
    $stmt->execute([$id]);
    $story = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$story) {
        header('Location: ' . route('back'));
        exit();
    }
} else {
    header('Location: ' . route('back'));
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    } else {
        // regenerate after successful validation
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $id               = (int) trim($_POST['id'] ?? '');
    $newsTitle        = trim($_POST['title'] ?? '');
    $category         = trim($_POST['category'] ?? '');
    $content          = trim($_POST['content'] ?? '');
    $status           = trim($_POST['status'] ?? '');
    $publication_date = trim($_POST['date'] ?? '');

    if (empty($newsTitle))        $errors['titleError'] = "Title is required";
    if (empty($category))         $errors['categoryError'] = "Category is required";
    if (empty($content))          $errors['contentError'] = "Content is required";
    if (empty($status))           $errors['statusError'] = "Status is required";
    if (empty($publication_date) || !strtotime($publication_date)) {
        $errors['publicationDateError'] = "Valid publication date is required";
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                UPDATE news 
                SET title = ?, category = ?, content = ?, status = ?, publication_date = ?
                WHERE id = ?
            ");
            $success = $stmt->execute([$newsTitle, $category, $content, $status, $publication_date, $id]);

            if ($success) {
                $_SESSION['success'] = "News Updated successfully!";
                header("Location: " . route('back'));
                exit();
            } else {
                echo "<script>alert('Failed to update news');</script>";
            }
        } catch (PDOException $e) {
            echo "<script>alert('Database error: " . htmlspecialchars($e->getMessage()) . "');</script>";
        }
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}
?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/../includes/admins-section-nav.php") ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update School News</h1>
            <p class="text-xl text-blue-200">Share important announcements and updates with the school community</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <form id="newsForm" class="space-y-6" method="post">

                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($story['id']) ?>">


                    <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                    <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                    <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>



                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-gray-700 font-semibold mb-2">News Title <span class="text-red-600">*</span></label>
                        <input type="text" id="title" name="title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter news title" value="<?= htmlspecialchars($story['title']) ?>">
                        <span class="text-red-500 text-sm hidden" id="titleError"></span>

                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-gray-700 font-semibold mb-2">Category <span class="text-red-600">*</span></label>
                        <select id="category" name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                            <option value="">Select Category</option>
                            <option value="announcement" <?= $story['category'] === 'announcement' ? 'selected' : '' ?>>Announcement</option>
                            <option value="event" <?= $story['category'] === 'event' ? 'selected' : '' ?>>Event</option>
                            <option value="achievement" <?= $story['category'] === 'achievement' ? 'selected' : '' ?>>Achievement</option>
                            <option value="update" <?= $story['category'] === 'update' ? 'selected' : '' ?>>Update</option>
                        </select>
                        <span class="text-red-500 text-sm hidden" id="categoryError"></span>

                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-gray-700 font-semibold mb-2">Content <span class="text-red-600">*</span></label>
                        <textarea id="content" name="content" rows="8" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter news content..."><?= htmlspecialchars($story['content']) ?></textarea>
                        <p class="text-sm text-gray-500 mt-2"><span id="charCount">0</span>/500 characters</p>
                        <span class="text-red-500 text-sm hidden" id="contentError"></span>

                    </div>

                    <!-- Featured Image -->
                    <div>
                        <label for="image" class="block text-gray-700 font-semibold mb-2">Featured Image</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition cursor-pointer">
                            <input type="file" id="image" name="image" accept="image/*" class="hidden">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600 font-semibold">Click to upload image or drag and drop</p>
                            <p class="text-sm text-gray-500">PNG, JPG, GIF up to 5MB</p>
                        </div>
                        <div id="imagePreview" class="mt-4 hidden">
                            <img id="previewImg" src="/placeholder.svg" alt="Preview" class="w-full h-64 object-cover rounded-lg">
                            <button type="button" onclick="clearImage()" class="mt-2 text-red-600 hover:text-red-700 text-sm font-semibold">
                                <i class="fas fa-trash mr-2"></i>Remove Image
                            </button>
                        </div>
                    </div>

                    <!-- Publication Date -->
                    <div>
                        <label for="date" class="block text-gray-700 font-semibold mb-2">Publication Date <span class="text-red-600">*</span></label>
                        <input type="date" id="date" name="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" value="<?= date('Y-m-d', strtotime($story['publication_date'])) ?> ">
                        <span class="text-red-500 text-sm hidden" id="publicationDateError">cpntent</span>

                    </div>


                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
                            <option value="published" <?= $story['status'] === 'published' ? 'selected' : '' ?>>Publish</option>
                            <option value="draft" <?= $story['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                        </select>
                    </div>


                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6 border-t">
                        <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>Post News
                        </button>
                        <a href="<?= route('back') ?>" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 transition flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../../includes/footer.php"); ?>


    <script>
        // Image upload handling
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');

        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    previewImg.src = event.target.result;
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        function clearImage() {
            imageInput.value = '';
            imagePreview.classList.add('hidden');
        }

        // Character counter
        const contentInput = document.getElementById('content');
        const charCount = document.getElementById('charCount');

        contentInput.addEventListener('input', () => {
            charCount.textContent = contentInput.value.length;
        });

        // Set today's date as default
        document.getElementById('date').valueAsDate = new Date();

        // Form submission
        const newsFrom = document.getElementById('newsForm');
        newsFrom.addEventListener('submit', (e) => {
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
                document.getElementById('publicationDateError').textContent = 'Publication Date  is required';
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
                newsFrom.submit();
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