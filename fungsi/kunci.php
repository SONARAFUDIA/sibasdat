<?php
/**
 * File ini berisi fungsi untuk mengelola sistem penguncian form (advisory lock).
 * Menggunakan fungsi bawaan MySQL untuk efisiensi dan keandalan.
 */

/**
 * Mencoba untuk mendapatkan kunci (mengunci form).
 * Jika form sudah dikunci oleh sesi lain, fungsi ini akan langsung gagal tanpa menunggu.
 *
 * @param mysqli $koneksi Objek koneksi database.
 * @param string $tabel Nama tabel yang akan menjadi dasar nama kunci.
 * @return bool True jika berhasil mendapatkan kunci, false jika gagal.
 */
function coba_kunci_form(mysqli $koneksi, string $tabel): bool {
    $nama_kunci = "lock_form_{$tabel}";
    // Timeout 0 berarti tidak akan menunggu, langsung gagal jika sudah terkunci.
    $result = $koneksi->query("SELECT GET_LOCK('$nama_kunci', 0) as locked")->fetch_assoc();
    
    // GET_LOCK() mengembalikan 1 jika berhasil, 0 jika gagal (timeout atau sudah terkunci).
    return $result['locked'] == 1;
}

/**
 * Melepaskan kunci yang sebelumnya didapatkan oleh sesi ini.
 *
 * @param mysqli $koneksi Objek koneksi database.
 * @param string $tabel Nama tabel yang kuncinya akan dilepaskan.
 * @return void
 */
function lepaskan_kunci_form(mysqli $koneksi, string $tabel): void {
    $nama_kunci = "lock_form_{$tabel}";
    $koneksi->query("SELECT RELEASE_LOCK('$nama_kunci')");
}