<?php
<<<<<<< HEAD

$title = "Update Bank Account";
include(__DIR__ . '/../../../includes/header.php');

/* ------------------------------
   AUTHENTICATION & ACCESS CHECKS
------------------------------ */

=======
$title = "Update Bank Account";
include(__DIR__ . '/../../../includes/header.php');

>>>>>>> 271894334d344b716e30670c3770b73d583f3916
if (!$is_logged_in) {
    $_SESSION['failure'] = "Login is Required!";
    header("Location: " . route('home'));
    exit();
}

if (!isset($user_type) || $user_type !== 'admin') {
    $_SESSION['failure'] = "Access denied! Only Admins are allowed.";
    header("Location: " . route('home'));
    exit();
}

<<<<<<< HEAD
/* ------------------------------
   CSRF TOKEN
------------------------------ */
=======
>>>>>>> 271894334d344b716e30670c3770b73d583f3916

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

<<<<<<< HEAD
/* ------------------------------
   FETCH BANK ACCOUNT TO EDIT
------------------------------ */

if (!isset($_GET['id'])) {
=======
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare('SELECT * FROM bank_accounts WHERE id = ?');
    $stmt->execute([$id]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$account) {
        header('Location: ' . route('back'));
        exit();
    }
} else {
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    header('Location: ' . route('back'));
    exit();
}

<<<<<<< HEAD
$id = (int) $_GET['id'];

$stmt = $pdo->prepare("
    SELECT * 
    FROM bank_accounts 
    WHERE id = ? AND deleted_at IS NULL
");
$stmt->execute([$id]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$account) {
    header('Location: ' . route('back'));
    exit();
}

/* ------------------------------
   FORM PROCESSING
------------------------------ */

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ------------------------------
       CSRF VALIDATION
    ------------------------------ */
=======
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die('CSRF validation failed. Please refresh and try again.');
    }

