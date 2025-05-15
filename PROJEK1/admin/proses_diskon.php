<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $persen_diskon = $_POST['persen_diskon'];
    $deskripsi = $_POST['deskripsi'];

    $query = "INSERT INTO kartu_diskon (nama, persen_diskon, deskripsi) 
              VALUES ('$nama', '$persen_diskon', '$deskripsi')";
    
    if (mysqli_query($koneksi, $query)) {
        header('Location: diskon_list.php?status=sukses');
        exit;
    } else {
        header('Location: diskon_list.php?status=gagal&error=' . mysqli_error($koneksi));
        exit;
    }
}
?>