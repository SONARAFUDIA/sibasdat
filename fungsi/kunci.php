<?php
define('KUNCI_TIMEOUT_MENIT', 5);

function kunci_sedang_digunakan($koneksi, $tabel) {
    $result = $koneksi->query("SELECT * FROM kunci_edit WHERE tabel = '$tabel'");
    $row = $result->fetch_assoc();

    if ($row['sedang_edit'] && strtotime($row['last_edit']) < strtotime('-' . KUNCI_TIMEOUT_MENIT . ' minutes')) {
        nonaktifkan_kunci($koneksi, $tabel, $row['edited_by']);
        return false;
    }

    return $row['sedang_edit'] ? $row['edited_by'] : false;
}

function aktifkan_kunci($koneksi, $tabel, $user) {
    $koneksi->query("UPDATE kunci_edit SET sedang_edit = TRUE, edited_by = '$user', last_edit = NOW() WHERE tabel = '$tabel'");
}

function nonaktifkan_kunci($koneksi, $tabel, $user) {
    $result = $koneksi->query("SELECT edited_by FROM kunci_edit WHERE tabel = '$tabel'");
    $row = $result->fetch_assoc();

    if ($row['edited_by'] === $user) {
        $koneksi->query("UPDATE kunci_edit SET sedang_edit = FALSE, edited_by = NULL WHERE tabel = '$tabel'");
    }
}
