<?php include_once 'top.php';

require_once 'koneksi.php';

if (isset($_GET['pesanan_id'])) {
  $pesanan_id = $_GET['pesanan_id'];
  
  // Ambil data pembayaran
  $query = "SELECT * FROM pembayaran WHERE pesanan_id = $pesanan_id";
  $result = mysqli_query($koneksi, $query);
  $pembayaran = mysqli_fetch_assoc($result);
  
  // Ambil data pesanan untuk menampilkan info tambahan
  $query = "SELECT p.*, a.id as anggota_id, pg.nama as nama_anggota
            FROM pesanan p
            JOIN anggota a ON p.anggota_id = a.id
            JOIN pegawai pg ON a.pegawai_id = pg.id
            WHERE p.id = $pesanan_id";
  $pesanan_result = mysqli_query($koneksi, $query);
  $pesanan = mysqli_fetch_assoc($pesanan_result);
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
              <div class="col-sm-6"><h3 class="mb-0">Detail Pembayaran</h3></div>
              <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="produk_list.php">Proses Pembayaran</a></li>
                            <li class="breadcrumb-item active">Detail Pembayaran</li>
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
                    <div class="card-title">Detail Pembayaran</div>
                </div>
                <div class="card-body">
                <div class="container mt-4">
        <!-- <h2>Detail Pembayaran</h2> -->
        
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>No. Pesanan:</strong> <?= $pesanan_id ?></p>
                        <p><strong>Anggota:</strong> <?= $pesanan['nama_anggota'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanggal Pembayaran:</strong> <?= $pembayaran['tanggal'] ?></p>
                        <p><strong>Jumlah Bayar:</strong> Rp <?= number_format($pembayaran['jumlah_bayar'], 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <a href="pesanan_detail.php?id=<?= $pesanan_id ?>" class="btn btn-secondary">Kembali ke Pesanan</a>
    </div>
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



 
