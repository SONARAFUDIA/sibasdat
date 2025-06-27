<?php
include '../db/connect.php';
include '../fungsi/kunci.php';

$tabel = 'stok';
$action = $_GET['action'] ?? '';
$error = null;

try {
    $koneksi->begin_transaction();

    switch ($action) {
        case 'insert':
            $stmt = $koneksi->prepare("CALL insert_stok(?, ?, ?, ?)");
            $stmt->bind_param("sssi", $_POST['kode_brg'], $_POST['nama_brg'], $_POST['satuan'], $_POST['jml_stok']);
            $stmt->execute();
            break;

        case 'update':
            $stmt = $koneksi->prepare("CALL update_stok(?, ?, ?, ?)");
            $stmt->bind_param("sssi", $_POST['kode_brg'], $_POST['nama_brg'], $_POST['satuan'], $_POST['jml_stok']);
            $stmt->execute();
            break;

        case 'delete':
            $stmt = $koneksi->prepare("CALL delete_stok(?)");
            $stmt->bind_param("s", $_GET['kode']);
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
    echo "<a href='../pages/stok.php'>⬅ Kembali</a>";
} else {
    header("Location: ../pages/stok.php");
    exit;
}
?>