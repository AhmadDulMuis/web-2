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
              <div class="col-sm-6"><h3 class="mb-0">Daftar Anggota</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Daftar Anggota</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--begin::App Content-->
        <div class="app-content">
        <div class="container mt-4">
        <!-- <h2>Daftar Anggota</h2> -->
        <a href="anggota_tambah.php" class="btn btn-primary mb-3">Tambah Anggota</a>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Status</th>
                    <th>Diskon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT a.*, p.nip, p.nama, p.jabatan, k.nama as kartu_diskon, k.persen_diskon
                          FROM anggota a
                          JOIN pegawai p ON a.pegawai_id = p.id
                          LEFT JOIN kartu_diskon k ON a.kartu_diskon_id = k.id
                          ORDER BY p.nama ASC";
                $result = mysqli_query($koneksi, $query);
                
                if (mysqli_num_rows($result) > 0) {
                  $no = 1; // Tambahkan variabel counter
                    while ($row = mysqli_fetch_assoc($result)) {
                        $status = $row['status_aktif'];
                        $badge_class = $status == 'aktif' ? 'badge-aktif' : 'badge-non_aktif';
                        $status_text = $status == 'aktif' ? 'Aktif' : 'Non-Aktif';
                        
                        $diskon_text = '-';
                        if (!empty($row['kartu_diskon'])) {
                            $diskon_text = $row['kartu_diskon'] . " ({$row['persen_diskon']}%)";
                        }
                        
                        echo "<tr>
                                <td>{$no}</td> 
                                <td>{$row['nip']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['jabatan']}</td>
                                <td><span class='badge {$badge_class}'>{$status_text}</span></td>
                                <td>{$diskon_text}</td>
                                <td>
                                    <a href='anggota_edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='anggota_proses.php?id={$row['id']}'class='btn btn-danger btn-sm' onclick='return confirmHapus()'>Hapus</a></td></tr>";

                                    $no++; // Increment counter

                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Tidak ada data anggota</td></tr>";
                    
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


    
    <script>
function confirmHapus() {
    return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?');
}
</script>



 
