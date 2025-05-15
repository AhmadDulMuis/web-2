<?php include_once 'top.php';

require_once 'koneksi.php';


// buat ngitung jumlah pesanan
$query_pesanan = "SELECT COUNT(*) as total_pesanan FROM pesanan";
$result_pesanan = mysqli_query($koneksi, $query_pesanan);
$data_pesanan = mysqli_fetch_assoc($result_pesanan);
$total_pesanan = $data_pesanan['total_pesanan'];

// buat ngitung jumlah diskon 
$query_diskon = "SELECT COUNT(*) as total_diskon FROM kartu_diskon";
$result_diskon = mysqli_query($koneksi, $query_diskon);
$data_diskon = mysqli_fetch_assoc($result_diskon);
$total_diskon = $data_diskon['total_diskon'];

// buat ngitung jumlah anggota
$query_anggota = "SELECT COUNT(*) as total_anggota FROM anggota";
$result_anggota = mysqli_query($koneksi, $query_anggota);
$data_anggota = mysqli_fetch_assoc($result_anggota);
$total_anggota = $data_anggota['total_anggota'];

// buat ngitung jumlah produk
$query_produk = "SELECT COUNT(*) as total_produk FROM produk";
$result_produk = mysqli_query($koneksi, $query_produk);
$data_produk = mysqli_fetch_assoc($result_produk);
$total_produk = $data_produk['total_produk'];
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
              <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
              </div>
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content"> <!--begin::Container-->
                <div class="container-fluid"> <!--begin::Row-->
                    <div class="row"> <!--begin::Col-->
                    <div class="col-lg-3 col-6">
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3><?= $total_pesanan ?></h3>
                                <p>Jumlah Pesanan</p>
                            </div>
                            <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                            </svg>
                            <a href="pesanan_list.php" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Lihat Detail <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                    </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-success">
                                <div class="inner">
                                    <h3><?= $total_diskon ?></h3>
                                    <p>Jumlah Diskon</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"></path>
                                </svg>
                                <a href="diskon_list.php" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    Lihat Detail <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-warning">
                                <div class="inner">
                                    <h3><?= $total_anggota ?></h3>
                                    <p>Jumlah Anggota</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                                </svg>
                                <a href="anggota_list.php" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                                    Lihat Detail <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-danger">
                                <div class="inner">
                                    <h3><?= $total_produk ?></h3>
                                    <p>Jumlah Produk</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"></path>
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"></path>
                                </svg>
                                <a href="produk_list.php" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    Lihat Detail <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                    </div> <!--end::Row--> <!--begin::Row-->
        <div class="container mt-4">
         <div class="col-lg-12 connectedSortable">
                <div class="card mb-4">
                  <div class="card-header"><h3 class="card-title">Sales Value</h3></div>
                  <div class="card-body"><div id="revenue-chart"></div></div>
                </div>
                <!-- /.card -->
                <!-- DIRECT CHAT -->
                
      
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      
      <!--begin::Footer-->
        <?php include_once 'footer.php'; ?>

      <!--end::Footer-->
    </div>
    <!-- Button trigger modal -->


 
