<?php
include '../db/connect.php';
include '../fungsi/kunci.php';

$tabel = 'stok';

// Coba untuk mengunci form ini. Jika gagal, berarti sedang digunakan orang lain.
if (!coba_kunci_form($koneksi, $tabel)) {
    echo "<div class='error-banner'>Form ini sedang digunakan oleh pengguna lain. Silakan coba beberapa saat lagi.</div>";
    echo "<p style='text-align:center;'><a href='stok.php'>⬅ Kembali</a></p>";
    exit;
}

// Deteksi apakah ini edit atau insert
if (isset($_GET['edit'])) {
    $kode = $_GET['edit'];
    $q = $koneksi->query("SELECT * FROM stok WHERE kode_brg = '$kode'");
    $data = $q->fetch_assoc();
    $edit = true;
} else {
    $edit = false;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Barang</title>
    <link rel="stylesheet" href="../css/next.css">
</head>
<body>
<h2>Form Barang</h2>
<form method="POST" action="../aksi/stok_proses.php?action=<?= $edit ? 'update' : 'insert' ?>">
    <input type="text" name="kode_brg" placeholder="Kode Barang" value="<?= $edit ? $data['kode_brg'] : '' ?>" required <?= $edit ? 'readonly' : '' ?>>
    <input type="text" name="nama_brg" placeholder="Nama Barang" value="<?= $edit ? $data['nama_brg'] : '' ?>" required>
    <input type="text" name="satuan" placeholder="Satuan" value="<?= $edit ? $data['satuan'] : '' ?>" required>
    <input type="number" name="jml_stok" placeholder="Jumlah Stok" value="<?= $edit ? $data['jml_stok'] : '' ?>" required>
    <button type="submit">Save</button>
    <a href="stok.php?unlock=true"><button type="button">Cancel</button></a>
</form>
</body>
</html>