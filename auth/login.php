<?php
@session_start();
$title = "Login";
include("./includes/non-auth-header.php");
$error = '';
if (isset($_POST['submit'])) {
    $email =  trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        $statement = $connection->prepare("SELECT * from users where email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_email"] = $user["email"];

                header('Location: ../index.php');
            } else {
                $error = "Incorrect Email Or password";
            }
        } else {
            $error = "Account Does Not Exist";
        }
    } else {
        $error = 'All Fields Are Required!';
    }
}

?>


<main>
    <h2>Login</h2>

    <form action="" method="POST">
        <?php if (!empty($error)) : ?>
            <p>
                <?php echo $error; ?>
            </p>
        <?php endif; ?>

        <P>
            <Label for="email">Email: </Label>
            <input type="email" name="email" id="email" placeholder="Enter Email" required>
        </P>
        <P>
            <Label for="password">Password: </Label>
            <input type="password" name="password" id="password" placeholder="Enter Password" required>
        </P>

        <button type="submit" name="submit">Login</button>
        <p>Forgot password?
        <p>Don't have account? <a href="./create.php">Create now</a></p>
    </form>
</main>

<?php include("./includes/non-auth-footer.php"); ?>