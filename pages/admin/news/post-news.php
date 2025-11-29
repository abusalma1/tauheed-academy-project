<?php
$title = "Post News";
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


$stmt = $conn->prepare("SELECT * FROM news where deleted_at is null ORDER BY updated_at DESC LIMIT 10");
$stmt->execute();
$result =  $stmt->get_result();
$news = $result->fetch_all(MYSQLI_ASSOC);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }



    $newsTitle = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $publication_date = trim($_POST['date'] ?? '');



    if (empty($newsTitle)) $errors['titleError'] = "Title is required";
    if (empty($category)) $errors['categoryError'] = "Category is required";
    if (empty($content)) $errors['contentError'] = "Content is required";
    if (empty($status)) $errors['statusError'] = "Title is required";
    if (empty($publication_date)) $errors['publicationDateError'] = "Publication Date is required";

    if (empty($errors)) {
        $stmt = $conn->prepare("INSERT into news (title, category, content, status, publication_date) values (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $newsTitle, $category, $content, $status, $publication_date);
        if ($stmt->execute()) {
            $_SESSION['success'] = "News Posted successfully!";
            header("Location: " .  route('back'));
            exit();
        } else {
            echo "<script>alert('Failed to create news : " . $stmt->error . "');</script>";
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
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Post School News</h1>
            <p class="text-xl text-blue-200">Share important announcements and updates with the school community</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <form id="newsForm" class="space-y-6" method="post">

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
                        <a href="<?= route('back') ?>" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 transition flex items-center justify-center gap-2">
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