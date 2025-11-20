<?php
$title = 'About & Contact';

include(__DIR__ .  '/../includes/header.php');

$stmt = $conn->prepare("
  SELECT 
    t.id,
    t.name,
    t.qualification,
    t.email,
    GROUP_CONCAT(sc.subject_classes SEPARATOR '<br>') AS subjects
  FROM teachers t
  LEFT JOIN (
    SELECT 
      cs.teacher_id,
      CONCAT(
        s.name, ' (', 
        GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', '), 
        ')'
      ) AS subject_classes
    FROM class_subjects cs
    LEFT JOIN subjects s ON cs.subject_id = s.id
    LEFT JOIN classes c ON cs.class_id = c.id
    GROUP BY cs.teacher_id, s.id, s.name
  ) sc ON sc.teacher_id = t.id
  GROUP BY t.id, t.name, t.qualification, t.email
  ORDER BY t.name
");
$stmt->execute();
$teachers = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


?>

<body class="bg-gray-50">
    <?php include(__DIR__ .  '/../includes/nav.php'); ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Our Staff & Teachers</h1>
            <p class="text-xl text-blue-200">Meet Our Dedicated Team of Educators</p>
        </div>
    </section>

    <!-- Leadership Team -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Leadership Team</h2>
            <div class="grid md:grid-cols-3 gap-8">
                Director/CEO
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2 border-blue-900">
                    <img src="/placeholder.svg?height=300&width=300" alt="Director" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Dr. Sarah Johnson</h3>
                        <p class="text-blue-900 font-semibold mb-3">Director/CEO</p>
                        <p class="text-gray-600 text-sm mb-3">Ph.D. in Educational Leadership, M.Ed. in Curriculum Development</p>
                        <p class="text-gray-700 text-sm">Over 20 years of experience in educational administration and leadership.</p>
                    </div>
                </div>

                Principal
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2 border-blue-900">
                    <img src="/placeholder.svg?height=300&width=300" alt="Principal" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Mr. David Okafor</h3>
                        <p class="text-blue-900 font-semibold mb-3">Principal</p>
                        <p class="text-gray-600 text-sm mb-3">M.Ed. in Educational Management, B.Ed. in Mathematics</p>
                        <p class="text-gray-700 text-sm">15 years of teaching and administrative experience in secondary education.</p>
                    </div>
                </div>

                Vice Principal
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2 border-blue-900">
                    <img src="/placeholder.svg?height=300&width=300" alt="Vice Principal" class="w-full h-64 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Mrs. Grace Adeyemi</h3>
                        <p class="text-blue-900 font-semibold mb-3">Vice Principal (Academics)</p>
                        <p class="text-gray-600 text-sm mb-3">M.Ed. in Curriculum Studies, B.Ed. in English Language</p>
                        <p class="text-gray-700 text-sm">12 years of experience in curriculum development and academic coordination.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Teaching Staff -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Teaching Staff</h2>
            <div class="grid md:grid-cols-4 gap-6">
                <?php foreach ($teachers as $teacher) : ?>
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <img src="/placeholder.svg?height=250&width=250" alt="Teacher" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-1"><?= $teacher['name'] ?></h3>
                            <h4>Teachers</h4>
                            <p class="text-blue-900 font-semibold text-sm mb-2"><?= $teacher['subjects'] ?></p>
                            <p class="text-gray-600 text-xs mb-2"><?= $teacher['qualification'] ?></p>
                            <p class="text-gray-700 text-xs">Subjects: Mathematics (Primary 4-6)</p>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>
        </div>
    </section>

    <!-- Support Staff -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Support Staff</h2>
            <div class="grid md:grid-cols-4 gap-6">
                <div class="bg-blue-50 p-6 rounded-lg text-center">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-user-tie text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Mr. John Ojo</h3>
                    <p class="text-sm text-gray-600">School Administrator</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg text-center">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-book text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Mrs. Amina Yusuf</h3>
                    <p class="text-sm text-gray-600">Librarian</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg text-center">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-heartbeat text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Nurse Rebecca Ike</h3>
                    <p class="text-sm text-gray-600">School Nurse</p>
                </div>
                <div class="bg-blue-50 p-6 rounded-lg text-center">
                    <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-user-shield text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Mr. Emeka Nnamdi</h3>
                    <p class="text-sm text-gray-600">Security Officer</p>
                </div>
            </div>
        </div>
    </section>

    <?php include(__DIR__ . '/../includes/footer.php') ?>

</body>

</html>