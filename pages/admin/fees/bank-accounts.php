<?php
$title = "Bank Accounts";
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}


if (!isset($user_type) || $user_type !== 'admin') {
    $_SESSION['failure'] = "Access denied! Only Admins are allowed.";
    header("Location: " . route('home'));
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM bank_accounts");
$stmt->execute();
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/../includes/admins-section-nav.php") ?>


    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-4">Bank Accounts</h1>
                    <p class="text-xl text-blue-200">Manage school fees payment bank details</p>
                </div>
                <a href="<?= route('add-bank-account') ?>" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2 transition">
                    <i class="fas fa-plus"></i>Add Bank Account
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Accounts</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">3</p>
                        </div>
                        <i class="fas fa-university text-4xl text-blue-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Active Accounts</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">3</p>
                        </div>
                        <i class="fas fa-check-circle text-4xl text-green-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Banks</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">3</p>
                        </div>
                        <i class="fas fa-credit-card text-4xl text-orange-200"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-semibold">Total Balance</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">₦5.2M</p>
                        </div>
                        <i class="fas fa-money-bill-wave text-4xl text-purple-200"></i>
                    </div>
                </div>
            </div>

            <!-- Bank Accounts Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($accounts as $account): ?>
                    <div class="bg-white rounded-lg shadow-lg hover:shadow-2xl transition">
                        <div class="bg-gradient-to-r from-blue-800 to-blue-600 p-6 rounded-t-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-university text-white text-3xl"></i>
                                    <div>
                                        <h3 class="text-xl font-bold text-white"><?= $account['bank_name'] ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4 mb-6">
                                <div>
                                    <p class="text-gray-600 text-sm font-semibold">Account Name</p>
                                    <p class="text-gray-900 font-bold text-lg"><?= $account['account_name'] ?></p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-sm font-semibold">Account Number</p>
                                    <p class="text-gray-900 font-mono text-lg tracking-widest"><?= $account['account_number'] ?></p>
                                </div>

                                <div>
                                    <p class="text-gray-600 text-sm font-semibold">Account Purpose</p>
                                    <p class="text-gray-900"><?= $account['purpose'] ?></p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <a href="<?= route('update-bank-account') ?>?id=<?= $account['id'] ?>" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                                    <i class="fas fa-edit"></i>Edit
                                </a>
                                <a href="<?= route('delete-bank-account') ?>?id=<?= $account['id'] ?>" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                                    <i class="fas fa-trash"></i>Delete
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../../includes/footer.php"); ?>

</body>

</html>