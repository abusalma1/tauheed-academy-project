<?php
$title = 'Gallery';

include(__DIR__ .  '/../includes/header.php');
?>

<body class="bg-gray-50">
    <?php include(__DIR__ .  '/../includes/nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Photo Gallery</h1>
            <p class="text-xl text-blue-200">Capturing Moments of Excellence</p>
        </div>
    </section>

    <!-- Gallery Categories -->
    <section class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center gap-4">
                <button onclick="filterGallery('all')" class="filter-btn bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    All Photos
                </button>
                <button onclick="filterGallery('facilities')" class="filter-btn bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Facilities
                </button>
                <button onclick="filterGallery('classrooms')" class="filter-btn bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Classrooms
                </button>
                <button onclick="filterGallery('events')" class="filter-btn bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Events
                </button>
                <button onclick="filterGallery('sports')" class="filter-btn bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Sports
                </button>
                <button onclick="filterGallery('activities')" class="filter-btn bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition">
                    Activities
                </button>
            </div>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="gallery-grid">
                Facilities
                <div class="gallery-item facilities cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="School Building" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Main School Building</p>
                            <p class="text-white text-sm">Our modern educational facility</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item facilities cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Library" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">School Library</p>
                            <p class="text-white text-sm">Well-stocked with educational resources</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item facilities cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Laboratory" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Science Laboratory</p>
                            <p class="text-white text-sm">State-of-the-art lab equipment</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item facilities cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Computer Lab" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Computer Laboratory</p>
                            <p class="text-white text-sm">Modern computing facilities</p>
                        </div>
                    </div>
                </div>

                Classrooms
                <div class="gallery-item classrooms cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Classroom" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Primary Classroom</p>
                            <p class="text-white text-sm">Bright and spacious learning environment</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item classrooms cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Secondary Classroom" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Secondary Classroom</p>
                            <p class="text-white text-sm">Equipped with modern teaching aids</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item classrooms cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Teaching Session" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Interactive Learning</p>
                            <p class="text-white text-sm">Engaging classroom sessions</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item classrooms cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Students Learning" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Focused Learning</p>
                            <p class="text-white text-sm">Students engaged in studies</p>
                        </div>
                    </div>
                </div>

                Events
                <div class="gallery-item events cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Graduation" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Graduation Ceremony</p>
                            <p class="text-white text-sm">Celebrating academic achievements</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item events cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Cultural Day" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Cultural Day</p>
                            <p class="text-white text-sm">Celebrating diversity and culture</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item events cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Assembly" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Morning Assembly</p>
                            <p class="text-white text-sm">Daily gathering and announcements</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item events cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Awards" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Awards Ceremony</p>
                            <p class="text-white text-sm">Recognizing excellence</p>
                        </div>
                    </div>
                </div>

                Sports
                <div class="gallery-item sports cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Football" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Football Match</p>
                            <p class="text-white text-sm">Inter-house sports competition</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item sports cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Athletics" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Athletics Day</p>
                            <p class="text-white text-sm">Track and field events</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item sports cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Basketball" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Basketball Tournament</p>
                            <p class="text-white text-sm">School sports competition</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item sports cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Sports Field" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Sports Field</p>
                            <p class="text-white text-sm">Our expansive sports facilities</p>
                        </div>
                    </div>
                </div>

                Activities
                <div class="gallery-item activities cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Science Fair" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Science Fair</p>
                            <p class="text-white text-sm">Student experiments and projects</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item activities cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Art Class" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Art & Creativity</p>
                            <p class="text-white text-sm">Creative arts session</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item activities cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Music" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Music Performance</p>
                            <p class="text-white text-sm">School choir and band</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item activities cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Drama" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Drama Club</p>
                            <p class="text-white text-sm">Annual drama presentation</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item activities cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Excursion" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Educational Excursion</p>
                            <p class="text-white text-sm">Learning beyond the classroom</p>
                        </div>
                    </div>
                </div>

                <div class="gallery-item activities cursor-pointer" onclick="openModal(this)">
                    <div class="relative overflow-hidden rounded-lg shadow-lg group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Reading" class="w-full h-64 object-cover group-hover:scale-110 transition duration-300">
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                            <p class="text-white font-semibold">Reading Club</p>
                            <p class="text-white text-sm">Promoting literacy and learning</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Modal -->
    <div id="imageModal" class="modal" onclick="closeModal()">
        <span class="absolute top-4 right-8 text-white text-5xl font-bold cursor-pointer hover:text-gray-300">&times;</span>
        <img class="modal-content" id="modalImage" onclick="event.stopPropagation()">
    </div>

    <?php include(__DIR__ . '/../includes/footer.php') ?>

</body>

</html>