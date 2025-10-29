<?php
session_start();

if (isset($_SESSION["user_session"])) {
    $_SESSION["user_sessoin"] = null;
    session_destroy();
}
header('Location: ' . __DIR__ . '/../index.php');
