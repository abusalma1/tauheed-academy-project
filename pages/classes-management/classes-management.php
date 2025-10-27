<?php

$title = "Classes Management";
include(__DIR__ . '/../../includes/header.php');

?>

<body class="bg-gray-50">
    <?php include(__DIR__ . '/./includes/classes-management-nav.php') ?>
    <!-- Page Header -->
    <section class="bg-green-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Classes by Section</h1>
            <p class="text-xl text-green-200">View all classes organized by educational sections</p>
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
                        <input type="text" id="searchInput" placeholder="Search by class name, teacher, or room..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-900">
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
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Classes</p>
                            <p class="text-3xl font-bold text-green-900" id="totalClassesStat">0</p>
                        </div>
                        <i class="fas fa-chalkboard text-4xl text-green-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Students</p>
                            <p class="text-3xl font-bold text-blue-900" id="totalStudentsStat">0</p>
                        </div>
                        <i class="fas fa-users text-4xl text-blue-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Active Classes</p>
                            <p class="text-3xl font-bold text-purple-900" id="activeClassesStat">0</p>
                        </div>
                        <i class="fas fa-check-circle text-4xl text-purple-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Sections</p>
                            <p class="text-3xl font-bold text-orange-900" id="totalSectionsStat">0</p>
                        </div>
                        <i class="fas fa-layer-group text-4xl text-orange-200"></i>
                    </div>
                </div>
            </div>

            <!-- Sections with Tables -->
            <div id="sectionsContainer" class="space-y-8">
                <!-- Sections will be dynamically generated here -->
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../../includes/footer.php');    ?>
    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Section definitions with colors
        const sections = [{
                name: 'Tahfeez',
                color: 'blue',
                icon: 'fa-quran'
            },
            {
                name: 'Nursery',
                color: 'pink',
                icon: 'fa-child'
            },
            {
                name: 'Primary',
                color: 'yellow',
                icon: 'fa-book'
            },
            {
                name: 'Junior Secondary',
                color: 'purple',
                icon: 'fa-graduation-cap'
            },
            {
                name: 'Senior Secondary',
                color: 'red',
                icon: 'fa-university'
            }
        ];

        let allClasses = JSON.parse(localStorage.getItem('schoolClasses')) || [];

        function getSectionFromClass(classLevel) {
            const level = classLevel.toLowerCase();
            if (level.includes('tahfeez')) return 'Tahfeez';
            if (level.includes('nursery') || level.includes('kg')) return 'Nursery';
            if (level.includes('primary') || level.includes('p')) return 'Primary';
            if (level.includes('jss')) return 'Junior Secondary';
            if (level.includes('sss')) return 'Senior Secondary';
            return 'Other';
        }

        function updateStats() {
            const total = allClasses.length;
            const totalEnrollment = allClasses.reduce((sum, c) => sum + (parseInt(c.enrollment) || 0), 0);
            const active = allClasses.filter(c => c.status === 'active').length;
            const uniqueSections = new Set(allClasses.map(c => getSectionFromClass(c.classLevel))).size;

            document.getElementById('totalClassesStat').textContent = total;
            document.getElementById('totalStudentsStat').textContent = totalEnrollment;
            document.getElementById('activeClassesStat').textContent = active;
            document.getElementById('totalSectionsStat').textContent = uniqueSections;
        }

        function renderSections() {
            const container = document.getElementById('sectionsContainer');
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const selectedSection = document.getElementById('sectionFilter').value;

            container.innerHTML = '';

            sections.forEach(section => {
                // Filter classes by section
                let sectionClasses = allClasses.filter(cls => {
                    const classSection = getSectionFromClass(cls.classLevel);
                    return classSection === section.name;
                });

                // Apply search filter
                if (searchTerm) {
                    sectionClasses = sectionClasses.filter(cls =>
                        cls.className.toLowerCase().includes(searchTerm) ||
                        cls.classTeacher.toLowerCase().includes(searchTerm) ||
                        cls.roomNumber.toLowerCase().includes(searchTerm)
                    );
                }

                // Apply section filter
                if (selectedSection && selectedSection !== section.name) {
                    return;
                }

                // Only show section if it has classes
                if (sectionClasses.length === 0 && !selectedSection) {
                    return;
                }

                const sectionDiv = document.createElement('div');
                sectionDiv.className = 'bg-white rounded-lg shadow-lg overflow-hidden';

                const headerColor = {
                    'blue': 'bg-blue-900',
                    'pink': 'bg-pink-900',
                    'yellow': 'bg-yellow-900',
                    'purple': 'bg-purple-900',
                    'red': 'bg-red-900'
                } [section.color];

                sectionDiv.innerHTML = `
                    <div class="${headerColor} text-white p-6 flex items-center gap-3">
                        <i class="fas ${section.icon} text-3xl opacity-80"></i>
                        <div>
                            <h2 class="text-2xl font-bold">${section.name}</h2>
                            <p class="text-sm opacity-90">${sectionClasses.length} class${sectionClasses.length !== 1 ? 'es' : ''}</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-100 border-b-2 border-gray-300">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Class Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Class Teacher</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Enrollment</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Capacity</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Room</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                ${sectionClasses.length === 0 ? `
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">No classes in this section</td>
                                    </tr>
                                ` : sectionClasses.map((cls, index) => `
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">${cls.className}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">${cls.classTeacher}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">${cls.enrollment || 0}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">${cls.capacity}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">${cls.roomNumber || '-'}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-3 py-1 ${cls.status === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900'} rounded-full text-xs font-semibold capitalize">${cls.status}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <a href="class-update.html?class=${encodeURIComponent(cls.className)}" class="text-blue-600 hover:text-blue-900 font-semibold">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button onclick="deleteClass('${cls.className}')" class="text-red-600 hover:text-red-900 font-semibold">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                `;

                container.appendChild(sectionDiv);
            });

            if (container.children.length === 0) {
                container.innerHTML = `
                    <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                        <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                        <p class="text-xl text-gray-500">No classes found matching your search criteria</p>
                    </div>
                `;
            }
        }

        function deleteClass(className) {
            if (confirm(`Are you sure you want to delete the class "${className}"?`)) {
                allClasses = allClasses.filter(c => c.className !== className);
                localStorage.setItem('schoolClasses', JSON.stringify(allClasses));
                renderSections();
                updateStats();
            }
        }

        // Event listeners
        document.getElementById('searchInput').addEventListener('input', renderSections);
        document.getElementById('sectionFilter').addEventListener('change', renderSections);

        // Initial render
        renderSections();
        updateStats();
    </script>
</body>

</html>