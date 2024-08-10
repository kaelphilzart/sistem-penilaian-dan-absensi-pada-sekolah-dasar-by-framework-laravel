<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistem Raport SDN Watudakon</title>
  <!-- base:css -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="\mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="\css/vendor.bundle.base.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="\css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="\images/favicon.ico" />

  <style>
    /* CSS untuk sidebar */
    .table-wrapper {
    max-height: 400px; /* Sesuaikan tinggi tabel sesuai kebutuhan Anda */
    overflow-y: auto;
  }

  .sticky-header th {
    position: sticky;
    top: 0;
    background: #87CEFA; /* Sesuaikan warna latar belakang sesuai tema Anda */
    z-index: 1000;
    box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
  }

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
  </style>

</head>
<body>
  <div class="container-scroller d-flex">
    <!-- partial:./partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
      <li class="nav-item sidebar-category">
        <div class="navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard_guru_mapel') }}">
          <img src="\images/logo-sd-2.svg" alt="logo" />
        </a>
      </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('dashboard_guru_mapel')}}">
            <i class="mdi mdi-view-quilt menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            <div class="badge badge-info badge-pill">2</div>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('data-siswa-guru-mapel')}}">
          <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">Siswa</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('absen-guru-mapel')}}">
            <i class="mdi mdi-grid-large menu-icon"></i>
            <span class="menu-title">Absen</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('isi-nilai-guru-mapel')}}">
          <i class="mdi mdi-palette menu-icon"></i>
            <span class="menu-title">Isi Nilai</span>
          </a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="{{route('isi-eskul')}}">
          <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Isi Eskul</span>
          </a>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link" href="{{route('rekap-nilai')}}">
          <i class="mdi mdi-file-document-box-outline menu-icon"></i>
            <span class="menu-title">Rekap Nilai</span>
          </a>
        </li> -->
        <!-- <li class="nav-item">
          <a class="nav-link" href="{{route('skrining')}}">
          <i class="mdi mdi-emoticon menu-icon"></i>
            <span class="menu-title">Skrining</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('raport-siswa')}}">
          <i class="mdi mdi-view-headline menu-icon"></i>
            <span class="menu-title">Kompetensi</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{route('cetak-raport')}}">
          <i class="mdi mdi-chart-pie menu-icon"></i>
            <span class="menu-title">Cetak Raport</span>
          </a>
        </li> -->
       
      </ul>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:./partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <div class="navbar-brand-wrapper">
            <!-- <a class="navbar-brand brand-logo" href="index.html"><img src="images/logo.svg" alt="logo"/></a>
            <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo"/></a> -->
          </div>
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
                <a class="dropdown-item" href="{{ route('logout-guru')}}">
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
      <div class="main-panel">
        <div class="content-wrapper">
      @yield('content')

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
      <!-- main-panel ends -->
    </div>
    </div>
    </div>
      <!-- partial -->
   
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

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
    document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('confirmSubmit').addEventListener('click', function() {
        document.getElementById('nilaiForm').submit();
    });
});

  </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('confirmSubmit').addEventListener('click', function() {
        document.getElementById('raportForm').submit();
    });
});

  </script>
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