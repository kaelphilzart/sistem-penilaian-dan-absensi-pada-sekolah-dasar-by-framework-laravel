@extends('template.template_guru')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body ">
          <div class="form-inline mb-4 pb-4">
            <h5 class="mr-4">Kelas: {{ $kelas->nama_kelas }} - {{ $kelas->bagian }}</h5>
            <h5 class="mx-4">Nama Siswa: {{ $siswa->nama_siswa }}</h5>
            <h4 class="mx-4">Tahun Ajar: {{ $kelas->tahunAjar->tahunAjar ?? 'Tidak ada kelas yang ditemukan' }}</h4>
            <h4 class="mr-4">Semester: {{ $semester }}</h4>
          </div>
          <h4 class="">Input Estrakulikuler</h4>
          <form class="form-inline" action="{{ route('input-eskul') }}" method="POST" id="nilaiForm">
            @csrf
            <input type="hidden" value="{{$nisn}}" id="nisn" name="nisn">
            <input type="hidden" value="{{$semester}}" id="semester" name="semester">
            <input type="hidden" value="{{$id_kelas}}" id="id_kelas" name="id_kelas">
            <div class="form-group mx-4">
              <select class="form-control" id="id_eskul" name="id_eskul">
                <option>Pilih Esktrakulikuler</option>
                @foreach($eskul as $item)
                  <option value="{{ $item->id }}">{{ $item->nama_eskul }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group mx-4">
              <input type="text" step="0.01" class="form-control" id="predikat" name="predikat" placeholder="Masukkan Predikat">
              @error('predikat')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
            <div class="form-group mx-2">
              <textarea class="form-control" id="keterangan" name="keterangan" rows="4" placeholder="Keterangan"></textarea>
              @error('keterangan')
                <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
            </div>
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#confirmModal">Submit</button>
          </form>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr class="">
                  <th>No</th>
                  <th>Estrakulikuler</th>
                  <th>Predikat</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($nilaiEskul as $key => $dataNilaiEskul)
                  <tr class="">
                    <td>{{ $nilaiEskul->firstItem() + $key }}</td>
                    <td>{{ $dataNilaiEskul->nama_eskul }}</td>
                    <td>{{ $dataNilaiEskul->predikat }}</td>
                    <td>{{ $dataNilaiEskul->keterangan }}</td>
                    <td>
                      <a href="#" class="text-dark btn btn-warning  px-2" type="button" data-bs-toggle="modal" data-bs-target="#edit-nilai-eskul{{$dataNilaiEskul->id}}">Edit Eskul</a>
                    </td>
                  </tr>
                  @include('guru.edit-nilai-eskul')
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@include('guru.validasi-modal-nilai')

<script>
  document.getElementById('confirmSubmit').addEventListener('click', function() {
    document.getElementById('nilaiForm').submit();
  });
</script>
@endsection
