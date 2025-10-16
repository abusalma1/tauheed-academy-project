<?php
$title = 'About & Contact';

include(__DIR__ .  '/../includes/header.php');
?>

<body class="bg-gray-50">
    <?php include(__DIR__ .  '/../includes/nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Admissions</h1>
            <p class="text-xl text-blue-200">Join the Excellence Academy Family</p>
        </div>
    </section>

    <!-- Admission Procedure -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Admission Procedure</h2>
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="/placeholder.svg?height=400&width=600" alt="Students" class="rounded-lg shadow-xl w-full">
                </div>
                <div>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="bg-blue-900 text-white w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Visit the School</h3>
                                <p class="text-gray-700">Schedule a visit to tour our facilities and meet with our admissions team to learn more about our programs.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="bg-blue-900 text-white w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Complete Application Form</h3>
                                <p class="text-gray-700">Download and fill out the admission form with accurate information about the student and parents/guardians.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="bg-blue-900 text-white w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Submit Required Documents</h3>
                                <p class="text-gray-700">Provide birth certificate, previous school records, passport photographs, and other required documents.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="bg-blue-900 text-white w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Entrance Assessment</h3>
                                <p class="text-gray-700">Students will take an age-appropriate assessment to determine their academic level and placement.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="bg-blue-900 text-white w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 font-bold">5</div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Receive Admission Letter</h3>
                                <p class="text-gray-700">Upon successful completion, you will receive an official admission letter with your unique admission number.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Admission Numbering Format -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Admission Numbering Format</h2>
            <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
                <p class="text-gray-700 mb-6 text-center">Each admitted student receives a unique admission number following this format:</p>
                <div class="bg-blue-50 border-2 border-blue-900 p-6 rounded-lg text-center">
                    <p class="text-3xl font-bold text-blue-900 mb-4">EXA/2025/ADM/0001</p>
                    <div class="grid grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="font-bold text-gray-900">EXA</p>
                            <p class="text-gray-600">School Code</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">2025</p>
                            <p class="text-gray-600">Year</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">ADM</p>
                            <p class="text-gray-600">Admission</p>
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">0001</p>
                            <p class="text-gray-600">Serial Number</p>
                        </div>
                    </div>
                </div>
                <p class="text-gray-600 text-sm mt-6 text-center">This number will be used throughout the student's academic journey at Excellence Academy.</p>
            </div>
        </div>
    </section>

    <!-- Downloadable Forms -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Download Forms & Documents</h2>
            <div class="grid md:grid-cols-3 gap-8">
                Admission Form
                <div class="bg-white border-2 border-gray-200 p-8 rounded-lg shadow-lg hover:shadow-xl transition text-center">
                    <div class="bg-blue-900 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Admission Form</h3>
                    <p class="text-gray-600 mb-6">Download the official admission application form to begin your enrollment process.</p>
                    <a href="#" class="inline-block bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                        <i class="fas fa-download mr-2"></i>Download PDF
                    </a>
                </div>

                <!-- Sample Admission Letter -->
                <div class="bg-white border-2 border-gray-200 p-8 rounded-lg shadow-lg hover:shadow-xl transition text-center">
                    <div class="bg-blue-900 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope-open-text text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Sample Admission Letter</h3>
                    <p class="text-gray-600 mb-6">View a sample of the admission letter you will receive upon successful enrollment.</p>
                    <a href="#" class="inline-block bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                        <i class="fas fa-eye mr-2"></i>View Sample
                    </a>
                </div>

                <!-- Requirements Checklist -->
                <div class="bg-white border-2 border-gray-200 p-8 rounded-lg shadow-lg hover:shadow-xl transition text-center">
                    <div class="bg-blue-900 text-white w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-list-check text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Requirements Checklist</h3>
                    <p class="text-gray-600 mb-6">Download the complete list of documents required for admission.</p>
                    <a href="#" class="inline-block bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                        <i class="fas fa-download mr-2"></i>Download PDF
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Apply Now CTA -->
    <section class="py-16 bg-blue-900 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Join Excellence Academy?</h2>
            <p class="text-xl text-blue-200 mb-8">Start your child's journey to academic excellence today. Our admissions team is ready to assist you.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <button class="bg-white text-blue-900 px-8 py-4 rounded-lg font-semibold hover:bg-blue-50 transition text-lg">
                    <i class="fas fa-paper-plane mr-2"></i>Apply Now
                </button>
                <a href="about.html" class="bg-blue-800 text-white px-8 py-4 rounded-lg font-semibold hover:bg-blue-700 transition text-lg">
                    <i class="fas fa-phone mr-2"></i>Contact Us
                </a>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../includes/footer.php') ?>
