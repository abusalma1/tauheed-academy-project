<?php
$title = "News Detail";
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
    $stmt->execute([$id]);
    $story = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($story) {
        // Get Previous Article (earlier created_at)
        $stmtPrev = $pdo->prepare('
            SELECT id, picture_path, created_at, title 
            FROM news 
            WHERE created_at < ? 
            ORDER BY created_at DESC 
            LIMIT 1
        ');
        $stmtPrev->execute([$story['created_at']]);
        $previous = $stmtPrev->fetch(PDO::FETCH_ASSOC);

        // Get Next Article (later created_at)
        $stmtNext = $pdo->prepare('
            SELECT id, picture_path, created_at, title 
            FROM news 
            WHERE created_at > ? 
            ORDER BY created_at ASC 
            LIMIT 1
        ');
        $stmtNext->execute([$story['created_at']]);
        $next = $stmtNext->fetch(PDO::FETCH_ASSOC);
    } else {
        header('Location: ' . route('back'));
        exit();
    }
} else {
    header('Location: ' . route('back'));
    exit();
}
?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/../includes/admins-section-nav.php") ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">News Detail</h1>
            <p class="text-xl text-blue-200">See the content of the story</p>
        </div>
    </section>


    <!-- News Detail Content -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <article class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Featured Image -->
                <div class="relative overflow-hidden h-96 md:h-96">
                    <img src="/placeholder.svg?height=500&width=800" alt="News" class="w-full h-full object-cover">
                    <!-- Category badge in top-right corner -->
                    <?php if ($story['category'] === 'event'): ?>
                        <div class="absolute top-4 right-4 bg-green-600  text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            <i class="fas fa-calendar-check mr-2"></i>Event
                        </div>
                    <?php elseif ($story['category'] === 'achievement'): ?>
                        <div class="absolute top-4 right-4 bg-yellow-600  text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            <i class="fas fa-star mr-2"></i>Achievement
                        </div>
                    <?php elseif ($story['category'] === 'announcement'): ?>
                        <div class="absolute top-4 right-4 bg-blue-600  text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            <i class="fas fa-bullhorn mr-2"></i>Announcement
                        </div>
                    <?php elseif ($story['category'] === 'update'): ?>
                        <div class="absolute top-4 right-4 bg-purple-600  text-white px-4 py-2 rounded-full text-sm font-semibold shadow-lg">
                            <i class="fas fa-info-circle mr-2"></i>Update
                        </div>
                    <?php endif ?>
                </div>

                <!-- Article Header -->
                <div class="p-8 border-b">
                    <div class="flex flex-wrap items-center gap-4 mb-4 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar text-blue-900"></i>
                            <span><?= date('D d M, Y', strtotime($story['created_at'])); ?></span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user text-blue-900"></i>
                            <span>By Admin</span>
                        </div>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= htmlspecialchars(ucwords($story['title'])) ?></h1>

                </div>

                <!-- Article Body -->
                <div class="p-8 prose prose-lg max-w-none">
                    <h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">Article Content</h2>
                    <p class="text-gray-700 mb-6 leading-relaxed"><?= nl2br(htmlspecialchars($story['content'])); ?></p>



                </div>

                <!-- Article Footer with Social Sharing -->
                <div class="p-8 bg-gray-50 border-t">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <p class="text-gray-600 text-sm mb-3">Share this article:</p>
                            <div class="flex gap-3">
                                <a href="#" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-sm">
                                    <i class="fab fa-facebook-f"></i>Facebook
                                </a>
                                <a href="#" class="inline-flex items-center gap-2 bg-blue-400 text-white px-4 py-2 rounded hover:bg-blue-500 transition text-sm">
                                    <i class="fab fa-twitter"></i>Twitter
                                </a>
                                <a href="#" class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition text-sm">
                                    <i class="fab fa-whatsapp"></i>WhatsApp
                                </a>
                            </div>
                        </div>
                        <a href="school-news.html" class="inline-flex items-center gap-2 bg-blue-900 text-white px-6 py-2 rounded hover:bg-blue-800 transition font-semibold">
                            <i class="fas fa-arrow-left"></i>Back to News
                        </a>
                    </div>
                </div>
            </article>

            <!-- Next & Previous Articles -->
            <section class="mt-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">More Articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Previous Article -->
                    <?php if ($previous): ?>
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            <div class="relative overflow-hidden h-40">
                                <img src="/placeholder.svg?height=200&width=400" alt="Previous Article" class="w-full h-full object-cover">
                                <div class="absolute top-2 left-2 bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold">
                                    <i class="fas fa-arrow-left mr-1"></i>Previous
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-2"><i class="fas fa-calendar mr-1"></i><?= date('D d M, Y', strtotime($previous['created_at'])); ?></p>
                                <h3 class="text-lg font-bold text-gray-900 mb-2"><?= htmlspecialchars(ucwords($previous['title'])) ?></h3>
                                <a href="<?= route('admin-news-detial') . '?id=' . $previous['id'] ?>" class="text-blue-900 font-semibold text-sm hover:text-blue-700">
                                    Read Previous <i class="fas fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php if ($next): ?>
                        <!-- Next Article -->
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                            <div class="relative overflow-hidden h-40">
                                <img src="/placeholder.svg?height=200&width=400" alt="Next Article" class="w-full h-full object-cover">
                                <div class="absolute top-2 right-2 bg-purple-600 text-white px-3 py-1 rounded text-xs font-semibold">
                                    <i class="fas fa-arrow-right mr-1"></i>Next
                                </div>
                            </div>
                            <div class="p-4">
                                <p class="text-xs text-gray-500 mb-2"><i class="fas fa-calendar mr-1"></i><?= date('D d M, Y', strtotime($next['created_at'])); ?></p>
                                <h3 class="text-lg font-bold text-gray-900 mb-2"><?= htmlspecialchars(ucwords($next['title'])) ?></h3>
                                <a href="<?= route('admin-news-detial') . '?id=' . $next['id'] ?>" class="text-blue-900 font-semibold text-sm hover:text-blue-700">
                                    Read Next <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endif ?>

                </div>
            </section>

        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../../includes/footer.php"); ?>

</body>

</html>