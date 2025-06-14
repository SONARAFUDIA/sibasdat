<?php
$koneksi = new mysqli("localhost", "root", "", "inventoryze");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
