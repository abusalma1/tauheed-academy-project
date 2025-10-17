 <?php
    $title = "Register";
    include(__DIR__ . "/./includes/non-auth-header.php");

    $error = "";
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name  = trim($_POST['name']);
        $email =  trim($_POST['email']);
        $password =  trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        if (!empty($name) && !empty($email) && !empty($password) && !empty($confirm_password)) {

            if ($confirm_password === $password) {
                $sql = "SELECT * FROM users where email = ?";
                $statement = $connection->prepare($sql);
                $statement->bind_param("s", $email);
                $statement->execute();
                $result = $statement->get_result();

                if ($result->num_rows > 0) {
                    $error = "Email already exist";
                } else {
                    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
                    $statement = $connection->prepare($sql);
                    $hashed_password =   password_hash($password, PASSWORD_DEFAULT);
                    $statement->bind_param("sss", $name, $email, $hashed_password);
                    if ($statement->execute()) {
                        $error = "Registration Successfull,<a href='./login.php'>Login Now</a>";
                    } else {
                        $error = "Something went wrong: " . $connection->error;
                    }
                }
            } else {
                $error = "Password And Password Confirmaation did not match!";
            }
        } else {
            $error = 'All the Fields Are Required';
        }
    }


    ?>


 <body class="bg-gray-50">

     <!-- Register Section  -->
     <section class="py-16 bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex items-center">
         <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
             <!-- Register Card -->
             <div class="bg-white rounded-2xl shadow-2xl p-8">
                 <!-- Header -->
                 <div class="text-center mb-8">
                     <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-900 rounded-full mb-4">
                         <i class="fas fa-user-plus text-white text-2xl"></i>
                     </div>
                     <h2 class="text-3xl font-bold text-gray-900">Create Account</h2>
                     <p class="text-gray-600 mt-2">Join Excellence Academy today</p>
                 </div>

                 <!-- Register Form -->
                 <form id="register-form" class="space-y-6">
                     <!-- User Type Selection -->
                     <div>
                         <label class="block text-sm font-semibold text-gray-700 mb-3">
                             <i class="fas fa-users mr-2 text-blue-900"></i>I am a:
                         </label>
                         <div class="grid grid-cols-3 gap-4">
                             <label class="relative">
                                 <input type="radio" name="user_type" value="student" class="peer sr-only" checked>
                                 <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-900 peer-checked:bg-blue-50 transition text-center">
                                     <i class="fas fa-user-graduate text-2xl text-blue-900 mb-2"></i>
                                     <p class="font-semibold text-sm">Student</p>
                                 </div>
                             </label>
                             <label class="relative">
                                 <input type="radio" name="user_type" value="parent" class="peer sr-only">
                                 <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-900 peer-checked:bg-blue-50 transition text-center">
                                     <i class="fas fa-user-friends text-2xl text-blue-900 mb-2"></i>
                                     <p class="font-semibold text-sm">Parent</p>
                                 </div>
                             </label>
                             <label class="relative">
                                 <input type="radio" name="user_type" value="staff" class="peer sr-only">
                                 <div class="p-4 border-2 border-gray-300 rounded-lg cursor-pointer peer-checked:border-blue-900 peer-checked:bg-blue-50 transition text-center">
                                     <i class="fas fa-chalkboard-teacher text-2xl text-blue-900 mb-2"></i>
                                     <p class="font-semibold text-sm">Staff</p>
                                 </div>
                             </label>
                         </div>
                     </div>

                     <!-- Name Fields -->
                     <div class="grid md:grid-cols-2 gap-4">
                         <div>
                             <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                 First Name
                             </label>
                             <input
                                 type="text"
                                 id="first_name"
                                 name="first_name"
                                 required
                                 class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                                 placeholder="Enter first name">
                         </div>
                         <div>
                             <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                 Last Name
                             </label>
                             <input
                                 type="text"
                                 id="last_name"
                                 name="last_name"
                                 required
                                 class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                                 placeholder="Enter last name">
                         </div>
                     </div>

                     <!-- Email -->
                     <div>
                         <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                             <i class="fas fa-envelope mr-2 text-blue-900"></i>Email Address
                         </label>
                         <input
                             type="email"
                             id="email"
                             name="email"
                             required
                             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                             placeholder="Enter your email">
                     </div>

                     <!-- Phone Number -->
                     <div>
                         <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                             <i class="fas fa-phone mr-2 text-blue-900"></i>Phone Number
                         </label>
                         <input
                             type="tel"
                             id="phone"
                             name="phone"
                             required
                             class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                             placeholder="+234 800 000 0000">
                     </div>

                     <!-- Password Fields -->
                     <div class="grid md:grid-cols-2 gap-4">
                         <div>
                             <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                 <i class="fas fa-lock mr-2 text-blue-900"></i>Password
                             </label>
                             <div class="relative">
                                 <input
                                     type="password"
                                     id="password"
                                     name="password"
                                     required
                                     class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                                     placeholder="Create password">
                                 <button
                                     type="button"
                                     id="toggle-password"
                                     class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                     <i class="fas fa-eye" id="eye-icon"></i>
                                 </button>
                             </div>
                         </div>
                         <div>
                             <label for="confirm_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                 Confirm Password
                             </label>
                             <div class="relative">
                                 <input
                                     type="password"
                                     id="confirm_password"
                                     name="confirm_password"
                                     required
                                     class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-900 focus:border-transparent transition"
                                     placeholder="Confirm password">
                                 <button
                                     type="button"
                                     id="toggle-confirm-password"
                                     class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                     <i class="fas fa-eye" id="eye-icon-confirm"></i>
                                 </button>
                             </div>
                         </div>
                     </div>

                     <!-- Terms & Conditions -->
                     <div class="flex items-start">
                         <input type="checkbox" id="terms" required class="w-4 h-4 mt-1 text-blue-900 border-gray-300 rounded focus:ring-blue-900">
                         <label for="terms" class="ml-2 text-sm text-gray-700">
                             I agree to the <a href="#" class="text-blue-900 hover:text-blue-700 font-semibold">Terms & Conditions</a> and <a href="#" class="text-blue-900 hover:text-blue-700 font-semibold">Privacy Policy</a>
                         </label>
                     </div>

                     <!-- Submit Button -->
                     <button
                         type="submit"
                         class="w-full bg-blue-900 text-white py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow-lg hover:shadow-xl">
                         <i class="fas fa-user-plus mr-2"></i>Create Account
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

                 <!-- Login Link -->
                 <div class="text-center">
                     <p class="text-gray-600">
                         Already have an account?
                         <a href="<?= route('login') ?>" class="text-blue-900 hover:text-blue-700 font-semibold">
                             Sign In
                         </a>
                     </p>
                 </div>
             </div>

             <!-- Additional Info -->
             <div class="mt-6 text-center">
                 <p class="text-sm text-gray-600">
                     <i class="fas fa-shield-alt mr-2 text-blue-900"></i>
                     Your information is secure and protected
                 </p>
             </div>
         </div>
     </section>



     <!-- Scripts -->
     <script>
         // Password Toggle
         const togglePassword = document.getElementById('toggle-password');
         const passwordInput = document.getElementById('password');
         const eyeIcon = document.getElementById('eye-icon');

         togglePassword.addEventListener('click', () => {
             const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
             passwordInput.setAttribute('type', type);
             eyeIcon.classList.toggle('fa-eye');
             eyeIcon.classList.toggle('fa-eye-slash');
         });

         // Confirm Password Toggle
         const toggleConfirmPassword = document.getElementById('toggle-confirm-password');
         const confirmPasswordInput = document.getElementById('confirm_password');
         const eyeIconConfirm = document.getElementById('eye-icon-confirm');

         toggleConfirmPassword.addEventListener('click', () => {
             const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
             confirmPasswordInput.setAttribute('type', type);
             eyeIconConfirm.classList.toggle('fa-eye');
             eyeIconConfirm.classList.toggle('fa-eye-slash');
         });

         // Form Submission
         const registerForm = document.getElementById('register-form');
         registerForm.addEventListener('submit', (e) => {
             e.preventDefault();

             // Password validation
             const password = passwordInput.value;
             const confirmPassword = confirmPasswordInput.value;

             if (password !== confirmPassword) {
                 alert('Passwords do not match!');
                 return;
             }

             if (password.length < 8) {
                 alert('Password must be at least 8 characters long!');
                 return;
             }

             // Add your registration logic here
             alert('Registration functionality will be implemented with backend integration');
         });
     </script>
 </body>

 </html>