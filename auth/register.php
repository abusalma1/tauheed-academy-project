 <?php
    $title = "Register";
    include("./includes/non-auth-header.php");
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

 <main>
     <h2>Register</h2>

     <form action="" method="POST">
         <?php if (!empty($error)) : ?>
             <p>
                 <?php echo $error; ?>
             </p>
         <?php endif; ?>


         <P> <Label for="name">Name: </Label>
             <input type="text" name="name" id="name" required>
         </P>

         <P> <Label for="email">Email: </Label>
             <input type="email" name="email" id="email" required>
         </P>
         <P>
             <Label for="password">Password: </Label>
             <input type="password" name="password" id="password" required>
         </P>
         <P>
             <Label for="confirm_password">Confirm Password: </Label>
             <input type="password" name="confirm_password" id="confirm_password" required>
         </P>

         <input type="submit" value="Sign Up">
     </form>
     <p>Already have account? <a href="./login.php">Login</a></p>
 </main>

 <?php include("./includes/non-auth-footer.php"); ?>