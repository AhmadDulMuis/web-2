<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pegawai_id = $_POST['pegawai_id'];
    $kartu_diskon_id = !empty($_POST['kartu_diskon_id']) ? $_POST['kartu_diskon_id'] : NULL;
    $status_aktif = $_POST['status_aktif']; // 'aktif' atau 'non_aktif'
    
    // Validasi data
    if (empty($pegawai_id) || !in_array($status_aktif, ['aktif', 'non_aktif'])) {
        die("Data tidak valid!");
    }
    
    // Gunakan prepared statement
    $query = "INSERT INTO anggota (pegawai_id, kartu_diskon_id, status_aktif) 
              VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iss", $pegawai_id, $kartu_diskon_id, $status_aktif);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: anggota_list.php?sukses=tambah");
        } else {
            die("Gagal menyimpan: " . mysqli_error($koneksi));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        die("Error dalam prepared statement: " . mysqli_error($koneksi));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $kartu_diskon_id = !empty($_POST['kartu_diskon_id']) ? $_POST['kartu_diskon_id'] : NULL;
    $status_aktif = $_POST['status_aktif']; // 'aktif' atau 'non_aktif'
    
    // Validasi data
    if (!in_array($status_aktif, ['aktif', 'non_aktif'])) {
        die("Status tidak valid!");
    }
    
    // Gunakan prepared statement
    $query = "UPDATE anggota SET 
              kartu_diskon_id = ?,
              status_aktif = ?
              WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssi", $kartu_diskon_id, $status_aktif, $id);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: anggota_list.php?sukses=update");
        } else {
            die("Gagal mengupdate: " . mysqli_error($koneksi));
        }
        
        mysqli_stmt_close($stmt);
    } else {
        die("Error dalam prepared statement: " . mysqli_error($koneksi));
    }
}


if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Query untuk menghapus data
    $query = "DELETE FROM anggota WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $result = mysqli_stmt_execute($stmt);
    
    if($result) {
        header("Location: anggota_list.php?hapus=sukses");
    } else {
        header("Location: anggota_list.php?hapus=gagal");
    }
} else {
    header("Location: anggota_list.php");
}



?>