<?php
session_start();

if (!isset($_SESSION['username'])) {
    $path_ke_login = str_contains($_SERVER['REQUEST_URI'], '/pages/') ? '../login.php' : 'login.php';
    header("Location: " . $path_ke_login);
    exit();
}
?>