<?php
require_once 'koneksi.php';

// Validasi ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Mulai transaksi untuk memastikan data konsisten
    mysqli_begin_transaction($koneksi);

    try {
        // Hapus data pembayaran terkait dengan pesanan
        $query_pembayaran = "DELETE FROM pembayaran WHERE pesanan_id = ?";
        $stmt = mysqli_prepare($koneksi, $query_pembayaran);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);

        // Hapus detail pesanan terlebih dahulu untuk menghindari constraint foreign key
        $query_detail = "DELETE FROM detail_pesanan WHERE pesanan_id = ?";
        $stmt = mysqli_prepare($koneksi, $query_detail);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);

        // Hapus pesanan dari tabel pesanan
        $query_pesanan = "DELETE FROM pesanan WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $query_pesanan);
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);

        // Commit transaksi
        mysqli_commit($koneksi);

        // Redirect ke daftar pesanan
        header('Location: pesanan_list.php?status=sukses');
    } catch (Exception $e) {
        // Rollback transaksi jika terjadi error
        mysqli_rollback($koneksi);
        echo "<script>alert('Gagal menghapus pesanan dan data terkait.'); window.location.href='pesanan_list.php';</script>";
    }
} else {
    // Jika ID tidak valid
    echo "<script>alert('ID pesanan tidak valid.'); window.location.href='pesanan_list.php';</script>";
}
?>
