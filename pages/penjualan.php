<?php
include '../db/connect.php';
include '../fungsi/kunci.php';

$user = $_SESSION['username'];
$tabel = 'penjualan';

if (isset($_GET['unlock']) && kunci_sedang_digunakan($koneksi, $tabel) === $user) {
    nonaktifkan_kunci($koneksi, $tabel, $user);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Modul Penjualan</title>
    <link rel="stylesheet" href="../css/next.css">
</head>

<body>
    <h2>Data Penjualan</h2>
    <div class="toolbar">
        <a class="btn-aksi btn-tambah" href="penjualan_form.php">➕ Tambah Penjualan</a>
        <a class="btn-aksi btn-kembali" href="../index.php">🏠 Kembali</a>
    </div>
    
    <table>
        <tr>
            <th>Kode Transaksi</th>
            <th>Tanggal</th>
            <th>Kode Barang</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
        <?php
        $result = $koneksi->query("SELECT * FROM t_jual");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
            <td>{$row['kd_trans']}</td>
            <td>{$row['tgl_trans']}</td>
            <td>{$row['kode_brg']}</td>
            <td>{$row['jml_jual']}</td>
            <td>
                <a class='btn-aksi btn-edit' href='penjualan_form.php?edit={$row['kd_trans']}'>Edit</a>
                <a class='btn-aksi btn-delete' href='../aksi/jual_proses.php?action=delete&kd_trans={$row['kd_trans']}' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?');\">Delete</a>
            </td>
        </tr>";
        }
        ?>
    </table>
</body>

</html>