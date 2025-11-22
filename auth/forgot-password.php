<?php
$title = "Forgot Password";
include(__DIR__ . '/./includes/non-auth-header.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = trim($_POST['email']);

  $tables = ['admins', 'teachers', 'guardians', 'students'];
  $userTable = null;

  foreach ($tables as $table) {
    $stmt = $conn->prepare("SELECT id FROM $table WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
      $userTable = $table;
      break;
    }
  }

  if (!$userTable) {
    $emailError = "Email not found";
  } else {
    // Generate token
    $token = bin2hex(random_bytes(32));
    $expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $stmt = $conn->prepare(
      "UPDATE $userTable SET reset_token=?, reset_expires=? WHERE email=?"
    );
    $stmt->bind_param("sss", $token, $expires_at, $email);
    $stmt->execute();

    // For now just show success block (later you’ll send email)
    $showSuccess = true;
    $resetLink = "http://localhost/tauheed-academy-project/auth/reset-password.php?token=$token";
  }
}
?>

<body class="bg-gray-50">
  <!-- Forgot Password Section -->
  <section class="py-16 bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center">
    <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 w-full">
      <!-- Forgot Password Card -->
      <div class="bg-white rounded-2xl shadow-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
          <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-900 rounded-full mb-4">
            <i class="fas fa-key text-white text-2xl"></i>
          </div>
          <h2 class="text-3xl font-bold text-gray-900">Forgot Password?</h2>
          <p class="text-gray-600 mt-2">
            No worries, we'll send you reset instructions
          </p>
        </div>

        <!-- Success Message -->
        <div id="success-message"
          class="<?php echo isset($showSuccess) ? '' : 'hidden'; ?> mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
          <div class="flex items-start">
            <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-0.5"></i>
            <div>
              <h3 class="font-semibold text-green-900">Email Sent!</h3>
              <p class="text-sm text-green-700 mt-1">
                We've sent password reset instructions to your email address.
                Please check your inbox and spam folder.
              </p>
              <?php if (isset($resetLink)): ?>
                <p class="text-xs text-green-600 mt-2">
                  <strong>Debug Reset Link:</strong>
                  <a href="<?= $resetLink ?>" class="text-blue-700 underline"><?= $resetLink ?></a>
                </p>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- Error Message -->
        <?php if (isset($emailError)): ?>
          <div id="error-message"
            class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-start">
              <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3 mt-0.5"></i>
              <div>
                <p class="text-sm text-red-700 mt-1">
                  <?= $emailError ?>
                </p>
              </div>
            </div>
          </div>
        <?php endif ?>

        <!-- Forgot Password Form -->
        <form id="forgot-password-form"
          method="POST"
          class="space-y-6"
          style="<?php echo isset($showSuccess) ? 'display:none;' : ''; ?>">
          <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-envelope mr-2 text-blue-900"></i>Email Address
            </label>
            <input type="email"
              id="email"
              name="email"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
              placeholder="Enter your registered email" />
            <p class="text-xs text-gray-500 mt-2">
              Enter the email address associated with your account
            </p>
          </div>

          <!-- Submit Button -->
          <button type="submit"
            class="w-full bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow-lg hover:shadow-xl">
            <i class="fas fa-paper-plane mr-2"></i>Send Reset Link
          </button>
        </form>

        <!-- Divider -->
        <div class="relative my-6">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white text-gray-500">Or</span>
          </div>
        </div>

        <!-- Back to Login -->
        <div class="text-center">
          <a href="<?= route('login') ?>"
            class="inline-flex items-center text-blue-900 hover:text-blue-700 font-semibold">
            <i class="fas fa-arrow-left mr-2"></i>
            back to Login
          </a>
        </div>
      </div>

      <!-- Additional Help -->
      <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h3 class="font-semibold text-blue-900 mb-2">
          <i class="fas fa-info-circle mr-2"></i>Need Help?
        </h3>
        <p class="text-sm text-blue-800 mb-3">
          If you're having trouble resetting your password, please contact our support team:
        </p>
        <div class="space-y-1 text-sm text-blue-900">
          <p><i class="fas fa-phone mr-2"></i>+234 800 123 4567</p>
          <p><i class="fas fa-envelope mr-2"></i>support@excellenceacademy.edu</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Scripts -->
  <script>
    let error = document.getElementById("error-message");
    if (error) {
      setTimeout(() => {
        error.classList.add("hidden");
      }, 5000);
    }
  </script>
</body>

</html>