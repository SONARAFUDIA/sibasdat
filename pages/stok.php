<?php
include '../db/connect.php';
include '../fungsi/kunci.php';
session_start();

$_SESSION['user'] = $_SESSION['user'] ?? 'user_' . rand(1000, 9999);
$user = $_SESSION['user'];

// CEK apakah user saat ini adalah pemilik kunci
$tabel = 'stok';
$pengunci = kunci_sedang_digunakan($koneksi, $tabel);

if ($pengunci === $user) {
    // Hanya jika user ini pemegang kunci, lepaskan
    nonaktifkan_kunci($koneksi, $tabel, $user);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modul Barang</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Modul Barang (Stok)</h2>
<nav>
    <a href="stok_form.php">➕ Tambah / Ubah Barang</a>
    <a href="stok_display.php">📦 Tampilkan Data Barang</a>
    <a href="../index.php">🏠 Kembali</a>
</nav>
</body>
</html>
