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
              <div class="col-sm-6"><h3 class="mb-0">Tambah Pesanan</h3></div>
              <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item"><a href="produk_list.php">Daftar Pesanan</a></li>
                            <li class="breadcrumb-item active">Tambah Pesanan</li>
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
                    <!-- <div class="card-title">Edit Produk</div> -->
                </div>
                <div class="card-body">
                <form action="pesanan_simpan.php" method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Anggota</label>
                    <select class="form-select" name="anggota_id" id="anggota_id" required>
                        <option value="">Pilih Anggota</option>
                        <?php
                        $query = "SELECT a.id, p.nama, k.persen_diskon 
                                  FROM anggota a
                                  JOIN pegawai p ON a.pegawai_id = p.id
                                  LEFT JOIN kartu_diskon k ON a.kartu_diskon_id = k.id
                                  WHERE a.status_aktif = 1";
                        $result = mysqli_query($koneksi, $query);
                        
                        while ($row = mysqli_fetch_assoc($result)) {
                            $diskon = $row['persen_diskon'] ? " (Diskon {$row['persen_diskon']}%)" : "";
                            echo "<option value='{$row['id']}' data-diskon='{$row['persen_diskon']}'>{$row['nama']}{$diskon}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>
            
            <input type="hidden" name="diskon" id="diskon" value="0">
            
            <div class="mb-3">
                <label class="form-label">Produk</label>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <select class="form-select" id="produk_select">
                            <option value="">Pilih Produk</option>
                            <?php
                            $query = "SELECT * FROM produk WHERE stok > 0";
                            $result = mysqli_query($koneksi, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['id']}' data-harga='{$row['harga']}' data-stok='{$row['stok']}'>{$row['nama']} (Rp " . number_format($row['harga'], 0, ',', '.') . " | Stok: {$row['stok']})</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control" id="jumlah" placeholder="Jumlah" min="1" value="1">
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary" id="tambah_produk">Tambah ke Pesanan</button>
                    </div>
                </div>
                
                <table class="table" id="produk_table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Produk akan ditambahkan disini via JavaScript -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Total</th>
                            <th id="total_harga">Rp 0</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3">Diskon</th>
                            <th id="total_diskon">0%</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th colspan="3">Total Bayar</th>
                            <th id="total_bayar">Rp 0</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div id="produk_hidden"></div>
            
            <button type="submit" class="btn btn-primary">Simpan Pesanan</button>
            <a href="pesanan_list.php" class="btn btn-secondary">Kembali</a>
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



 
