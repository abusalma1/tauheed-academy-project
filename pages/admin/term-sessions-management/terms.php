<?php
// Sample data - replace with database queries
$terms = [
    ['id' => 1, 'name' => 'First Term', 'start_date' => '2024-09-01', 'end_date' => '2024-11-30', 'sessions' => 2],
    ['id' => 2, 'name' => 'Second Term', 'start_date' => '2024-12-01', 'end_date' => '2025-02-28', 'sessions' => 2],
    ['id' => 3, 'name' => 'Third Term', 'start_date' => '2025-03-01', 'end_date' => '2025-05-31', 'sessions' => 2],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Terms</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-blue-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="fas fa-book text-2xl"></i>
                <h1 class="text-2xl font-bold">School Management</h1>
            </div>
            <ul class="flex gap-6">
                <li><a href="sessions.php" class="hover:text-blue-200">Sessions</a></li>
                <li><a href="terms.php" class="hover:text-blue-200">Terms</a></li>
            </ul>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-blue-900 mb-2 flex items-center gap-2">
                <i class="fas fa-layer-group"></i> Academic Terms
            </h2>
            <p class="text-gray-600">Manage academic terms and their associated sessions</p>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Terms</p>
                        <p class="text-3xl font-bold text-blue-900"><?php echo count($terms); ?></p>
                    </div>
                    <i class="fas fa-layer-group text-4xl text-blue-100"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Avg Sessions per Term</p>
                        <p class="text-3xl font-bold text-blue-600"><?php echo round(array_sum(array_column($terms, 'sessions')) / count($terms)); ?></p>
                    </div>
                    <i class="fas fa-chart-bar text-4xl text-blue-50"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Sessions Linked</p>
                        <p class="text-3xl font-bold text-indigo-600"><?php echo array_sum(array_column($terms, 'sessions')); ?></p>
                    </div>
                    <i class="fas fa-link text-4xl text-indigo-100"></i>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="mb-6 flex gap-2">
            <a href="add-term.php" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Add New Term
            </a>
        </div>

        <!-- Terms Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Term Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Start Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">End Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Sessions</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Duration</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($terms as $term): 
                        $start = new DateTime($term['start_date']);
                        $end = new DateTime($term['end_date']);
                        $duration = $end->diff($start)->days;
                    ?>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-blue-900"><?php echo $term['name']; ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo date('M d, Y', strtotime($term['start_date'])); ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo date('M d, Y', strtotime($term['end_date'])); ?></td>
                        <td class="px-6 py-4">
                            <span class="bg-indigo-100 text-indigo-900 px-3 py-1 rounded-full text-sm font-medium">
                                <?php echo $term['sessions']; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <i class="fas fa-hourglass-end"></i> <?php echo $duration; ?> days
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="edit-term.php?id=<?php echo $term['id']; ?>" class="text-blue-600 hover:text-blue-900 transition">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="#" class="text-red-600 hover:text-red-900 transition">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
