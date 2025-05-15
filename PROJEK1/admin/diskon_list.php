<?php include_once 'top.php';

require_once 'koneksi.php';

if (isset($_GET['pesanan_id'])) {
  $pesanan_id = $_GET['pesanan_id'];
  
  // Hitung total yang harus dibayar
  $query = "SELECT SUM(dp.jumlah * pr.harga) as total, p.diskon
            FROM detail_pesanan dp
            JOIN produk pr ON dp.produk_id = pr.id
            JOIN pesanan p ON dp.pesanan_id = p.id
            WHERE dp.pesanan_id = $pesanan_id";
  $result = mysqli_query($koneksi, $query);
  $row = mysqli_fetch_assoc($result);
  
  $total = $row['total'];
  $diskon = $row['diskon'];
  $total_bayar = $total - ($total * $diskon / 100);
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
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <div class="col-sm-6"><h3 class="mb-0">Daftar Diskon</h3></div>
              <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="diskon_list.php"></a>Daftar Diskon</li>
                            <!-- <li class="breadcrumb-item active">Edit</li> -->
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
                <button data-bs-toggle="modal" data-bs-target="#diskontambah" class="btn btn-primary">Tambah Diskon</button>
                </div>
                <div class="card-body">
                <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Diskon</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM kartu_diskon";
                $result = mysqli_query($koneksi, $query);
                
                $no=1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$no}</td> 
                            <td>{$row['nama']}</td>
                            <td>{$row['persen_diskon']}%</td>
                            <td>{$row['deskripsi']}</td>
                            <td>
                                <a href='diskon_edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                <a href='diskon_hapus.php?id={$row['id']}' class='btn btn-danger btn-sm' 
                                   onclick='return confirm(\"Yakin hapus diskon ini?\")'>Hapus</a>
                            </td>
                          </tr>";
                          $no++; // Increment counter  
                }
                ?>
            </tbody>
        </table>
                </div>
            </div>
         </div>
        </div>
       
      </main>
      <!--end::App Main-->
      
        <?php include_once 'footer.php'; ?>

    </div>
    <!-- Button trigger modal -->
    <!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="diskontambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Diskon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="proses_diskon.php" method="POST">
        <div class="modal-body">
          <div class="mb-3">
              <label class="form-label">Nama Diskon</label>
              <input type="text" class="form-control" name="nama" required>
          </div>
          
          <div class="mb-3">
              <label class="form-label">Persentase Diskon (%)</label>
              <input type="number" class="form-control" name="persen_diskon" min="1" max="100" required>
          </div>
          
          <div class="mb-3">
              <label class="form-label">Deskripsi</label>
              <textarea class="form-control" name="deskripsi" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
    <script>
function confirmHapus() {
    return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?');
}
</script>



 
