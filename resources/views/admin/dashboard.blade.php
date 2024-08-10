@extends('template.template_admin')

@section('content')
<div class="page-header flex-wrap">
  <h3 class="mb-0"> Hi, welcome back! <span class="pl-0 h6 pl-sm-2 text-muted d-inline-block">Your web analytics
      dashboard template.</span>
  </h3>
</div>
<div class="row">
  <div class="col-xl-3 col-lg-12 stretch-card grid-margin">
    <div class="row">
      <div class="col-xl-12 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
        <div class="card bg-warning">
          <div class="card-body px-3 py-4">
            <div class="d-flex justify-content-between align-items-start">
              <div class="color-card">
                <p class="mb-0 color-card-head">Siswa Aktif</p>
                <h2 class="text-white"> {{$jumlahSiswaAktif}}</h2>
              </div>
              <i class="card-icon-indicator mdi mdi-account-multiple bg-inverse-icon-warning"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-12 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3">
        <div class="card bg-danger">
          <div class="card-body px-3 py-4">
            <div class="d-flex justify-content-between align-items-start">
              <div class="color-card">
                <p class="mb-0 color-card-head">Siswa Tidak Aktif</p>
                <h2 class="text-white"> {{$jumlahSiswa}}</h2>
              </div>
              <i class="card-icon-indicator mdi mdi-account-off bg-inverse-icon-danger"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-12 col-md-6 stretch-card grid-margin grid-margin-sm-0 pb-sm-3 pb-lg-0 pb-xl-3">
        <div class="card bg-primary">
          <div class="card-body px-3 py-4">
            <div class="d-flex justify-content-between align-items-start">
              <div class="color-card">
                <p class="mb-0 color-card-head">Guru Aktif</p>
                <h2 class="text-white"> {{$jumlahGuruAktif}}</h2>
              </div>
              <i class="card-icon-indicator mdi mdi-account bg-inverse-icon-primary"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-12 col-md-6 stretch-card pb-sm-3 pb-lg-0">
        <div class="card bg-success">
          <div class="card-body px-3 py-4">
            <div class="d-flex justify-content-between align-items-start">
              <div class="color-card">
                <p class="mb-0 color-card-head">Guru Tidak Aktif</p>
                <h2 class="text-white">{{$jumlahGuru}}</h2>
              </div>
              <i class="card-icon-indicator mdi mdi-account-off bg-inverse-icon-success"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-9 stretch-card grid-margin">
    <div class="container">
        <div class="card shadow-sm">  
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-7">
                        <h5>Statistik Nilai dan Siswa</h5>
                    </div>     
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="flot-chart-wrapper">
                            <div id="flotChart" class="flot-chart mx-4">
                                <canvas id="combinedChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<script>
    var ctx = document.getElementById('combinedChart').getContext('2d');
    var combinedChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [
                {
                    label: 'Rata-rata Nilai',
                    data: {!! json_encode($values) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    barThickness: 20,
                    fill: false
                },
                {
                    label: 'Jumlah Siswa Masuk',
                    data: {!! json_encode($siswaValues) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    barThickness: 20,
                    fill: false
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                x: {
                    barPercentage: 0.5,
                    categoryPercentage: 0.5
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
