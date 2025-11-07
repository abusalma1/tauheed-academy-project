<?php
// Sample data - replace with database queries
$sessions = [
    ['id' => 1, 'name' => '2024/2025', 'start_date' => '2024-09-01', 'end_date' => '2025-08-31', 'status' => 'Active', 'terms' => 3],
    ['id' => 2, 'name' => '2023/2024', 'start_date' => '2023-09-01', 'end_date' => '2024-08-31', 'status' => 'Completed', 'terms' => 3],
    ['id' => 3, 'name' => '2025/2026', 'start_date' => '2025-09-01', 'end_date' => '2026-08-31', 'status' => 'Pending', 'terms' => 0],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Sessions</title>
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
                <li><a href="#" class="hover:text-blue-200">Dashboard</a></li>
                <li><a href="sessions.php" class="hover:text-blue-200">Sessions</a></li>
                <li><a href="terms.php" class="hover:text-blue-200">Terms</a></li>
                <li><a href="classes.php" class="hover:text-blue-200">Classes</a></li>
            </ul>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-blue-900 mb-2 flex items-center gap-2">
                <i class="fas fa-calendar"></i> Academic Sessions
            </h2>
            <p class="text-gray-600">Manage academic sessions and their associated terms</p>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Sessions</p>
                        <p class="text-3xl font-bold text-blue-900"><?php echo count($sessions); ?></p>
                    </div>
                    <i class="fas fa-calendar text-4xl text-blue-100"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Active Sessions</p>
                        <p class="text-3xl font-bold text-green-600"><?php echo count(array_filter($sessions, fn($s) => $s['status'] === 'Active')); ?></p>
                    </div>
                    <i class="fas fa-check-circle text-4xl text-green-100"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Pending Sessions</p>
                        <p class="text-3xl font-bold text-orange-600"><?php echo count(array_filter($sessions, fn($s) => $s['status'] === 'Pending')); ?></p>
                    </div>
                    <i class="fas fa-clock text-4xl text-orange-100"></i>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-gray-400">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Terms</p>
                        <p class="text-3xl font-bold text-gray-600"><?php echo array_sum(array_column($sessions, 'terms')); ?></p>
                    </div>
                    <i class="fas fa-layer-group text-4xl text-gray-100"></i>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="mb-6 flex gap-2">
            <a href="add-session.php" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition flex items-center gap-2">
                <i class="fas fa-plus"></i> Add New Session
            </a>
        </div>

        <!-- Sessions Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Session Name</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Start Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">End Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Terms</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($sessions as $session): ?>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-medium text-blue-900"><?php echo $session['name']; ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo date('M d, Y', strtotime($session['start_date'])); ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo date('M d, Y', strtotime($session['end_date'])); ?></td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-900 px-3 py-1 rounded-full text-sm font-medium">
                                <?php echo $session['terms']; ?> Terms
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                <?php echo $session['status'] === 'Active' ? 'bg-green-100 text-green-700' : 
                                      ($session['status'] === 'Pending' ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700'); ?>">
                                <i class="fas fa-<?php echo $session['status'] === 'Active' ? 'check-circle' : 
                                      ($session['status'] === 'Pending' ? 'clock' : 'archive'); ?>"></i>
                                <?php echo $session['status']; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="session-terms.php?session_id=<?php echo $session['id']; ?>" class="text-blue-600 hover:text-blue-900 transition">
                                <i class="fas fa-link"></i> Manage Terms
                            </a>
                            <a href="edit-session.php?id=<?php echo $session['id']; ?>" class="text-blue-600 hover:text-blue-900 transition">
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
