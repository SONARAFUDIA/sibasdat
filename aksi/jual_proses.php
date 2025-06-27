<?php
include '../db/connect.php';
include '../fungsi/kunci.php';

$tabel = 'penjualan';
$action = $_GET['action'] ?? '';
$error = null;

try {
    $koneksi->begin_transaction();

    switch ($action) {
        case 'insert':
            $stmt = $koneksi->prepare("CALL insert_jual(?, ?, ?, ?)");
            $stmt->bind_param("sssi", $_POST['kd_trans'], $_POST['tgl_trans'], $_POST['kode_brg'], $_POST['jml_jual']);
            $stmt->execute();
            break;

        case 'update':
            $stmt = $koneksi->prepare("CALL update_jual(?, ?, ?, ?)");
            $stmt->bind_param("sssi", $_POST['kd_trans'], $_POST['tgl_trans'], $_POST['kode_brg'], $_POST['jml_jual']);
            $stmt->execute();
            break;

        case 'delete':
            $stmt = $koneksi->prepare("CALL delete_jual(?)");
            $stmt->bind_param("s", $_GET['kd_trans']);
            $stmt->execute();
            break;

        default:
            throw new Exception("Aksi tidak valid.");
    }

    $koneksi->commit();

} catch (Exception $e) {
    $koneksi->rollback();
    $error = $e; // Simpan error untuk ditampilkan nanti

} finally {
    // APA PUN YANG TERJADI (sukses atau gagal), lepaskan kuncinya.
    lepaskan_kunci_form($koneksi, $tabel);
}

// Arahkan kembali atau tampilkan error setelah kunci dilepaskan
if ($error) {
    echo "<div class='error-banner'>Terjadi kesalahan: " . $error->getMessage() . "</div>";
    echo "<a href='../pages/penjualan.php'>⬅ Kembali</a>";
} else {
    header("Location: ../pages/penjualan.php");
    exit;
}
?>