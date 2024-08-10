@extends('template.template_guru')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body ">
          <div class="form-inline mb-4 pb-4">
            <h5 class="mx-4">Nama Siswa: {{ $siswa->nama_siswa }}</h5>
          </div>
          <div class="table-responsive">
          <div class="table-wrapper">
              <table class="table table-hover">
                <thead class="sticky-header">
                <tr class="">
                  <th>No</th>
                  <th>Tinggi Badan</th>
                  <th>Berat Badan</th>
                  <th>Pendengaran</th>
                  <th>Penglihatan</th>
                  <th>Gigi</th>
                  <th>Kelas</th>
                  <th>Tahun Ajaran</th>
                  <th>Semester</th>
                </tr>
              </thead>
              <tbody>
                @foreach($skrining as $key => $dataNilaiEskul)
                  <tr class="">
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $dataNilaiEskul->tinggi_badan }}</td>
                    <td>{{ $dataNilaiEskul->berat_badan }}</td>
                    <td>{{ $dataNilaiEskul->pendengaran }}</td>
                    <td>{{ $dataNilaiEskul->penglihatan }}</td>
                    <td>{{ $dataNilaiEskul->gigi }}</td>
                    <td>{{ $dataNilaiEskul->kelas->nama_kelas }}</td>
                    <td>{{ $dataNilaiEskul->kelas->tahunAjar->tahunAjar }}</td>
                    <td>{{ $dataNilaiEskul->semester }}</td>
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
</section>

@endsection
