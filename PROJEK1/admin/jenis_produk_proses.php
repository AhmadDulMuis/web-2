<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah'])) {
        // Proses tambah data
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
        
        $query = "INSERT INTO jenis_produk (nama, deskripsi) VALUES ('$nama', '$deskripsi')";
        
        if (mysqli_query($koneksi, $query)) {
            header('Location: jenis_produk_list.php?status=sukses_tambah');
        } else {
            header('Location: jenis_produk_list.php?status=gagal&error='.mysqli_error($koneksi));
        }
    } 
    elseif (isset($_POST['edit'])) {
        // Proses edit data
        $id = $_POST['id'];
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
        
        $query = "UPDATE jenis_produk SET 
                  nama = '$nama',
                  deskripsi = '$deskripsi'
                  WHERE id = $id";
        
        if (mysqli_query($koneksi, $query)) {
            header('Location: jenis_produk_list.php?status=sukses_edit');
        } else {
            header('Location: jenis_produk_list.php?status=gagal&error='.mysqli_error($koneksi));
        }
    }
}
?>