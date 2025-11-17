<?php
$title = 'My Results';
include __DIR__ . '/../../includes/header.php';

if ($is_logged_in === false) {
  $_SESSION['failure'] = "Login is Required!";
  header("Location: " . route('home'));
  exit();
}

$student_id = $user['id'];

// 1. Get basic student info
$stmt = $conn->prepare("
    SELECT s.id, s.name, s.admission_number,
           c.name AS class_name,
           a.name AS arm_name,
           t.name AS term_name,
           ses.name AS session_name
    FROM students s
    LEFT JOIN classes c ON s.class_id = c.id
    LEFT JOIN class_arms a ON s.arm_id = a.id
    LEFT JOIN terms t ON s.term_id = t.id
    LEFT JOIN sessions ses ON t.session_id = ses.id
    WHERE s.id = ?
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$studentInfo = $stmt->get_result()->fetch_assoc();

// 2. Get ALL class records of this student (history)
$stmt = $conn->prepare("
    SELECT 
        scr.id AS student_class_record_id,
        scr.class_id,
        scr.arm_id,
        scr.session_id,
        
        str.id AS student_term_record_id,
        str.term_id,

        c.name AS class_name,
        a.name AS arm_name,
        t.name AS term_name,
        ses.name AS session_name
    FROM student_class_records scr
    LEFT JOIN student_term_records str 
        ON scr.id = str.student_class_record_id
    LEFT JOIN classes c ON scr.class_id = c.id
    LEFT JOIN class_arms a ON scr.arm_id = a.id
    LEFT JOIN terms t ON str.term_id = t.id
    LEFT JOIN sessions ses ON scr.session_id = ses.id
    WHERE scr.student_id = ?
    ORDER BY ses.id ASC, t.id ASC
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$classResult = $stmt->get_result();

// Rearrange data: CLASS -> TERM -> RECORD ID
$records = [];

while ($row = $classResult->fetch_assoc()) {

  $classId  = $row['class_id'];
  $termId   = $row['term_id'];
  $session  = $row['session_name'];
  $scrId    = $row['student_class_record_id'];
  $strId    = $row['student_term_record_id'];

  if (!isset($records[$session])) {
    $records[$session] = [];
  }

  if (!isset($records[$session][$classId])) {
    $records[$session][$classId] = [
      'class_name' => $row['class_name'],
      'arm_name'   => $row['arm_name'],
      'terms'      => []
    ];
  }

  if ($termId) {
    $records[$session][$classId]['terms'][$termId] = [
      'term_name'   => $row['term_name'],
      'str_id'      => $strId,
      'subjects_results' => []
    ];
  }
}

// 3. Fetch ALL results by student_record_id
$stmt = $conn->prepare("
    SELECT 
        r.student_term_record_id AS str_id,
        r.ca, r.exam, r.total, r.grade, r.remark,
        s.name AS subject_name,

        str.term_id,
        scr.class_id,
        ses.name AS session_name
    FROM results r
    LEFT JOIN student_term_records str 
        ON r.student_term_record_id = str.id
    LEFT JOIN student_class_records scr 
        ON str.student_class_record_id = scr.id
    LEFT JOIN sessions ses ON scr.session_id = ses.id
    LEFT JOIN subjects s ON r.subject_id = s.id
    WHERE scr.student_id = ?
");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$scoreResult = $stmt->get_result();


// Attach results into $records
while ($row = $scoreResult->fetch_assoc()) {

  $session = $row['session_name'];
  $classId = $row['class_id'];
  $termId  = $row['term_id'];

  $records[$session][$classId]['terms'][$termId]['subjects_results'][] = [
    'subject_name' => $row['subject_name'],
    'ca'           => $row['ca'],
    'exam'         => $row['exam'],
    'total'        => $row['total'],
    'grade'        => $row['grade'],
    'remark'       => $row['remark']
  ];
}

?>


<body class="bg-gray-50">
  <!-- Navigation -->
  <?php include __DIR__ . '/../../includes/nav.php'; ?>

  <!-- Page Header -->
  <section class="bg-blue-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-4xl md:text-5xl font-bold mb-4">My Results</h1>
      <p class="text-xl text-blue-200">View Your Academic Performance</p>
    </div>
  </section>

  <!-- Main Content -->
  <main class="container mx-auto px-4 py-12">
    <!-- Student Information Card with hardcoded student data -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
      <div class="grid md:grid-cols-2 gap-8 items-start">
        <div>
          <h1 class="text-4xl font-bold text-gray-800 mb-2">My Academic Results</h1>
          <p class="text-gray-600">Complete Academic History</p>
        </div>
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-300">
          <div class="space-y-4">
            <div>
              <p class="text-sm text-gray-600 font-semibold">Student Name</p>
              <p class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($studentInfo['name']) ?></p>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <p class="text-sm text-gray-600 font-semibold">Current Class</p>
                <p class="text-xl font-bold text-blue-900"><?= htmlspecialchars($studentInfo['class_name']) ?></p>
              </div>
              <div>
                <p class="text-sm text-gray-600 font-semibold">Current Arm</p>
                <p class="text-xl font-bold text-blue-900"><?= htmlspecialchars($studentInfo['arm_name']) ?></p>
              </div>
              <div>
                <p class="text-sm text-gray-600 font-semibold">Current Session</p>
                <p class="text-xl font-bold text-blue-900"><?= htmlspecialchars($studentInfo['session_name']) ?></p>
              </div>
              <div>
                <p class="text-sm text-gray-600 font-semibold">Current Term</p>
                <p class="text-xl font-bold text-blue-900"><?= htmlspecialchars($studentInfo['term_name']) ?></p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- All classes and terms hardcoded in HTML with no JavaScript rendering -->

    <?php if (!empty($records)): ?>
      <?php foreach ($records as $sessionName => $classes): ?>

        <?php foreach ($classes as $classId => $class): ?>

          <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
            <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white p-6">
              <div class="flex justify-between items-center">
                <div>
                  <h2 class="text-3xl font-bold"><?= htmlspecialchars($class['class_name']) ?></h2>
                  <p class="text-blue-200 text-lg">Session: <?= htmlspecialchars($sessionName) ?></p>
                  <p class="text-blue-200 text-sm">Arm: <?= htmlspecialchars($class['arm_name']) ?></p>
                </div>
              </div>
            </div>

            <div class="p-6 space-y-12">
              <?php foreach ($class['terms'] as $term): ?>

                <div class="border-l-4 border-blue-900 pl-6 mb-8">
                  <h3 class="text-2xl font-bold text-gray-800 mb-4">
                    <?= htmlspecialchars($term['term_name']) ?>
                  </h3>

                  <div class="overflow-x-auto mb-6">
                    <table class="w-full">
                      <thead>
                        <tr class="bg-blue-900 text-white">
                          <th class="px-6 py-4 text-left">Subject</th>
                          <th class="px-6 py-4 text-center">CA</th>
                          <th class="px-6 py-4 text-center">Exam</th>
                          <th class="px-6 py-4 text-center">Total</th>
                          <th class="px-6 py-4 text-center">Grade</th>
                          <th class="px-6 py-4 text-center">Remark</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($term['subjects_results'] as $result): ?>
                          <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4"><?= htmlspecialchars($result['subject_name']) ?></td>
                            <td class="px-6 py-4 text-center"><?= htmlspecialchars($result['ca']) ?></td>
                            <td class="px-6 py-4 text-center"><?= htmlspecialchars($result['exam']) ?></td>
                            <td class="px-6 py-4 text-center font-bold"><?= htmlspecialchars($result['total']) ?></td>
                            <td class="px-6 py-4 text-center"><?= htmlspecialchars($result['grade']) ?></td>
                            <td class="px-6 py-4 text-center"><?= htmlspecialchars($result['remark']) ?></td>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>

              <?php endforeach; ?>
            </div>

          </div>

        <?php endforeach; ?>
      <?php endforeach; ?>

    <?php else: ?>
      <p class="text-center text-gray-600">No results found.</p>
    <?php endif; ?>



  </main>

  <!-- Footer -->
  <?php include __DIR__ . '/../../includes/footer.php'; ?>
</body>

</html>