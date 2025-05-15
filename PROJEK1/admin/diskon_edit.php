<?php include_once 'top.php';
require_once 'koneksi.php';

// Ambil data diskon yang akan diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM kartu_diskon WHERE id = $id";
    $result = mysqli_query($koneksi, $query);
    $diskon = mysqli_fetch_assoc($result);
    
    if (!$diskon) {
        die("Data diskon tidak ditemukan");
    }
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $persen_diskon = $_POST['persen_diskon'];
    $deskripsi = $_POST['deskripsi'];
    
    $query = "UPDATE kartu_diskon SET 
              nama = '$nama',
              persen_diskon = '$persen_diskon',
              deskripsi = '$deskripsi'
              WHERE id = $id";
    
    if (mysqli_query($koneksi, $query)) {
        header('Location: diskon_list.php?status=sukses');
        exit;
    } else {
        $error = mysqli_error($koneksi);
        header("Location: diskon_edit.php?id=$id&status=gagal&error=$error");
        exit;
    }
}
?>

<!--begin::App Wrapper-->
<div class="app-wrapper">
    <!--begin::Header-->
    <?php include_once 'navbar.php'; ?>
    <!--end::Header-->

    <!--begin::Sidebar-->
    <?php include_once 'sidebar.php'; ?>
    <!--end::Sidebar-->

    <!--begin::App Main-->
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Edit Diskon</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="diskon_list.php">Daftar Diskon</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <!--begin::App Content-->
        <div class="app-content">
            <div class="col-md-12">
                <div class="card card-warning card-outline mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Form Edit Diskon</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
                            <div class="alert alert-danger">
                                Gagal mengupdate diskon: <?= htmlspecialchars($_GET['error']) ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="diskon_edit.php">
                            <input type="hidden" name="id" value="<?= $diskon['id'] ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Diskon</label>
                                <input type="text" class="form-control" name="nama" 
                                       value="<?= htmlspecialchars($diskon['nama']) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Persentase Diskon (%)</label>
                                <input type="number" class="form-control" name="persen_diskon" 
                                       min="1" max="100" value="<?= htmlspecialchars($diskon['persen_diskon']) ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3"><?= htmlspecialchars($diskon['deskripsi']) ?></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="diskon_list.php" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Simpan </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--end::App Main-->
    
    <?php include_once 'footer.php'; ?>
</div>
<!--end::App Wrapper-->

<script>
function confirmHapus() {
    return confirm('Apakah Anda yakin ingin menghapus data diskon ini?');
}
</script>