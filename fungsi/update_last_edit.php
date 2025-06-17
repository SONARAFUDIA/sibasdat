<?php
include '../db/connect.php';
session_start();

$user = $_SESSION['user'] ?? '';
$tabel = $_GET['tabel'] ?? '';

if ($user && $tabel) {
    $stmt = $koneksi->prepare("UPDATE kunci_edit SET last_edit = NOW() WHERE tabel = ? AND edited_by = ?");
    $stmt->bind_param("ss", $tabel, $user);
    $stmt->execute();
    $stmt->close();
}
?>
