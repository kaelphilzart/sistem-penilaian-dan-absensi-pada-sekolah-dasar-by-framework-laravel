<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Sistem Raport SDN Watudakon</title>
  <!-- base:css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="\mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="\css/vendor.bundle.base.css"> 

  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="\css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="\images/favicon.ico" />


   <!-- Custom CSS -->
   <style>
    /* CSS untuk sidebar */
    .navbar-brand-wrapper {
        text-align: center;
    /* Sesuaikan dengan warna background yang diinginkan */
    }

    .navbar-brand-wrapper img {
        width: 150px; /* Ukuran logo normal */
        height: auto;
    }

    /* Responsif untuk layar kecil */
    @media (max-width: 992px) {
      

        .navbar-brand-wrapper {
            padding: 0.5rem;
        }

        .navbar-brand-wrapper img {
            width: 100px; /* Ukuran logo pada layar kecil */
            height: auto;
        }

        .nav-item span {
            display: none; /* Menyembunyikan teks menu pada layar kecil */
        }

        .nav-link {
            text-align: center;
        }
    }

    /* Responsif untuk layar sangat kecil */
    @media (max-width: 576px) {
      

        .navbar-brand-wrapper img {
            width: 70px; /* Ukuran logo pada layar sangat kecil */
            height: auto;
        }
    }

    .table-wrapper {
    max-height: 500px; /* Sesuaikan tinggi tabel sesuai kebutuhan Anda */
    overflow-y: auto;
  }

  .sticky-header th {
    position: sticky;
    top: 0;
    background: #87CEFA; /* Sesuaikan warna latar belakang sesuai tema Anda */
    z-index: 1000;
    box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
  }

  </style>

</head>
<body>
  <div class="container-scroller d-flex">
    <!-- partial:./partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <!-- Logo di luar ul -->
      
      <ul class="nav">
        <li class="nav-item sidebar-category">
        <div class="navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard_admin') }}">
          <img src="\images/logo-sd-2.svg" alt="logo" />
        </a>
      </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard_admin') }}">
            <i class="mdi mdi-view-quilt menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            <div class="badge badge-info badge-pill">2</div>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="{{ route('data-guru') }}">
            <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">Guru</span>
          </a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#data-guru" aria-expanded="false" aria-controls="data-guru">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">Guru</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="data-guru">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{ route('data-guru') }}">Data Guru</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('data-guruMapel') }}">Guru Mapel</a></li>
              <!-- <li class="nav-item"> <a class="nav-link" href="{{ route('status-guru') }}">Status Guru</a></li> -->
              <!-- <li class="nav-item"> <a class="nav-link" href="{{route('wali-kelas')}}">Ganti Wali Kelas</a></li> -->
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('data-kurikulum') }}">
            <i class="mdi mdi-file-document-box-outline menu-icon"></i>
            <span class="menu-title">Kurikulum</span>
          </a>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('data-kelas') }}">
            <i class="mdi mdi-chart-pie menu-icon"></i>
            <span class="menu-title">Kelas</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('data-tahun') }}">
            <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">Tahun Pelajaran</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('data-rombel') }}">
            <i class="mdi mdi-emoticon menu-icon"></i>
            <span class="menu-title">Rombongan Belajar</span>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="{{ route('data-siswa-admin') }}">
            <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">Siswa</span>
          </a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">Siswa</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{ route('data-siswa-admin') }}">Data Siswa</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{route('naik-kelas')}}">Naik Kelas</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('data-mapel') }}">
            <i class="mdi mdi-file-document-box-outline menu-icon"></i>
            <span class="menu-title">Mata Pelajaran</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('rekap-nilai-admin') }}">
            <i class="mdi mdi-file-document-box-outline menu-icon"></i>
            <span class="menu-title">Rekap Nilai</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('data-eskul-admin') }}">
          <i class="mdi mdi-chart-pie menu-icon"></i>
            <span class="menu-title">Data Eskul</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('akun-waliMurid') }}">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">Wali Murid</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('data-user') }}">
            <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">User</span>
          </a>
        </li>
        </li>
      </ul>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- Navbar -->
      <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <h4 class="font-weight-bold mb-0 d-none d-md-block mt-1 ml-4">Sistem Informasi Raport</h4>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown bg-dark rounded m-2 p-3">
              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                <span class="nav-profile-name">{{ Auth::user()->name }} ({{ Auth::user()->status->nama }})</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item">
                  <i class="mdi mdi-settings text-primary"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="{{ route('logout-admin') }}">
                  <i class="mdi mdi-logout text-primary"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
     
      <!-- main-panel ends -->
      <div class="main-panel">
        <div class="content-wrapper">
       @yield('content')
    </div>
    </div>
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="liveToast" class="toast @if(session('error') || session('success')) show @else hide @endif" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            @if(session('error'))
                <img src="/images/erorr.png" class="rounded me-2" alt="Gagal" style="width: 16px; height: 16px;">
                <strong class="me-auto">Gagal</strong>
            @elseif(session('success'))
                <img src="/images/success.png" class="rounded me-2" alt="Berhasil" style="width: 16px; height: 16px;">
                <strong class="me-auto">Berhasil</strong>
            @endif
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            @if(session('error'))
                {{ session('error') }}
            @elseif(session('success'))
                {{ session('success') }}
            @endif
        </div>
    </div>
</div>

  <!-- base:js -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

  <script src="\js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="\chart.js/Chart.min.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="\js/off-canvas.js"></script>
  <script src="\js/hoverable-collapse.js"></script>
  <script src="\js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="\js/dashboard.js"></script>
  <!-- End custom js for this page-->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('error') || session('success'))
            var toastEl = document.getElementById('liveToast');
            var toast = new bootstrap.Toast(toastEl, { delay: 6000 });
            toast.show();
        @endif
    });
</script>
</body>

</html>