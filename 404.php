<?php

$title = "404 Page Not Found";
include(__DIR__ .  '/./includes/header.php');


?>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/./includes/nav.php'); ?>

    <!-- 404 Content -->
    <section class="py-16 bg-white">

        <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-lg w-full text-center">
                <!-- Icon -->
                <div class="mb-8">
                    <i class="fas fa-exclamation-triangle text-6xl text-blue-900"></i>
                </div>

                <!-- 404 Text -->
                <h1 class="text-6xl font-bold text-blue-900 mb-2">404</h1>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Page Not Found</h2>

                <!-- Description -->
                <p class="text-gray-600 text-lg mb-2">Sorry, the page you are looking for doesn't exist or has been moved.</p>
                <p class="text-gray-500 text-base mb-8">The resource might have been deleted or the URL may be incorrect.</p>

                <!-- Search Icon and Text -->
                <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-8">
                    <i class="fas fa-search text-3xl text-blue-900 mb-3"></i>
                    <p class="text-gray-700">Try using the navigation menu or search for what you need</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/" class="inline-flex items-center justify-center gap-2 bg-blue-900 hover:bg-blue-950 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-home"></i>
                        Go to Home
                    </a>
                    <a href="/subjects.php" class="inline-flex items-center justify-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-900 font-bold py-3 px-6 rounded-lg transition duration-200">
                        <i class="fas fa-book"></i>
                        View Subjects
                    </a>
                </div>

                <!-- Additional Help -->
                <div class="mt-12 pt-8 border-t border-gray-300">
                    <p class="text-gray-600 text-sm mb-4">Need additional help?</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="mailto:support@school.edu" class="text-blue-900 hover:text-blue-950 font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-envelope"></i>
                            Contact Support
                        </a>
                        <span class="text-gray-400">|</span>
                        <a href="tel:+15551234567" class="text-blue-900 hover:text-blue-950 font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-phone"></i>
                            +1 (555) 123-4567
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