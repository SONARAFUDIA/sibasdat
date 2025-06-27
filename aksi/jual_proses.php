<?php
include '../db/connect.php';
include '../fungsi/kunci.php';

$user = $_SERVER['REMOTE_ADDR'];
$tabel = 'penjualan';
$pengunci = kunci_sedang_digunakan($koneksi, $tabel);

if ($pengunci !== false && $pengunci !== $user) {
    echo "<div class='error-banner'>Aksi ditolak. Form sedang digunakan oleh <strong>$pengunci</strong>.</div>";
    echo "<a href='../pages/penjualan.php'>⬅ Kembali</a>";
    exit;
}

$action = $_GET['action'] ?? '';

try {
    $koneksi->begin_transaction();

    switch ($action) {
        case 'insert':
            $kd = $_POST['kd_trans'];
            $tgl = $_POST['tgl_trans'];
            $kode_brg = $_POST['kode_brg'];
            $jumlah = $_POST['jml_jual'];
            $koneksi->query("CALL insert_jual('$kd', '$tgl', '$kode_brg', $jumlah)");
            break;

        case 'update':
            $kd = $_POST['kd_trans'];
            $tgl = $_POST['tgl_trans'];
            $kode_brg = $_POST['kode_brg'];
            $jumlah = $_POST['jml_jual'];
            $koneksi->query("CALL update_jual('$kd', '$tgl', '$kode_brg', $jumlah)");
            break;

        case 'delete':
            $kd = $_GET['kd_trans'];
            $koneksi->query("CALL delete_jual('$kd')");
            break;

        default:
            throw new Exception("Aksi tidak valid.");
    }

    $koneksi->commit();
    nonaktifkan_kunci($koneksi, $tabel, $user);
    header("Location: ../pages/penjualan.php");
    exit;

} catch (Exception $e) {
    $koneksi->rollback();
    echo "<div class='error-banner'>Terjadi kesalahan: " . $e->getMessage() . "</div>";
    echo "<a href='../pages/penjualan.php'>⬅ Kembali</a>";
}
?>