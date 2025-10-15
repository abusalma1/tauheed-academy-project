<?php
include("./config/db-connect.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tauheed Academy | Login</title>
</head>
<body>
        <h2>Login</h2>

    <form action="" method="POST">

    <P>
        <Label for="email">Email: </Label>
        <input type="email" name="email" id="email" required>
    </P>
    <P>
        <Label for="password">Password: </Label>
        <input type="password" name="password" id="password" required>
        </P>

        <button type="submit">Submit</button>
    </form>
</body>
</html>