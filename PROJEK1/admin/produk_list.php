<?php include_once 'top.php';

require_once 'koneksi.php';

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
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Daftar Produk</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Daftar Produk</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--begin::App Content-->
        <div class="app-content">
        <div class="card mb-4">
                  <div class="card-header">
                  <button  data-bs-toggle="modal" data-bs-target="#tambahanggota" href="pegawai_tambah.php" class="btn btn-primary">Tambah Produk</button>
                  </div>        
        <div class="card-body p-0">
        <table class="table ">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Jenis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT p.*, j.nama as jenis FROM produk p 
                          JOIN jenis_produk j ON p.jenis_produk_id = j.id";
                $result = mysqli_query($koneksi, $query);
                
                $no = 1; // Tambahkan variabel counter
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$no}</td> 
                            <td>{$row['kode']}</td>
                            <td>{$row['nama']}</td>
                            <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                            <td>{$row['stok']}</td>
                            <td>{$row['jenis']}</td>
                            <td>
                                <a href='produk_edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='produk_proses.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                            </td>
                          </tr>";
                          $no++; // Increment counter
                }
                ?>
            </tbody>
        </table>
      
        </div>

    </div>
      </main>
      <!--end::App Main-->
      
        <?php include_once 'footer.php'; ?>

    </div>
    <!-- Button trigger modal -->

    <!-- Modal Tambah-->
<div class="modal fade" id="tambahanggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="produk_proses.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Kode Produk</label>
                <input type="text" class="form-control" name="kode" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" class="form-control" name="nama" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" class="form-control" name="harga" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" class="form-control" name="stok" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Jenis Produk</label>
                <select class="form-select" name="jenis_produk_id" required>
                    <?php
                    $query = "SELECT * FROM jenis_produk";
                    $result = mysqli_query($koneksi, $query);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['nama']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="3"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="produk_list.php" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
  </div>
</div>

    
    <script>
function confirmHapus() {
    return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?');
}
</script>



 
