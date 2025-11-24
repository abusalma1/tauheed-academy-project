<?php
$title = 'Dashboard';

include(__DIR__ .  '/./includes/header.php');

$stmt = $conn->prepare("SELECT * FROM news ORDER BY created_at DESC limit 6");
$stmt->execute();
$result = $stmt->get_result();
$news = $result->fetch_all(MYSQLI_ASSOC);

?>

<body class="bg-gray-50">

    <?php include(__DIR__ .  '/./includes/nav.php'); ?>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-pink-700 to-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <img src="<?= asset('images/logo.png') ?>"
                alt="School Logo"
                class="h-32 w-32 mx-auto block mb-6 bg-white rounded-full p-2 object-contain object-center">

            <h1 class="text-4xl md:text-6xl font-bold mb-4">Tauheed Academy</h1>
            <p class="text-xl md:text-2xl text-blue-200 mb-8">Nurturing Future Leaders Through Quality Education</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= route('admission') ?>" class="bg-white text-blue-900 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">Apply Now</a>
                <a href="<?= route('about') ?>" class="bg-blue-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-900 transition">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Welcome Message -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="/placeholder.svg?height=400&width=600" alt="Director" class="rounded-lg shadow-xl w-full">
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Welcome from Our Director</h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Dear Parents, Students, and Visitors,
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        It is with great pleasure that I welcome you to Excellence Academy. Our institution stands as a beacon of quality education, dedicated to nurturing young minds and preparing them for the challenges of tomorrow.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        We believe in holistic development, combining academic excellence with character building, creativity, and critical thinking. Our experienced faculty, modern facilities, and student-centered approach ensure that every child receives the attention and guidance they deserve.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Thank you for considering Excellence Academy as your partner in education. Together, we will shape the leaders of tomorrow.
                    </p>
                    <p class="text-gray-900 font-semibold">
                        Dr. Sarah Johnson<br>
                        <span class="text-gray-600 text-sm">Director/CEO, Excellence Academy</span>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- News Grid -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">School News</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="news-grid">
                <?php foreach ($news as $story) : ?>
                    <div class="news-item <?= $story['category'] ?> bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition transform hover:scale-105">
                        <div class="relative overflow-hidden h-48">
                            <img src="/placeholder.svg?height=300&width=400" alt="News" class="w-full h-full object-cover">

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
                            <h3 class="text-xl font-bold text-gray-900 mb-3"><?= $story['title'] ?></h3>
                            <p class="text-gray-600 mb-4"><?= htmlspecialchars(substr($story['content'], 0, 50) . "...") ?></p>
                            <a href="<?= route('news-detial') . '?id=' . $story['id']; ?>" class="inline-flex items-center gap-2 text-blue-900 font-semibold hover:text-blue-700">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach ?>



            </div>
        </div>
    </section>


    <!-- Gallery Slider -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Our Campus & Activities</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="relative overflow-hidden rounded-lg shadow-lg group">
                    <img src="/placeholder.svg?height=300&width=400" alt="School Building" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                        <p class="text-white font-semibold">Modern School Building</p>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-lg shadow-lg group">
                    <img src="/placeholder.svg?height=300&width=400" alt="Classroom" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                        <p class="text-white font-semibold">Interactive Classrooms</p>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-lg shadow-lg group">
                    <img src="/placeholder.svg?height=300&width=400" alt="Sports" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                        <p class="text-white font-semibold">Sports & Recreation</p>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-lg shadow-lg group">
                    <img src="/placeholder.svg?height=300&width=400" alt="Library" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                        <p class="text-white font-semibold">Well-Stocked Library</p>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-lg shadow-lg group">
                    <img src="/placeholder.svg?height=300&width=400" alt="Laboratory" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                        <p class="text-white font-semibold">Science Laboratories</p>
                    </div>
                </div>
                <div class="relative overflow-hidden rounded-lg shadow-lg group">
                    <img src="/placeholder.svg?height=300&width=400" alt="Computer Lab" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                        <p class="text-white font-semibold">Computer Laboratory</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Links -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Quick Links</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <a href="<?= route('admission') ?>" class="bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg">
                    <i class="fas fa-user-plus text-4xl mb-3"></i>
                    <p class="font-semibold">Admissions</p>
                </a>
                <a href="<?= route('fees') ?>" class="bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg">
                    <i class="fas fa-money-bill-wave text-4xl mb-3"></i>
                    <p class="font-semibold">Fees</p>
                </a>
                <a href="<?= route('timetable') ?>" class="bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg">
                    <i class="fas fa-calendar-alt text-4xl mb-3"></i>
                    <p class="font-semibold">Timetable</p>
                </a>
                <a href="<?php
                            if ($is_logged_in) {
                                if ($user_type === 'student') {
                                    echo (route('student-result'));
                                } else if ($user_type === 'guardian') {
                                    echo (route('my-children'));
                                } else {
                                    echo ((route('results-management')));
                                }
                            } else {
                                echo (route('academics'));
                            }
                            ?>" class="bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg">
                    <i class="fas fa-graduation-cap text-4xl mb-3"></i>
                    <p class="font-semibold">Results</p>
                </a>
                <a href="<?= route('about') ?>" class="bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg">
                    <i class="fas fa-envelope text-4xl mb-3"></i>
                    <p class="font-semibold">Contact</p>
                </a>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/includes/footer.php') ?>
    <script>
        //  Mobile Menu Script
        const mobileMenuBtn = document.getElementById("mobile-menu-btn");
        const mobileMenu = document.getElementById("mobile-menu");

        mobileMenuBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    </script>
</body>

</html>