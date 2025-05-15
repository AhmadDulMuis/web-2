<?php
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $jabatan = $_POST['jabatan'];
    
    // Jika ada ID, berarti ini proses edit
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        $query = "UPDATE pegawai SET 
                  nip = ?, 
                  nama = ?, 
                  jenis_kelamin = ?, 
                  jabatan = ?
                  WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, 'ssssi', $nip, $nama, $jenis_kelamin, $jabatan, $id);
    } 
    // Jika tidak ada ID, berarti ini proses tambah
    else {
        $query = "INSERT INTO pegawai (nip, nama, jenis_kelamin, jabatan) 
                  VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, 'ssss', $nip, $nama, $jenis_kelamin, $jabatan);
    }
    
    mysqli_stmt_execute($stmt);
    
    header('Location: pegawai_list.php');
    exit;
}

// Proses hapus
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM pegawai WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    
    header('Location: pegawai_list.php');
    exit;
}
?>