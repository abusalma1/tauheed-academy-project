<?php
$title = 'About & Contact';

include(__DIR__ .  '/../includes/header.php');

$stmt = $conn->prepare("
    SELECT 
        classes.name,
        fees.*,
        (
            first_term +
            second_term +
            third_term +
            uniform +
            transport +
            materials
        ) AS total
    FROM fees
    LEFT JOIN classes ON fees.class_id = classes.id
    ORDER BY classes.level ASC
");

$stmt->execute();
$fees = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


?>

<body class="bg-gray-50">
    <?php include(__DIR__ .  '/../includes/nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Fees & Payment</h1>
            <p class="text-xl text-blue-200">Transparent and Affordable Fee Structure</p>
        </div>
    </section>


    <!-- Fee Structure by Term -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">School Fees by Classes</h2>
            <div class="overflow-x-auto">
                <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-6 py-4 text-center">Class</th>
                            <th class="px-6 py-4 text-center">First Term</th>
                            <th class="px-6 py-4 text-center">Second Term</th>
                            <th class="px-6 py-4 text-center">Third Term</th>


                            <th class="px-6 py-4 text-center">Uniform</th>
                            <th class="px-6 py-4 text-center">Books & Materials</th>
                            <th class="px-6 py-4 text-center">Transport</th>

                            <th class="px-6 py-4 text-center">Total Annual Fee</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($fees as $fee): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold"><?= $fee['name'] ?></td>
                                <td class="px-6 py-4 text-center">₦<?= number_format($fee['first_term']) ?></td>
                                <td class="px-6 py-4 text-center">₦<?= number_format($fee['second_term']) ?></td>
                                <td class="px-6 py-4 text-center">₦<?= number_format($fee['third_term']) ?></td>
                                <td class="px-6 py-4 text-center">₦<?= number_format($fee['uniform']) ?></td>
                                <td class="px-6 py-4 text-center">₦<?= number_format($fee['materials']) ?></td>
                                <td class="px-6 py-4 text-center">₦<?= number_format($fee['transport']) ?></td>
                                <td class="px-6 py-4 text-center font-bold text-blue-900">₦<?= number_format($fee['total']) ?></td>

                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>
            </div>
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-900 p-6 rounded">
                <p class="text-gray-700"><strong>Note: </strong></p>
                <br>
                <ul class="text-gray-700 list-disc pl-5">
                    <li>Tuition and instructional fees, together with facilities and development fees, are distributed across the academic terms.</li>
                    <li>Payment of transport fees is required for students who make use of the school bus service.</li>
                </ul>



            </div>
        </div>
    </section>

    <!-- Fee Breakdown -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">What's Included in School Fees</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-book text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tuition & Instruction</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Quality teaching</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Classroom materials</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Learning resources</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Assessment & reports</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Facilities & Development</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Library access</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Laboratory usage</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Sports facilities</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Computer lab</li>
                    </ul>
                </div>


                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-clipboard-list text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Books & Materials</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Textbooks</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Exercise books</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Stationery</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Workbooks</li>
                    </ul>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-shirt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Uniform</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Regular School Uniform (2 sets)</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Sport Wears</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-bus-alt text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Transport</h3>
                    <ul class="space-y-2 text-gray-700">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Transporting students to school</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Returning students from school</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Service available on school days</li>
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

    <?php include(__DIR__ . '/../includes/footer.php') ?>

</body>

</html>