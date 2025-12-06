<?php
$title = 'Islamiyya Student Results';
include __DIR__ . '/../../../includes/header.php';

if (!$is_logged_in || $is_logged_in === false) {
  $_SESSION['failure'] = "Login is Required!";
  header("Location: " . route('home'));
  exit();
}

if ($user_type !== 'student') {
  if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($student) {
      $student_id = $student['id'];
    } else {
      $_SESSION['failure'] = "Student is required.";
      header('Location: ' . route('back'));
      exit();
    }
  } else {
    $_SESSION['failure'] = "Student is required.";
    header('Location: ' . route('back'));
    exit();
  }
} else {
  $student_id = $user['id'];
}

// 1. Get basic student info (Islamiyya track)
$stmt = $pdo->prepare("
    SELECT s.id, s.name, s.admission_number,
           c.name AS class_name,
           a.name AS arm_name,
           t.name AS term_name,
           ses.name AS session_name
    FROM students s
    LEFT JOIN islamiyya_classes c ON s.islamiyya_class_id = c.id
    LEFT JOIN islamiyya_class_arms a ON s.islamiyya_arm_id = a.id
    LEFT JOIN terms t ON s.term_id = t.id
    LEFT JOIN sessions ses ON t.session_id = ses.id
    WHERE s.id = ?
");
$stmt->execute([$student_id]);
$studentInfo = $stmt->fetch(PDO::FETCH_ASSOC);

// 2. Get ALL Islamiyya class records of this student (history)
$stmt = $pdo->prepare("
    SELECT 
        scr.id AS student_class_record_id,
        scr.class_id,
        scr.arm_id,
        scr.session_id,
        scr.overall_total,
        scr.overall_average,
        scr.overall_position,
        scr.promotion_status,
        
        str.id AS student_term_record_id,
        str.term_id,
        str.total_marks,
        str.average_marks,
        str.position_in_class,
        str.class_size,
        str.overall_grade,   

        c.name AS class_name,
        a.name AS arm_name,
        t.name AS term_name,
        ses.name AS session_name
    FROM islamiyya_student_class_records scr
    LEFT JOIN islamiyya_student_term_records str 
        ON scr.id = str.student_class_record_id
    LEFT JOIN islamiyya_classes c ON scr.class_id = c.id
    LEFT JOIN islamiyya_class_arms a ON scr.arm_id = a.id
    LEFT JOIN terms t ON str.term_id = t.id
    LEFT JOIN sessions ses ON scr.session_id = ses.id
    WHERE scr.student_id = ?
    ORDER BY ses.id ASC, t.id ASC
");
$stmt->execute([$student_id]);
$classRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Rearrange data: SESSION -> CLASS -> TERM
$records = [];
foreach ($classRows as $row) {
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
      'term_name'        => $row['term_name'],
      'total_marks'      => $row['total_marks'],
      'average_marks'    => $row['average_marks'],
      'position_in_class' => $row['position_in_class'],
      'class_size'       => $row['class_size'],
      'overall_grade'    => $row['overall_grade'],
      'str_id'           => $strId,
      'subjects_results' => []
    ];
  }
}

