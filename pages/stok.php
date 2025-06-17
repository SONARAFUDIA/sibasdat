<?php
include '../db/connect.php';
include '../fungsi/kunci.php';
session_start();

$_SESSION['user'] = $_SESSION['user'] ?? 'user_' . rand(1000, 9999);
$user = $_SESSION['user'];
$tabel = 'stok';

// Jika ada permintaan unlock dari URL, dan user adalah pemilik kunci
if (isset($_GET['unlock']) && kunci_sedang_digunakan($koneksi, $tabel) === $user) {
    nonaktifkan_kunci($koneksi, $tabel, $user);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modul Barang (Stok)</title>
    <link rel="stylesheet" href="../css/next.css">
</head>
<body>
<h2>Data Barang</h2>
<div class="toolbar">
    <a class="btn-aksi btn-tambah" href="stok_form.php">➕ Tambah Barang</a>
    <a class="btn-aksi btn-kembali" href="../index.php">🏠 Kembali</a>
</div>
<table>
    <tr><th>Kode</th><th>Nama</th><th>Satuan</th><th>Stok</th><th>Aksi</th></tr>
    <?php
    $result = $koneksi->query("SELECT * FROM stok");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['kode_brg']}</td>
            <td>{$row['nama_brg']}</td>
            <td>{$row['satuan']}</td>
            <td>{$row['jml_stok']}</td>
            <td>
                <a class='btn-aksi btn-edit' href='stok_form.php?edit={$row['kode_brg']}'>Edit</a>
                <a class='btn-aksi btn-delete' href='../aksi/stok_proses.php?action=delete&kode={$row['kode_brg']}'>Delete</a>
            </td>
        </tr>";
    }
    ?>
</table>
</body>
</html>
