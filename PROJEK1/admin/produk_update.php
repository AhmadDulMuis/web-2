<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $kode = $_POST['kode'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $jenis_produk_id = $_POST['jenis_produk_id'];
    $deskripsi = $_POST['deskripsi'];
    
    // Validasi data
    if (empty($kode) || empty($nama) || empty($harga) || empty($stok)) {
        die("Semua field wajib diisi!");
    }
    
    // Update data produk
    $query = "UPDATE produk SET 
              kode = '$kode',
              nama = '$nama',
              harga = $harga,
              stok = $stok,
              jenis_produk_id = $jenis_produk_id,
              deskripsi = '$deskripsi'
              WHERE id = $id";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: produk_list.php?sukses=update");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>