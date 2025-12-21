<?php
$title = 'Our Staff';

include(__DIR__ . '/../includes/header.php');

// =======================
// General Studies Teachers
// =======================
$stmt = $pdo->prepare("
  SELECT 
    t.id,
    t.name,
    t.qualification,
    t.gender,
    t.experience,
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
  GROUP BY t.id, t.name, t.qualification, t.gender, t.experience, t.email
  ORDER BY t.name
");
$stmt->execute();
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);


// =======================
// Islamiyya Teachers
// =======================
$stmt = $pdo->prepare("
  SELECT 
    t.id,
    t.name,
    t.qualification,
    t.gender,
    t.experience,
    t.email,
    GROUP_CONCAT(sc.subject_classes SEPARATOR '<br>') AS islamiyya_subjects
  FROM teachers t
  LEFT JOIN (
    SELECT 
      cs.teacher_id,
      CONCAT(
        s.name, ' (', 
        GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', '), 
        ')'
      ) AS subject_classes
    FROM islamiyya_class_subjects cs
    LEFT JOIN islamiyya_subjects s ON cs.subject_id = s.id
    LEFT JOIN islamiyya_classes c ON cs.class_id = c.id
    GROUP BY cs.teacher_id, s.id, s.name
  ) sc ON sc.teacher_id = t.id
  GROUP BY t.id, t.name, t.qualification, t.gender, t.experience, t.email
  ORDER BY t.name
");
$stmt->execute();
$islamiyyaTeachers = $stmt->fetchAll(PDO::FETCH_ASSOC);


// =======================
// Admins
// =======================
$stmt = $pdo->prepare("
  SELECT * 
  FROM admins 
  WHERE type = ? 
    
  ORDER BY name
");
$stmt->execute(['admin']);
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);


// =======================
// Super Admins
// =======================
$stmt = $pdo->prepare("
  SELECT * 
  FROM admins 
  WHERE type = ? 
    
  ORDER BY name
");
$stmt->execute(['superAdmin']);
$superAdmins = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
        <?php foreach ($superAdmins as $admin) : ?>
          <div class="bg-white rounded-lg shadow-lg overflow-hidden border-2 border-blue-900">
            <img src="/placeholder.svg?height=300&width=300" alt="Director" class="w-full h-64 object-cover">
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-2"><?= $admin['gender'] === 'male' ? "Mr. " : 'Mrs ' ?><?= $admin['name'] ?></h3>
              <p class="text-blue-900 font-semibold mb-3"><?= $admin['department'] ?></p>
              <p class="text-gray-600 text-sm mb-3"><?= $admin['qualification'] ?></p>
              <p class="text-gray-700 text-sm"><?= $admin['experience'] ?></p>
            </div>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </section>

  <!-- Teaching Staff (General Studies) -->
  <section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">General Studies Teaching Staff</h2>
      <div class="grid md:grid-cols-4 gap-6">
        <?php foreach ($teachers as $teacher) : ?>
          <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            <img src="/placeholder.svg?height=250&width=250" alt="Teacher" class="w-full h-48 object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold text-gray-900 mb-1"><?= $teacher['gender'] === 'male' ? "Mr. " : 'Mrs.' ?> <?= $teacher['name'] ?></h3>
              <p class="text-gray-600 text-xs mb-2"><b>Qualifications: </b><?= $teacher['qualification'] ?></p>
              <p class="text-gray-600 text-xs mb-2"><b>Experience: </b><?= $teacher['experience'] ?></p>
              <h4 class="text-lg font-bold text-gray-900 mb-1">Subjects</h4>
              <p class="text-blue-900 font-semibold text-sm mb-2"><?= $teacher['subjects'] ?></p>
            </div>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </section>

  <!-- Teaching Staff (Islamiyya) -->
  <section class="py-16 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Islamiyya Teaching Staff</h2>
      <div class="grid md:grid-cols-4 gap-6">
        <?php foreach ($islamiyyaTeachers as $teacher) : ?>
          <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
            <img src="/placeholder.svg?height=250&width=250" alt="Islamiyya Teacher" class="w-full h-48 object-cover">
            <div class="p-4">
              <h3 class="text-lg font-bold text-gray-900 mb-1"><?= $teacher['gender'] === 'male' ? "Ustaz " : 'Ustazah ' ?> <?= $teacher['name'] ?></h3>
              <p class="text-gray-600 text-xs mb-2"><b>Qualifications: </b><?= $teacher['qualification'] ?></p>
              <p class="text-gray-600 text-xs mb-2"><b>Experience: </b><?= $teacher['experience'] ?></p>
              <h4 class="text-lg font-bold text-gray-900 mb-1">Islamiyya Subjects</h4>
              <p class="text-green-700 font-semibold text-sm mb-2"><?= $teacher['islamiyya_subjects'] ?></p>
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
        <?php foreach ($admins as $admin): ?>
          <div class="bg-blue-50 p-6 rounded-lg text-center">
            <div class="bg-blue-900 text-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3">
              <img src="images/book.png" alt="staff" class="w-8 h-8 inline-block align-middle" />
            </div>
            <h3 class="font-bold text-gray-900 mb-1"><?= $admin['gender'] === 'male' ? "Mr. " : 'Mrs.' ?> <?= $admin['name'] ?></h3>
            <p class="text-sm text-gray-600"><?= $admin['department'] ?></p>
          </div>
        <?php endforeach; ?>
      </div>
  </section>

  <?php include(__DIR__ . '/../includes/footer.php') ?>

</body>

</html>