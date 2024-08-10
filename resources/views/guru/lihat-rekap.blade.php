@extends('template.template_guru')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="form-inline mb-4 pb-4">
            <h5 class="mr-4">Kelas: {{ $kelas->nama_kelas }} - {{ $kelas->bagian }}</h5>
            <h5 class="mx-4">Nama Siswa: {{ $siswa->nama_siswa }}</h5>
          </div>
          <div class="col-md-12">
            <h4 class="text-center">Rekap Nilai</h4>
          </div>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Mata Pelajaran</th>
                  @foreach($jenisTugas as $tugas)
                    <th>{{ $tugas }}</th>
                  @endforeach
                  <th>Rata-Rata</th>
                </tr>
              </thead>
              <tbody>
                @foreach($rekap as $mapel => $nilaiMapel)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $mapel }}</td>
                  @foreach($jenisTugas as $tugas)
                    <td>
                      @php
                        $nilai = $nilaiMapel->firstWhere('nama_tugas', $tugas);
                      @endphp
                      {{ $nilai ? $nilai->isi_nilai : '-' }}
                    </td>
                  @endforeach
                  <td>{{ number_format($rataRata[$mapel], 2) }}</td>
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
