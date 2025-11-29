<?php
$title = "Fees Management";
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

$classesCount = countDataTotal('classes');

?>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/../includes/admins-section-nav.php") ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Fees Management</h1>
            <p class="text-xl text-blue-200">Manage school fees, assignments, and payment tracking</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Management Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <!-- View Fees Structure Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 rounded-t-lg">
                        <i class="fas fa-list text-white text-5xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-white">View Fees Structure</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">View current fee structure by class, term, and category</p>
                        <div class="space-y-3 mb-6">
                            <p class="text-sm text-gray-700"><strong>Total Classes:</strong> <?= $classesCount['total'] ?> classes</p>
                            <p class="text-sm text-gray-700"><strong>Fee Categories:</strong> (Tuition, Levies), Materials, Transport & uniform</p>
                            <p class="text-sm text-gray-700"><strong>Terms:</strong> First, Second, Third</p>
                        </div>
                        <a href="<?= route('admin-fees') ?>" class="w-full inline-block text-center bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                            <i class="fas fa-eye mr-2"></i>View Structure
                        </a>
                    </div>
                </div>

                <!-- Assign Annual Fees Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-8 rounded-t-lg">
                        <i class="fas fa-calculator text-white text-5xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-white">Assign Annual Fees</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Set annual fees for all classes in one place</p>
                        <div class="space-y-3 mb-6">
                            <p class="text-sm text-gray-700"><strong>Editable Fields:</strong> (Tuition, Levies), Materials, Transport & uniform</p>
                            <p class="text-sm text-gray-700"><strong>Auto Calculate:</strong> Total fees automatically</p>
                            <p class="text-sm text-gray-700"><strong>Bulk Update:</strong> Update all at once</p>
                        </div>
                        <a href="<?= route('fees-assginment') ?>" class="w-full inline-block text-center bg-orange-600 text-white py-3 rounded-lg font-semibold hover:bg-orange-700 transition">
                            <i class="fas fa-edit mr-2"></i>Assign Fees
                        </a>
                    </div>
                </div>

                <!-- Payment Methods Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-8 rounded-t-lg">
                        <i class="fas fa-credit-card text-white text-5xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-white">Payment Methods</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Configure payment methods and banking details</p>
                        <div class="space-y-3 mb-6">
                            <p class="text-sm text-gray-700"><strong>Methods:</strong> Bank Transfer, Online Payment</p>
                            <p class="text-sm text-gray-700"><strong>Bank Details:</strong> Account info configured</p>
                            <p class="text-sm text-gray-700"><strong>Payment Gateway:</strong> Setup and manage</p>
                        </div>

                        <a href="<?= route('bank-accounts') ?>" class="w-full inline-block text-center bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-cog mr-2"></i>Configure Methods
                        </a>
                    </div>
                </div>

            </div>


            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <a href="<?= route('fees-assginment') ?>" class="flex items-center gap-3 p-4 border-2 border-orange-200 rounded-lg hover:bg-orange-50 transition">
                        <i class="fas fa-edit text-orange-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Assign Fees</p>
                            <p class="text-xs text-gray-600">Set class fees</p>
                        </div>
                    </a>

                    <a href="<?= route('admin-fees') ?>" class="flex items-center gap-3 p-4 border-2 border-green-200 rounded-lg hover:bg-green-50 transition">
                        <i class="fas fa-eye text-green-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">View Structure</p>
                            <p class="text-xs text-gray-600">Current fees</p>
                        </div>
                    </a>


                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../../includes/footer.php"); ?>

</body>

</html>