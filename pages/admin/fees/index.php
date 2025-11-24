<?php
$title = "Fees Management";
include(__DIR__ . '/../../../includes/header.php');

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
                            <p class="text-sm text-gray-700"><strong>Total Classes:</strong> 16 classes</p>
                            <p class="text-sm text-gray-700"><strong>Fee Categories:</strong> Tuition, Levies, Materials</p>
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
                            <p class="text-sm text-gray-700"><strong>Editable Fields:</strong> Tuition, Levies, Materials</p>
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
                        <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-cog mr-2"></i>Configure Methods
                        </button>
                    </div>
                </div>

                <!-- Fees Reports Card -->
                <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:scale-105">
                    <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-8 rounded-t-lg">
                        <i class="fas fa-chart-bar text-white text-5xl mb-4"></i>
                        <h3 class="text-2xl font-bold text-white">Fees Reports</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6">Generate reports on fees collection and defaulters</p>
                        <div class="space-y-3 mb-6">
                            <p class="text-sm text-gray-700"><strong>Reports:</strong> Collection, Defaulters, Payments</p>
                            <p class="text-sm text-gray-700"><strong>Export:</strong> PDF and Excel formats</p>
                            <p class="text-sm text-gray-700"><strong>Analytics:</strong> Trends and statistics</p>
                        </div>
                        <button class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                            <i class="fas fa-file-export mr-2"></i>Generate Reports
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Classes Assigned</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">16</p>
                        </div>
                        <i class="fas fa-check-circle text-4xl text-green-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Fees Collected</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">₦1.5M</p>
                        </div>
                        <i class="fas fa-money-bill-wave text-4xl text-orange-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Defaulters</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">12</p>
                        </div>
                        <i class="fas fa-exclamation-circle text-4xl text-red-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Collection Rate</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">78%</p>
                        </div>
                        <i class="fas fa-percent text-4xl text-blue-200"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Quick Actions</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a href="fees-assignment.html" class="flex items-center gap-3 p-4 border-2 border-orange-200 rounded-lg hover:bg-orange-50 transition">
                        <i class="fas fa-edit text-orange-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Assign Fees</p>
                            <p class="text-xs text-gray-600">Set class fees</p>
                        </div>
                    </a>

                    <a href="fees.html" class="flex items-center gap-3 p-4 border-2 border-green-200 rounded-lg hover:bg-green-50 transition">
                        <i class="fas fa-eye text-green-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">View Structure</p>
                            <p class="text-xs text-gray-600">Current fees</p>
                        </div>
                    </a>

                    <button class="flex items-center gap-3 p-4 border-2 border-blue-200 rounded-lg hover:bg-blue-50 transition">
                        <i class="fas fa-users-cog text-blue-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Manage Payments</p>
                            <p class="text-xs text-gray-600">Payment tracking</p>
                        </div>
                    </button>

                    <button class="flex items-center gap-3 p-4 border-2 border-purple-200 rounded-lg hover:bg-purple-50 transition">
                        <i class="fas fa-file-export text-purple-600 text-xl"></i>
                        <div>
                            <p class="font-semibold text-gray-900">Export Reports</p>
                            <p class="text-xs text-gray-600">Generate reports</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../../includes/footer.php"); ?>

</body>

</html>