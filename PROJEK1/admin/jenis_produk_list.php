<?php include_once 'top.php';
require_once 'koneksi.php';

// Proses hapus data
if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $query = "DELETE FROM jenis_produk WHERE id = $id";
    mysqli_query($koneksi, $query);
    header('Location: jenis_produk_list.php?status=sukses_hapus');
    exit;
}
?>

<div class="app-wrapper">
    <?php include_once 'navbar.php'; ?>
    <?php include_once 'sidebar.php'; ?>

    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6"><h3 class="mb-0">Jenis Produk</h3></div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Jenis Produk</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="col-md-12">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <button data-bs-toggle="modal" data-bs-target="#tambahModal" class="btn btn-primary">
                            Tambah Jenis Produk
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jenis</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = "SELECT * FROM jenis_produk ORDER BY nama ASC";
                                $result = mysqli_query($koneksi, $query);
                                
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($row['nama']) ?></td>
                                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm edit-btn" 
                                                    data-id="<?= $row['id'] ?>"
                                                    data-nama="<?= $row['nama'] ?>"
                                                    data-deskripsi="<?= $row['deskripsi'] ?>"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editModal">
                                                Edit
                                            </button>
                                            <a href="jenis_produk_list.php?hapus=<?= $row['id'] ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Yakin hapus data ini?')">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once 'footer.php'; ?>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="jenis_produk_proses.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jenis Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" name="nama" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="jenis_produk_proses.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jenis Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="editId">
                <div class="mb-3">
                    <label class="form-label">Nama Jenis</label>
                    <input type="text" class="form-control" name="nama" id="editNama" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="editDeskripsi" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="edit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
// Script untuk mengisi data ke modal edit
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('editId').value = this.getAttribute('data-id');
        document.getElementById('editNama').value = this.getAttribute('data-nama');
        document.getElementById('editDeskripsi').value = this.getAttribute('data-deskripsi');
    });
});
</script>