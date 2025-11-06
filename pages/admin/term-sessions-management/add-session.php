<?php
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $status = $_POST['status'] ?? 'Pending';

    if (empty($name)) $errors[] = 'Session name is required';
    if (empty($start_date)) $errors[] = 'Start date is required';
    if (empty($end_date)) $errors[] = 'End date is required';
    if (!empty($start_date) && !empty($end_date) && $start_date >= $end_date) {
        $errors[] = 'End date must be after start date';
    }

    if (empty($errors)) {
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Session</title>
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

    <div class="max-w-2xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="sessions.php" class="text-blue-600 hover:text-blue-900 mb-4 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Sessions
            </a>
            <h2 class="text-3xl font-bold text-blue-900 mb-2 flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Add New Session
            </h2>
            <p class="text-gray-600">Create a new academic session</p>
        </div>

        <!-- Success Message -->
        <?php if ($success): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600"></i>
                <p class="text-green-700 font-medium">Session created successfully!</p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Error Messages -->
        <?php if (!empty($errors)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="mb-2 flex items-center gap-2">
                <i class="fas fa-exclamation-circle text-red-600"></i>
                <p class="text-red-700 font-semibold">Please fix the following errors:</p>
            </div>
            <ul class="text-red-600 ml-6 space-y-1">
                <?php foreach($errors as $error): ?>
                <li>• <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow p-8">
            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-blue-900 mb-2">
                        <i class="fas fa-heading"></i> Session Name
                    </label>
                    <input type="text" name="name" placeholder="e.g., 2024/2025" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-900"
                           value="<?php echo $_POST['name'] ?? ''; ?>">
                    <p class="text-xs text-gray-500 mt-1">Enter session in format: YYYY/YYYY</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-2">
                            <i class="fas fa-calendar-check"></i> Start Date
                        </label>
                        <input type="date" name="start_date" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-900"
                               value="<?php echo $_POST['start_date'] ?? ''; ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-2">
                            <i class="fas fa-calendar-times"></i> End Date
                        </label>
                        <input type="date" name="end_date" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-900"
                               value="<?php echo $_POST['end_date'] ?? ''; ?>">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-blue-900 mb-2">
                        <i class="fas fa-toggle-on"></i> Status
                    </label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-900">
                        <option value="Pending" <?php echo ($_POST['status'] ?? '') === 'Pending' ? 'selected' : ''; ?>>Pending</option>
                        <option value="Active" <?php echo ($_POST['status'] ?? '') === 'Active' ? 'selected' : ''; ?>>Active</option>
                        <option value="Completed" <?php echo ($_POST['status'] ?? '') === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-blue-900 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition font-medium flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Create Session
                    </button>
                    <a href="sessions.php" class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-medium flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
