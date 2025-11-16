<?php
$title = "Manage Subject";
include(__DIR__ . '/../../includes/header.php');

$stmt = $conn->prepare("SELECT * 
from sections
");
$stmt->execute();
$sections = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

?>

<body class="bg-gray-50">
  <!-- Navigation -->
  <?php include(__DIR__ . '/../../includes/nav.php'); ?>


  <!-- Page Header -->
  <section
    class="bg-gradient-to-r from-blue-900 to-blue-700 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
      <h1 class="text-4xl md:text-5xl font-bold mb-4">
        Manage Subjects Results
      </h1>
      <p class="text-xl text-blue-200">
        Create and update student results by subject
      </p>
    </div>
  </section>

  <!-- Main Content -->
  <section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Filters Section -->
      <div
        class="bg-gradient-to-r from-indigo-900 to-indigo-700 text-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
          <i class="fas fa-filter"></i>Filter Results
        </h2>
        <div class="grid md:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-2">Term</label>
            <select
              id="termSelect"
              class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-400">
              <option value="">-- Select Term --</option>
              <option value="First Term">First Term</option>
              <option value="Second Term">Second Term</option>
              <option value="Third Term">Third Term</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-semibold mb-2">Session</label>
            <select
              id="sessionSelect"
              class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-400">
              <option value="">-- Select Session --</option>
              <option value="2024/2025">2024/2025</option>
              <option value="2023/2024">2023/2024</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-semibold mb-2">Search Subject</label>
            <input
              type="text"
              id="searchInput"
              placeholder="Search subjects..."
              class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
          </div>
          <div>
            <label class="block text-sm font-semibold mb-2">Filter by Section</label>
            <select
              id="sectionFilter"
              class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-400">
              <option value="">All Sections</option>
              <option value="Primary">Primary</option>
              <option value="Junior Secondary">Junior Secondary</option>
              <option value="Senior Secondary">Senior Secondary</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Statistics -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div
          class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-900">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-600 text-sm">Total Subjects</p>
              <p class="text-3xl font-bold text-blue-900">24</p>
            </div>
            <i class="fas fa-book text-4xl text-blue-200"></i>
          </div>
        </div>
        <div
          class="bg-white rounded-lg shadow p-4 border-l-4 border-green-600">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-600 text-sm">Results Uploaded</p>
              <p class="text-3xl font-bold text-green-600">18</p>
            </div>
            <i class="fas fa-check-circle text-4xl text-green-200"></i>
          </div>
        </div>
        <div
          class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-600">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-600 text-sm">Pending</p>
              <p class="text-3xl font-bold text-yellow-600">6</p>
            </div>
            <i class="fas fa-hourglass-half text-4xl text-yellow-200"></i>
          </div>
        </div>
        <div
          class="bg-white rounded-lg shadow p-4 border-l-4 border-purple-600">
          <div class="flex items-center justify-between">
            <div>
              <p class="text-gray-600 text-sm">Current Session</p>
              <p class="text-2xl font-bold text-purple-600">2024/2025</p>
            </div>
            <i class="fas fa-calendar text-4xl text-purple-200"></i>
          </div>
        </div>
      </div>

      <!-- Sections with Subjects -->
      <div id="sectionsContainer" class="space-y-8">
        <!-- PRIMARY SECTION -->
        <div
          class="section-container bg-white rounded-lg shadow-lg overflow-hidden"
          data-section="Primary">
          <div class="bg-yellow-900 text-white p-6 flex items-center gap-3">
            <i class="fas fa-book text-3xl opacity-80"></i>
            <div>
              <h2 class="text-2xl font-bold">Primary Section</h2>
              <p class="text-sm opacity-90">6 subjects</p>
            </div>
          </div>
          <div class="p-6 space-y-4">
            <!-- English Language -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="English Language"
              data-section="Primary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    English Language
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">Primary 1-6</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">218</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 10, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=English%20Language&section=Primary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=English%20Language&section=Primary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Mathematics -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Mathematics"
              data-section="Primary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Mathematics
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">Primary 1-6</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">218</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">Pending</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Not yet</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Mathematics&section=Primary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Mathematics&section=Primary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Basic Science -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Basic Science"
              data-section="Primary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Basic Science
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">Primary 1-6</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">218</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 9, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Basic%20Science&section=Primary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Basic%20Science&section=Primary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Social Studies -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Social Studies"
              data-section="Primary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Social Studies
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">Primary 1-6</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">218</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 8, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Social%20Studies&section=Primary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Social%20Studies&section=Primary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Physical Education -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Physical Education"
              data-section="Primary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Physical Education
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">Primary 1-6</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">218</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">Pending</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Not yet</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Physical%20Education&section=Primary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Physical%20Education&section=Primary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Computer Studies -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Computer Studies"
              data-section="Primary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Computer Studies
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">Primary 3-6</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">156</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 7, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Computer%20Studies&section=Primary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Computer%20Studies&section=Primary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- JUNIOR SECONDARY SECTION -->
        <div
          class="section-container bg-white rounded-lg shadow-lg overflow-hidden"
          data-section="Junior Secondary">
          <div class="bg-purple-900 text-white p-6 flex items-center gap-3">
            <i class="fas fa-graduation-cap text-3xl opacity-80"></i>
            <div>
              <h2 class="text-2xl font-bold">Junior Secondary Section</h2>
              <p class="text-sm opacity-90">9 subjects</p>
            </div>
          </div>
          <div class="p-6 space-y-4">
            <!-- English Language -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="English Language"
              data-section="Junior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    English Language
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">JSS 1-3</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">127</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 10, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=English%20Language&section=Junior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=English%20Language&section=Junior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Mathematics -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Mathematics"
              data-section="Junior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Mathematics
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">JSS 1-3</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">127</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 10, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Mathematics&section=Junior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Mathematics&section=Junior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Integrated Science -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Integrated Science"
              data-section="Junior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Integrated Science
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">JSS 1-3</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">127</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">Pending</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Not yet</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Integrated%20Science&section=Junior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Integrated%20Science&section=Junior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Social Studies -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Social Studies"
              data-section="Junior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Social Studies
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">JSS 1-3</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">127</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 9, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Social%20Studies&section=Junior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Social%20Studies&section=Junior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Computer Studies -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Computer Studies"
              data-section="Junior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Computer Studies
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">JSS 1-3</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">127</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 8, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Computer%20Studies&section=Junior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Computer%20Studies&section=Junior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Physical Education -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Physical Education"
              data-section="Junior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Physical Education
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">JSS 1-3</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">127</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">Pending</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Not yet</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Physical%20Education&section=Junior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Physical%20Education&section=Junior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- French Language -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="French Language"
              data-section="Junior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    French Language
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">JSS 1-3</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">127</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 7, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=French%20Language&section=Junior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=French%20Language&section=Junior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Religious Studies -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Religious Studies"
              data-section="Junior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Religious Studies
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">JSS 1-3</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">127</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">Pending</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Not yet</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Religious%20Studies&section=Junior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Religious%20Studies&section=Junior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- SENIOR SECONDARY SECTION -->
        <div
          class="section-container bg-white rounded-lg shadow-lg overflow-hidden"
          data-section="Senior Secondary">
          <div class="bg-red-900 text-white p-6 flex items-center gap-3">
            <i class="fas fa-university text-3xl opacity-80"></i>
            <div>
              <h2 class="text-2xl font-bold">Senior Secondary Section</h2>
              <p class="text-sm opacity-90">12+ subjects</p>
            </div>
          </div>
          <div class="p-6 space-y-4">
            <!-- English Language -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="English Language"
              data-section="Senior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    English Language
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">SSS 1-3</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">144</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 10, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=English%20Language&section=Senior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=English%20Language&section=Senior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Mathematics -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Mathematics"
              data-section="Senior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Mathematics
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">SSS 1-3</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">144</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 10, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Mathematics&section=Senior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Mathematics&section=Senior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Physics -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Physics"
              data-section="Senior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Physics
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">
                        SSS 1-3 (Science)
                      </p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">96</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-yellow-100 text-yellow-900 rounded-full text-xs font-semibold">Pending</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Not yet</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Physics&section=Senior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Physics&section=Senior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Chemistry -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Chemistry"
              data-section="Senior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Chemistry
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">
                        SSS 1-3 (Science)
                      </p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">96</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 9, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Chemistry&section=Senior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Chemistry&section=Senior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>

            <!-- Biology -->
            <div
              class="subject-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
              data-subject="Biology"
              data-section="Senior Secondary">
              <div
                class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                  <h3 class="text-lg font-bold text-gray-900 mb-2">
                    Biology
                  </h3>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                      <p class="text-gray-600">Classes</p>
                      <p class="font-semibold text-gray-900">
                        SSS 1-3 (Science)
                      </p>
                    </div>
                    <div>
                      <p class="text-gray-600">Students</p>
                      <p class="font-semibold text-gray-900">96</p>
                    </div>
                    <div>
                      <p class="text-gray-600">Status</p>
                      <span
                        class="px-2 py-1 bg-green-100 text-green-900 rounded-full text-xs font-semibold">Uploaded</span>
                    </div>
                    <div>
                      <p class="text-gray-600">Last Updated</p>
                      <p class="font-semibold text-gray-900">Nov 8, 2025</p>
                    </div>
                  </div>
                </div>
                <div class="flex flex-col gap-2 md:w-auto">
                  <a
                    href="teacher-bulk-results.html?subject=Biology&section=Senior%20Secondary"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Create
                  </a>
                  <a
                    href="teacher-bulk-results.html?subject=Biology&section=Senior%20Secondary&edit=true"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fas fa-edit"></i> Update
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include(__DIR__ . '/../../includes/footer.php'); ?>


  <script>
    function filterSubjects() {
      const searchTerm = document
        .getElementById("searchInput")
        .value.toLowerCase();
      const selectedSection = document.getElementById("sectionFilter").value;

      const sections = document.querySelectorAll(".section-container");
      let visibleSections = 0;

      sections.forEach((section) => {
        const sectionName = section.getAttribute("data-section");

        if (selectedSection && selectedSection !== sectionName) {
          section.style.display = "none";
          return;
        }

        const subjectItems = section.querySelectorAll(".subject-item");
        let visibleSubjects = 0;

        subjectItems.forEach((subjectItem) => {
          const subjectName = subjectItem
            .getAttribute("data-subject")
            .toLowerCase();
          const matches = subjectName.includes(searchTerm);

          subjectItem.style.display = matches ? "block" : "none";
          if (matches) visibleSubjects++;
        });

        section.style.display = visibleSubjects > 0 ? "block" : "none";
        if (visibleSubjects > 0) visibleSections++;
      });
    }

    document
      .getElementById("searchInput")
      .addEventListener("input", filterSubjects);
    document
      .getElementById("sectionFilter")
      .addEventListener("change", filterSubjects);
    document.getElementById("termSelect").addEventListener("change", () => {
      const term = document.getElementById("termSelect").value;
      if (term) alert(`Selected Term: ${term}`);
    });
    document
      .getElementById("sessionSelect")
      .addEventListener("change", () => {
        const session = document.getElementById("sessionSelect").value;
        if (session) alert(`Selected Session: ${session}`);
      });
  </script>
</body>

</html>