<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h3 class="text-xl font-bold mb-4"><?= $school['name'] ?? 'Tauheed Academy' ?></h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Committed to providing quality education and nurturing future leaders through academic excellence and character development.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="index.html" class="text-gray-400 hover:text-white transition">Home</a></li>
                    <li><a href="pages/about.html" class="text-gray-400 hover:text-white transition">About Us</a></li>
                    <li><a href="pages/admissions.html" class="text-gray-400 hover:text-white transition">Admissions</a></li>
                    <li><a href="pages/academics.html" class="text-gray-400 hover:text-white transition">Academics</a></li>
                    <li><a href="pages/gallery.html" class="text-gray-400 hover:text-white transition">Gallery</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><i class="fas fa-map-marker-alt mr-2"></i><?= $school['address'] ?? '' ?></li>
                    <li><i class="fas fa-phone mr-2"></i><?= $school['phone'] ?? '' ?></li>
                    <li><i class="fas fa-envelope mr-2"></i><?= $school['email'] ?? '' ?></li>
                    <li><i class="fab fa-whatsapp mr-2"></i><?= $school['whatsapp_number'] ?? '' ?></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div>
                <h3 class="text-xl font-bold mb-4">Follow Us</h3>
                <div class="flex gap-4">
                    <a href="<?= $school['facebook'] ?? '#' ?>" class="bg-blue-600 hover:bg-blue-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="<?= $school['twitter'] ?? '#' ?>" class="bg-blue-400 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="<?= $school['instagram'] ?? '#' ?>" class="bg-pink-600 hover:bg-pink-700 w-10 h-10 rounded-full flex items-center justify-center transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400 text-sm">
            <p>&copy; 2025 <?= $school['name'] ?? 'Tauheed Academy' ?>. All rights reserved.</p>
        </div>
    </div>
</footer>
