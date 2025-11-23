<?php
$title = "Post News";
include(__DIR__ . '/../../includes/header.php');

$stmt = $conn->prepare("SELECT * FROM news order by created_at DESC LIMIT 10");
$stmt->execute();
$news =  $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/./includes/admins-section-nav.php") ?>


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
                <form id="newsForm" class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-gray-700 font-semibold mb-2">News Title <span class="text-red-600">*</span></label>
                        <input type="text" id="title" name="title" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter news title" required>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-gray-700 font-semibold mb-2">Category <span class="text-red-600">*</span></label>
                        <select id="category" name="category" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" required>
                            <option value="">Select Category</option>
                            <option value="announcement">Announcement</option>
                            <option value="event">Event</option>
                            <option value="achievement">Achievement</option>
                            <option value="update">Update</option>
                        </select>
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-gray-700 font-semibold mb-2">Content <span class="text-red-600">*</span></label>
                        <textarea id="content" name="content" rows="8" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter news content..." required></textarea>
                        <p class="text-sm text-gray-500 mt-2"><span id="charCount">0</span>/500 characters</p>
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
                        <input type="date" id="date" name="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" required>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-3">Status</label>
                        <div class="flex gap-6">
                            <div class="flex items-center">
                                <input type="radio" id="draft" name="status" value="draft" class="w-4 h-4">
                                <label for="draft" class="ml-2 text-gray-700">Draft</label>
                            </div>
                            <div class="flex items-center">
                                <input type="radio" id="published" name="status" value="published" checked class="w-4 h-4">
                                <label for="published" class="ml-2 text-gray-700">Publish</label>
                            </div>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6 border-t">
                        <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>Post News
                        </button>
                        <a href="school-news.html" class="flex-1 bg-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-400 transition flex items-center justify-center gap-2">
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
                            <?php foreach ($news as $new) : ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">End of Term Examination Schedule</td>
                                    <td class="px-6 py-4"><span class="

                                <?php if ($row('category') === 'event'): ?>
                                    bg-green-100 text-green-800
                                <?php elseif ($row('category') === 'achievement'): ?>
                                    bg-yellow-100 text-yellow-800
                                <?php elseif ($row('category') === 'announcement'): ?>
                                    bg-blue-100 text-blue-800
                                <?php elseif ($row('category') === 'udate'): ?>
                                    bg-purple-100 text-purple-800
                                <?php endif ?>

                                 px-3 py-1 rounded-full text-sm"><?= ucwords($new['category']) ?></span></td>
                                    <td class="px-6 py-4"><?= date('D d M, Y', strtotime($new['created_at'])); ?></td>
                                    <td class="px-6 py-4"><span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm"><?= ucwords($newp['status']) ?></span></td>
                                    <td class="px-6 py-4">
                                        <button class="text-blue-600 hover:text-blue-800 mr-3"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
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
    <?php include(__DIR__ . "/../../includes/footer.php"); ?>


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
        document.getElementById('newsForm').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('News posted successfully! (This is a demo)');
        });
    </script>
</body>

</html>