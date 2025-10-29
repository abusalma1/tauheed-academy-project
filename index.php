<?php
$title = 'Dashboard';

include(__DIR__ .  '/./includes/header.php');

?>

<body class="bg-gray-50">

    <?php include(__DIR__ .  '/./includes/nav.php'); ?>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <img src="/placeholder.svg?height=120&width=120" alt="School Logo" class="h-32 w-32 mx-auto mb-6 bg-white rounded-full p-3">
            <h1 class="text-4xl md:text-6xl font-bold mb-4">Tauheed Academy</h1>
            <p class="text-xl md:text-2xl text-blue-200 mb-8">Nurturing Future Leaders Through Quality Education</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="pages/admissions.html" class="bg-white text-blue-900 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">Apply Now</a>
                <a href="pages/about.html" class="bg-blue-800 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-900 transition">Learn More</a>
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
                <a href="pages/admissions.html" class="bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg">
                    <i class="fas fa-user-plus text-4xl mb-3"></i>
                    <p class="font-semibold">Admissions</p>
                </a>
                <a href="pages/fees.html" class="bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg">
                    <i class="fas fa-money-bill-wave text-4xl mb-3"></i>
                    <p class="font-semibold">Fees</p>
                </a>
                <a href="pages/timetable.html" class="bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg">
                    <i class="fas fa-calendar-alt text-4xl mb-3"></i>
                    <p class="font-semibold">Timetable</p>
                </a>
                <a href="pages/academics.html" class="bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg">
                    <i class="fas fa-graduation-cap text-4xl mb-3"></i>
                    <p class="font-semibold">Results</p>
                </a>
                <a href="pages/about.html" class="bg-blue-900 text-white p-6 rounded-lg text-center hover:bg-blue-800 transition shadow-lg">
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