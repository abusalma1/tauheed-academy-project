<?php
$title = "Subject Results/Class";
include(__DIR__ . '/../../includes/header.php');

?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../../includes/nav.php');  ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-700  text-white py-16">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 flex items-center gap-3">
                </i>View Class Results
            </h1>
            <p class="text-xl text-blue-200">See students results per subject</p>
        </div>
    </section>

    <!-- Main Content -->
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
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Admission #</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Arm</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
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
                                            <i class="fas fa-eye"></i>View Details
                                        </a>
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

    <!-- Footer -->
    <?php include(__DIR__ . '/../../includes/footer.php'); ?>


    <script>
    </script>
</body>

</html>