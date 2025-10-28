<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes by Section - Excellence Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-900 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <img src="/placeholder.svg?height=50&width=50" alt="School Logo" class="h-12 w-12 rounded-full bg-white p-1">
                    <div>
                        <h1 class="text-xl font-bold">Excellence Academy</h1>
                        <p class="text-xs text-blue-200">Admin Panel</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-6">
                    <a href="class-management.html" class="hover:text-blue-300 transition">Add Class</a>
                    <a href="classes-sections-arms-management.html" class="hover:text-blue-300 transition">Management</a>
                    <a href="../index.html" class="hover:text-blue-300 transition">Back to Site</a>
                </div>
                <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-blue-800 px-4 py-4 space-y-2">
            <a href="class-management.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Add Class</a>
            <a href="classes-sections-arms-management.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Management</a>
            <a href="../index.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Back to Site</a>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Classes by Section</h1>
            <p class="text-xl text-green-200">View all classes organized by educational sections with their arms</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Bar -->
            <div class="mb-8 bg-white rounded-lg shadow-lg p-6">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <label for="searchInput" class="block text-sm font-semibold text-gray-700 mb-2">Search Classes</label>
                        <input type="text" id="searchInput" placeholder="Search by class name, arm, or teacher..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                    </div>
                    <div class="flex-1">
                        <label for="sectionFilter" class="block text-sm font-semibold text-gray-700 mb-2">Filter by Section</label>
                        <select id="sectionFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
                            <option value="">All Sections</option>
                            <option value="Tahfeez">Tahfeez</option>
                            <option value="Nursery">Nursery</option>
                            <option value="Primary">Primary</option>
                            <option value="Junior Secondary">Junior Secondary</option>
                            <option value="Senior Secondary">Senior Secondary</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <a href="class-management.html" class="w-full md:w-auto bg-green-900 hover:bg-green-800 text-white font-semibold py-2 px-6 rounded-lg transition flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i> Create Class
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Classes</p>
                            <p class="text-3xl font-bold text-green-900">16</p>
                        </div>
                        <i class="fas fa-chalkboard text-4xl text-green-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Arms</p>
                            <p class="text-3xl font-bold text-blue-900">42</p>
                        </div>
                        <i class="fas fa-sitemap text-4xl text-blue-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Students</p>
                            <p class="text-3xl font-bold text-purple-900">611</p>
                        </div>
                        <i class="fas fa-users text-4xl text-purple-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Sections</p>
                            <p class="text-3xl font-bold text-orange-900">5</p>
                        </div>
                        <i class="fas fa-layer-group text-4xl text-orange-200"></i>
                    </div>
                </div>
            </div>

            <!-- Sections with Classes and Arms -->
            <div id="sectionsContainer" class="space-y-8">
                <!-- TAHFEEZ SECTION -->
                <div class="section-container bg-white rounded-lg shadow-lg overflow-hidden" data-section="Tahfeez">
                    <div class="bg-blue-900 text-white p-6 flex items-center gap-3">
                        <i class="fas fa-quran text-3xl opacity-80"></i>
                        <div>
                            <h2 class="text-2xl font-bold">Tahfeez</h2>
                            <p class="text-sm opacity-90">2 classes</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Tahfeez 1 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="Tahfeez 1" data-teacher="Ustaz Ahmed" data-arms="A,B">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Tahfeez 1</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Ustaz Ahmed</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">28/30</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">2</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">30</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold">A</span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold">B</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=Tahfeez%201" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=Tahfeez%201" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Tahfeez 2 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="Tahfeez 2" data-teacher="Ustaz Ibrahim" data-arms="A,B,C">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Tahfeez 2</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Ustaz Ibrahim</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">25/30</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">3</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">30</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold">A</span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold">B</span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold">C</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=Tahfeez%202" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=Tahfeez%202" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- NURSERY SECTION -->
                <div class="section-container bg-white rounded-lg shadow-lg overflow-hidden" data-section="Nursery">
                    <div class="bg-pink-900 text-white p-6 flex items-center gap-3">
                        <i class="fas fa-child text-3xl opacity-80"></i>
                        <div>
                            <h2 class="text-2xl font-bold">Nursery</h2>
                            <p class="text-sm opacity-90">2 classes</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Nursery A -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="Nursery A" data-teacher="Miss Fatima" data-arms="Gold,Silver">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Nursery A</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Miss Fatima</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">24/25</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">2</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">25</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-pink-100 text-pink-900 rounded-full text-xs font-semibold">Gold</span>
                                        <span class="px-3 py-1 bg-pink-100 text-pink-900 rounded-full text-xs font-semibold">Silver</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=Nursery%20A" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=Nursery%20A" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Nursery B -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="Nursery B" data-teacher="Miss Aisha" data-arms="Gold,Silver,Bronze">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Nursery B</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Miss Aisha</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">22/25</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">3</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">25</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-pink-100 text-pink-900 rounded-full text-xs font-semibold">Gold</span>
                                        <span class="px-3 py-1 bg-pink-100 text-pink-900 rounded-full text-xs font-semibold">Silver</span>
                                        <span class="px-3 py-1 bg-pink-100 text-pink-900 rounded-full text-xs font-semibold">Bronze</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=Nursery%20B" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=Nursery%20B" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PRIMARY SECTION -->
                <div class="section-container bg-white rounded-lg shadow-lg overflow-hidden" data-section="Primary">
                    <div class="bg-yellow-900 text-white p-6 flex items-center gap-3">
                        <i class="fas fa-book text-3xl opacity-80"></i>
                        <div>
                            <h2 class="text-2xl font-bold">Primary</h2>
                            <p class="text-sm opacity-90">6 classes</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Primary 1 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="Primary 1" data-teacher="Mr. Hassan" data-arms="A,B,C">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Primary 1</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Mr. Hassan</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">38/40</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">3</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">40</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">A</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">B</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">C</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=Primary%201" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=Primary%201" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Primary 2 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="Primary 2" data-teacher="Mrs. Zainab" data-arms="A,B">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Primary 2</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Mrs. Zainab</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">36/40</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">2</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">40</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">A</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">B</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=Primary%202" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=Primary%202" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Primary 3 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="Primary 3" data-teacher="Mr. Karim" data-arms="A,B,C,D">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Primary 3</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Mr. Karim</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">39/40</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">4</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">40</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">A</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">B</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">C</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">D</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=Primary%203" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=Primary%203" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Primary 4 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="Primary 4" data-teacher="Miss Hana" data-arms="A,B">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Primary 4</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Miss Hana</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">35/40</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">2</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">40</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">A</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">B</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=Primary%204" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=Primary%204" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Primary 5 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="Primary 5" data-teacher="Mr. Salim" data-arms="A,B,C">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Primary 5</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Mr. Salim</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">37/40</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">3</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">40</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">A</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">B</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">C</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=Primary%205" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=Primary%205" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Primary 6 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="Primary 6" data-teacher="Mrs. Layla" data-arms="A,B,C,D">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">Primary 6</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Mrs. Layla</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">40/40</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">4</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">40</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">A</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">B</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">C</span>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">D</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=Primary%206" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=Primary%206" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- JUNIOR SECONDARY SECTION -->
                <div class="section-container bg-white rounded-lg shadow-lg overflow-hidden" data-section="Junior Secondary">
                    <div class="bg-purple-900 text-white p-6 flex items-center gap-3">
                        <i class="fas fa-graduation-cap text-3xl opacity-80"></i>
                        <div>
                            <h2 class="text-2xl font-bold">Junior Secondary</h2>
                            <p class="text-sm opacity-90">3 classes</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- JSS 1 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="JSS 1" data-teacher="Mr. Rashid" data-arms="Orange,Blue,Red">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">JSS 1</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Mr. Rashid</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">42/45</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">3</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">45</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-orange-100 text-orange-900 rounded-full text-xs font-semibold">Orange</span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold">Blue</span>
                                        <span class="px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-semibold">Red</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=JSS%201" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=JSS%201" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- JSS 2 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="JSS 2" data-teacher="Mrs. Noor" data-arms="Orange,Blue,Red,Green">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">JSS 2</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Mrs. Noor</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">44/45</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">4</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">45</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-orange-100 text-orange-900 rounded-full text-xs font-semibold">Orange</span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold">Blue</span>
                                        <span class="px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-semibold">Red</span>
                                        <span class="px-3 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Green</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=JSS%202" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=JSS%202" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- JSS 3 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="JSS 3" data-teacher="Mr. Tariq" data-arms="Orange,Blue">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">JSS 3</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Mr. Tariq</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">41/45</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">2</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">45</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-orange-100 text-orange-900 rounded-full text-xs font-semibold">Orange</span>
                                        <span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold">Blue</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=JSS%203" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=JSS%203" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SENIOR SECONDARY SECTION -->
                <div class="section-container bg-white rounded-lg shadow-lg overflow-hidden" data-section="Senior Secondary">
                    <div class="bg-red-900 text-white p-6 flex items-center gap-3">
                        <i class="fas fa-university text-3xl opacity-80"></i>
                        <div>
                            <h2 class="text-2xl font-bold">Senior Secondary</h2>
                            <p class="text-sm opacity-90">3 classes</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- SSS 1 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="SSS 1" data-teacher="Dr. Amina" data-arms="Science,Arts">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">SSS 1</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Dr. Amina</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">48/50</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">2</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">50</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-semibold">Science</span>
                                        <span class="px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-semibold">Arts</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=SSS%201" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=SSS%201" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- SSS 2 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="SSS 2" data-teacher="Prof. Malik" data-arms="Science,Arts,Commercial">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">SSS 2</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Prof. Malik</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">46/50</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">3</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">50</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-semibold">Science</span>
                                        <span class="px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-semibold">Arts</span>
                                        <span class="px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-semibold">Commercial</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=SSS%202" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=SSS%202" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- SSS 3 -->
                        <div class="class-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition" data-class-name="SSS 3" data-teacher="Mr. Jamal" data-arms="Science,Arts">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2">SSS 3</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Teacher</p>
                                            <p class="font-semibold text-gray-900">Mr. Jamal</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Enrollment</p>
                                            <p class="font-semibold text-gray-900">50/50</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Arms</p>
                                            <p class="font-semibold text-gray-900">2</p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Capacity</p>
                                            <p class="font-semibold text-gray-900">50</p>
                                        </div>
                                    </div>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-semibold">Science</span>
                                        <span class="px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-semibold">Arts</span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2 md:w-auto">
                                    <a href="class-update.html?class=SSS%203" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-edit"></i> Update
                                    </a>
                                    <a href="delete-confirmation.html?type=class&name=SSS%203" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Excellence Academy</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Committed to providing quality education and nurturing future leaders.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="../index.html" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="class-management.html" class="text-gray-400 hover:text-white transition">Add Class</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><i class="fas fa-map-marker-alt mr-2"></i>123 Education Street, City</li>
                        <li><i class="fas fa-phone mr-2"></i>+234 800 123 4567</li>
                        <li><i class="fas fa-envelope mr-2"></i>info@excellenceacademy.edu</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Follow Us</h3>
                    <div class="flex gap-4">
                        <a href="#" class="bg-blue-600 hover:bg-blue-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-blue-400 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-pink-600 hover:bg-pink-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2025 Excellence Academy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        function filterClasses() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const selectedSection = document.getElementById('sectionFilter').value;

            const sections = document.querySelectorAll('.section-container');
            let visibleSections = 0;

            sections.forEach(section => {
                const sectionName = section.getAttribute('data-section');

                // Filter by section if selected
                if (selectedSection && selectedSection !== sectionName) {
                    section.style.display = 'none';
                    return;
                }

                const classItems = section.querySelectorAll('.class-item');
                let visibleClasses = 0;

                classItems.forEach(classItem => {
                    const className = classItem.getAttribute('data-class-name').toLowerCase();
                    const teacher = classItem.getAttribute('data-teacher').toLowerCase();
                    const arms = classItem.getAttribute('data-arms').toLowerCase();

                    const matches = className.includes(searchTerm) ||
                        teacher.includes(searchTerm) ||
                        arms.includes(searchTerm);

                    classItem.style.display = matches ? 'block' : 'none';
                    if (matches) visibleClasses++;
                });

                section.style.display = visibleClasses > 0 ? 'block' : 'none';
                if (visibleClasses > 0) visibleSections++;
            });

            // Show "no results" message if needed
            const container = document.getElementById('sectionsContainer');
            const noResults = container.querySelector('.no-results');
            if (visibleSections === 0) {
                if (!noResults) {
                    const noResultsDiv = document.createElement('div');
                    noResultsDiv.className = 'no-results bg-white rounded-lg shadow-lg p-12 text-center';
                    noResultsDiv.innerHTML = `
                        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                        <p class="text-xl text-gray-500">No classes found matching your search criteria</p>
                    `;
                    container.appendChild(noResultsDiv);
                }
            } else {
                if (noResults) noResults.remove();
            }
        }

        // Event listeners
        document.getElementById('searchInput').addEventListener('input', filterClasses);
        document.getElementById('sectionFilter').addEventListener('change', filterClasses);
    </script>
</body>

</html>