<?php
$title = "Delete Confirmation";
include(__DIR__ . '/../../../includes/header.php');

if (!$is_logged_in) {
  $_SESSION['failure'] = "Login is Required!";
  header("Location: " . route('home'));
  exit();
}

if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET['id'])) {
  $id = (int) $_GET['id'];

  $stmt = $pdo->prepare("SELECT * FROM classes WHERE id = ?");
  $stmt->execute([$id]);
  $class = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$class) {
    header('Location: ' . route('back'));
    exit();
  }
} else {
  header('Location: ' . route('back'));
  exit();
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {

    die('CSRF validation failed. Please refresh and try again.');
  } else {

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }


  $id = (int) trim($_POST['id'] ?? '');

  if (empty($id)) {
    $errors['id'] = 'Class Not Found';
  }

  if (empty($errors)) {
    $stmt = $pdo->prepare("UPDATE classes SET deleted_at = NOW() WHERE id = ?");
    $success = $stmt->execute([$id]);

    if ($success) {
      $_SESSION['success'] = "Class Deleted successfully!";
      header("Location: " . route('back'));
      exit();
    } else {
      echo "<script>alert('Failed to delete a Class');</script>";
    }
  } else {
    foreach ($errors as $field => $error) {
      echo "<p class='text-red-600 font-semibold'>$error</p>";
    }
  }
}
?>


<body class="bg-gray-50">
  <!-- Navigation -->


  <!-- Main Content -->
  <section
    class="py-12 bg-gray-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-auto px-4">
      <form method="POST" class="bg-white rounded-lg shadow-lg p-8">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
        <input type="hidden" name="id" value="<?= $class['id'] ?>">

        <!-- Warning Icon -->
        <div class="flex justify-center mb-6">
          <div class="bg-red-100 rounded-full p-4">
            <i class="fas fa-exclamation-triangle text-red-600 text-4xl"></i>
          </div>
        </div>

        <!-- Title -->
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-2">
          Delete Class
        </h2>
        <p class="text-gray-600 text-center mb-6">
          Are you sure you want to delete this Class?
        </p>

        <!-- class Details -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
          <div class="space-y-3">
            <div>
              <p class="text-sm text-gray-600">Class Name</p>
              <p class="text-lg font-semibold text-gray-900" id="className">
                <?= $class['name'] ?? '-' ?>
              </p>
            </div>

          </div>
        </div>

        <!-- Warning Message -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
          <p class="text-sm text-red-800">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Warning:</strong> This action cannot be undone. All
            associated data will be permanently deleted.
          </p>
        </div>

        <!-- Confirmation Checkbox -->
        <div class="mb-6">
          <label class="flex items-center gap-3 cursor-pointer">
            <input
              type="checkbox"
              id="confirmCheckbox"
              class="w-4 h-4 text-red-600 rounded focus:ring-2 focus:ring-red-500" />
            <span class="text-sm text-gray-700">I understand this action is permanent and cannot be
              reversed</span>
          </label>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4">
          <a href="<?= route('back') ?>"
            id="cancelBtn"
            class="flex-1 bg-gray-300 text-center text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
            <i class="fas fa-times mr-2"></i>Cancel
          </a>
          <button
            id="deleteBtn"
            type="submit"
            disabled
            class="flex-1 bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
            <i class="fas fa-trash mr-2"></i>Delete Account
          </button>
        </div>
      </form>
    </div>
  </section>

  <script>
    // Confirmation checkbox
    const confirmCheckbox = document.getElementById("confirmCheckbox");
    const deleteBtn = document.getElementById("deleteBtn");

    confirmCheckbox.addEventListener("change", () => {
      deleteBtn.disabled = !confirmCheckbox.checked;
    });
  </script>
</body>

</html>