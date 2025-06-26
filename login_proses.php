<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$host = 'localhost';
$dbname = 'inventoryze';

@$koneksi = new mysqli($host, $username, $password, $dbname);

if ($koneksi->connect_error) {
    header("Location: login.php?error=1");
    exit();
}

$_SESSION['username'] = $username;
$_SESSION['password'] = $password;

$koneksi->close();

header("Location: index.php");
exit();
?>