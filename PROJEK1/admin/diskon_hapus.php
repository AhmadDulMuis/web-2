<?php
// Mulai dengan koneksi
require_once 'koneksi.php';

// Cek apakah parameter ID tersedia
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Jalankan query hapus
    $query = "DELETE FROM kartu_diskon WHERE id = $id";

    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, redirect kembali ke daftar diskon
        header("Location: diskon_list.php?msg=sukses_hapus");
        exit();
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    echo "ID diskon tidak ditemukan!";
}
?>
