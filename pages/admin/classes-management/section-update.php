<?php

$title = "Classe Update Form";
include(__DIR__ . '/../../../includes/header.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $statement = $connection->prepare('SELECT * FROM sections WHERE id=?');
    $statement->bind_param('i', $id);
    $statement->execute();
    $result = $statement->get_result();
    if ($result->num_rows > 0) {
        $section = $result->fetch_assoc();
    }
} else {
    header('Location: ' .  route('back'));
}

$statement = $connection->prepare("SELECT * FROM sections WHERE id != ?");
$statement->bind_param('i', $id);
$statement->execute();
$result = $statement->get_result();
$sections = $result->fetch_all(MYSQLI_ASSOC);

$statement = $connection->prepare("SELECT * FROM teachers");
$statement->execute();
$result = $statement->get_result();
$teachers = $result->fetch_all(MYSQLI_ASSOC);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
    ) {
        die('CSRF validation failed. Please refresh and try again.');
    }

    $name = htmlspecialchars(trim($_POST['sectionName'] ?? ''), ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars(trim($_POST['sectionDescription'] ?? ''), ENT_QUOTES);
    $headTeacher = htmlspecialchars(trim($_POST['sectionHead'] ?? ''), ENT_QUOTES, 'UTF-8');
    $headId = htmlspecialchars(trim($_POST['sectionId'] ?? ''), ENT_QUOTES, 'UTF-8');




    if (empty($name)) {
        $nameError = "Name is required";
    }

    if (empty($description)) {
        $descriptionError = "Description is required";
    }

    if (empty($headTeacher)) {
        $headTeacherError = "Head Teacher is required";
    }

    if (empty($nameError)  && empty($descriptionError) && empty($headTeacherError)) {
        $statement = $connection->prepare(
            "UPDATE sections SET name =? , description = ?, head_teacher_id = ?
             WHERE id = ?"
        );
        $statement->bind_param('ssii', $name, $description, $headTeacher, $id);

        if ($statement->execute()) {
            header("Location: " .  route('back'));
            exit();
        } else {
            echo "<script>alert('Failed to create section : " . $statement->error . "');</script>";
        }
    }
}

?>


<script>
    const sections = <?= json_encode($sections, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
</script>


<body class="bg-gray-50">
    <!-- Navigation -->
    <?php include(__DIR__ . '/../includes/admins-section-nav.php'); ?>


    <!-- Page Header -->
    <section class="bg-purple-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Update Section</h1>
            <p class="text-xl text-purple-200">Edit section information</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Add New Section</h2>


                        <form id="updateSectionForm" class="space-y-6" method="POST">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <input type="hidden" name="sectionId" value="<?= $section['id'] ?>">


                            <?php include(__DIR__ . '/../../../includes/components/success-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/error-message.php'); ?>
                            <?php include(__DIR__ . '/../../../includes/components/form-loader.php'); ?>



                            <!-- Section Name -->
                            <div>
                                <label for="sectionName" class="block text-sm font-semibold text-gray-700 mb-2">Section Name *</label>
                                <input type="text" id="sectionName" name="sectionName" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="e.g., Tahfeez, Nursery, Primary" value="<?= $section['name'] ?>">
                                <span class="text-red-500 text-sm hidden" id="sectionNameError"></span>
                            </div>

                            <!-- Section Description -->
                            <div>
                                <label for="sectionDescription" class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                                <textarea id="sectionDescription" name="sectionDescription" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900" placeholder="Describe the section and its purpose"><?= $section['description'] ?></textarea>
                                <span class="text-red-500 text-sm hidden" id="sectionDescriptionError"></span>
                            </div>


                            <!-- Section Head -->
                            <div>
                                <label for="sectionHead" class="block text-sm font-semibold text-gray-700 mb-2">Section Head/Coordinator</label>
                                <select type="text" id="sectionHead" name="sectionHead" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-900">
                                    <option value="">-- Select Section Head --</option>
                                    <?php if ($teachers < 1) : ?>
                                        <option value="">-- You Must add teacher first --</option>
                                    <?php else : ?>
                                        <?php foreach ($teachers as $teacher) : ?>
                                            <option value="<?= $teacher['id'] ?>" <?= $teacher['id'] === $section['head_teacher_id'] ? 'selected' : '' ?>><?= $teacher['name']; ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                                <span class="text-red-500 text-sm hidden" id="sectionHeadError"></span>

                            </div>



                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-purple-900 text-white py-3 rounded-lg font-semibold hover:bg-purple-800 transition">
                                    <i class="fas fa-save mr-2"></i>Update Section
                                </button>

                                <a href="<?= route('back') ?>" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                    Cancel
                                </a>
                            </div>
                        </form>


                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-purple-50 rounded-lg shadow p-6 border-l-4 border-purple-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            <i class="fas fa-info-circle text-purple-900 mr-2"></i>Update Guidelines
                        </h3>
                        <ul class="space-y-3 text-sm text-gray-700">

                            <li class="flex gap-2">
                                <i class="fas fa-check text-purple-600 mt-1"></i>
                                <span>Modify the details as needed</span>
                            </li>

                            <li class="flex gap-2">
                                <i class="fas fa-check text-purple-600 mt-1"></i>
                                <span>Click Update to save changes</span>
                            </li>

                        </ul>
                    </div>


                </div>
            </div>


        </div>
    </section>

    <!-- Footer -->
    <?php include(__DIR__ . '/../../../includes/footer.php');  ?>


    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        const updateSectionForm = document.getElementById('updateSectionForm');
        updateSectionForm.addEventListener('submit', (e) => {
            e.preventDefault();
            document.querySelectorAll('[id$="Error"]').forEach(el => el.classList.add('hidden'));

            const sectionName = document.getElementById('sectionName').value.trim();
            const sectionDescription = document.getElementById('sectionDescription').value.trim();
            const sectionHead = document.getElementById('sectionHead').value;


            let isValid = true;

            if (!sectionName) {
                document.getElementById('sectionNameError').textContent = 'Section name is required';
                document.getElementById('sectionNameError').classList.remove('hidden');
                isValid = false;
            }

            if (sections.some(s => s.name === sectionName)) {
                document.getElementById('sectionNameError').textContent = 'Section name already exists';
                document.getElementById('sectionNameError').classList.remove('hidden');
                isValid = false;
            }

            if (!sectionDescription) {
                document.getElementById('sectionDescriptionError').textContent = 'Description is required';
                document.getElementById('sectionDescriptionError').classList.remove('hidden');
                isValid = false;
            }

            if (!sectionHead) {
                document.getElementById('sectionHeadError').textContent = 'Please Select section head';
                document.getElementById('sectionHeadError').classList.remove('hidden');
                isValid = false;
            }
            if (isValid) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                showLoader();
                updateSectionForm.submit();
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