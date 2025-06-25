<?php
session_start();

// Jika session username tidak ada, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    // Sesuaikan path jika direktori berbeda
    $path_ke_login = str_contains($_SERVER['REQUEST_URI'], '/pages/') ? '../login.php' : 'login.php';
    header("Location: " . $path_ke_login);
    exit();
}
?>