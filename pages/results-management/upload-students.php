<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Upload Students - Excellence Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-900 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-full bg-white p-1 flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-blue-900 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">Excellence Academy</h1>
                        <p class="text-xs text-blue-200">Nurturing Future Leaders</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-6">
                    <a href="../index.html" class="hover:text-blue-300 transition"><i class="fas fa-home mr-2"></i>Home</a>
                    <a href="academics.html" class="hover:text-blue-300 transition"><i class="fas fa-book mr-2"></i>Academics</a>
                    <a href="classes.php" class="hover:text-blue-300 transition"><i class="fas fa-list mr-2"></i>Classes</a>
                </div>
                <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 flex items-center gap-3">
                <i class="fas fa-upload"></i>Bulk Upload Students
            </h1>
            <p class="text-xl text-blue-200">Upload multiple student records at once</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Upload Form -->
            <div class="bg-white rounded-lg shadow-lg p-8 border-2 border-blue-900 mb-8">
                <h2 class="text-2xl font-bold text-blue-900 mb-6 flex items-center gap-3">
                    <i class="fas fa-file-upload"></i>Upload Student Data
                </h2>

                <form id="uploadForm" class="space-y-6">
                    <!-- Class Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">
                                <i class="fas fa-chalkboard mr-2"></i>Select Class
                            </label>
                            <select id="classSelect" name="class" required class="w-full px-4 py-3 rounded-lg border-2 border-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="">-- Select Class --</option>
                                <option value="Primary 5 A">Primary 5 A</option>
                                <option value="Primary 5 B">Primary 5 B</option>
                                <option value="Primary 6 A">Primary 6 A</option>
                                <option value="JSS 1 A">JSS 1 A</option>
                                <option value="JSS 1 B">JSS 1 B</option>
                                <option value="JSS 2 A">JSS 2 A</option>
                                <option value="JSS 2 B">JSS 2 B</option>
                                <option value="SSS 1 A">SSS 1 A</option>
                                <option value="SSS 1 B">SSS 1 B</option>
                                <option value="SSS 2 A">SSS 2 A</option>
                                <option value="SSS 3 A">SSS 3 A</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-blue-900 mb-2">
                                <i class="fas fa-calendar mr-2"></i>Academic Session
                            </label>
                            <input type="text" id="session" name="session" placeholder="e.g., 2024/2025" required class="w-full px-4 py-3 rounded-lg border-2 border-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-blue-900 mb-2">
                            <i class="fas fa-file-csv mr-2"></i>Upload CSV or Excel File
                        </label>
                        <div class="border-2 border-dashed border-blue-900 rounded-lg p-6 text-center hover:bg-blue-50 transition cursor-pointer" onclick="document.getElementById('fileInput').click()">
                            <i class="fas fa-cloud-upload-alt text-4xl text-blue-900 mb-3"></i>
                            <p class="text-gray-700 font-semibold">Click to upload or drag and drop</p>
                            <p class="text-gray-500 text-sm">CSV, XLS, or XLSX (Max 5MB)</p>
                        </div>
                        <input type="file" id="fileInput" name="file" accept=".csv,.xls,.xlsx" class="hidden" onchange="handleFileSelect(event)">
                        <div id="fileInfo" class="mt-2 hidden bg-green-50 border border-green-300 rounded-lg p-3">
                            <i class="fas fa-check-circle text-green-600 mr-2"></i>
                            <span id="fileName" class="text-green-700 font-semibold"></span>
                        </div>
                    </div>

                    <!-- Manual Entry -->
                    <div class="border-t-2 border-gray-200 pt-6">
                        <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                            <i class="fas fa-keyboard"></i>Or Add Students Manually
                        </h3>
                        <div id="studentRows" class="space-y-4">
                            <!-- First row will be added by default -->
                        </div>
                        <button type="button" onclick="addStudentRow()" class="mt-4 bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg font-semibold flex items-center gap-2 transition">
                            <i class="fas fa-plus"></i>Add Another Student
                        </button>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6 border-t-2 border-gray-200">
                        <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center justify-center gap-2 transition">
                            <i class="fas fa-save"></i>Upload Students
                        </button>
                        <button type="reset" onclick="resetForm()" class="flex-1 bg-gray-400 hover:bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold flex items-center justify-center gap-2 transition">
                            <i class="fas fa-redo"></i>Clear Form
                        </button>
                        <a href="classes.php" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold flex items-center justify-center gap-2 transition">
                            <i class="fas fa-arrow-left"></i>Back to Classes
                        </a>
                    </div>
                </form>
            </div>

            <!-- Instructions -->
            <div class="bg-blue-50 border-l-4 border-blue-900 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold text-blue-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>Upload Instructions
                </h3>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check text-green-600 mt-1"></i>
                        <span>Prepare a CSV or Excel file with columns: Admission No, First Name, Last Name, Date of Birth, Gender, Guardian Name, Contact</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check text-green-600 mt-1"></i>
                        <span>Ensure all required fields are filled before uploading</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check text-green-600 mt-1"></i>
                        <span>Maximum file size is 5MB with up to 500 students per upload</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check text-green-600 mt-1"></i>
                        <span>You can also manually add students one by one using the form below</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check text-green-600 mt-1"></i>
                        <span>All data will be saved to the system once you click Upload Students</span>
                    </li>
                </ul>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4"><i class="fas fa-graduation-cap mr-2"></i>Excellence Academy</h3>
                    <p class="text-gray-400 text-sm">Committed to quality education and excellence.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4"><i class="fas fa-link mr-2"></i>Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="../index.html" class="text-gray-400 hover:text-white"><i class="fas fa-home mr-1"></i>Home</a></li>
                        <li><a href="classes.php" class="text-gray-400 hover:text-white"><i class="fas fa-list mr-1"></i>Classes</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4"><i class="fas fa-phone mr-2"></i>Contact</h3>
                    <p class="text-gray-400 text-sm">+234 800 123 4567</p>
                    <p class="text-gray-400 text-sm">info@excellenceacademy.edu</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4"><i class="fas fa-share-alt mr-2"></i>Follow Us</h3>
                    <div class="flex gap-4">
                        <a href="#" class="bg-blue-600 hover:bg-blue-700 w-10 h-10 rounded-full flex items-center justify-center transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="bg-blue-400 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center transition"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; 2025 Excellence Academy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Add initial student row
        window.addEventListener('DOMContentLoaded', () => {
            addStudentRow();
        });

        function addStudentRow() {
            const container = document.getElementById('studentRows');
            const rowCount = container.children.length + 1;
            
            const row = document.createElement('div');
            row.className = 'grid grid-cols-1 md:grid-cols-3 gap-3 p-4 bg-gray-50 rounded-lg';
            row.innerHTML = `
                <div>
                    <label class="block text-xs font-semibold text-blue-900 mb-1"><i class="fas fa-id-card mr-1"></i>Admission No</label>
                    <input type="text" placeholder="e.g., ADM001" class="w-full px-3 py-2 rounded border-2 border-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-blue-900 mb-1"><i class="fas fa-user mr-1"></i>First Name</label>
                    <input type="text" placeholder="First Name" class="w-full px-3 py-2 rounded border-2 border-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-blue-900 mb-1"><i class="fas fa-user mr-1"></i>Last Name</label>
                    <input type="text" placeholder="Last Name" class="w-full px-3 py-2 rounded border-2 border-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-blue-900 mb-1"><i class="fas fa-calendar mr-1"></i>Date of Birth</label>
                    <input type="date" class="w-full px-3 py-2 rounded border-2 border-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-blue-900 mb-1"><i class="fas fa-venus-mars mr-1"></i>Gender</label>
                    <select class="w-full px-3 py-2 rounded border-2 border-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                        <option value="">Select</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-blue-900 mb-1"><i class="fas fa-mobile-alt mr-1"></i>Contact</label>
                    <input type="tel" placeholder="Phone Number" class="w-full px-3 py-2 rounded border-2 border-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                </div>
                <div class="md:col-span-3">
                    <button type="button" onclick="this.parentElement.parentElement.remove()" class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm flex items-center gap-1 transition">
                        <i class="fas fa-trash"></i>Remove
                    </button>
                </div>
            `;
            
            container.appendChild(row);
        }

        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('fileInfo').classList.remove('hidden');
            }
        }

        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const classVal = document.getElementById('classSelect').value;
            const session = document.getElementById('session').value;
            
            if (!classVal || !session) {
                alert('Please select a class and academic session');
                return;
            }

            alert('Students uploaded successfully!\nClass: ' + classVal + '\nSession: ' + session);
            this.reset();
            document.getElementById('fileInfo').classList.add('hidden');
            document.getElementById('studentRows').innerHTML = '';
            addStudentRow();
        });

        function resetForm() {
            document.getElementById('uploadForm').reset();
            document.getElementById('fileInfo').classList.add('hidden');
            document.getElementById('studentRows').innerHTML = '';
            addStudentRow();
        }
    </script>
</body>
</html>
