<?php
$title = "Create Subject";
include(__DIR__ . '/../../../includes/header.php');


if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


$classes = selectAllData('classes');
$subjects = selectAllData('subjects');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }


    // Sanitizing input
    $name = trim($_POST['name']);
    $class_ids = isset($_POST['classes']) ? $_POST['classes'] : [];


    // Form validations
    if (empty($name)) {
        $errors['name'] = "Subject name is required.";
    }

    if (empty($class_ids) || !is_array($class_ids)) {
        $errors['classes'] = "Please select at least one class.";
    }


    if (empty($errors)) {

        $stmt = $connection->prepare("INSERT INTO subjects (name) VALUES (?)");

        if ($stmt) {
            $stmt->bind_param('s', $name);

            if ($stmt->execute()) {
                $subject_id = $stmt->insert_id;
                $stmt->close();

                $pivot_query = "INSERT INTO class_subject (class_id, subject_id) VALUES (?, ?)";
                $stmt_pivot = $connection->prepare($pivot_query);

                foreach (
                    $class_ids as
                    $class_id
                ) {

                    $stmt_pivot->bind_param('ii', $class_id, $subject_id);
                    $stmt_pivot->execute();
                }

                $stmt_pivot->close();

                $_SESSION['success'] = "Subject added successfully!";
                header("Location: " .  route('back'));
                exit();
            } else {
                echo "<script>alert('Failed to insert subject into database.: " . $statement->error . "');</script>";
            }
        } else {
            echo "<script>alert('Error preparing subject insertion.: " . $statement->error . "');</script>";
        }
    } else {
        foreach ($errors as $field => $error) {
            echo "<p class='text-red-600 font-semibold'>$error</p>";
        }
    }
}





?>
<script>
    const subjects = <?= json_encode($subjects, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>

<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php')    ?>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Create Subject</h1>
            <p class="text-xl text-blue-200">Create and manage subjects</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Create New Subject</h2>

                        <form id="subjectFrom" class="space-y-6" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>


                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Subject name *</label>
                                <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="Enter Subject name">
                                <span class="text-red-500 text-sm hidden" id="nameError"></span>
                            </div>



                            <!-- classes -->
                            <div class="relative w-full" id="multi-select-wrapper">
                                <label for="classes" class="block text-sm font-semibold text-gray-700 mb-2">Classes</label>

                                <!-- Input / Display -->
                                <div id="multi-select-input"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-900">
                                    <span id="multi-select-placeholder" class="text-gray-500 w-full ">Select classes... </span>

                                    <span id="multi-select-selected" class="text-gray-800 hidden"></span>
                                </div>

                                <!-- Dropdown List -->
                                <div id="multi-select-options"
                                    class="absolute w-full mt-2 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-scroll z-10 hidden">
                                    <?php foreach ($classes as $class): ?>
                                        <label class="flex items-center px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                            <input type="checkbox" value="<?= $class['id'] ?>" class="form-checkbox text-blue-900" />
                                            <span class="ml-2"><?= $class['name'] ?></span>
                                        </label>
                                    <?php endforeach ?>
                                </div>

                                <!-- Hidden inputs to submit selection -->
                                <div id="multi-select-hidden"></div>
                                <span class="text-red-500 text-sm hidden" id="classesError"></span>

                            </div>


                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Create Subject
                                </button>
                                <button type="reset" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                                    Clear From
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-blue-50 rounded-lg shadow p-6 border-l-4 border-blue-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-blue-900 mr-2"></i>Subject Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Subject Name Must Be Unique</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-green-600 mt-1"></i>
                                <span>Atleast One class must be picked</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Statistics -->
                    <!-- 
                    <div class="mt-6 bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">SUbjects Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Total Teachers</span>
                                <span class="text-2xl font-bold text-blue-900" id="totalTeachers"><?= $teachersCount['total'] ?></span>
                            </div>
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-gray-600">Active</span>
                                <span class="text-2xl font-bold text-green-600" id="activeTeachers"><?= $teachersCount['active'] ?></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Inactive</span>
                                <span class="text-2xl font-bold text-red-600" id="inactiveTeachers"><?= $teachersCount['inactive'] ?></span>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>

            <!-- Teachers Table -->
            <!--   
            <div class="mt-12 bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">Teacher Accounts</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-blue-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Staff No</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Qualification</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="teachersTableBody" class="divide-y divide-gray-200">
                            <?php if (count($classes) > 0) : ?>
                                <?php foreach ($classes as $class): ?>

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-900"><?= $class['name'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $teacher['email'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $class['staff_no'] ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-600"><?= $class['qualification'] ?></td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-3 py-1 <?= $class['status'] === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900' ?> rounded-full text-xs font-semibold capitalize"><?= $class['status'] ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-sm space-x-2">
                                            <a href="<?= route('teacher-update') . '?id=' . $teacher['id'] ?>">
                                                <button class="text-blue-600 hover:text-blue-900 font-semibold">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            </a>
                                            <a href="">
                                                <button class="text-red-600 hover:text-red-900 font-semibold">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>


                                <tr class="text-center py-8">
                                    <td colspan="6" class="px-6 py-8 text-gray-500">No teacher accounts created yet</td>
                                </tr>
                            <?php endif ?>


                        </tbody>
                    </table>
                </div>
            </div> -->
        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../includes/footer.php'); ?>


    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        const input = document.getElementById('multi-select-input');
        const dropdown = document.getElementById('multi-select-options');
        const placeholder = document.getElementById('multi-select-placeholder');
        const selectedDisplay = document.getElementById('multi-select-selected');
        const hiddenContainer = document.getElementById('multi-select-hidden');
        const checkboxes = dropdown.querySelectorAll('input[type="checkbox"]');

        input.addEventListener('click', () => {
            dropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!document.getElementById('multi-select-wrapper').contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                const selected = Array.from(checkboxes)
                    .filter(i => i.checked)
                    .map(i => i.value);

                if (selected.length > 0) {
                    placeholder.classList.add('hidden');
                    selectedDisplay.textContent = selected.join(', ');
                    selectedDisplay.classList.remove('hidden');
                } else {
                    placeholder.classList.remove('hidden');
                    selectedDisplay.classList.add('hidden');
                }

                hiddenContainer.innerHTML = '';
                selected.forEach(value => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'classes[]';
                    hiddenInput.value = value;
                    hiddenContainer.appendChild(hiddenInput);
                });
            });
        });


        // Form validation and submission
        const subjectFrom = document.getElementById('subjectFrom');

        subjectFrom.addEventListener('submit', (e) => {
            e.preventDefault();

            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('[id$="Error"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            const name = document.getElementById('name').value.trim();
            const classInputs = document.querySelectorAll('input[name="classes[]"]');

            // Validate name
            if (!name) {
                document.getElementById('nameError').textContent = 'Subject name is required.';
                document.getElementById('nameError').classList.remove('hidden');
                isValid = false;
            }

            if (subjects.some(t => t.name === name)) {
                document.getElementById('nameError').textContent = 'Subject already exists';
                document.getElementById('nameError').classList.remove('hidden');
                isValid = false;
            }

            // Validate at least one class selected
            const classesErrorEl = document.getElementById('classesError');
            if (classInputs.length === 0) {
                classesErrorEl.textContent = 'Please select at least one class.';
                classesErrorEl.classList.remove('hidden');
                isValid = false;
            } else {
                classesErrorEl.classList.add('hidden');
                classesErrorEl.textContent = '';
            }


            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                subjectFrom.submit();
                showLoader();
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showErrorMessage()
            }
        });
    </script>
</body>

</html>