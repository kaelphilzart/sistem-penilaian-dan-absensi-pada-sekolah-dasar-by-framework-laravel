@extends('template.template_guru')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="form-inline mb-4 pb-4">
            <h5 class="mr-4">Kelas: {{ $kelas->nama_kelas }} - {{ $kelas->bagian }}</h5>
            <h5 class="mx-4">Semester: {{ $semester }}</h5>
            <h5 class="mx-4">Nama Siswa: {{ $siswa->nama_siswa }}</h5>
          </div>
          <div class="text-center">
            <iframe src="{{ url('/review-raport/'.$siswa->NISN.'/'.$kelas->id. '/'.$semester) }}" width="816.68px" height="1000px" ></iframe>
            <div class="text-center mt-4">
            <a href="{{ url('/download-raport/'.$siswa->NISN.'/'.$kelas->id. '/'.$semester ) }}" class="btn btn-success">Download PDF</a>
            </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
