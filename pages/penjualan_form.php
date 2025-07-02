<?php
include '../db/connect.php';
include '../fungsi/kunci.php';

$user = $_SESSION['username'];
$tabel = 'penjualan';

$pengunci = kunci_sedang_digunakan($koneksi, $tabel);
if (!$pengunci) {
    aktifkan_kunci($koneksi, $tabel, $user);
    $pengunci = $user;
}

if ($pengunci !== $user) {
    echo "<div class='error-banner'>Form sedang digunakan oleh <strong>$pengunci</strong>.</div>";
    echo "<a href='penjualan.php'>⬅ Kembali</a>";
    exit;
}

$edit = isset($_GET['edit']);
$data = $edit ? $koneksi->query("SELECT * FROM t_jual WHERE kd_trans = '{$_GET['edit']}'")->fetch_assoc() : null;

$barang_list = $koneksi->query("SELECT kode_brg, nama_brg FROM stok");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form Penjualan</title>
    <link rel="stylesheet" href="../css/next.css">
</head>
<body>
<h2><?= $edit ? 'Edit' : 'Tambah' ?> Data Penjualan</h2>

<form method="POST" action="../aksi/jual_proses.php?action=<?= $edit ? 'update' : 'insert' ?>">
    <input type="text" name="kd_trans" placeholder="Kode Transaksi" value="<?= $edit ? $data['kd_trans'] : '' ?>" required <?= $edit ? 'readonly' : '' ?>>

    <input type="date" name="tgl_trans" value="<?= $edit ? $data['tgl_trans'] : '' ?>" required>

    <label for="kode_brg">Pilih Barang:</label>
    <select name="kode_brg" required>
        <option value="">-- Pilih Barang --</option>
        <?php while ($barang = $barang_list->fetch_assoc()): ?>
            <option value="<?= $barang['kode_brg'] ?>"
                <?= ($edit && $data['kode_brg'] === $barang['kode_brg']) ? 'selected' : '' ?>>
                <?= $barang['kode_brg'] ?> - <?= $barang['nama_brg'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <input type="number" name="jml_jual" placeholder="Jumlah Jual" value="<?= $edit ? $data['jml_jual'] : '' ?>" required>

    <button type="submit">Save</button>
    <a href="penjualan.php?unlock=true"><button type="button">Cancel</button></a>
</form>
</body>
</html>