<?php
$title = 'About & Contact';

include(__DIR__ .  '/../includes/header.php');
?>

<body class="bg-gray-50">
    <?php include(__DIR__ .  '/../includes/nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">About & Contact Us</h1>
            <p class="text-xl text-blue-200">Get in touch with <?= $school['name'] ?? 'Tauheed Academy' ?></p>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">About <?= $school['name'] ?? 'Tauheed Academy' ?></h2>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Excellence Academy is a premier educational institution dedicated to providing quality education and nurturing the next generation of leaders. Established with a vision to create a learning environment that fosters academic excellence, character development, and holistic growth.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        Our state-of-the-art facilities, experienced faculty, and student-centered approach ensure that every child receives personalized attention and guidance. We believe in developing not just academic skills, but also critical thinking, creativity, and strong moral values.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        With a track record of outstanding academic performance and well-rounded student development, Excellence Academy continues to be the preferred choice for parents seeking quality education for their children.
                    </p>
                </div>
                <div>
                    <img src="/placeholder.svg?height=400&width=600" alt="School Campus" class="rounded-lg shadow-xl w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Contact Information</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Address -->
                <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Address</h3>
                    <p class="text-gray-700"><?= $school['address'] ?? '' ?></p>
                </div>

                <!-- Phone & Email -->
                <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Phone & Email</h3>
                    <p class="text-gray-700">
                        <i class="fas fa-phone mr-2"></i><?= $school['phone'] ?? '' ?><br>
                        <i class="fas fa-envelope mr-2"></i><?= $school['email'] ?? '' ?><br>
                        <i class="fab fa-whatsapp mr-2"></i><?= $school['whatsapp_number'] ?? '' ?>
                    </p>
                </div>

                <!-- Social Media -->
                <div class="bg-white p-8 rounded-lg shadow-lg text-center">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-share-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Social Media</h3>
                    <div class="flex justify-center gap-4 mt-4">
                        <a href="<?= $school['facebook'] ?? '#' ?>" class="bg-blue-600 hover:bg-blue-700 w-12 h-12 rounded-full flex items-center justify-center transition text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="<?= $school['twitter'] ?? '#' ?>" class="bg-blue-400 hover:bg-blue-500 w-12 h-12 rounded-full flex items-center justify-center transition text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="<?= $school['instagram'] ?? '#' ?>" class="bg-pink-600 hover:bg-pink-700 w-12 h-12 rounded-full flex items-center justify-center transition text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Find Us</h2>
            <div class="bg-gray-300 h-96 rounded-lg shadow-lg flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-map-marked-alt text-6xl text-gray-500 mb-4"></i>
                    <p class="text-gray-700 font-semibold">Map Placeholder</p>
                    <p class="text-gray-600 text-sm">Embed Google Maps or other map service here</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Send Us a Message</h2>
            <form class="bg-white p-8 rounded-lg shadow-lg">
                <div class="mb-6">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Full Name</label>
                    <input type="text" id="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter your full name" required>
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email Address</label>
                    <input type="email" id="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter your email" required>
                </div>
                <div class="mb-6">
                    <label for="message" class="block text-gray-700 font-semibold mb-2">Message</label>
                    <textarea id="message" rows="6" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Write your message here..." required></textarea>
                </div>
                <button type="submit" class="w-full bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    Send Message
                </button>
            </form>
        </div>
    </section>

    <?php include(__DIR__ . '/../includes/footer.php') ?>

    <script src="<?= BASE_URL ?>/static/js/main.js"></script>

</body>

</html>