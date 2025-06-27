<?php
include '../db/connect.php';
include '../fungsi/kunci.php';

$tabel = 'penjualan';

// Coba untuk mengunci form ini. Jika gagal, berarti sedang digunakan orang lain.
if (!coba_kunci_form($koneksi, $tabel)) {
    echo "<div class='error-banner'>Form ini sedang digunakan oleh pengguna lain. Silakan coba beberapa saat lagi.</div>";
    echo "<p style='text-align:center;'><a href='penjualan.php'>⬅ Kembali</a></p>";
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
    <input type="date" name="tgl_trans" value="<?= $edit ? $data['tgl_trans'] : date('Y-m-d') ?>" required>
    <label for="kode_brg">Pilih Barang:</label>
    <select name="kode_brg" required>
        <option value="">-- Pilih Barang --</option>
        <?php while ($barang = $barang_list->fetch_assoc()): ?>
            <option value="<?= $barang['kode_brg'] ?>"
                <?= ($edit && $data['kode_brg'] === $barang['kode_brg']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($barang['nama_brg']) ?> (<?= $barang['kode_brg'] ?>)
            </option>
        <?php endwhile; ?>
    </select>
    <input type="number" name="jml_jual" placeholder="Jumlah Jual" value="<?= $edit ? $data['jml_jual'] : '' ?>" required>
    <button type="submit">Save</button>
    <a href="penjualan.php?unlock=true"><button type="button">Cancel</button></a>
</form>
</body>
</html>