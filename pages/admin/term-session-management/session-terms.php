<?php
$session_id = $_GET['session_id'] ?? 1;

// Sample data
$session = ['id' => 1, 'name' => '2024/2025', 'start_date' => '2024-09-01', 'end_date' => '2025-08-31'];
$all_terms = [
    ['id' => 1, 'name' => 'First Term', 'start_date' => '2024-09-01', 'end_date' => '2024-11-30'],
    ['id' => 2, 'name' => 'Second Term', 'start_date' => '2024-12-01', 'end_date' => '2025-02-28'],
    ['id' => 3, 'name' => 'Third Term', 'start_date' => '2025-03-01', 'end_date' => '2025-05-31'],
];
$linked_terms = [1, 2, 3]; // IDs of terms linked to this session

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $linked_terms = $_POST['terms'] ?? [];
    $success = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Session Terms</title>
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
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="sessions.php" class="text-blue-600 hover:text-blue-900 mb-4 inline-flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Back to Sessions
            </a>
            <h2 class="text-3xl font-bold text-blue-900 mb-2 flex items-center gap-2">
                <i class="fas fa-link"></i> Manage Terms for <?php echo $session['name']; ?>
            </h2>
            <p class="text-gray-600">Link academic terms to this session (many-to-many relationship)</p>
        </div>

        <!-- Success Message -->
        <?php if ($success): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
            <div class="flex items-center gap-2">
                <i class="fas fa-check-circle text-green-600"></i>
                <p class="text-green-700 font-medium">Terms updated successfully!</p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Session Info -->
        <div class="bg-blue-50 border-l-4 border-blue-900 p-6 mb-8 rounded">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-blue-600">Session Name</p>
                    <p class="text-lg font-semibold text-blue-900"><?php echo $session['name']; ?></p>
                </div>
                <div>
                    <p class="text-sm text-blue-600">Start Date</p>
                    <p class="text-lg font-semibold text-blue-900"><?php echo date('M d, Y', strtotime($session['start_date'])); ?></p>
                </div>
                <div>
                    <p class="text-sm text-blue-600">End Date</p>
                    <p class="text-lg font-semibold text-blue-900"><?php echo date('M d, Y', strtotime($session['end_date'])); ?></p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" class="bg-white rounded-lg shadow p-8">
            <h3 class="text-xl font-bold text-blue-900 mb-6 flex items-center gap-2">
                <i class="fas fa-list-check"></i> Select Terms to Link
            </h3>

            <div class="space-y-3 mb-8">
                <?php foreach($all_terms as $term): ?>
                <div class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    <input type="checkbox" name="terms[]" value="<?php echo $term['id']; ?>" 
                           id="term_<?php echo $term['id']; ?>"
                           <?php echo in_array($term['id'], $linked_terms) ? 'checked' : ''; ?>
                           class="w-4 h-4 text-blue-900 rounded">
                    <label for="term_<?php echo $term['id']; ?>" class="ml-4 flex-1 cursor-pointer">
                        <div class="font-semibold text-blue-900"><?php echo $term['name']; ?></div>
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-calendar-alt"></i> 
                            <?php echo date('M d', strtotime($term['start_date'])); ?> - 
                            <?php echo date('M d, Y', strtotime($term['end_date'])); ?>
                        </div>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="flex-1 bg-blue-900 text-white px-6 py-3 rounded-lg hover:bg-blue-800 transition font-medium flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Save Terms
                </button>
                <a href="sessions.php" class="flex-1 bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400 transition font-medium flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>

        <!-- Linked Terms Display -->
        <div class="mt-12">
            <h3 class="text-xl font-bold text-blue-900 mb-6 flex items-center gap-2">
                <i class="fas fa-check-double"></i> Currently Linked Terms (<?php echo count($linked_terms); ?>)
            </h3>
            <?php if (!empty($linked_terms)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach($all_terms as $term): 
                    if (in_array($term['id'], $linked_terms)):
                ?>
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-semibold text-green-900"><?php echo $term['name']; ?></p>
                            <p class="text-sm text-green-700">
                                <i class="fas fa-hourglass-start"></i> 
                                <?php echo date('M d', strtotime($term['start_date'])); ?> - 
                                <?php echo date('M d, Y', strtotime($term['end_date'])); ?>
                            </p>
                        </div>
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <?php 
                    endif;
                endforeach; 
                ?>
            </div>
            <?php else: ?>
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                <div class="flex items-center gap-2">
                    <i class="fas fa-info-circle text-yellow-600"></i>
                    <p class="text-yellow-700">No terms linked to this session yet</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
