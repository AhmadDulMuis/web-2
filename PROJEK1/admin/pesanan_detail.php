<?php include_once 'top.php';

require_once 'koneksi.php';

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  
  // Ambil data pesanan
  $query = "SELECT p.*, a.id as anggota_id, pg.nama as nama_anggota, 
                   k.nama as nama_diskon, k.persen_diskon
            FROM pesanan p
            JOIN anggota a ON p.anggota_id = a.id
            JOIN pegawai pg ON a.pegawai_id = pg.id
            LEFT JOIN kartu_diskon k ON a.kartu_diskon_id = k.id
            WHERE p.id = $id";
  $result = mysqli_query($koneksi, $query);
  $pesanan = mysqli_fetch_assoc($result);
  
  // Ambil detail pesanan
  $query = "SELECT dp.*, pr.nama as nama_produk, pr.harga
            FROM detail_pesanan dp
            JOIN produk pr ON dp.produk_id = pr.id
            WHERE dp.pesanan_id = $id";
  $detail_result = mysqli_query($koneksi, $query);
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
              <div class="col-sm-6"><h3 class="mb-0">Detail Pesanan</h3></div>
              <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="produk_list.php">Tambah Pesanan</a></li>
                            <li class="breadcrumb-item active">Detail Pesanan</li>
                        </ol>
                    </div>
            </div>
          </div>
        </div>
        <!--begin::App Content-->
        <div class="app-content">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Tanggal:</strong> <?= $pesanan['tanggal'] ?></p>
                        <p><strong>Anggota:</strong> <?= $pesanan['nama_anggota'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> 
                            <?= $pesanan['status_bayar'] ? 
                                '<span class="badge bg-success">Lunas</span>' : 
                                '<span class="badge bg-warning text-dark">Belum Lunas</span>' ?>
                        </p>
                        <?php if ($pesanan['nama_diskon']) : ?>
                            <p><strong>Diskon:</strong> <?= $pesanan['nama_diskon'] ?> (<?= $pesanan['persen_diskon'] ?>%)</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <h4>Daftar Produk</h4>
        <table class="table table-striped mb-4">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                while ($row = mysqli_fetch_assoc($detail_result)) : 
                    $subtotal = $row['harga'] * $row['jumlah'];
                    $total += $subtotal;
                ?>
                    <tr>
                        <td><?= $row['nama_produk'] ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['jumlah'] ?></td>
                        <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
                </tr>
                <?php if ($pesanan['diskon'] > 0) : ?>
                    <tr>
                        <th colspan="3">Diskon (<?= $pesanan['diskon'] ?>%)</th>
                        <th>- Rp <?= number_format($total * $pesanan['diskon'] / 100, 0, ',', '.') ?></th>
                    </tr>
                    <tr>
                        <th colspan="3">Total Bayar</th>
                        <th>Rp <?= number_format($total - ($total * $pesanan['diskon'] / 100), 0, ',', '.') ?></th>
                    </tr>
                <?php endif; ?>
            </tfoot>
        </table>
        <?php if (!$pesanan['status_bayar']) : ?>
            <a href="pembayaran_tambah.php?pesanan_id=<?= $id ?>" class="btn btn-success">Proses Pembayaran</a>
        <?php else : ?>
            <a href="pembayaran_detail.php?pesanan_id=<?= $id ?>" class="btn btn-info">Lihat Pembayaran</a>
        <?php endif; ?>
        <a href="pesanan_list.php" class="btn btn-secondary">Kembali</a>
        </div>
       
      </main>
      <!--end::App Main-->
      
        <?php include_once 'footer.php'; ?>

    </div>
    <!-- Button trigger modal -->
    
    <script>
    $(document).ready(function() {
        let produkCounter = 0;
        let produkList = [];
        
        // Update diskon ketika anggota dipilih
        $('#anggota_id').change(function() {
            const selected = $(this).find('option:selected');
            const diskon = selected.data('diskon') || 0;
            $('#diskon').val(diskon);
            $('#total_diskon').text(diskon + '%');
            hitungTotal();
        });
        
        // Tambah produk ke tabel
        $('#tambah_produk').click(function() {
            const produkId = $('#produk_select').val();
            const produkText = $('#produk_select option:selected').text().split(' (')[0];
            const harga = $('#produk_select option:selected').data('harga');
            const stok = $('#produk_select option:selected').data('stok');
            const jumlah = parseInt($('#jumlah').val());
            
            if (!produkId) {
                alert('Pilih produk terlebih dahulu!');
                return;
            }
            
            if (jumlah < 1 || jumlah > stok) {
                alert('Jumlah tidak valid atau melebihi stok!');
                return;
            }
            
            // Cek apakah produk sudah ada di list
            const existingIndex = produkList.findIndex(item => item.id == produkId);
            if (existingIndex >= 0) {
                produkList[existingIndex].jumlah += jumlah;
            } else {
                produkList.push({
                    id: produkId,
                    nama: produkText,
                    harga: harga,
                    jumlah: jumlah
                });
            }
            
            renderProdukTable();
        });
        
        // Render tabel produk
        function renderProdukTable() {
            let html = '';
            produkList.forEach((produk, index) => {
                const subtotal = produk.harga * produk.jumlah;
                html += `
                    <tr>
                        <td>${produk.nama}</td>
                        <td>Rp ${produk.harga.toLocaleString('id-ID')}</td>
                        <td>${produk.jumlah}</td>
                        <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm hapus-produk" data-index="${index}">Hapus</button>
                        </td>
                    </tr>
                `;
            });
            
            $('#produk_table tbody').html(html);
            hitungTotal();
            
            // Generate input hidden untuk form submission
            let hiddenInputs = '';
            produkList.forEach(produk => {
                hiddenInputs += `
                    <input type="hidden" name="produk_id[]" value="${produk.id}">
                    <input type="hidden" name="produk_jumlah[]" value="${produk.jumlah}">
                `;
            });
            $('#produk_hidden').html(hiddenInputs);
        }
        
        // Hapus produk dari tabel
        $(document).on('click', '.hapus-produk', function() {
            const index = $(this).data('index');
            produkList.splice(index, 1);
            renderProdukTable();
        });
        
        // Hitung total harga
        function hitungTotal() {
            let total = 0;
            produkList.forEach(produk => {
                total += produk.harga * produk.jumlah;
            });
            
            const diskon = parseInt($('#diskon').val()) || 0;
            const totalDiskon = total * diskon / 100;
            const totalBayar = total - totalDiskon;
            
            $('#total_harga').text('Rp ' + total.toLocaleString('id-ID'));
            $('#total_bayar').text('Rp ' + totalBayar.toLocaleString('id-ID'));
        }
    });
    </script>

    <script>
function confirmHapus() {
    return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?');
}
</script>



 
