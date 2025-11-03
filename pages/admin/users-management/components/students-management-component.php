<!-- Students Section -->
<div id="students-section" class="user-section hidden">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Students</h2>

    <!-- Student Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Total Students</p>
            <p class="text-2xl font-bold text-indigo-900">16</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Active</p>
            <p class="text-2xl font-bold text-green-600">16</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Classes</p>
            <p class="text-2xl font-bold text-orange-600">10</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-gray-600 text-sm">Sections</p>
            <p class="text-2xl font-bold text-pink-600">5</p>
        </div>
    </div>

    <!-- Student Section Filter -->
    <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Filter by Section</label>
        <select id="sectionFilter" class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
            <option value="">All Sections</option>
            <?php foreach ($sections as $section) : ?>
                <option value="<?= $section['section_name'] ?>"><?= $section['section_name'] ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <!-- Students by Section - Hardcoded HTML -->
    <div id="studentsBySectionContainer" class="space-y-8">

        <?php foreach ($sections as $section) : ?>
            <div class="student-section-group bg-white rounded-lg shadow-lg overflow-hidden" data-section="<?= strtolower(str_replace(' ', '-', $section['section_name'])) ?>">

                <div class="bg-gradient-to-r from-orange-900 to-orange-700 text-white p-6">
                    <h3 class="text-2xl font-bold"><?= $section['section_name'] ?></h3>
                    <p class="text-sm opacity-90"><?= count($section['students']) ?> students</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Admission #</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Class</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Arm</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($section['students'] as $student) : ?>
                                <tr class="border-b hover:bg-gray-50 student-row" data-search="<?= $student['student_name'] . ' ' . $student['admission_number'] ?>">
                                    <td class="px-6 py-4 text-sm text-gray-900"><?= $student['student_name'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= $student['admission_number'] ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= $student['class_name'] ?></td>
                                    <td class="px-6 py-4 text-sm"><span class="px-3 py-1 bg-blue-100 text-blue-900 rounded-full text-xs font-semibold"><?= $student['arm_name'] ?></span></td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="px-3 py-1 <?= $student['status'] === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900' ?> rounded-full text-xs font-semibold capitalize"><?= $student['status'] ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-sm space-x-2">
                                        <a href="<?= route('student-update') . '?id=' . $student['student_id'] ?>" class="text-green-600 hover:text-green-800 font-semibold"><button class="text-blue-600 hover:text-blue-900 font-semibold">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <a href="delete-confirmation.html?type=student&id=12" class="text-red-600 hover:text-red-800 font-semibold"><button class="text-red-600 hover:text-red-900 font-semibold">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button></a></a>
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