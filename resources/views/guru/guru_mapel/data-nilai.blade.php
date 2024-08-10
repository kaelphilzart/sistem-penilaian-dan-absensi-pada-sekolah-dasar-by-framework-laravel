@extends('template.template_guru_mapel')

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
                  <th>Tugas 1</th>
                  <th>Tugas 2</th>
                  <th>UTS</th>
                  <th>Tugas 3</th>
                  <th>Tugas 4</th>
                  <th>UAS</th>
                  <th>Rata Rata</th>
                </tr>
              </thead>
              <tbody>
                @foreach($nilai as $dataNilai)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $dataNilai->nama_mapel }}</td>
                  <td>{{ $dataNilai->tugas_1 }}</td>
                  <td>{{ $dataNilai->tugas_2 }}</td>
                  <td>{{ $dataNilai->uts }}</td>
                  <td>{{ $dataNilai->tugas_3 }}</td>
                  <td>{{ $dataNilai->tugas_4 }}</td>
                  <td>{{ $dataNilai->uas }}</td>
                  <td>{{ number_format($dataNilai->rata_rata, 2) }}</td>
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
