<?php
include '../db/connect.php';
include '../fungsi/kunci.php';
session_start();

// $_SESSION['user'] = $_SESSION['user'] ?? 'user_' . rand(1000, 9999);
$_SESSION['user'] = $koneksi->query("SELECT USER()")->fetch_row()[0];
$user = $_SESSION['user'];
$tabel = 'stok';

$pengunci = kunci_sedang_digunakan($koneksi, $tabel);


if ($pengunci && $pengunci !== $user) {
    echo "<div class='error-banner'>Record is edited by another user: <strong>$pengunci</strong></div>";
    echo "<p style='text-align:center;'><a href='stok.php'>⬅ Kembali</a></p>";
    exit;
}

// Hanya aktifkan jika belum dikunci
if (!$pengunci) {
    aktifkan_kunci($koneksi, $tabel, $user);
    $pengunci = $user; // update pengunci ke diri sendiri
}

if ($pengunci !== $user) {
    echo "<div class='error-banner'>Form sedang digunakan oleh <strong>$pengunci</strong>. Anda tidak dapat mengaksesnya sekarang.</div>";
    echo "<p style='text-align:center;'><a href='stok.php'>⬅ Kembali</a></p>";
    exit;
}


// Jika belum terkunci, kunci sekarang
aktifkan_kunci($koneksi, $tabel, $user);

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
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <p style="text-align:right; font-size:14px;">Login sebagai: <strong><?= htmlspecialchars($user) ?></strong></p>

    <h2>Form Barang</h2>
    <form method="POST" action="../aksi/stok_proses.php?action=<?= $edit ? 'update' : 'insert' ?>">
        <input type="text" name="kode_brg" placeholder="Kode Barang" value="<?= $edit ? $data['kode_brg'] : '' ?>" required <?= $edit ? 'readonly' : '' ?>>
        <input type="text" name="nama_brg" placeholder="Nama Barang" value="<?= $edit ? $data['nama_brg'] : '' ?>" required>
        <input type="text" name="satuan" placeholder="Satuan" value="<?= $edit ? $data['satuan'] : '' ?>" required>
        <input type="number" name="jml_stok" placeholder="Jumlah Stok" value="<?= $edit ? $data['jml_stok'] : '' ?>" required>
        <button type="submit">Save</button>
        <a href="stok.php?unlock=true"><button type="button">Cancel</button></a>

        <!-- <a href="stok.php"><button type="button">Cancel</button></a> -->
    </form>
    <script>
        const tabel = 'stok';
        let activityTimeout;
        const maxIdleTime = 5 * 60 * 1000; // 5 menit

        function updateLastEdit() {
            fetch(`../fungsi/update_last_edit.php?tabel=${tabel}`);
        }

        function resetActivityTimer() {
            clearTimeout(activityTimeout);
            updateLastEdit();
            activityTimeout = setTimeout(() => {
                alert("Sesi Anda di halaman form Barang telah berakhir karena tidak aktif selama 5 menit.");
                window.location.href = "stok.php?unlock=true";
            }, maxIdleTime);
        }

        ['click', 'keydown', 'mousemove', 'scroll'].forEach(evt => {
            window.addEventListener(evt, resetActivityTimer);
        });

        resetActivityTimer();
    </script>

</body>

</html>