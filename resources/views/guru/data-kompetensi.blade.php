@extends('template.template_guru')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="form-inline mb-4">
            <h5 class="mr-4">Kelas: {{ $kelas->nama_kelas }} - {{ $kelas->bagian }}</h5>
            <h5 class="mx-4">Nama Siswa: {{ $siswa->nama_siswa }}</h5>
            <h4 class="mx-4">Tahun Ajar: {{ $kelas->tahunAjar->tahunAjar ?? 'Tidak ada kelas yang ditemukan' }}</h4>
            <h4 class="mr-4">Semester: {{ $semester }}</h4>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Mata Pelajaran</th>
                  <th>Kompetensi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($kompetensi as $dataNilai)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $dataNilai->mapel->nama_mapel }}</td>
                  <td>{{ $dataNilai->kompetensi }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
