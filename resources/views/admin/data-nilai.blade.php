@extends('template.template_admin')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="container">
            <h4 class="text-center fw-bold">REKAP NILAI</h4>
          </div>
          <div class="table-responsive py-4 ">
            <div class="table-wrapper">
              <table class="table table-hover ">
                <thead class="sticky-header">
                  <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    @foreach($allMapel as $nama_mapel)
                      <th>{{ $nama_mapel }}</th>
                    @endforeach
                    <th>Rata-rata Keseluruhan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($nilaiPerSiswa as $data)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $data['nama_siswa'] }}</td>
                      @foreach($allMapel as $nama_mapel)
                        <td>{{ $data['nilai_mapel']->get($nama_mapel, 0) }}</td>
                      @endforeach
                      <td>{{ $data['rata_rata_keseluruhan'] }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2"><strong>Rata-rata Mapel</strong></td>
                    @foreach($allMapel as $kode_mapel => $nama_mapel)
                      <td>{{ $rataRataPerMapel->get($kode_mapel, 0) }}</td>
                    @endforeach
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
