<?php
session_start();

if (isset($_SESSION["user_id"]) &&  isset($_SESSION["user_email"])) {
    unset($_SESSION["user_id"]);
    unset($_SESSION["user_email"]);
    header("Location: ./login.php");
} else {
    header('Location: index.php');
}
