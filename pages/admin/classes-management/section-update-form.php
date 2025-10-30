<?php

$title = "Classe Update Form";
include(__DIR__ . '/../../../includes/header.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SERVER['HTTP_REFERER'])) {
    $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'];
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
    header('Location: ' . $_SESSION['previous_page']);
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
        $statement->bind_param('ssii', $name , $description, $headTeacher, $id);

        if ($statement->execute()) {
            header("Location: " . $_SESSION['previous_page']);
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
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Section Details</h2>

                    <form id="updateSectionForm" class="space-y-6" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
                        <input type="hidden" name="sectionId" value="<?= $section['id'] ?>">


                        <!-- Success Message -->
                        <div id="successMessage" class="hidden mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            <span>Section is created successfully!</span>
                        </div>

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

                            <a href="<?= $_SESSION['previous_page'] ?>" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Excellence Academy</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Committed to providing quality education and nurturing future leaders.
                    </p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="../index.html" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="section-management.html" class="text-gray-400 hover:text-white transition">Sections</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><i class="fas fa-map-marker-alt mr-2"></i>123 Education Street, City</li>
                        <li><i class="fas fa-phone mr-2"></i>+234 800 123 4567</li>
                        <li><i class="fas fa-envelope mr-2"></i>info@excellenceacademy.edu</li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Follow Us</h3>
                    <div class="flex gap-4">
                        <a href="#" class="bg-blue-600 hover:bg-blue-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-blue-400 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-pink-600 hover:bg-pink-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2025 Excellence Academy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        // Success Message
        function showSuccessMessage() {
            const message = document.getElementById("successMessage");
            if (message) {
                message.classList.remove("hidden"); // show the message
                message.classList.add("flex"); // ensure it displays properly

                // Hide it after 5 seconds
                setTimeout(() => {
                    message.classList.add("hidden");
                    message.classList.remove("flex");
                }, 5000);
            }
        }


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
                updateSectionForm.submit();
            } else {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        });
    </script>
</body>

</html>