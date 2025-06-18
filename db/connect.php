<?php
$koneksi = new mysqli("192.168.1.4", "admin1", "pw123", "inventoryze");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
