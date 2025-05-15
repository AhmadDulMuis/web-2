<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mulai transaksi
    mysqli_begin_transaction($koneksi);
    
    try {
        $pesanan_id = $_POST['pesanan_id'];
        $jumlah_bayar = $_POST['jumlah_bayar'];
        $tanggal = $_POST['tanggal'];
        
        // Simpan data pembayaran
        $query = "INSERT INTO pembayaran (jumlah_bayar, tanggal, pesanan_id) 
                  VALUES ($jumlah_bayar, '$tanggal', $pesanan_id)";
        mysqli_query($koneksi, $query);
        
        // Update status pesanan menjadi lunas
        $query = "UPDATE pesanan SET status_bayar = 1 WHERE id = $pesanan_id";
        mysqli_query($koneksi, $query);
        
        // Commit transaksi jika semua query berhasil
        mysqli_commit($koneksi);
        header("Location: pembayaran_detail.php?pesanan_id=$pesanan_id&sukses=1");
    } catch (Exception $e) {
        // Rollback jika ada error
        mysqli_rollback($koneksi);
        echo "Error: " . $e->getMessage();
    }
}
?>