<?php
<<<<<<< HEAD

$title = 'Student Results';
include(__DIR__ . '/../../../includes/header.php');

/* ------------------------------
   AUTHENTICATION CHECKS
------------------------------ */

if (!$is_logged_in) {
=======
$title = 'Student Results';
include(__DIR__ . '/../../../includes/header.php');


if (!$is_logged_in || $is_logged_in === false) {
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
  $_SESSION['failure'] = "Login is Required!";
  header("Location: " . route('home'));
  exit();
}

if (!isset($user_type) || $user_type !== 'admin') {
<<<<<<< HEAD
  $_SESSION['failure'] = "Access denied. Only Admins are allowed.";
=======
  $_SESSION['failure'] = "Access denied! Only Admins are allowed.";
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
  header("Location: " . route('home'));
  exit();
}

<<<<<<< HEAD
/* ------------------------------
   VALIDATE STUDENT ID
------------------------------ */

if (!isset($_GET['id'])) {
=======

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
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
  $_SESSION['failure'] = "Student is required.";
  header('Location: ' . route('back'));
  exit();
}

<<<<<<< HEAD
$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT * 
    FROM students 
    WHERE id = ? AND deleted_at IS NULL
");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
  $_SESSION['failure'] = "Student not found or deleted.";
  header('Location: ' . route('back'));
  exit();
}

$student_id = $student['id'];

/* ------------------------------
   1. BASIC STUDENT INFO
------------------------------ */

