<?php
$title = "Reset Password";
include(__DIR__ . '/./includes/non-auth-header.php');

$errorMessage = null;
$showSuccess  = null;

//  CSRF token generation for GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$token = $_GET['token'] ?? null;
if (!$token) {
    $errorMessage = "Invalid reset token";
}

// Hash the incoming token to match stored hash
$tokenHash = $token ? hash('sha256', $token) : null;

// Tables to check
$tables   = ['admins', 'teachers', 'guardians', 'students'];
$userTable = null;
$userId    = null;

//  Find token
if ($tokenHash) {
    foreach ($tables as $table) {
        $stmt = $pdo->prepare("SELECT id, reset_expires FROM $table WHERE reset_token = ? LIMIT 1");
        $stmt->execute([$tokenHash]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (new DateTime() > new DateTime($row['reset_expires'])) {
                $errorMessage = "Reset link expired";
            } else {
                $userTable = $table;
                $userId    = $row['id'];
            }
            break;
        }
    }
}

if (!$userTable && !$errorMessage) {
    $errorMessage = "Invalid or expired reset token";
}

//  Handle POST (password reset)
if ($_SERVER["REQUEST_METHOD"] === "POST" && $userTable) {
    // CSRF validation
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errorMessage = "Invalid request. Please refresh and try again.";
    } else {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // regenerate after validation

        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm_password'] ?? '');

        if ($password !== $confirm) {
            $errorMessage = "Passwords do not match";
        } elseif (strlen($password) < 8) {
            $errorMessage = "Password must be at least 8 characters long";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            try {
                //  Transaction ensures atomic update
                $pdo->beginTransaction();

                $stmt = $pdo->prepare("UPDATE $userTable 
                    SET password = ?, reset_token = NULL, reset_expires = NULL 
                    WHERE id = ?");
                $stmt->execute([$hashed, $userId]);

                $pdo->commit();
                $showSuccess = true;
            } catch (PDOException $e) {
                $pdo->rollBack();
                $errorMessage = "Database error: " . htmlspecialchars($e->getMessage());
            }
        }
    }
}
?>



<body class="bg-gray-50">
    <!-- Reset Password Section -->
    <section class="py-16 bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <!-- Reset Password Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-900 rounded-full mb-4">
                        <i class="fas fa-lock text-white text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
                    <p class="text-gray-600 mt-2">Create a new secure password</p>
                </div>

                <!-- Success Message -->
                <div id="success-message"
                    class="<?php echo isset($showSuccess) ? '' : 'hidden'; ?> mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-0.5"></i>
                        <div>
                            <h3 class="font-semibold text-green-900">Password Reset Successful!</h3>
                            <p class="text-sm text-green-700 mt-1">
                                Your password has been successfully reset. You can now login with your new password.
                            </p>

                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <?php if (isset($errorMessage)): ?>
                    <div id="error-message"
                        class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3 mt-0.5"></i>
                            <div>
                                <p class="text-sm text-red-700 mt-1">
                                    <?= $errorMessage ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <!-- Reset Password Form -->
                <form id="reset-password-form"
                    method="POST"
                    class="space-y-6"
                    style="<?php echo isset($showSuccess) ? 'display:none;' : ''; ?>">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                    <!-- Password Requirements Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="font-semibold text-blue-900 text-sm mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Password Requirements:
                        </h3>
                        <ul class="text-xs text-blue-800 space-y-1">
                            <li><i class="fas fa-circle text-xs mr-2"></i>At least 8 characters long</li>
                            <li><i class="fas fa-circle text-xs mr-2"></i>Contains uppercase letter</li>
                            <li><i class="fas fa-circle text-xs mr-2"></i>Contains lowercase letter</li>
                            <li><i class="fas fa-circle text-xs mr-2"></i>Contains a number</li>
                        </ul>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-900"></i>New Password
                        </label>
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                            placeholder="Enter new password">
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="confirm_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-900"></i>Confirm New Password
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                            placeholder="Confirm new password">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow-lg hover:shadow-xl">
                        <i class="fas fa-check mr-2"></i>Reset Password
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
                    <a href="<?= route('login') ?>" class="inline-flex items-center text-blue-900 hover:text-blue-700 font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>
                        back to Login
                    </a>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    <i class="fas fa-shield-alt mr-2 text-blue-900"></i>
                    Your password is encrypted and secure
                </p>
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