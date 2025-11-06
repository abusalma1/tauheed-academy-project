<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Sessions & Terms - Excellence Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-blue-900 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <img src="/placeholder.svg?height=50&width=50" alt="School Logo" class="h-12 w-12 rounded-full bg-white p-1">
                    <div>
                        <h1 class="text-xl font-bold">Excellence Academy</h1>
                        <p class="text-xs text-blue-200">Admin Panel</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center gap-6">
                    <a href="classes.php" class="hover:text-blue-300 transition">Classes</a>
                    <a href="users-management.html" class="hover:text-blue-300 transition">Users</a>
                    <a href="index.html" class="hover:text-blue-300 transition">Back to Site</a>
                </div>
                <button id="mobile-menu-btn" class="md:hidden text-white focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-blue-800 px-4 py-4 space-y-2">
            <a href="classes.php" class="block py-2 hover:bg-blue-700 px-3 rounded">Classes</a>
            <a href="users-management.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Users</a>
            <a href="index.html" class="block py-2 hover:bg-blue-700 px-3 rounded">Back to Site</a>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="bg-blue-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4"><i class="fas fa-calendar-alt mr-3"></i>Academic Sessions & Terms</h1>
            <p class="text-xl text-blue-200">Manage academic sessions and link terms</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Sessions</p>
                            <p class="text-3xl font-bold text-blue-900" id="totalSessions">0</p>
                        </div>
                        <i class="fas fa-calendar text-4xl text-blue-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Active Sessions</p>
                            <p class="text-3xl font-bold text-green-900" id="activeSessions">0</p>
                        </div>
                        <i class="fas fa-check-circle text-4xl text-green-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Total Terms</p>
                            <p class="text-3xl font-bold text-purple-900" id="totalTerms">0</p>
                        </div>
                        <i class="fas fa-book text-4xl text-purple-200"></i>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm">Linked Pairs</p>
                            <p class="text-3xl font-bold text-orange-900" id="linkedPairs">0</p>
                        </div>
                        <i class="fas fa-link text-4xl text-orange-200"></i>
                    </div>
                </div>
            </div>

            <!-- Main Grid -->
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Add Session Form -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6"><i class="fas fa-plus-circle mr-3 text-blue-900"></i>Add New Session</h2>

                        <form id="sessionForm" class="space-y-6">
                            <!-- Session Name -->
                            <div>
                                <label for="sessionName" class="block text-sm font-semibold text-gray-700 mb-2">Session Name *</label>
                                <input type="text" id="sessionName" name="sessionName" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="e.g., 2024/2025">
                                <span class="text-red-500 text-sm hidden" id="sessionNameError"></span>
                            </div>

                            <!-- Start Date -->
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label for="startDate" class="block text-sm font-semibold text-gray-700 mb-2">Start Date *</label>
                                    <input type="date" id="startDate" name="startDate" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                                    <span class="text-red-500 text-sm hidden" id="startDateError"></span>
                                </div>

                                <!-- End Date -->
                                <div>
                                    <label for="endDate" class="block text-sm font-semibold text-gray-700 mb-2">End Date *</label>
                                    <input type="date" id="endDate" name="endDate" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                                    <span class="text-red-500 text-sm hidden" id="endDateError"></span>
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="sessionStatus" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select id="sessionStatus" name="sessionStatus" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex gap-4 pt-4">
                                <button type="submit" class="flex-1 bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                                    <i class="fas fa-plus mr-2"></i>Add Session
                                </button>
                                <button type="reset" class="flex-1 bg-gray-300 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-400 transition">
                                    Clear Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="md:col-span-1">
                    <div class="bg-blue-50 rounded-lg shadow p-6 border-l-4 border-blue-900">
                        <h3 class="text-lg font-bold text-gray-900 mb-4"><i class="fas fa-info-circle text-blue-900 mr-2"></i>Session Guidelines</h3>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex gap-2">
                                <i class="fas fa-check text-blue-600 mt-1"></i>
                                <span>Session name should be unique</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-blue-600 mt-1"></i>
                                <span>Set start and end dates</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-blue-600 mt-1"></i>
                                <span>Mark session as active/inactive</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-blue-600 mt-1"></i>
                                <span>Link terms to sessions</span>
                            </li>
                            <li class="flex gap-2">
                                <i class="fas fa-check text-blue-600 mt-1"></i>
                                <span>Manage many-to-many relationships</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Add Term Form -->
                    <div class="mt-6 bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4"><i class="fas fa-book mr-2 text-blue-900"></i>Add Term</h3>
                        <form id="termForm" class="space-y-4">
                            <div>
                                <label for="termName" class="block text-sm font-semibold text-gray-700 mb-2">Term Name *</label>
                                <input type="text" id="termName" name="termName" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900" placeholder="e.g., First Term">
                                <span class="text-red-500 text-sm hidden" id="termNameError"></span>
                            </div>

                            <div>
                                <label for="termStartDate" class="block text-sm font-semibold text-gray-700 mb-2">Start Date *</label>
                                <input type="date" id="termStartDate" name="termStartDate" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                            </div>

                            <div>
                                <label for="termEndDate" class="block text-sm font-semibold text-gray-700 mb-2">End Date *</label>
                                <input type="date" id="termEndDate" name="termEndDate" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-900">
                            </div>

                            <button type="submit" class="w-full bg-blue-900 text-white py-2 rounded-lg font-semibold hover:bg-blue-800 transition">
                                <i class="fas fa-plus mr-2"></i>Add Term
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sessions Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-12">
                <div class="bg-blue-900 text-white p-6">
                    <h2 class="text-2xl font-bold"><i class="fas fa-list mr-3"></i>Academic Sessions</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b-2 border-gray-300">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Session Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Start Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">End Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Manage</th>
                            </tr>
                        </thead>
                        <tbody id="sessionsTableBody" class="divide-y divide-gray-200">
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                    <p>No sessions created yet</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Terms Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-blue-900 text-white p-6">
                    <h2 class="text-2xl font-bold"><i class="fas fa-book mr-3"></i>Academic Terms</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b-2 border-gray-300">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Term Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Start Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">End Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Sessions</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="termsTableBody" class="divide-y divide-gray-200">
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                                    <p>No terms created yet</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                    <p class="text-gray-400 text-sm leading-relaxed">Committed to providing quality education and nurturing future leaders.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="index.html" class="text-gray-400 hover:text-white transition">Home</a></li>
                        <li><a href="classes.php" class="text-gray-400 hover:text-white transition">Classes</a></li>
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
                        <a href="#" class="bg-blue-600 hover:bg-blue-700 w-10 h-10 rounded-full flex items-center justify-center transition"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="bg-blue-400 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="bg-pink-600 hover:bg-pink-700 w-10 h-10 rounded-full flex items-center justify-center transition"><i class="fab fa-instagram"></i></a>
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

        // Data storage
        let sessions = JSON.parse(localStorage.getItem('academicSessions')) || [];
        let terms = JSON.parse(localStorage.getItem('academicTerms')) || [];
        let sessionTerms = JSON.parse(localStorage.getItem('sessionTerms')) || [];

        // Forms
        const sessionForm = document.getElementById('sessionForm');
        const termForm = document.getElementById('termForm');

        // Update stats
        function updateStats() {
            const activeSessions = sessions.filter(s => s.status === 'active').length;
            const linkedCount = sessionTerms.length;

            document.getElementById('totalSessions').textContent = sessions.length;
            document.getElementById('activeSessions').textContent = activeSessions;
            document.getElementById('totalTerms').textContent = terms.length;
            document.getElementById('linkedPairs').textContent = linkedCount;
        }

        // Render sessions table
        function renderSessions() {
            const tbody = document.getElementById('sessionsTableBody');

            if (sessions.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-gray-500"><i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i><p>No sessions created yet</p></td></tr>';
                return;
            }

            tbody.innerHTML = sessions.map((session, index) => `
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">${session.name}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">${session.startDate}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">${session.endDate}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 ${session.status === 'active' ? 'bg-green-100 text-green-900' : 'bg-red-100 text-red-900'} rounded-full text-xs font-semibold capitalize">${session.status}</span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <button onclick="editSession(${index})" class="text-blue-600 hover:text-blue-900 font-semibold"><i class="fas fa-edit"></i> Edit</button>
                        <button onclick="deleteSession(${index})" class="text-red-600 hover:text-red-900 font-semibold"><i class="fas fa-trash"></i> Delete</button>
                    </td>
                </tr>
            `).join('');
        }

        // Render terms table
        function renderTerms() {
            const tbody = document.getElementById('termsTableBody');

            if (terms.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" class="px-6 py-8 text-center text-gray-500"><i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i><p>No terms created yet</p></td></tr>';
                return;
            }

            tbody.innerHTML = terms.map((term, index) => {
                const linkedSessions = sessionTerms.filter(st => st.termId === index).map(st => sessions[st.sessionId]?.name || '').join(', ');
                return `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">${term.name}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">${term.startDate}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">${term.endDate}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">${linkedSessions || '-'}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <button onclick="manageTerm(${index})" class="text-blue-600 hover:text-blue-900 font-semibold"><i class="fas fa-link"></i> Manage</button>
                            <button onclick="deleteTerm(${index})" class="text-red-600 hover:text-red-900 font-semibold"><i class="fas fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Add session
        sessionForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const name = document.getElementById('sessionName').value.trim();
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const status = document.getElementById('sessionStatus').value;

            if (!name || !startDate || !endDate) {
                alert('Please fill all required fields');
                return;
            }

            sessions.push({
                name,
                startDate,
                endDate,
                status,
                createdAt: new Date().toLocaleDateString()
            });
            localStorage.setItem('academicSessions', JSON.stringify(sessions));

            sessionForm.reset();
            renderSessions();
            updateStats();
            alert('Session added successfully!');
        });

        // Add term
        termForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const name = document.getElementById('termName').value.trim();
            const startDate = document.getElementById('termStartDate').value;
            const endDate = document.getElementById('termEndDate').value;

            if (!name || !startDate || !endDate) {
                alert('Please fill all required fields');
                return;
            }

            terms.push({
                name,
                startDate,
                endDate,
                createdAt: new Date().toLocaleDateString()
            });
            localStorage.setItem('academicTerms', JSON.stringify(terms));

            termForm.reset();
            renderTerms();
            updateStats();
            alert('Term added successfully!');
        });

        // Delete session
        function deleteSession(index) {
            if (confirm('Are you sure you want to delete this session?')) {
                sessions.splice(index, 1);
                localStorage.setItem('academicSessions', JSON.stringify(sessions));
                renderSessions();
                updateStats();
            }
        }

        // Delete term
        function deleteTerm(index) {
            if (confirm('Are you sure you want to delete this term?')) {
                terms.splice(index, 1);
                sessionTerms = sessionTerms.filter(st => st.termId !== index);
                localStorage.setItem('academicTerms', JSON.stringify(terms));
                localStorage.setItem('sessionTerms', JSON.stringify(sessionTerms));
                renderTerms();
                updateStats();
            }
        }

        // Edit session
        function editSession(index) {
            const session = sessions[index];
            document.getElementById('sessionName').value = session.name;
            document.getElementById('startDate').value = session.startDate;
            document.getElementById('endDate').value = session.endDate;
            document.getElementById('sessionStatus').value = session.status;

            sessions.splice(index, 1);
            localStorage.setItem('academicSessions', JSON.stringify(sessions));
            renderSessions();
            updateStats();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Manage term (link to sessions)
        function manageTerm(termIndex) {
            const term = terms[termIndex];
            let sessionOptions = sessions.map((s, i) => `<option value="${i}">${s.name}</option>`).join('');

            const linkedSessionIds = sessionTerms.filter(st => st.termId === termIndex).map(st => st.sessionId);

            let checkboxes = sessions.map((s, i) => `
                <label class="flex items-center gap-2 p-2">
                    <input type="checkbox" value="${i}" class="session-checkbox" ${linkedSessionIds.includes(i) ? 'checked' : ''}>
                    <span>${s.name}</span>
                </label>
            `).join('');

            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
                    <h3 class="text-xl font-bold mb-4">Link Term to Sessions</h3>
                    <p class="text-gray-600 mb-4">Term: ${term.name}</p>
                    <div class="space-y-2 mb-6 max-h-64 overflow-y-auto border border-gray-200 rounded p-3">
                        ${checkboxes}
                    </div>
                    <div class="flex gap-3">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 bg-gray-300 text-gray-900 py-2 rounded font-semibold hover:bg-gray-400">Cancel</button>
                        <button onclick="saveLinkages(${termIndex})" class="flex-1 bg-blue-900 text-white py-2 rounded font-semibold hover:bg-blue-800">Save</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }

        // Save linkages
        function saveLinkages(termIndex) {
            const checkboxes = document.querySelectorAll('.session-checkbox:checked');
            sessionTerms = sessionTerms.filter(st => st.termId !== termIndex);

            checkboxes.forEach(checkbox => {
                sessionTerms.push({
                    sessionId: parseInt(checkbox.value),
                    termId: termIndex
                });
            });

            localStorage.setItem('sessionTerms', JSON.stringify(sessionTerms));
            document.querySelector('.fixed').remove();
            renderTerms();
            updateStats();
        }

        // Initial render
        renderSessions();
        renderTerms();
        updateStats();
    </script>
</body>

</html>