// 3. Fetch ALL Islamiyya subject results by student_term_record_id
$stmt = $pdo->prepare("
    SELECT 
        r.student_term_record_id AS str_id,
        r.ca, r.exam, r.total, r.grade, r.remark,
        s.name AS subject_name,
        str.term_id,
        scr.class_id,
        ses.name AS session_name
    FROM islamiyya_results r
    LEFT JOIN islamiyya_student_term_records str 
        ON r.student_term_record_id = str.id
    LEFT JOIN islamiyya_student_class_records scr 
        ON str.student_class_record_id = scr.id
    LEFT JOIN sessions ses ON scr.session_id = ses.id
    LEFT JOIN islamiyya_subjects s ON r.subject_id = s.id
    WHERE scr.student_id = ?
");
$stmt->execute([$student_id]);
$scoreRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Attach results into $records
foreach ($scoreRows as $row) {
  $session = $row['session_name'];
  $classId = $row['class_id'];
  $termId  = $row['term_id'];

  if (isset($records[$session][$classId]['terms'][$termId])) {
    $records[$session][$classId]['terms'][$termId]['subjects_results'][] = [
      'subject_name' => $row['subject_name'],
      'ca'           => $row['ca'],
      'exam'         => $row['exam'],
      'total'        => $row['total'],
      'grade'        => $row['grade'],
      'remark'       => $row['remark']
    ];
  }
}
?>



<body class="bg-gray-50">
  <!-- Navigation -->
  <?php include __DIR__ . '/../../../includes/nav.php'; ?>

  <!-- Page Header -->
  <section class="bg-gradient-to-r from-blue-900 to-blue-700  text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <?php if ($user_type === 'student') : ?>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">My Islamiyya Results</h1>
        <p class="text-xl text-blue-200">View Your Islamiyya Academic Performance</p>
      <?php elseif ($user_type === 'teacher') : ?>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">My Students Islamiyya Results</h1>
        <p class="text-xl text-blue-200">View Students Islamiyya Academic Performance</p>
      <?php else: ?>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">My Child's Islamiyya Results</h1>
        <p class="text-xl text-blue-200">View Your Childs Islamiyya Academic Performance</p>
      <?php endif ?>
    </div>
  </section>
  <!-- Main Content -->
  <section class="py-8 px-4">
    <div class="max-w-4xl mx-auto">
      <!-- Student Header Information -->
      <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-lg shadow-lg p-8 mb-8 no-print">
        <div class="grid md:grid-cols-3 gap-6">
          <div class="flex items-center gap-4">
            <img src="/placeholder.svg?height=100&width=100" alt="Student Photo" class="h-24 w-24 rounded-full border-4 border-white">
            <div>
              <h2 class="text-2xl font-bold"><?= $studentInfo['name'] ?></h2>
              <p class="text-blue-200"><?= $studentInfo['class_name']  . ' - ' . $studentInfo['arm_name'] ?></p>
              <p class="text-blue-200">Admission: <?= $studentInfo['admission_number'] ?></p>
            </div>
          </div>
        </div>
      </div>


      <?php if (!empty($records)): ?>
        <?php foreach ($records as $sessionName => $classes): ?>

          <?php foreach ($classes as $classId => $class): ?>
            <?php foreach ($class['terms'] as $term): ?>


              <!-- Printable Student Header -->
              <div class="hidden print:block bg-white p-8 mb-8 border-2 border-blue-900">
                <div class="text-center mb-6">
                  <img src="/placeholder.svg?height=60&width=60" alt="School Logo" class="h-16 w-16 mx-auto mb-2">
                  <h1 class="text-2xl font-bold text-blue-900"><?= $school['name'] ?></h1>
                  <p class="text-gray-600">2024/2025 Academic Session - Report Card</p>
                </div>
                <div class="grid grid-cols-4 gap-4 text-sm border-t-2 border-blue-900 pt-4">
                  <div>
                    <p class="text-gray-600 font-semibold">Student Name:</p>
                    <p class="font-bold">Chioma Eze</p>
                  </div>
                  <div>
                    <p class="text-gray-600 font-semibold">Admission No:</p>
                    <p class="font-bold">EXA/2024/ADM/0045</p>
                  </div>
                  <div>
                    <p class="text-gray-600 font-semibold">Class:</p>
                    <p class="font-bold">Primary 5 - Arm A</p>
                  </div>
                  <div>
                    <p class="text-gray-600 font-semibold">Session:</p>
                    <p class="font-bold">2024/2025</p>
                  </div>
                </div>
              </div>

              <div class="result-card bg-white rounded-lg shadow-lg p-8 mb-8">
                <div class="flex justify-between items-center mb-6 pb-4 border-b-2 border-blue-900">
                  <div class="flex justify-between items-center">
                    <div>
                      <h2 class="text-3xl "><b><?= htmlspecialchars($class['class_name']) ?></b><small><?= htmlspecialchars($class['arm_name']) ?></small></h2>
                      <div>
                        <p class="text-black-200 text-lg">Session: <?= htmlspecialchars($sessionName) ?></p>
                        <p class="text-black-200 text-lg">Term: <?= htmlspecialchars($term['term_name']) ?></p>

                      </div>
                    </div>
                  </div>
                  <button onclick="window.print()" class="no-print bg-blue-900 hover:bg-blue-800 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2">
                    <i class="fas fa-print"></i>Print
                  </button>
                </div>

                <div class="overflow-x-auto mb-6">
                  <table class="w-full text-sm">
                    <thead class="bg-blue-900 text-white">
                      <tr>
                        <th class="px-4 py-3 text-left font-semibold">Subject</th>
                        <th class="px-4 py-3 text-center font-semibold">CA (40)</th>
                        <th class="px-4 py-3 text-center font-semibold">Exam (60)</th>
                        <th class="px-4 py-3 text-center font-semibold">Total (100)</th>
                        <th class="px-4 py-3 text-center font-semibold">Grade</th>
                        <th class="px-4 py-3 text-left font-semibold">Remark</th>
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                      <?php foreach ($term['subjects_results'] as $result): ?>
                        <tr class="hover:bg-blue-50">
                          <td class="px-4 py-3"><?= $result['subject_name'] ?></td>
                          <td class="px-4 py-3 text-center"><?= $result['ca'] ?></td>
                          <td class="px-4 py-3 text-center"><?= $result['exam'] ?></td>
                          <td class="px-4 py-3 text-center font-bold"><?= $result['total'] ?></td>
                          <td class="px-4 py-3 text-center">
                            <?php if ($result['grade'] != 'F'): ?>
                              <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-bold"><?= $result['grade'] ?></span>
                            <?php else: ?>
                              <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full font-bold"><?= $result['grade'] ?></span>
                            <?php endif ?>
                          </td>
                          <td class="px-4 py-3"><?= $result['remark'] ?></td>
                        </tr>
                      <?php endforeach;  ?>
                      <tr class="bg-blue-50 font-bold text-sm">
                        <td class="px-4 py-3" colspan="2">Total Score</td>
                        <td class="px-4 py-3 text-center" colspan="2"><?= $term['total_marks'] ?>/<?= count($term['subjects_results']) * 100 ?></td>
                        <td class="px-4 py-3 text-center" colspan="2">Average: <?= $term['average_marks'] ?>%</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="grid md:grid-cols-4 gap-4 mb-6">
                  <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-900">
                    <p class="text-gray-600 text-sm font-semibold">Total School Days</p>
                    <p class="text-2xl font-bold text-blue-900">100</p>
                  </div>
                  <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-600">
                    <p class="text-gray-600 text-sm font-semibold">Days Present</p>
                    <p class="text-2xl font-bold text-green-600">97</p>
                  </div>
                  <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-600">
                    <p class="text-gray-600 text-sm font-semibold">Position in Class</p>
                    <p class="text-2xl font-bold text-yellow-600"><?= $term['position_in_class'] ?? 'N/A' ?> of <?= $term['class_size'] ?? 'N/A' ?></p>
                  </div>
                  <div class="bg-purple-50 p-4 rounded-lg border-l-4 border-purple-600">
                    <p class="text-gray-600 text-sm font-semibold">Class Average</p>
                    <p class="text-2xl font-bold text-purple-600"><?= $term['average_marks'] ?? 'N/A' ?>%</p>
                  </div>
                </div>

                <div class="border-t-2 border-blue-900 pt-6">
                  <div class="mb-4">
                    <h3 class="font-bold text-blue-900 mb-2">
                      <i class="fas fa-user-tie text-blue-900 mr-2"></i>Class Teacher's Remark
                    </h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                      <?php if ($term['average_marks'] >= 75) : ?>
                        Excellent performance! Keep up the outstanding work.
                      <?php elseif (($term['average_marks'] >= 60) && ($term['average_marks'] <= 74)) : ?>
                        Very good! You can achieve even more with consistent effort.
                      <?php elseif (($term['average_marks'] >= 50) && ($term['average_marks'] <= 59)) : ?>
                        Good effort. Focus on your weaker areas to improve further.
                      <?php elseif (($term['average_marks'] >= 40) && ($term['average_marks'] <= 49)) : ?>
                        Fair performance. Needs improvement in some subjects.
                      <?php elseif (($term['average_marks'] >= 0) && ($term['average_marks'] <= 39)) : ?>
                        Below average. Extra practice and attention required.
                        Poor performance. Needs serious improvement and guidance.
                      <?php endif ?>
                    </p>
                  </div>
                  <div>
                    <h3 class="font-bold text-blue-900 mb-2">
                      <i class="fas fa-medal text-blue-900 mr-2"></i>Principal's/Headteacher's Remark
                    </h3>
                    <p class="text-gray-700 text-sm leading-relaxed">
                      <?php if ($term['average_marks'] >= 75) : ?>
                        Keep striving for excellence. Very proud of your achievement!
                      <?php elseif (($term['average_marks'] >= 60) && ($term['average_marks'] <= 74)) : ?>
                        Good work. Maintain this standard and aim higher.
                      <?php elseif (($term['average_marks'] >= 50) && ($term['average_marks'] <= 59)) : ?>
                        Encouraging progress. With more effort, better results are possible.
                      <?php elseif (($term['average_marks'] >= 40) && ($term['average_marks'] <= 49)) : ?>
                        Needs improvement. Focus on studies to reach higher grades.
                      <?php elseif (($term['average_marks'] >= 0) && ($term['average_marks'] <= 39)) : ?>
                        Unsatisfactory performance. Immediate action and commitment required
                        Work harder and seek guidance. Improvement is necessary.
                      <?php endif ?>
                    </p>
                  </div>
                </div>
              </div>

            <?php endforeach; ?>
          <?php endforeach; ?>

        <?php endforeach; ?>

      <?php else: ?>
        <p class="text-center text-gray-600">No results found.</p>
      <?php endif; ?>

      <div class="result-card bg-white rounded-lg shadow-lg p-8 print-page-break">
        <a href="<?= route("back") ?>" class="no-print mt-6 inline-block bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition">
          <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include __DIR__ . '/../../../includes/footer.php'; ?>

</body>

</html>