<?php
$title = "Admin School News";
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


$stmt = $pdo->prepare("SELECT * FROM news WHERE deleted_at IS NULL ORDER BY updated_at DESC");
$stmt->execute();
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/../includes/admins-section-nav.php") ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">School News</h1>
            <p class="text-xl text-blue-200">Stay updated with latest announcements and events</p>
        </div>
    </section>

    <!-- Search and Filter -->
    <section class="py-8 bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <input type="text" id="searchInput" placeholder="Search news..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                </div>
                <div>
                    <select id="categoryFilter" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                        <option value="all">All Categories</option>
                        <option value="announcement">Announcements</option>
                        <option value="event">Events</option>
                        <option value="achievement">Achievements</option>
                        <option value="update">Updates</option>
                    </select>
                </div>
                <a href="<?= route('post-news') ?>" class="inline-flex items-center gap-2 bg-blue-900 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    <i class="fas fa-plus"></i>Post New News
                </a>

            </div>

        </div>
    </section>

    <!-- News Grid -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if (count($news) <= 0) : ?>
                <span class="text-gray-400 text-center block">Nothing Is posted</span>
            <?php else : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="news-grid">
                    <?php foreach ($news as $story) : ?>
                        <!-- Announcement -->
                        <div class="news-item  <?= $story['category'] ?> bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:scale-105">
                            <div class="relative overflow-hidden h-48">
                                <img src="<?= !empty($story['picture_path']) ? asset($story['picture_path']) : asset('/images/news.png') ?>" alt="News" class="w-full h-full object-cover">

                                <?php if ($story['category'] === 'event'): ?>
                                    <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-calendar-check mr-2"></i>Event
                                    </div>
                                <?php elseif ($story['category'] === 'achievement'): ?>
                                    <div class="absolute top-4 right-4 bg-yellow-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-star mr-2"></i>Achievement
                                    </div>
                                <?php elseif ($story['category'] === 'announcement'): ?>
                                    <div class="absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-bullhorn mr-2"></i>Announcement
                                    </div>
                                <?php elseif ($story['category'] === 'update'): ?>
                                    <div class="absolute top-4 right-4 bg-purple-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-info-circle mr-2"></i>Update
                                    </div>
                                <?php endif ?>

                            </div>
                            <div class="p-6">
                                <div class="flex items-center gap-2 text-gray-500 text-sm mb-3">
                                    <i class="fas fa-calendar"></i>
                                    <span><?= date('D d M, Y', strtotime($story['created_at'])); ?></span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3"><?= htmlspecialchars($story['title']) ?></h3>
                                <p class="text-gray-600 mb-4"><?= htmlspecialchars(substr($story['content'], 0, 50) . "...") ?></p>
                                <a href="<?= route('admin-news-detial') . '?id=' . $story['id']; ?>" class="inline-flex items-center gap-2 text-blue-900 font-semibold hover:text-blue-700">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>

                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mb-4">
                                    <!-- Edit -->
                                    <a href="<?= route('update-news-post') ?>?id=<?= $story['id'] ?>"
                                        class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition text-center text-sm font-semibold">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>


                                    <!-- Delete -->
                                    <a href="<?= route('delete-news-post') ?>?id=<?= $story['id'] ?>"
                                        class="flex-1 bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition text-center text-sm font-semibold">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </a>


                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>



                </div>
            <?php endif ?>
        </div>
    </section>



    <!-- Footer -->
    <?php include(__DIR__ . "/../../../includes/footer.php"); ?>


    <script>
        // Search and filter functionality
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const newsItems = document.querySelectorAll('.news-item');

        function filterNews() {
            const searchTerm = searchInput.value.toLowerCase();
            const category = categoryFilter.value;

            newsItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                const itemCategory = Array.from(item.classList).find(c => ['announcement', 'event', 'achievement', 'update'].includes(c));

                const matchesSearch = text.includes(searchTerm);
                const matchesCategory = category === 'all' || itemCategory === category;

                if (matchesSearch && matchesCategory) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterNews);
        categoryFilter.addEventListener('change', filterNews);
    </script>
</body>

</html>