<?php
include '../db/connect.php';
include '../fungsi/kunci.php';

$user = $_SESSION['username'];
$tabel = 'stok';
$pengunci = kunci_sedang_digunakan($koneksi, $tabel);

if ($pengunci !== false && $pengunci !== $user) {
    echo "<div class='error-banner'>Aksi ditolak. Form sedang digunakan oleh <strong>$pengunci</strong>.</div>";
    echo "<a href='../pages/stok.php'>⬅ Kembali</a>";
    exit;
}

$action = $_GET['action'] ?? '';

try {
    $koneksi->begin_transaction();

    switch ($action) {
        case 'insert':
            $kode = $_POST['kode_brg'];
            $nama = $_POST['nama_brg'];
            $satuan = $_POST['satuan'];
            $jumlah = $_POST['jml_stok'];
            $koneksi->query("CALL insert_stok('$kode', '$nama', '$satuan', $jumlah)");
            break;

        case 'update':
            $kode = $_POST['kode_brg'];
            $nama = $_POST['nama_brg'];
            $satuan = $_POST['satuan'];
            $jumlah = $_POST['jml_stok'];
            $koneksi->query("CALL update_stok('$kode', '$nama', '$satuan', $jumlah)");
            break;

        case 'delete':
            $kode = $_GET['kode'];
            $koneksi->query("CALL delete_stok('$kode')");
            break;

        default:
            throw new Exception("Aksi tidak valid.");
    }

    $koneksi->commit();
    nonaktifkan_kunci($koneksi, $tabel, $user);
    header("Location: ../pages/stok.php");
    exit;

} catch (Exception $e) {
    $koneksi->rollback();
    echo "<div class='error-banner'>Terjadi kesalahan: " . $e->getMessage() . "</div>";
    echo "<a href='../pages/stok.php'>⬅ Kembali</a>";
}
?>