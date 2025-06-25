<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// Coba buat koneksi ke database dengan kredensial yang diberikan
@$koneksi = new mysqli("192.168.18.160", $username, $password, "inventoryze");

if ($koneksi->connect_error) {
    // Jika koneksi gagal, kembalikan ke halaman login dengan pesan error
    header("Location: login.php?error=1");
    exit();
}

// Jika koneksi berhasil, simpan kredensial di session
$_SESSION['username'] = $username;
$_SESSION['password'] = $password;

// Tutup koneksi percobaan
$koneksi->close();

// Arahkan ke halaman utama
header("Location: index.php");
exit();
?>