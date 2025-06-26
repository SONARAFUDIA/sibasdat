<?php
include __DIR__ . '/../fungsi/sesi.php';

$host = 'localhost';
$dbname = 'inventoryze';

$user = $_SESSION['username'];
$pass = $_SESSION['password'];

$koneksi = new mysqli($host, $user, $pass, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>