<?php include '../db/connect.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<h2>Data Barang</h2>
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
<a href="stok.php">⬅ Kembali</a>
</body>
</html>
