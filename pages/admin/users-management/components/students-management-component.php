<!-- Students Section -->
<div id="students-section" class="user-section hidden">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Students</h2>

    <!-- Student Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Total Students</p>
            <p class="text-2xl font-bold text-indigo-900"><?= $studentsCount ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Active</p>
            <p class="text-2xl font-bold text-green-600"><?= $totalActiveStudents ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Classes</p>
            <p class="text-2xl font-bold text-orange-600"><?= $classesCount ?></p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Arms</p>
            <p class="text-2xl font-bold text-pink-600"><?= $armsCount ?></p>
        </div>
    </div>

    <!-- Class Filter -->
    <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Filter by Class</label>
        <select id="classFilter" class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
            <option value="">All Classes</option>
            <?php foreach ($classes as $class): ?>
                <option value="<?= strtolower(str_replace(' ', '-', $class['class_name'])) ?>">
                    <?= $class['class_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Students by Class -->
    <div id="studentsByClassContainer" class="space-y-8">
        <?php foreach ($classes as $class): ?>
            <div class="student-class-group bg-white rounded-lg shadow-lg overflow-hidden" data-class="<?= strtolower(str_replace(' ', '-', $class['class_name'])) ?>">
                <div class="bg-gradient-to-r from-orange-900 to-orange-700 text-white p-6">
                    <h3 class="text-2xl font-bold"><?= $class['class_name'] ?></h3>
                    <p class="text-sm opacity-90"><?= count($class['students']) ?> students</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Name</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Admission #</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Arm</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($class['students'] as $student): ?>
                                <tr class="border-b hover:bg-gray-50 student-row" data-search="<?= $student['student_name'] . ' ' . $student['admission_number'] ?>">
                                    <td class="px-6 py-4 text-sm text-gray-900"><?= $student['student_name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= $student['admission_number'] ?></td>
                                    <td class="px-6 py-4 text-sm"><span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold"><?= $student['arm_name'] ?></span></td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1 <?= $student['status'] === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900' ?> rounded-full text-xs font-semibold capitalize"><?= $student['status'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-sm space-x-2">
                                        <a href="<?= route('update-user-password') . '?id=' . $student['student_id']  . '&user_type=student' ?>" class="text-blue-600 hover:text-blue-800 font-semibold">
                                            <i class="fas fa-lock"></i> Edit Password
                                        </a>
                                        <a href="<?= route('student-update') . '?id=' . $student['student_id'] ?>" class="text-green-600 hover:text-green-800 font-semibold">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= route('view-user-details') . '?id=' . $student['student_id'] . '&type=student' ?>" class="text-purple-600 hover:text-green-800 font-semibold">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                        <!-- Results Dropdown -->
                                        <div class="relative inline-block text-left">
                                            <!-- Trigger link -->
                                            <a href="#"
                                                onclick="toggleResultsDropdown(event)"
                                                class="text-purple-600 hover:text-green-800 font-semibold flex items-center">
                                                <i class="fas fa-eye mr-2"></i> View Results
                                                <svg class="ml-1 h-4 w-4 text-purple-600 hover:text-green-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </a>

                                            <!-- Dropdown menu -->
                                            <div id="resultsDropdown"
                                                class="absolute mt-2 w-56 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 scale-95 pointer-events-none transition ease-out duration-200 z-10">
                                                <div class="py-2">
                                                    <a href="<?= route('admin-student-result') . '?id=' . $student['student_id'] ?>"
                                                        class="block px-4 py-2 text-sm text-purple-600 hover:bg-gray-100 hover:text-green-800 font-semibold">
                                                        <i class="fas fa-list mr-2"></i> General Result History
                                                    </a>
                                                    <a href="<?= route('admin-student-islamiyya-result') . '?id=' . $student['student_id'] ?>"
                                                        class="block px-4 py-2 text-sm text-purple-600 hover:bg-gray-100 hover:text-green-800 font-semibold">
                                                        <i class="fas fa-book-quran mr-2"></i> Islamiyya Result History
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="<?= route('delete-user') . '?id=' . $student['student_id'] ?>&table=students&type=Student" class="text-red-600 hover:text-red-800 font-semibold">
                                            <i class="fas fa-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


<script>
    function toggleResultsDropdown(e) {
        e.preventDefault();
        const dropdown = document.getElementById('resultsDropdown');
        const isOpen = !dropdown.classList.contains('pointer-events-none');

        if (isOpen) {
            closeResultsDropdown();
        } else {
            dropdown.classList.remove('opacity-0', 'scale-95', 'pointer-events-none');
            dropdown.classList.add('opacity-100', 'scale-100');
        }
    }

    // Close dropdown with transition
    function closeResultsDropdown() {
        const dropdown = document.getElementById('resultsDropdown');
        dropdown.classList.remove('opacity-100', 'scale-100');
        dropdown.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
    }

    // Close when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('resultsDropdown');
        const trigger = event.target.closest('a[href="#"]');
        const insideDropdown = event.target.closest('#resultsDropdown');

        if (!insideDropdown && !trigger) {
            closeResultsDropdown();
        }
    });
</script>