<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes Management - Excellence Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-900 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-full bg-white p-1 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-blue-900 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Excellence Academy</h1>
                        <p class="text-xs text-blue-200">Nurturing Future Leaders</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-6">
                    <a href="../index.html" class="hover:text-blue-300 transition"><i class="fas fa-home mr-2"></i>Home</a>
                    <a href="academics.html" class="hover:text-blue-300 transition"><i class="fas fa-book mr-2"></i>Academics</a>
                    <a href="timetable.html" class="hover:text-blue-300 transition"><i class="fas fa-calendar mr-2"></i>Timetable</a>
                </div>
                <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 flex items-center gap-3">
                <i class="fas fa-list"></i>Classes Management
            </h1>
            <p class="text-xl text-blue-200">View and manage all school classes by section</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <?php
                $classes = array(
                    'Primary' => array(
                        array('name' => 'Primary 5', 'students' => 32, 'arm' => 'A', 'classTeacher' => 'Mrs. Folake Adebayo'),
                        array('name' => 'Primary 5', 'students' => 30, 'arm' => 'B', 'classTeacher' => 'Mr. Chinedu Eze'),
                        array('name' => 'Primary 6', 'students' => 28, 'arm' => 'A', 'classTeacher' => 'Mrs. Grace Johnson'),
                    ),
                    'Junior Secondary' => array(
                        array('name' => 'JSS 1', 'students' => 40, 'arm' => 'A', 'classTeacher' => 'Mr. Ibrahim Musa'),
                        array('name' => 'JSS 1', 'students' => 38, 'arm' => 'B', 'classTeacher' => 'Mrs. Zainab Hassan'),
                        array('name' => 'JSS 2', 'students' => 35, 'arm' => 'A', 'classTeacher' => 'Mr. Adekunle Okafor'),
                        array('name' => 'JSS 2', 'students' => 36, 'arm' => 'B', 'classTeacher' => 'Mrs. Chidinma Nwosu'),
                    ),
                    'Senior Secondary' => array(
                        array('name' => 'SSS 1', 'students' => 45, 'arm' => 'A', 'classTeacher' => 'Mr. Oluwatoyin Adeyemi'),
                        array('name' => 'SSS 1', 'students' => 42, 'arm' => 'B', 'classTeacher' => 'Mrs. Amina Hassan'),
                        array('name' => 'SSS 2', 'students' => 38, 'arm' => 'A', 'classTeacher' => 'Mr. Chukwuma Eze'),
                        array('name' => 'SSS 3', 'students' => 35, 'arm' => 'A', 'classTeacher' => 'Mr. Zainab Ibrahim'),
                    )
                );

                $sectionColors = array(
                    'Primary' => 'blue',
                    'Junior Secondary' => 'indigo',
                    'Senior Secondary' => 'purple'
                );
            ?>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
                <div class="bg-gradient-to-br from-blue-900 to-blue-700 text-white rounded-lg p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-blue-200 text-sm font-semibold">Total Classes</p>
                            <p class="text-4xl font-bold mt-2"><?php echo count($classes['Primary']) + count($classes['Junior Secondary']) + count($classes['Senior Secondary']); ?></p>
                        </div>
                        <i class="fas fa-graduation-cap text-2xl opacity-50"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-indigo-600 to-indigo-400 text-white rounded-lg p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-indigo-200 text-sm font-semibold">Total Students</p>
                            <p class="text-4xl font-bold mt-2">
                                <?php 
                                    $total = 0;
                                    foreach($classes as $section) {
                                        foreach($section as $class) {
                                            $total += $class['students'];
                                        }
                                    }
                                    echo $total;
                                ?>
                            </p>
                        </div>
                        <i class="fas fa-users text-2xl opacity-50"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-600 to-blue-400 text-white rounded-lg p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-blue-200 text-sm font-semibold">Avg Class Size</p>
                            <p class="text-4xl font-bold mt-2">
                                <?php 
                                    $totalClasses = count($classes['Primary']) + count($classes['Junior Secondary']) + count($classes['Senior Secondary']);
                                    echo round($total / $totalClasses);
                                ?>
                            </p>
                        </div>
                        <i class="fas fa-chart-bar text-2xl opacity-50"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-cyan-600 to-cyan-400 text-white rounded-lg p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-cyan-200 text-sm font-semibold">Class Teachers</p>
                            <p class="text-4xl font-bold mt-2">
                                <?php 
                                    $teachers = 0;
                                    foreach($classes as $section) {
                                        $teachers += count($section);
                                    }
                                    echo $teachers;
                                ?>
                            </p>
                        </div>
                        <i class="fas fa-chalkboard-user text-2xl opacity-50"></i>
                    </div>
                </div>
            </div>

            <!-- Classes by Section -->
            <?php foreach($classes as $section => $sectionClasses): ?>
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-blue-900 mb-6 flex items-center gap-2">
                        <i class="fas fa-book"></i><?php echo $section; ?>
                    </h2>

                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2 border-blue-900">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-blue-900 text-white">
                                    <tr>
                                        <th class="px-6 py-4 text-left font-semibold"><i class="fas fa-chalkboard mr-2"></i>Class</th>
                                        <th class="px-6 py-4 text-center font-semibold"><i class="fas fa-users mr-2"></i>Students</th>
                                        <th class="px-6 py-4 text-center font-semibold"><i class="fas fa-code mr-2"></i>Arm</th>
                                        <th class="px-6 py-4 text-left font-semibold"><i class="fas fa-person-chalkboard mr-2"></i>Class Teacher</th>
                                        <th class="px-6 py-4 text-center font-semibold"><i class="fas fa-cogs mr-2"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php foreach($sectionClasses as $class): ?>
                                        <tr class="hover:bg-blue-50 transition">
                                            <td class="px-6 py-4 font-semibold text-blue-900"><?php echo $class['name']; ?></td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="inline-block bg-blue-100 text-blue-900 px-3 py-1 rounded-full font-bold">
                                                    <?php echo $class['students']; ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center font-bold text-blue-600"><?php echo $class['arm']; ?></td>
                                            <td class="px-6 py-4"><?php echo $class['classTeacher']; ?></td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex justify-center gap-2">
                                                    <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-xs flex items-center gap-1 transition">
                                                        <i class="fas fa-eye"></i>View
                                                    </a>
                                                    <a href="bulk-upload-students.php?class=<?php echo urlencode($class['name'] . ' ' . $class['arm']); ?>" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-xs flex items-center gap-1 transition">
                                                        <i class="fas fa-upload"></i>Upload
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4"><i class="fas fa-graduation-cap mr-2"></i>Excellence Academy</h3>
                    <p class="text-gray-400 text-sm">Committed to quality education and excellence.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4"><i class="fas fa-link mr-2"></i>Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="../index.html" class="text-gray-400 hover:text-white"><i class="fas fa-home mr-1"></i>Home</a></li>
                        <li><a href="academics.html" class="text-gray-400 hover:text-white"><i class="fas fa-book mr-1"></i>Academics</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4"><i class="fas fa-phone mr-2"></i>Contact</h3>
                    <p class="text-gray-400 text-sm">+234 800 123 4567</p>
                    <p class="text-gray-400 text-sm">info@excellenceacademy.edu</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4"><i class="fas fa-share-alt mr-2"></i>Follow Us</h3>
                    <div class="flex gap-4">
                        <a href="#" class="bg-blue-600 hover:bg-blue-700 w-10 h-10 rounded-full flex items-center justify-center transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="bg-blue-400 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center transition"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2025 Excellence Academy. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
