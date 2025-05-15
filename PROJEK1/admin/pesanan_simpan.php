<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mulai transaksi
    mysqli_begin_transaction($koneksi);
    
    try {
        // Simpan data pesanan
        $anggota_id = $_POST['anggota_id'];
        $tanggal = $_POST['tanggal'];
        $diskon = $_POST['diskon'] ?: 0;
        
        $query = "INSERT INTO pesanan (tanggal, diskon, status_bayar, anggota_id) 
                  VALUES ('$tanggal', $diskon, 0, $anggota_id)";
        mysqli_query($koneksi, $query);
        $pesanan_id = mysqli_insert_id($koneksi);
        
        // Simpan detail pesanan dan update stok
        for ($i = 0; $i < count($_POST['produk_id']); $i++) {
            $produk_id = $_POST['produk_id'][$i];
            $jumlah = $_POST['produk_jumlah'][$i];
            
            // Simpan detail pesanan
            $query = "INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah) 
                      VALUES ($pesanan_id, $produk_id, $jumlah)";
            mysqli_query($koneksi, $query);
            
            // Update stok produk
            $query = "UPDATE produk SET stok = stok - $jumlah WHERE id = $produk_id";
            mysqli_query($koneksi, $query);
        }
        
        // Commit transaksi jika semua query berhasil
        mysqli_commit($koneksi);
        header("Location: pesanan_detail.php?id=$pesanan_id&sukses=1");
    } catch (Exception $e) {
        // Rollback jika ada error
        mysqli_rollback($koneksi);
        echo "Error: " . $e->getMessage();
    }
}
?>