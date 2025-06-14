
<?php
include '../db/connect.php';
include '../fungsi/kunci.php';
session_start();

$_SESSION['user'] = $_SESSION['user'] ?? 'user_' . rand(1000, 9999);
$user = $_SESSION['user'];
$tabel = 'penjualan';

$pengunci = kunci_sedang_digunakan($koneksi, $tabel);

if ($pengunci && $pengunci !== $user) {
    echo "<div class='error-banner'>Record is edited by another user: <strong>$pengunci</strong></div>";
    echo "<p style='text-align:center;'><a href='penjualan.php'>⬅ Kembali</a></p>";
    exit;
}

// Hanya aktifkan jika belum dikunci
if (!$pengunci) {
    aktifkan_kunci($koneksi, $tabel, $user);
    $pengunci = $user; // update pengunci ke diri sendiri
}

if ($pengunci !== $user) {
    echo "<div class='error-banner'>Form sedang digunakan oleh <strong>$pengunci</strong>. Anda tidak dapat mengaksesnya sekarang.</div>";
    echo "<p style='text-align:center;'><a href='stok.php'>⬅ Kembali</a></p>";
    exit;
}


// Jika belum terkunci, kunci sekarang
aktifkan_kunci($koneksi, $tabel, $user);

// Deteksi edit atau insert
if (isset($_GET['edit'])) {
    $kd = $_GET['edit'];
    $q = $koneksi->query("SELECT * FROM t_jual WHERE kd_trans = '$kd'");
    $data = $q->fetch_assoc();
    $edit = true;
} else {
    $edit = false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Penjualan</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Form Penjualan</h2>
<form method="POST" action="../aksi/jual_proses.php?action=<?= $edit ? 'update' : 'insert' ?>">
    <input type="text" name="kd_trans" placeholder="Kode Transaksi" value="<?= $edit ? $data['kd_trans'] : '' ?>" required <?= $edit ? 'readonly' : '' ?>>
    <input type="date" name="tgl_trans" value="<?= $edit ? $data['tgl_trans'] : '' ?>" required>
    <input type="text" name="kode_brg" placeholder="Kode Barang" value="<?= $edit ? $data['kode_brg'] : '' ?>" required>
    <input type="number" name="jml_jual" placeholder="Jumlah Jual" value="<?= $edit ? $data['jml_jual'] : '' ?>" required>
    <button type="submit">Save</button>
    <a href="penjualan.php"><button type="button">Cancel</button></a>
</form>
</body>
</html>