<<<<<<< HEAD
    // Regenerate token after validation
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    /* ------------------------------
       SANITIZE INPUT
    ------------------------------ */
    $bankName       = htmlspecialchars(trim($_POST['bankName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $accountPurpose = htmlspecialchars(trim($_POST['accountPurpose'] ?? ''), ENT_QUOTES, 'UTF-8');
    $accountName    = htmlspecialchars(trim($_POST['accountName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $accountNumber  = htmlspecialchars(trim($_POST['accountNumber'] ?? ''), ENT_QUOTES, 'UTF-8');

    /* ------------------------------
       VALIDATION
    ------------------------------ */
=======
    $bankName       = trim($_POST['bankName'] ?? '');
    $accountPurpose = trim($_POST['accountPurpose'] ?? '');
    $accountName    = trim($_POST['accountName'] ?? '');
    $accountNumber  = trim($_POST['accountNumber'] ?? '');

>>>>>>> 271894334d344b716e30670c3770b73d583f3916
    if (empty($bankName)) {
        $errors['nameError'] = "Bank name is required";
    }

    if (empty($accountPurpose)) {
        $errors['accountPurpose'] = "Account purpose is required";
    }

    if (empty($accountName)) {
        $errors['accountName'] = "Account name is required";
    }

    if (empty($accountNumber)) {
        $errors['accountNumber'] = "Account number is required";
    }

<<<<<<< HEAD
    /* ------------------------------
       UPDATE BANK ACCOUNT
    ------------------------------ */
    if (empty($errors)) {

        $stmt = $pdo->prepare("
            UPDATE bank_accounts 
            SET 
                bank_name = ?, 
                purpose = ?, 
                account_name = ?, 
                account_number = ?, 
                updated_at = NOW()
            WHERE id = ? AND deleted_at IS NULL
        ");

        $success = $stmt->execute([
            $bankName,
            $accountPurpose,
            $accountName,
            $accountNumber,
            $id
        ]);

        if ($success) {
            $_SESSION['success'] = "Bank Account updated successfully!";
            header("Location: " . route('back'));
            exit();
        }

        echo "<script>alert('Failed to update bank account');</script>";
    }

    /* ------------------------------
       DISPLAY ERRORS
    ------------------------------ */
    foreach ($errors as $error) {
        echo "<p class='text-red-600 font-semibold'>$error</p>";
    }
}

=======
    if (empty($errors)) {
        $stmt = $pdo->prepare("
            UPDATE bank_accounts 
            SET bank_name = ?, purpose = ?, account_name = ?, account_number = ?
            WHERE id = ?
        ");
        $success = $stmt->execute([$bankName, $accountPurpose, $accountName, $accountNumber, $id]);

        if ($success) {
            $_SESSION['success'] = "Bank Account Updated successfully!";
            header("Location: " . route('back'));
            exit();
        } else {
            echo "<script>alert('Failed to update bank account');</script>";
        }
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}
>>>>>>> 271894334d344b716e30670c3770b73d583f3916
?>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . "/../includes/admins-section-nav.php") ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Add Bank Account</h1>
            <p class="text-xl text-blue-200">Add a new bank account for school fees collection</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <!-- Form Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">New Bank Account Details</h2>
                    <p class="text-gray-600">Fill in all the required information for the bank account</p>
                </div>

                <!-- Form -->
                <form id="bankAccountForm" class="space-y-8" method="post">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                    <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                    <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                    <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>

                    <!-- Bank Information Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-bank text-blue-900"></i>
                            Bank Information
                        </h3>

                        <!-- Bank Name -->
                        <div class="mb-6">
                            <label for="bankName" class="block text-gray-700 font-semibold mb-2">
                                Bank Name <span class="text-red-500">*</span>
                            </label>
                            <input id="bankName" name="bankName" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Eg. UBA Bank, Zenith Bank,GT Bank" value="<?= $account['bank_name'] ?>">
                            <span class="text-red-500 text-sm hidden" id="bankNameError"></span>

                        </div>

                        <!-- Account Purpose -->
                        <div class="mb-6">
                            <label for="accountPurpose" class="block text-gray-700 font-semibold mb-2">
                                Account Purpose <span class="text-red-500">*</span>
                            </label>
                            <input id="accountPurpose" name="accountPurpose" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="For Transport Fees" value="<?= $account['purpose'] ?>">
                            <span class="text-red-500 text-sm hidden" id="accountPurposeError"></span>

                        </div>
                    </div>

                    <!-- Account Details Section -->
                    <div class="border-b pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="fas fa-credit-card text-blue-900"></i>
                            Account Details
                        </h3>

                        <!-- Account Name -->
                        <div class="mb-6">
                            <label for="accountName" class="block text-gray-700 font-semibold mb-2">
                                Account Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="accountName" name="accountName" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="<?= $school['name'] ?>" value="<?= $account['account_name'] ?>">
                            <span class="text-red-500 text-sm hidden" id="accountNameError"></span>

                        </div>

                        <!-- Account Number -->
                        <div class="mb-6">
                            <label for="accountNumber" class="block text-gray-700 font-semibold mb-2">
                                Account Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="accountNumber" name="accountNumber" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="1234567890" maxlength="10" value="<?= $account['account_number'] ?>">
                            <p class="text-gray-600 text-sm mt-2">Enter 10-digit account number</p>

                            <span class="text-red-500 text-sm hidden" id="accountNumberError"></span>

                        </div>

                    </div>


                    <!-- Form Actions -->
                    <div class="flex gap-4 pt-8 border-t">
                        <button type="submit" class="flex-1 bg-blue-900 hover:bg-blue-800 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i>
                            Update Account
                        </button>
                        <a type="button" onclick="window.history.back()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                    </div>
                </form>

                <!-- Success Message -->
                <div id="successMessage" class="hidden mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>Bank account added successfully!</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . "/../../../includes/footer.php"); ?>


    <script>
        // Form validation and submission
        const bankAccountForm = document.getElementById('bankAccountForm');


        bankAccountForm.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const bankName = document.getElementById('bankName').value.trim();
            const accountPurpose = document.getElementById('accountPurpose').value;
            const accountName = document.getElementById('accountName').value;
            const accountNumber = document.getElementById('accountNumber').value;


            let isValid = true;

            if (!bankName) {
                document.getElementById('bankNameError').textContent = 'Bank name is required';
                document.getElementById('bankNameError').classList.remove('hidden');
                isValid = false;
            }



            if (!accountPurpose) {
                document.getElementById('accountPurposeError').textContent = 'Account Purpose is required';
                document.getElementById('accountPurposeError').classList.remove('hidden');
                isValid = false;
            }

            if (!accountName) {
                document.getElementById('accountNameError').textContent = 'Account Name is required';
                document.getElementById('accountNameError').classList.remove('hidden');
                isValid = false;
            }

            if (!accountNumber) {
                document.getElementById('accountNumberError').textContent = 'Account number is required';
                document.getElementById('accountNumberError').classList.remove('hidden');
                isValid = false;
            }



            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                bankAccountForm.submit();
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

                showErrorMessage();
            }
        });
    </script>
</body>

</html>