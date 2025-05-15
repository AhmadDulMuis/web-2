<?php include_once 'top.php';

require_once 'koneksi.php';


if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "SELECT * FROM produk WHERE id = $id";
  $result = mysqli_query($koneksi, $query);
  $produk = mysqli_fetch_assoc($result);
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
              <div class="col-sm-6"><h3 class="mb-0">Daftar Pesanan</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Daftar Pesanan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--begin::App Content-->
        <div class="app-content">
          <div class="col-md-12">
            <div class="card card-primary card-outline mb-4">
            <div class="card-header">
            <a href="pesanan_tambah.php" class="btn btn-primary">Buat Pesanan Baru</a>
            </div>
                <div class="card-body">
                  
                <table class="table table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Anggota</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT p.*, a.id as anggota_id, pg.nama as nama_anggota 
                          FROM pesanan p
                          JOIN anggota a ON p.anggota_id = a.id
                          JOIN pegawai pg ON a.pegawai_id = pg.id
                          ORDER BY p.tanggal DESC";
                $result = mysqli_query($koneksi, $query);
                
                $no = 1; // Tambahkan variabel counter
                while ($row = mysqli_fetch_assoc($result)) {
                    // Hitung total pesanan
                    $total_query = "SELECT SUM(dp.jumlah * pr.harga) as total 
                                    FROM detail_pesanan dp
                                    JOIN produk pr ON dp.produk_id = pr.id
                                    WHERE dp.pesanan_id = {$row['id']}";
                    $total_result = mysqli_query($koneksi, $total_query);
                    $total_row = mysqli_fetch_assoc($total_result);
                    $total = $total_row['total'] - ($total_row['total'] * $row['diskon'] / 100);
                    
                    $status = $row['status_bayar'] ? 
                        '<span class="badge bg-success">Lunas</span>' : 
                        '<span class="badge bg-warning text-dark">Belum Lunas</span>';
                    
                    echo "<tr>
                            <td>{$no}</td> 
                            <td>{$row['tanggal']}</td>
                            <td>{$row['nama_anggota']}</td>
                            <td>Rp " . number_format($total, 0, ',', '.') . "</td>
                            <td>{$status}</td>
                           <td>
                                <a href='pesanan_detail.php?id={$row['id']}' class='btn btn-info btn-sm'>Detail</a>
                                " . (!$row['status_bayar'] ? 
                                    "<a href='pembayaran_tambah.php?pesanan_id={$row['id']}' class='btn btn-success btn-sm'>Bayar</a>" : 
                                    "<a href='pembayaran_detail.php?pesanan_id={$row['id']}' class='btn btn-secondary btn-sm'>Lihat Pembayaran</a>") . "
                                <a href='pesanan_hapus.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus pesanan ini?\");'>Hapus</a>
                            </td>

                          </tr>";
                          $no++;
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



 
