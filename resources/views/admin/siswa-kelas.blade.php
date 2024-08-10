
@extends('template.template_admin')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body ">
            <div class="row mt-4">
            <div class="col-md-4">
            <h5 class="">Kelas : {{ ($dataKelas->nama_kelas) }} - {{ ($dataKelas->bagian) }}</h5>
            </div>
            <div class="col-md-4">
            <h5 class="">Tahun Pelajaran : {{ ($dataKelas->tahunAjar->tahunAjar) }}</h5>
            </div>
            <div class="col-md-4">
           
            </div>
            </div>
            <div class="table-responsive py-4 ">
        <div class="table-wrapper">
              <table class="table table-hover ">
                <thead class="sticky-header">
            <tr class="">
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>           
                    </tr>
            </thead>
            @foreach($data as $key => $dataSiswa)
            <tbody>
            <tr class="">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dataSiswa->NISN }}</td>
                        <td>{{ $dataSiswa->nama_siswa }}</td>
                        <td>{{ $dataSiswa->jenis_kelamin }}</td>
                           </tr>
                   @endforeach
            </tbody>
          </table>
            </div>
        </div>
      </div>
        </div>
      </div>

    </div>
  </div>
</section>



@endsection