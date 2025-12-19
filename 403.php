<?php

$title = "403 Forbidden";
include(__DIR__ . '/./includes/header.php');

?>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/./includes/nav.php'); ?>

    <!-- 403 Content -->
    <section class="py-16 bg-white">

        <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-lg w-full text-center">
                <!-- Icon -->
                <div class="mb-8">
                    <i class="fas fa-ban text-6xl text-blue-900"></i>
                </div>

                <!-- 403 Text -->
                <h1 class="text-6xl font-bold text-blue-900 mb-2">403</h1>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Access Forbidden</h2>

                <!-- Description -->
                <p class="text-gray-600 text-lg mb-2">
                    You don’t have permission to access this resource.
                </p>
                <p class="text-gray-500 text-base mb-8">
                    This directory or page is restricted or does not allow direct access.
                </p>

                <!-- Info Box -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-8">
                    <i class="fas fa-lock text-3xl text-blue-900 mb-3"></i>
                    <p class="text-gray-700">
                        If you believe this is an error, please contact support.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="<?= route('home') ?>" class="inline-flex items-center justify-center gap-2 bg-blue-900 hover:bg-blue-950 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-home"></i>
                        Go to Home
                    </a>
                    <a href="<?= route('contact') ?>" class="inline-flex items-center justify-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-envelope"></i>
                        Contact Us
                    </a>
                </div>

                <!-- Additional Help -->
                <div class="mt-12 pt-8 border-t border-gray-300">
                    <p class="text-gray-600 text-sm mb-4">Need assistance?</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="mailto:<?= $school['email'] ?>" class="text-blue-900 hover:text-blue-950 font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-envelope"></i>
                            Contact Support
                        </a>
                        <span class="text-gray-400">|</span>
                        <a href="tel:<?= $school['phone'] ?>" class="text-blue-900 hover:text-blue-950 font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-phone"></i>
                            <?= $school['phone'] ?>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/./includes/footer.php'); ?>

</body>

</html>