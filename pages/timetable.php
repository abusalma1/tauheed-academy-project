<?php
$title = 'About & Contact';

include(__DIR__ .  '/../includes/header.php');
?>

<body class="bg-gray-50">
    <?php include(__DIR__ .  '/../includes/nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16 no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">School Timetables</h1>
            <p class="text-xl text-blue-200">Examination & Lesson Schedules</p>
        </div>
    </section>

    <!-- Timetable Navigation -->
    <section class="py-8 bg-white no-print">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-center gap-4">
                <button onclick="showTimetable('exam')" class="bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    <i class="fas fa-clipboard-list mr-2"></i>Examination Timetable
                </button>
                <button onclick="showTimetable('lesson')" class="bg-blue-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                    <i class="fas fa-calendar-alt mr-2"></i>Lesson Timetable
                </button>
                <button onclick="window.print()" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                    <i class="fas fa-print mr-2"></i>Print Timetable
                </button>
            </div>
        </div>
    </section>

    <!-- Examination Timetable -->
    <section id="exam-timetable" class="py-16 bg-gray-100 print-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">First Term Examination Timetable</h2>
                <p class="text-gray-600">2024/2025 Academic Session - Primary 5</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-blue-900 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left">Date</th>
                                <th class="px-6 py-4 text-left">Day</th>
                                <th class="px-6 py-4 text-left">Time</th>
                                <th class="px-6 py-4 text-left">Subject</th>
                                <th class="px-6 py-4 text-left">Duration</th>
                                <th class="px-6 py-4 text-left">Venue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">March 10, 2025</td>
                                <td class="px-6 py-4">Monday</td>
                                <td class="px-6 py-4">9:00 AM</td>
                                <td class="px-6 py-4">Mathematics</td>
                                <td class="px-6 py-4">2 hours</td>
                                <td class="px-6 py-4">Hall A</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">March 11, 2025</td>
                                <td class="px-6 py-4">Tuesday</td>
                                <td class="px-6 py-4">9:00 AM</td>
                                <td class="px-6 py-4">English Language</td>
                                <td class="px-6 py-4">2 hours</td>
                                <td class="px-6 py-4">Hall A</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">March 12, 2025</td>
                                <td class="px-6 py-4">Wednesday</td>
                                <td class="px-6 py-4">9:00 AM</td>
                                <td class="px-6 py-4">Basic Science</td>
                                <td class="px-6 py-4">1.5 hours</td>
                                <td class="px-6 py-4">Hall B</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">March 13, 2025</td>
                                <td class="px-6 py-4">Thursday</td>
                                <td class="px-6 py-4">9:00 AM</td>
                                <td class="px-6 py-4">Social Studies</td>
                                <td class="px-6 py-4">1.5 hours</td>
                                <td class="px-6 py-4">Hall B</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">March 14, 2025</td>
                                <td class="px-6 py-4">Friday</td>
                                <td class="px-6 py-4">9:00 AM</td>
                                <td class="px-6 py-4">Verbal Reasoning</td>
                                <td class="px-6 py-4">1 hour</td>
                                <td class="px-6 py-4">Hall A</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">March 17, 2025</td>
                                <td class="px-6 py-4">Monday</td>
                                <td class="px-6 py-4">9:00 AM</td>
                                <td class="px-6 py-4">Computer Studies</td>
                                <td class="px-6 py-4">1 hour</td>
                                <td class="px-6 py-4">Computer Lab</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">March 18, 2025</td>
                                <td class="px-6 py-4">Tuesday</td>
                                <td class="px-6 py-4">9:00 AM</td>
                                <td class="px-6 py-4">Creative Arts</td>
                                <td class="px-6 py-4">1.5 hours</td>
                                <td class="px-6 py-4">Art Room</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold">March 19, 2025</td>
                                <td class="px-6 py-4">Wednesday</td>
                                <td class="px-6 py-4">9:00 AM</td>
                                <td class="px-6 py-4">Physical Education</td>
                                <td class="px-6 py-4">1 hour</td>
                                <td class="px-6 py-4">Sports Field</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bg-blue-50 p-6 border-t-2 border-blue-900">
                    <h4 class="font-bold text-gray-900 mb-2">Important Instructions:</h4>
                    <ul class="space-y-1 text-sm text-gray-700">
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Students must arrive 30 minutes before exam time</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Bring writing materials and student ID card</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>No electronic devices allowed in exam halls</li>
                        <li><i class="fas fa-check text-green-600 mr-2"></i>Late arrivals will not be permitted after 15 minutes</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Lesson Timetable -->
    <section id="lesson-timetable" class="py-16 bg-white hidden print-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Weekly Lesson Timetable</h2>
                <p class="text-gray-600">2024/2025 Academic Session - Primary 5</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-blue-900 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left">Time</th>
                                <th class="px-4 py-3 text-center">Monday</th>
                                <th class="px-4 py-3 text-center">Tuesday</th>
                                <th class="px-4 py-3 text-center">Wednesday</th>
                                <th class="px-4 py-3 text-center">Thursday</th>
                                <th class="px-4 py-3 text-center">Friday</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="bg-gray-50">
                                <td class="px-4 py-3 font-semibold">8:00 - 8:30</td>
                                <td colspan="5" class="px-4 py-3 text-center bg-blue-50">Assembly & Devotion</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold">8:30 - 9:30</td>
                                <td class="px-4 py-3 text-center">Mathematics</td>
                                <td class="px-4 py-3 text-center">English</td>
                                <td class="px-4 py-3 text-center">Mathematics</td>
                                <td class="px-4 py-3 text-center">English</td>
                                <td class="px-4 py-3 text-center">Mathematics</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold">9:30 - 10:30</td>
                                <td class="px-4 py-3 text-center">English</td>
                                <td class="px-4 py-3 text-center">Mathematics</td>
                                <td class="px-4 py-3 text-center">Basic Science</td>
                                <td class="px-4 py-3 text-center">Social Studies</td>
                                <td class="px-4 py-3 text-center">English</td>
                            </tr>
                            <tr class="bg-yellow-50">
                                <td class="px-4 py-3 font-semibold">10:30 - 11:00</td>
                                <td colspan="5" class="px-4 py-3 text-center font-semibold">BREAK TIME</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold">11:00 - 12:00</td>
                                <td class="px-4 py-3 text-center">Basic Science</td>
                                <td class="px-4 py-3 text-center">Social Studies</td>
                                <td class="px-4 py-3 text-center">English</td>
                                <td class="px-4 py-3 text-center">Mathematics</td>
                                <td class="px-4 py-3 text-center">Computer Studies</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold">12:00 - 1:00</td>
                                <td class="px-4 py-3 text-center">Verbal Reasoning</td>
                                <td class="px-4 py-3 text-center">Quantitative Reasoning</td>
                                <td class="px-4 py-3 text-center">Creative Arts</td>
                                <td class="px-4 py-3 text-center">Computer Studies</td>
                                <td class="px-4 py-3 text-center">Library Period</td>
                            </tr>
                            <tr class="bg-yellow-50">
                                <td class="px-4 py-3 font-semibold">1:00 - 2:00</td>
                                <td colspan="5" class="px-4 py-3 text-center font-semibold">LUNCH BREAK</td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 font-semibold">2:00 - 3:00</td>
                                <td class="px-4 py-3 text-center">Physical Education</td>
                                <td class="px-4 py-3 text-center">Creative Arts</td>
                                <td class="px-4 py-3 text-center">Music</td>
                                <td class="px-4 py-3 text-center">Physical Education</td>
                                <td class="px-4 py-3 text-center">Clubs & Societies</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="bg-blue-50 p-6 border-t-2 border-blue-900">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2">Class Teacher:</h4>
                            <p class="text-gray-700">Mrs. Elizabeth Okonkwo</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 mb-2">Note:</h4>
                            <p class="text-gray-700 text-sm">Timetable subject to change. Check notice board for updates.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../includes/footer.php') ?>
