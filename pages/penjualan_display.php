<?php include '../db/connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Display Semua Data</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>📊 Tampilkan Semua Data</h2>

<h3>Data Barang</h3>
<table>
    <tr><th>Kode</th><th>Nama</th><th>Satuan</th><th>Stok</th></tr>
    <?php
    $stok = $koneksi->query("SELECT * FROM stok");
    while ($s = $stok->fetch_assoc()) {
        echo "<tr>
            <td>{$s['kode_brg']}</td>
            <td>{$s['nama_brg']}</td>
            <td>{$s['satuan']}</td>
            <td>{$s['jml_stok']}</td>
        </tr>";
    }
    ?>
</table>

<h3>Data Penjualan</h3>
<table>
    <tr><th>Kode Transaksi</th><th>Tanggal</th><th>Kode Barang</th><th>Jumlah</th></tr>
    <?php
    $jual = $koneksi->query("SELECT * FROM t_jual");
    while ($j = $jual->fetch_assoc()) {
        echo "<tr>
            <td>{$j['kd_trans']}</td>
            <td>{$j['tgl_trans']}</td>
            <td>{$j['kode_brg']}</td>
            <td>{$j['jml_jual']}</td>
        </tr>";
    }
    ?>
</table>

<a href="../index.php">⬅ Kembali</a>
</body>
</html>
