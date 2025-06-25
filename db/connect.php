<?php
// Mulai sesi dan periksa otentikasi
// Path relatif disesuaikan berdasarkan lokasi file ini
include __DIR__ . '/../fungsi/sesi.php';

$host = "192.168.18.160";
$db = "inventoryze";

// Ambil kredensial dari sesi
$user = $_SESSION['username'];
$pass = $_SESSION['password'];

$koneksi = new mysqli($host, $user, $pass, $db);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>