$stmt = $pdo->prepare("
    SELECT 
        s.id, s.name, s.admission_number, s.picture_path,

        c.name AS class_name,
        a.name AS arm_name,
        t.name AS term_name,
        ses.name AS session_name

    FROM students s

    LEFT JOIN classes c 
        ON s.class_id = c.id 
        AND c.deleted_at IS NULL

    LEFT JOIN class_arms a 
        ON s.arm_id = a.id 
        AND a.deleted_at IS NULL

    LEFT JOIN terms t 
        ON s.term_id = t.id 
        AND t.deleted_at IS NULL

    LEFT JOIN sessions ses 
        ON t.session_id = ses.id 
        AND ses.deleted_at IS NULL

=======
//  1. Get basic student info
$stmt = $pdo->prepare("
    SELECT s.id, s.name, s.admission_number, s.picture_path,

           c.name AS class_name,
           a.name AS arm_name,
           t.name AS term_name,
           ses.name AS session_name
    FROM students s
    LEFT JOIN classes c ON s.class_id = c.id
    LEFT JOIN class_arms a ON s.arm_id = a.id
    LEFT JOIN terms t ON s.term_id = t.id
    LEFT JOIN sessions ses ON t.session_id = ses.id
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    WHERE s.id = ?
");
$stmt->execute([$student_id]);
$studentInfo = $stmt->fetch(PDO::FETCH_ASSOC);

<<<<<<< HEAD
/* ------------------------------
   2. ALL CLASS RECORDS (HISTORY)
------------------------------ */

=======
//  2. Get ALL class records of this student (history)
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
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
<<<<<<< HEAD

=======
        
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
        str.id AS student_term_record_id,
        str.term_id,
        str.total_marks,
        str.average_marks,
        str.position_in_class,
        str.class_size,
<<<<<<< HEAD
        str.overall_grade,
=======
        str.overall_grade,   
>>>>>>> 271894334d344b716e30670c3770b73d583f3916

        c.name AS class_name,
        a.name AS arm_name,
        t.name AS term_name,
        ses.id AS session_id,
        ses.name AS session_name

    FROM student_class_records scr
<<<<<<< HEAD

    LEFT JOIN student_term_records str 
        ON scr.id = str.student_class_record_id
        AND str.deleted_at IS NULL

    LEFT JOIN classes c 
        ON scr.class_id = c.id
        AND c.deleted_at IS NULL

    LEFT JOIN class_arms a 
        ON scr.arm_id = a.id
        AND a.deleted_at IS NULL

    LEFT JOIN terms t 
        ON str.term_id = t.id
        AND t.deleted_at IS NULL

    LEFT JOIN sessions ses 
        ON scr.session_id = ses.id
        AND ses.deleted_at IS NULL

    WHERE scr.student_id = ?
      AND scr.deleted_at IS NULL

=======
    LEFT JOIN student_term_records str 
        ON scr.id = str.student_class_record_id
    LEFT JOIN classes c ON scr.class_id = c.id
    LEFT JOIN class_arms a ON scr.arm_id = a.id
    LEFT JOIN terms t ON str.term_id = t.id
    LEFT JOIN sessions ses ON scr.session_id = ses.id
    WHERE scr.student_id = ?
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    ORDER BY ses.id ASC, t.id ASC
");
$stmt->execute([$student_id]);
$classRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

<<<<<<< HEAD
/* ------------------------------
   RESTRUCTURE DATA
------------------------------ */

$records = [];

foreach ($classRows as $row) {

  $classId   = $row['class_id'];
  $termId    = $row['term_id'];
  $session   = $row['session_name'];
=======
// Rearrange data: CLASS -> TERM -> RECORD ID
$records = [];

foreach ($classRows as $row) {
  $classId  = $row['class_id'];
  $termId   = $row['term_id'];
  $session_id  = $row['session_id'];
  $session  = $row['session_name'];

  $scrId    = $row['student_class_record_id'];
  $strId    = $row['student_term_record_id'];
>>>>>>> 271894334d344b716e30670c3770b73d583f3916

  if (!isset($records[$session])) {
    $records[$session] = [];
  }

  if (!isset($records[$session][$classId])) {
    $records[$session][$classId] = [
<<<<<<< HEAD
      'class_name'       => $row['class_name'],
      'arm_name'         => $row['arm_name'],
      'overall_average'  => $row['overall_average'],
      'promotion_status' => $row['promotion_status'],
      'terms'            => []
=======
      'class_name' => $row['class_name'],
      'arm_name'   => $row['arm_name'],
      'overall_average' => $row['overall_average'],
      'promotion_status'  => $row['promotion_status'],
      'terms'      => []
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    ];
  }

  if ($termId) {
    $records[$session][$classId]['terms'][$termId] = [
<<<<<<< HEAD
      'term_name'         => $row['term_name'],
      'total_marks'       => $row['total_marks'],
      'average_marks'     => $row['average_marks'],
      'position_in_class' => $row['position_in_class'],
      'class_size'        => $row['class_size'],
      'overall_grade'     => $row['overall_grade'],
      'session_id'        => $row['session_id'],
      'str_id'            => $row['student_term_record_id'],
      'subjects_results'  => []
=======
      'term_name'        => $row['term_name'],
      'total_marks'      => $row['total_marks'],
      'average_marks'    => $row['average_marks'],
      'position_in_class' => $row['position_in_class'],
      'class_size'       => $row['class_size'],
      'overall_grade'    => $row['overall_grade'],
      'session_id'        => $row['session_id'],
      'str_id'           => $strId,
      'subjects_results' => []
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    ];
  }
}

<<<<<<< HEAD
/* ------------------------------
   3. FETCH ALL SUBJECT RESULTS
------------------------------ */

=======
//  3. Fetch ALL results by student_record_id
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
$stmt = $pdo->prepare("
    SELECT 
        r.student_term_record_id AS str_id,
        r.ca, r.exam, r.total, r.grade, r.remark,
<<<<<<< HEAD

        s.name AS subject_name,

        str.term_id,
        scr.class_id,
        ses.name AS session_name

    FROM results r

    LEFT JOIN student_term_records str 
        ON r.student_term_record_id = str.id
        AND str.deleted_at IS NULL

    LEFT JOIN student_class_records scr 
        ON str.student_class_record_id = scr.id
        AND scr.deleted_at IS NULL

    LEFT JOIN sessions ses 
        ON scr.session_id = ses.id
        AND ses.deleted_at IS NULL

    LEFT JOIN subjects s 
        ON r.subject_id = s.id
        AND s.deleted_at IS NULL

    WHERE scr.student_id = ?
      AND r.deleted_at IS NULL
=======
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
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
");
$stmt->execute([$student_id]);
$scoreRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

<<<<<<< HEAD
/* ------------------------------
   ATTACH RESULTS TO RECORDS
------------------------------ */

foreach ($scoreRows as $row) {

=======
// Attach results into $records
foreach ($scoreRows as $row) {
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
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

<<<<<<< HEAD
/* ------------------------------
   4. SESSION AVERAGES
------------------------------ */
=======
>>>>>>> 271894334d344b716e30670c3770b73d583f3916

$sessionAverages = [];

foreach ($records as $sessionName => $classes) {
  foreach ($classes as $classId => $classData) {

<<<<<<< HEAD
    $sessionAverages[$sessionName][$classId] = [
      'first'  => null,
      'second' => null,
      'third'  => null
    ];

    foreach ($classData['terms'] as $termId => $termData) {

      $name = strtolower(trim($termData['term_name']));
=======
    // Initialize
    $sessionAverages[$sessionName][$classId] = [
      'first' => null,
      'second' => null,
      'third' => null
    ];

    foreach ($classData['terms'] as $termId => $termData) {
      $name = strtolower(trim($termData['term_name'])); // e.g. "first term"
>>>>>>> 271894334d344b716e30670c3770b73d583f3916

      if (strpos($name, 'first') !== false) {
        $sessionAverages[$sessionName][$classId]['first'] = $termData['average_marks'];
      } elseif (strpos($name, 'second') !== false) {
        $sessionAverages[$sessionName][$classId]['second'] = $termData['average_marks'];
      } elseif (strpos($name, 'third') !== false) {
        $sessionAverages[$sessionName][$classId]['third'] = $termData['average_marks'];
      }
    }
  }
}

<<<<<<< HEAD
?>


=======


?>

>>>>>>> 271894334d344b716e30670c3770b73d583f3916

<body class="bg-gray-50">
  <!-- Navigation -->
  <?php include(__DIR__ . '/../includes/admins-section-nav.php'); ?>


  <!-- Page Header -->
  <section class="bg-gradient-to-r from-blue-900 to-blue-700  text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-4xl md:text-5xl font-bold mb-4">Student's Results</h1>
      <p class="text-xl text-blue-200">View Student's Academic Performance</p>
    </div>
  </section>
  <!-- Main Content -->
  <section class="py-8 px-4">
    <div class="max-w-4xl mx-auto">
      <!-- Student Header Information -->
      <div class="bg-gradient-to-r from-blue-900 to-blue-700 text-white rounded-lg shadow-lg p-8 mb-8 no-print">
        <div class="flex items-center gap-6">
          <img src="<?= !empty($studentInfo['picture_path']) ? asset($studentInfo['picture_path']) : asset('/images/avatar.png') ?>"
            alt="Student Photo"
            class="h-24 w-24 rounded-full border-4 border-white object-cover">
          <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold truncate"><?= $studentInfo['name'] ?></h2>
            <p class="text-blue-200"><?= $studentInfo['class_name']  . ' - ' . $studentInfo['arm_name'] ?></p>
            <p class="text-blue-200">Admission: <?= $studentInfo['admission_number'] ?></p>
          </div>
        </div>
      </div>



      <?php if (!empty($records)): ?>
        <?php foreach ($records as $sessionName => $classes): ?>

          <?php foreach ($classes as $classId => $class): ?>
            <?php foreach ($class['terms'] as $term): ?>
              <?php
              $next = getNextTermForRecord(
                $pdo,
                $classId,
                (int)$term['session_id'],
                $term['term_name']
              );
              ?>


              <!-- Printable Student Header -->
              <div class="hidden" style="
                          width:210mm;
                          height:297mm;
                          margin-left:auto;
                          margin-right:auto;
                          background:white;
                          padding:10mm;
                          box-sizing:border-box;
                          border: 1px solid black;
                      ">
                <!-- A4 Container -->
                <div style="width:100%; padding-left: 5px;  padding-right: 5px;" id="result-<?= $term['str_id'] ?>">

                  <!-- HEADER -->
                  <div style="text-align:center; border-bottom:3px solid #000; padding-bottom:8px; margin-bottom:8px;">
                    <div style="font-size:23px; font-weight:bold;"><?= strtoupper($school['name']) ?></div>
                    <div style="
                                font-size:13px;
                                margin-top:5px;
                                width:350px;
                                margin-left:auto;
                                margin-right:auto;
                                text-align:center;
                                white-space:normal;
                                word-wrap:break-word;
                                ">
                      <?= $school['address'] ?>
                    </div>


                    <div style="border:2px solid #000; display:inline-block; padding:6px 20px; margin-top:10px; font-weight:bold; font-size:20px;">
                      Pupil's Report Sheet
                    </div>
                  </div>

                  <!-- STUDENT INFO -->
                  <table style="width:100%; border-collapse:collapse; margin-bottom:10px;">
                    <tr>
                      <td style="font-weight:bold; width:40px; font-size: 11px;">NAME:</td>
                      <td style="border-bottom:1px solid #000;"><?= strtoupper($studentInfo['name']) ?></td>

                      <td style="font-weight:bold; width:120px; font-size: 11px;">ADMISSION NUMBER:</td>
                      <td style="border-bottom:1px solid #000; "><?= strtoupper($studentInfo['admission_number']) ?></td>

                    </tr>
                  </table>

                  <table style="width:100%; border-collapse:collapse; margin-bottom:10px; font-size:11px;">
                    <tr>

                      <td style="font-weight:bold; width:40px; font-size: 11px;">CLASS:</td>
                      <td style="border-bottom:1px solid #000; "><?= htmlspecialchars($class['class_name']) . ' ' . htmlspecialchars($class['arm_name']) ?></td>
                      <td style="font-weight:bold; width:40px; font-size: 11px;">TERM:</td>
                      <td style="border-bottom:1px solid #000; text-align:center; "> <?= htmlspecialchars($term['term_name']) ?>
                      </td>
                      <td style="font-weight:bold; width:40px; font-size: 11px;">SESSION:</td>
                      <td style="border-bottom:1px solid #000; text-align:center; "> <?= htmlspecialchars($sessionName) ?>
                      </td>

                      <!-- Position -->
                      <td style="font-weight:bold;   width:10px;">POSITION:</td>
                      <td style="border-bottom:1px solid #000 ;   text-align:center; width:60px;">
                        <?= $term['position_in_class'] != null ?   ordinal($term['position_in_class']) : 'N/A' ?>
                      </td>

                      <!-- Number of pupils -->
                      <td style="font-weight:bold; width:115px;">NUMBER IN CLASS:</td>
                      <td style="border-bottom:1px solid #000;  text-align:center; width:60px;"> <?= $term['class_size'] ?? 'N/A' ?>
                      </td>

                    </tr>
                  </table>
                  <table style="width:100%; border-collapse:collapse; margin-bottom:10px; font-size:11px;">
                    <tr>

                      <!-- 1st Term -->
                      <td style="font-weight:bold; width:100px; text-align:center;">1st Term Average</td>
                      <td style="border-bottom:1px solid #000; text-align:center;">
                        <?= $sessionAverages[$sessionName][$classId]['first'] ?? 'N/A' ?> %
                      </td>

                      <!-- 2nd Term -->
                      <td style="font-weight:bold; width:100px; text-align:center;">2nd Term Average</td>
                      <td style="border-bottom:1px solid #000; text-align:center;">
                        <?= $sessionAverages[$sessionName][$classId]['second'] ?? 'N/A' ?>%
                      </td>

                      <!-- 3rd Term -->
                      <td style="font-weight:bold; width:95px; text-align:center;">3rd Term Average</td>
                      <td style="border-bottom:1px solid #000; text-align:center;">
                        <?= $sessionAverages[$sessionName][$classId]['third'] ?? 'N/A' ?>%
                      </td>

                      <!-- Total Class Average -->
                      <td style="font-weight:bold; width:95px; text-align:center;">Class Average</td>
                      <td style="border-bottom:1px solid #000; text-align:center;">
                        <?= $records[$sessionName][$classId]['overall_average'] ?? 'N/A' ?>%
                      </td>

                    </tr>
                  </table>


                  <!-- COGNITIVE ACTIVITY -->
                  <div style="font-weight:bold; margin:6px 0 4px 0;">1. COGNITIVE ACTIVITY</div>

                  <table style="width:100%; border-collapse:collapse; font-size:11px; margin-bottom:12px;">
                    <tr>
                      <th style="border:1px solid #000; padding:6px; text-align:left;">SUBJECTS</th>
                      <th style="border:1px solid #000; padding:6px;">CA</th>
                      <th style="border:1px solid #000; padding:6px;">EXAM</th>
                      <th style="border:1px solid #000; padding:6px;">TOTAL</th>
                      <th style="border:1px solid #000; padding:6px;">GRADE</th>
                      <th style="border:1px solid #000; padding:6px;">REMARK</th>
                    </tr>

                    <!-- SUBJECT ROWS -->
                    <?php foreach ($term['subjects_results'] as $result): ?>

                      <tr>
                        <td style="border:1px solid #000; padding:6px; font-weight:bold;"><?= $result['subject_name'] ?></td>
                        <td style="border:1px solid #000;  text-align:center;"><?= $result['ca'] ?></td>
                        <td style="border:1px solid #000;  text-align:center;"><?= $result['exam'] ?></td>
                        <td style="border:1px solid #000;  text-align:center;"><?= $result['total'] ?></td>
                        <td style="border:1px solid #000;  text-align:center;"><?= $result['grade'] ?></td>
                        <td style="border:1px solid #000;  text-align:center;"><?= $result['remark'] ?></td>
                      </tr>
                    <?php endforeach ?>

                    <tr>
                      <td style="border:none;"></td>
                      <td style="border:none;"></td>
                      <td style="border:none;"></td>
                      <td style="border:1px solid #000; text-align:center;"><?= $term['total_marks'] ?></td>
                      <td style="border:none;"></td>
                      <td style="border:none;"></td>
                    </tr>
                  </table>

                  <!-- ATTENDANCE + PSYCHOMOTOR -->
                  <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
                    <tr>

                      <!-- Attendance -->
                      <td style="width:50%; vertical-align:top;">
                        <div style="font-weight:bold; margin-bottom:7px;">2. ATTENDANCE</div>
                        <table style="width:100%; border-collapse:collapse; font-size:12px;">
                          <tr>
                            <td style="border:1px solid #000; font-weight:bold;padding:3px 5px; ">Frequencies</td>
                            <td style="border:1px solid #000; font-weight:bold; padding:3px 5px;">School attended</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Number of Times School Opened</td>
                            <td style="border:1px solid #000; text-align:center;">86</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Number of Times Present</td>
                            <td style="border:1px solid #000; text-align:center;">92</td>
                          </tr>
                        </table>
                      </td>

                      <!-- Psychomotor -->
                      <td style="width:50%; vertical-align:top;">
                        <div style="font-weight:bold; margin-bottom:7px;">3. PSYCHOMOTOR SKILLS</div>
                        <table style="width:100%; border-collapse:collapse; font-size:11px;">
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Verbal fluency</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Sports</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Games</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Drawing painting</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Musical skills</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>
                        </table>
                      </td>

                    </tr>
                  </table>

                  <!-- AFFECTIVE AREAS + GRADING SCALE -->
                  <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
                    <tr>

                      <!-- Affective Areas -->
                      <td style="width:50%; vertical-align:top;">
                        <div style="font-weight:bold; margin-bottom:7px;">4. AFFECTIVE AREAS</div>
                        <table style="width:100%; border-collapse:collapse; font-size:10px;">
                          <tr>
                            <th style="border:1px solid #000; text-align:left; padding:3px 5px;">Attributes</th>
                            <th style="border:1px solid #000;">5</th>
                            <th style="border:1px solid #000;">4</th>
                            <th style="border:1px solid #000;">3</th>
                            <th style="border:1px solid #000;">2</th>
                            <th style="border:1px solid #000;">1</th>
                          </tr>

                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Punctuality</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>

                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Neatness</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>

                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Politeness</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>

                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Honesty</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>

                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Cooperation in school</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>

                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Attentiveness</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>

                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">Leadership</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                            <td style="border:1px solid #000;">&nbsp;</td>
                          </tr>
                        </table>
                      </td>

                      <!-- Grading Scale -->
                      <td style="width:50%; vertical-align:top;">
                        <div style="font-size:11px; margin-top: 5px; margin-bottom:7px;">
                          Scale: 5-EXCELLENT, 4-GOOD, 3-FAIR, 2-POOR, 1-VERY POOR
                        </div>

                        <table style="width:100%; border-collapse:collapse; font-size:10px;">
                          <tr>
                            <th style="border:1px solid #000; padding:3px 5px;">Scores</th>
                            <th style="border:1px solid #000; padding:3px 5px;">Grade</th>
                            <th style="border:1px solid #000; padding:3px 5px;">Remark</th>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">75 - 100</td>
                            <td style="border:1px solid #000; padding:3px 5px;">A</td>
                            <td style="border:1px solid #000; padding:3px 5px;">EXCELLENT</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">60 - 74</td>
                            <td style="border:1px solid #000; padding:3px 5px;">B</td>
                            <td style="border:1px solid #000; padding:3px 5px;">V.GOOD</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">50 - 59</td>
                            <td style="border:1px solid #000; padding:3px 5px;">C</td>
                            <td style="border:1px solid #000; padding:3px 5px;">GOOD</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">40 - 49</td>
                            <td style="border:1px solid #000; padding:3px 5px;">D</td>
                            <td style="border:1px solid #000; padding:3px 5px;">FAIR</td>
                          </tr>
                          <tr>
                            <td style="border:1px solid #000; padding:3px 5px;">0 - 39</td>
                            <td style="border:1px solid #000; padding:3px 5px;">E</td>
                            <td style="border:1px solid #000; padding:3px 5px;">POOR</td>
                          </tr>
                        </table>
                      </td>

                    </tr>
                  </table>

                  <!-- FOOTER -->
                  <div style="margin-top:20px; font-size:13px;">
                    <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
                      <tr>
                        <td style="font-weight:bold; width:145px;">PROMOTION STATUS:</td>
                        <td style="border-bottom:1px solid   #000;">
                          <?= ucfirst($class['promotion_status'] ?? 'pending') ?>
                        </td>
                      </tr>
                    </table>

                    <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
                      <tr>
                        <td style="font-weight:bold; width:200px; ">CLASS TEACHER'S COMMENT:</td>
                        <td style="border-bottom:1px solid #000;"> <?php if ($term['average_marks'] >= 75) : ?>
                            Excellent performance! Keep up the outstanding work.
                          <?php elseif (($term['average_marks'] >= 60) && ($term['average_marks'] <= 74)) : ?>
                            Very good! You can achieve even more with consistent effort.
                          <?php elseif (($term['average_marks'] >= 50) && ($term['average_marks'] <= 59)) : ?>
                            Good effort, Focus on your weaker areas to improve further.
                          <?php elseif (($term['average_marks'] >= 40) && ($term['average_marks'] <= 49)) : ?>
                            Fair performance, Needs improvement in some subjects.
                          <?php elseif (($term['average_marks'] >= 0) && ($term['average_marks'] <= 39)) : ?>
                            Poor performance, Needs serious improvement and guidance.
                          <?php endif ?></td>
                      </tr>
                    </table>

                    <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
                      <tr>
                        <td style="font-weight:bold; width:135px;">NEXT TERM BEGINS:</td>
                        <td style="border-bottom:1px solid #000; "><?= $next['start'] ? date('D d M, Y', strtotime($next['start'])) : 'N/A' ?>
                        </td>

                        <td style="font-weight:bold; width:120px;">NEXT TERM FEES:</td>
                        <td style="border-bottom:1px solid #000; ">
                          <?= $next['fee'] ? '<span style="font-family: DejaVu Sans, sans-serif;">₦</span>' . number_format($next['fee'], 2) : 'N/A' ?>
                        </td>
                      </tr>
                    </table>
                    <table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
                      <tr>
                        <td style="font-weight:bold; width:200px;">HEAD TEACHER'S COMMENT:</td>
                        <td style="border-bottom:1px solid #000;"> <?php if ($term['average_marks'] >= 75) : ?>
                            Keep striving for excellence. Very proud of your achievement!
                          <?php elseif (($term['average_marks'] >= 60) && ($term['average_marks'] <= 74)) : ?>
                            Good work. Maintain this standard and aim higher.
                          <?php elseif (($term['average_marks'] >= 50) && ($term['average_marks'] <= 59)) : ?>
                            Encouraging progress. With more effort, better results are possible.
                          <?php elseif (($term['average_marks'] >= 40) && ($term['average_marks'] <= 49)) : ?>
                            Needs improvement. Focus on studies to reach higher grades.
                          <?php elseif (($term['average_marks'] >= 0) && ($term['average_marks'] <= 39)) : ?>
                            Unsatisfactory performance. Immediate action and commitment required
                          <?php endif ?></td>
                      </tr>
                    </table>

                    <table style="width:100%; border-collapse:collapse; margin-bottom:6px;">
                      <tr>
                        <td style="font-weight:bold; width:70px;">Signature:</td>
                        <td style="border-bottom:1px solid #000; width:120px;"></td>
                        <td style="text-align:right; font-weight:bold;">Date:</td>
                        <td style="border-bottom:1px solid #000; width:80px;"></td>
                      </tr>
                    </table>

                  </div> <!-- end footer -->

                </div> <!-- end A4 container -->

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
                  <button onclick="printReportCard('result-<?= $term['str_id'] ?>')" class="no-print bg-blue-900 hover:bg-blue-800 text-white px-6 py-2 rounded-lg font-semibold flex items-center gap-2">
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
  <?php include(__DIR__ . '/../../../includes/footer.php'); ?>


  <script>
    function printReportCard(divId) {
      // Grab only the div content
      var html = document.getElementById(divId).outerHTML;

      // Send to PHP
      fetch("<?= route('print') ?>", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: "html=" + encodeURIComponent(html),
        })
        .then((response) => response.blob())
        .then((blob) => {
          var url = window.URL.createObjectURL(blob);
          window.open(url); // open PDF in new tab
        });
    }
  </script>
</body>

</html>