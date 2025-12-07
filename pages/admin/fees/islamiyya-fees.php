<?php
$title = 'Islamiyya Fees (Admin section)';
include(__DIR__ .  '/../../../includes/header.php');

if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

// Islamiyya fees query
$stmt = $pdo->prepare("
    SELECT 
        ic.name AS class_name,
        islamiyya_fees.*,
        (
            COALESCE(islamiyya_fees.first_term,0) +
            COALESCE(islamiyya_fees.second_term,0) +
            COALESCE(islamiyya_fees.third_term,0) +
            COALESCE(islamiyya_fees.materials,0)
        ) AS total
    FROM islamiyya_fees
    LEFT JOIN islamiyya_classes ic 
        ON islamiyya_fees.islamiyya_class_id = ic.id
    ORDER BY ic.level ASC
");
$stmt->execute();
$islamiyyaFees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<body class="bg-gray-50">
    <?php include(__DIR__ . "/../includes/admins-section-nav.php") ?>

    <!-- Page Header -->
    <section class="bg-green-700 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Islamiyya Fees & Payment</h1>
            <p class="text-xl text-green-200">Transparent and Affordable Islamiyya Fee Structure</p>
        </div>
    </section>

    <!-- Islamiyya Fee Structure by Term -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Islamiyya Fees by Classes</h2>
            <div class="overflow-x-auto rounded">
                <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-green-700 text-white">
                        <tr>
                            <th class="px-6 py-4 text-center">Islamiyya Class</th>
                            <th class="px-6 py-4 text-center">First Term</th>
                            <th class="px-6 py-4 text-center">Second Term</th>
                            <th class="px-6 py-4 text-center">Third Term</th>
                            <th class="px-6 py-4 text-center">Books & Materials</th>
                            <th class="px-6 py-4 text-center">Total Annual Fee</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($islamiyyaFees as $fee): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold"><?= $fee['class_name'] ?></td>
                                <td class="px-6 py-4 text-center">₦<?= number_format($fee['first_term']) ?></td>
                                <td class="px-6 py-4 text-center">₦<?= number_format($fee['second_term']) ?></td>
                                <td class="px-6 py-4 text-center">₦<?= number_format($fee['third_term']) ?></td>
                                <td class="px-6 py-4 text-center">₦<?= number_format($fee['materials']) ?></td>
                                <td class="px-6 py-4 text-center font-bold text-green-700">₦<?= number_format($fee['total']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-8 bg-green-50 border-l-4 border-green-700 p-6 rounded">
                <p class="text-gray-700"><strong>Note: </strong></p>
                <br>
                <ul class="text-gray-700 list-disc pl-5">
                    <li>Islamiyya tuition and instructional fees are distributed across the academic terms.</li>
                    <li>Books & materials include Qur’an, Islamic texts, and other study resources.</li>
                    <li>Uniform, PTA, registration, and transport remain part of the General Studies fee structure.</li>
                </ul>
            </div>
        </div>
    </section>


    <!-- Islamiyya Fee Breakdown -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">What's Included in Islamiyya Fees</h2>
            <div class="grid md:grid-cols-3 gap-8">

                <!-- Islamiyya Tuition -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="bg-green-700 text-white w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book-open text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tuition & Instruction</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Qur’an recitation & memorization</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Hadith & Fiqh lessons</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Arabic language instruction</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Islamic morals & values</li>
                    </ul>
                </div>

                <!-- Islamiyya Materials -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="bg-green-700 text-white w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-scroll text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Books & Study Materials</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Qur’an (Mushaf)</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Islamic textbooks</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Arabic grammar books</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Exercise books for Islamic studies</li>
                    </ul>
                </div>

                <!-- Clarification -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="bg-green-700 text-white w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-info-circle text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Shared Costs</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Uniforms are covered under General Studies fees</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>PTA contributions remain part of General Studies</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Transport fees apply only once (shared)</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Registration is handled under General Studies</li>
                    </ul>
                </div>

            </div>
        </div>
    </section>


    <!-- Payment Methods -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Payment Methods</h2>
            <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                <div class="bg-blue-50 p-8 rounded-lg border-2 border-blue-900">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-blue-900 text-white w-12 h-12 rounded-full flex items-center justify-center">
                            <i class="fas fa-university text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Bank Transfer</h3>
                    </div>
                    <div class="space-y-2 text-gray-700">
                        <p><strong>Bank Name:</strong> First National Bank</p>
                        <p><strong>Account Name:</strong> <?= $school['name'] ?></p>
                        <p><strong>Account Number:</strong> 1234567890</p>
                        <p class="text-sm text-gray-600 mt-4">Please use sstudent's name, class and admission number as payment reference</p>

                    </div>
                </div>
                <div class="bg-blue-50 p-8 rounded-lg border-2 border-blue-900">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-blue-900 text-white w-12 h-12 rounded-full flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-xl"></i>

                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Cash Payment</h3>
                    </div>
                    <div class="space-y-2 text-gray-700">
                        <p>Pay through school fincance officer (Accountant).</p>

                        <p class="text-sm text-gray-600 mt-4">Please use student's name, class and admission number as payment reference</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . "/../../../includes/footer.php"); ?>


</body>

</html>