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
              <div class="col-sm-6"><h3 class="mb-0">Data Pegawai</h3></div>
              <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active">Data Pegawai</li>
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
                    <h3 class="card-title">Detail Data Pegawai</h3>
                    <div class="card-tools">
                      <ul class="pagination pagination-sm float-end">
                        <button  data-bs-toggle="modal" data-bs-target="#tambahanggota" href="pegawai_tambah.php" class="btn btn-primary">Tambah Pegawai</button>
                      </ul>
                    </div>
                  </div> 
                <div class="card-body">
                <table class="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM pegawai";
                $result = mysqli_query($koneksi, $query);
                
                $no = 1; // Tambahkan variabel counter
                while ($row = mysqli_fetch_assoc($result)) {
                    $jk = $row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan';
                    echo "<tr>
                            <td>{$no}</td> 
                            <td>{$row['nip']}</td>
                            <td>{$row['nama']}</td>
                            <td>{$jk}</td>
                            <td>{$row['jabatan']}</td>
                            <td>
                                <button 
                                    class='btn btn-warning btn-sm'
                                    data-bs-toggle='modal'
                                    data-bs-target='#editModal'
                                    data-id='{$row['id']}'
                                    data-nip='{$row['nip']}'
                                    data-nama='{$row['nama']}'
                                    data-jk='{$row['jenis_kelamin']}'
                                    data-jabatan='{$row['jabatan']}'
                                >
                                    Edit
                                </button>
                            <a href='proses_pegawai.php?id={$row['id']}'class='btn btn-danger btn-sm' onclick='return confirmHapus()'>Hapus</a></td></tr>";
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
    
    <script>
function confirmHapus() {
    return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?');
}
</script>

<!-- Modal Tambah-->
<div class="modal fade" id="tambahanggota" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="proses_pegawai.php" method="POST">
    <div class="mb-3">
        <label class="form-label">NIP</label>
        <input type="text" class="form-control" name="nip" required maxlength="10">
    </div>
    
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" required>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Jenis Kelamin</label>
        <select class="form-select" name="jenis_kelamin" required>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Jabatan</label>
        <input type="text" class="form-control" name="jabatan" required>
    </div>
    <!-- <button type="submit" class="btn btn-primary">Simpan</button> -->

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>

    </div>
  </div>
</div>

 

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form action="proses_pegawai.php" method="POST" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Pegawai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="edit-id">
            <div class="mb-3">
              <label for="edit-nip" class="form-label">NIP</label>
              <input type="text" class="form-control" name="nip" id="edit-nip" required>
            </div>
            <div class="mb-3">
              <label for="edit-nama" class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama" id="edit-nama" required>
            </div>
            <div class="mb-3">
              <label for="edit-jk" class="form-label">Jenis Kelamin</label>
              <select class="form-control" name="jenis_kelamin" id="edit-jk" required>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="edit-jabatan" class="form-label">Jabatan</label>
              <input type="text" class="form-control" name="jabatan" id="edit-jabatan" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>


    <script>
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nip = button.getAttribute('data-nip');
        var nama = button.getAttribute('data-nama');
        var jk = button.getAttribute('data-jk');
        var jabatan = button.getAttribute('data-jabatan');

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-nip').value = nip;
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-jk').value = jk;
        document.getElementById('edit-jabatan').value = jabatan;
    });
    </script>