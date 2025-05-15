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
              <div class="col-sm-6"><h3 class="mb-0">Proses Pembayaran</h3></div>
              <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="produk_list.php">Pembayaran</a></li>
                            <li class="breadcrumb-item active">Proses Pembayaran</li>
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
                    <div class="card-title">Detail Proses Pembayaran</div>
                </div>
                <div class="card-body">
                <form action="pembayaran_simpan.php" method="POST">
            <input type="hidden" name="pesanan_id" value="<?= $pesanan_id ?>">
            
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>No. Pesanan:</strong> <?= $pesanan_id ?></p>
                            <p><strong>Total Tagihan:</strong> Rp <?= number_format($total_bayar, 0, ',', '.') ?></p>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Jumlah Bayar</label>
                                <input type="number" class="form-control" name="jumlah_bayar" 
                                       min="<?= $total_bayar ?>" value="<?= $total_bayar ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pembayaran</label>
                                <input type="date" class="form-control" name="tanggal" 
                                       value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan Pembayaran</button>
            <a href="pesanan_detail.php?id=<?= $pesanan_id ?>" class="btn btn-secondary">Kembali</a>
        </form>
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



 
