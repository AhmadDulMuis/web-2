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
              <div class="col-sm-6"><h3 class="mb-0">Tambah Anggota</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Anggota</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--begin::App Content-->
        <div class="app-content">
        <div class="col-md-12">
                <!--begin::Quick Example-->
                <div class="card card-primary card-outline mb-4">
                  <!--begin::Header-->
                  <div class="card-header">
                    <div class="card-title">Tambah Anggota</div>
                </div>
                <div class="card-body">
            <form action="anggota_proses.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Pegawai</label>
                <select class="form-select" name="pegawai_id" required>
                    <option value="">Pilih Pegawai</option>
                    <?php
                    $query = "SELECT * FROM pegawai WHERE id NOT IN (SELECT pegawai_id FROM anggota)";
                    $result = mysqli_query($koneksi, $query);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['nip']} - {$row['nama']}</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Kartu Diskon</label>
                <select class="form-select" name="kartu_diskon_id">
                    <option value="">Tidak ada diskon</option>
                    <?php
                    $query = "SELECT * FROM kartu_diskon";
                    $result = mysqli_query($koneksi, $query);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['id']}'>{$row['nama']} ({$row['persen_diskon']}%)</option>";
                    }
                    ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Status Keanggotaan</label>
                <select class="form-select" name="status_aktif" required>
                    <option value="aktif" selected>Aktif</option>
                    <option value="non_aktif">Non-Aktif</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="anggota_list.php" class="btn btn-secondary">Kembali</a>
        </form>
        </div>
              </div>
          </div>
      </main>
      <!--end::App Main-->
      
        <?php include_once 'footer.php'; ?>

    </div>
    <!-- Button trigger modal -->





 
