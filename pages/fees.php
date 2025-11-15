<?php
$title = 'About & Contact';

include(__DIR__ .  '/../includes/header.php');
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
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">School Fees by Class - First Term</h2>
            <div class="overflow-x-auto">
                <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="px-6 py-4 text-left">Class</th>
                            <th class="px-6 py-4 text-left">Category</th>
                            <th class="px-6 py-4 text-right">Tuition</th>
                            <th class="px-6 py-4 text-right">Development Levy</th>
                            <th class="px-6 py-4 text-right">Books & Materials</th>
                            <th class="px-6 py-4 text-right">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold">Nursery 1-2</td>
                            <td class="px-6 py-4 text-gray-600">Pre-Primary</td>
                            <td class="px-6 py-4 text-right">₦45,000</td>
                            <td class="px-6 py-4 text-right">₦10,000</td>
                            <td class="px-6 py-4 text-right">₦8,000</td>
                            <td class="px-6 py-4 text-right font-bold text-blue-900">₦63,000</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold">Primary 1-3</td>
                            <td class="px-6 py-4 text-gray-600">Lower Primary</td>
                            <td class="px-6 py-4 text-right">₦55,000</td>
                            <td class="px-6 py-4 text-right">₦12,000</td>
                            <td class="px-6 py-4 text-right">₦10,000</td>
                            <td class="px-6 py-4 text-right font-bold text-blue-900">₦77,000</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold">Primary 4-6</td>
                            <td class="px-6 py-4 text-gray-600">Upper Primary</td>
                            <td class="px-6 py-4 text-right">₦60,000</td>
                            <td class="px-6 py-4 text-right">₦12,000</td>
                            <td class="px-6 py-4 text-right">₦12,000</td>
                            <td class="px-6 py-4 text-right font-bold text-blue-900">₦84,000</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold">JSS 1-3</td>
                            <td class="px-6 py-4 text-gray-600">Junior Secondary</td>
                            <td class="px-6 py-4 text-right">₦70,000</td>
                            <td class="px-6 py-4 text-right">₦15,000</td>
                            <td class="px-6 py-4 text-right">₦15,000</td>
                            <td class="px-6 py-4 text-right font-bold text-blue-900">₦100,000</td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-semibold">SSS 1-3</td>
                            <td class="px-6 py-4 text-gray-600">Senior Secondary</td>
                            <td class="px-6 py-4 text-right">₦80,000</td>
                            <td class="px-6 py-4 text-right">₦15,000</td>
                            <td class="px-6 py-4 text-right">₦18,000</td>
                            <td class="px-6 py-4 text-right font-bold text-blue-900">₦113,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-8 bg-blue-50 border-l-4 border-blue-900 p-6 rounded">
                <p class="text-gray-700"><strong>Note:</strong> Second and Third term fees are 10% less than First term. Additional charges may apply for extracurricular activities, excursions, and special programs.</p>
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
                        <p><strong>Account Name:</strong> Excellence Academy</p>
                        <p><strong>Account Number:</strong> 1234567890</p>
                        <p class="text-sm text-gray-600 mt-4">Please use student's admission number as payment reference</p>
                    </div>
                </div>
                <div class="bg-blue-50 p-8 rounded-lg border-2 border-blue-900">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="bg-blue-900 text-white w-12 h-12 rounded-full flex items-center justify-center">
                            <i class="fas fa-credit-card text-xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Online Payment</h3>
                    </div>
                    <p class="text-gray-700 mb-4">Pay securely online using your debit/credit card or bank transfer through our payment gateway.</p>
                    <button class="bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition w-full">
                        <i class="fas fa-lock mr-2"></i>Pay Online (Coming Soon)
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Sample Payment Receipt -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Sample Payment Receipt</h2>
            <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-xl border-2 border-gray-200">
                <div class="text-center mb-6 pb-6 border-b-2 border-gray-200">
                    <img src="/placeholder.svg?height=80&width=80" alt="School Logo" class="h-20 w-20 mx-auto mb-3">
                    <h3 class="text-2xl font-bold text-blue-900">Excellence Academy</h3>
                    <p class="text-gray-600 text-sm">123 Education Street, City</p>
                    <p class="text-gray-600 text-sm">Tel: +234 800 123 4567</p>
                </div>
                <div class="mb-6">
                    <h4 class="text-xl font-bold text-center text-gray-900 mb-4">PAYMENT RECEIPT</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Receipt No:</p>
                            <p class="font-semibold">RCP/2025/0123</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Date:</p>
                            <p class="font-semibold">January 15, 2025</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Student Name:</p>
                            <p class="font-semibold">John Doe</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Admission No:</p>
                            <p class="font-semibold">EXA/2025/ADM/0001</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Class:</p>
                            <p class="font-semibold">Primary 5</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Term:</p>
                            <p class="font-semibold">First Term 2024/2025</p>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Description</th>
                                <th class="px-4 py-2 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr>
                                <td class="px-4 py-2">Tuition Fee</td>
                                <td class="px-4 py-2 text-right">₦60,000</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Development Levy</td>
                                <td class="px-4 py-2 text-right">₦12,000</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2">Books & Materials</td>
                                <td class="px-4 py-2 text-right">₦12,000</td>
                            </tr>
                            <tr class="font-bold bg-gray-100">
                                <td class="px-4 py-2">Total Amount Paid</td>
                                <td class="px-4 py-2 text-right">₦84,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center text-sm text-gray-600 border-t-2 border-gray-200 pt-4">
                    <p>This is a computer-generated receipt and does not require a signature.</p>
                    <p class="mt-2">Thank you for your payment!</p>
                </div>
            </div>
            <div class="text-center mt-6">
                <button class="bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    <i class="fas fa-download mr-2"></i>Download Sample Receipt
                </button>
            </div>
        </div>
    </section>
    <?php include(__DIR__ . '/../includes/footer.php') ?>

</body>

</html>