@extends('template.template_guru')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body ">
          <div class="form-inline mb-4 pb-4">
            <h5 class="mr-4">Kelas : {{ $kelas->nama_kelas }} - {{ $kelas->bagian }}</h5>
            <h5 class="mx-4">Nama Siswa : {{ $siswa->nama_siswa }}</h5>
          </div>
          <h4 class="">Input Kompetensi</h4>
          <form class="form-inline" action="{{ route('input-raport') }}" method="POST" id="raportForm">
                @csrf
                <input type="hidden" value="{{ $id_siswa }}" id="id_siswa" name="id_siswa">
                <input type="hidden" value="{{ $id_kelas }}" id="id_kelas" name="id_kelas">
                <div class="form-group mx-2">
                    <label for="id_mapel" class="form-label mx-2">Mata Pelajaran</label>
                    <select class="form-control" id="id_mapel" name="id_mapel">
                        <option value="">Pilih Mata Pelajaran</option>
                        @foreach($nilaiRataRata as $item)
                            <option value="{{ $item->id_mapel }}" data-ratarata="{{ $item->rata_rata_nilai }}">{{ $item->nama_mapel }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mx-2">
                    <label for="nilai_akhir" class="form-label mx-2">Nilai Akhir</label>
                    <input type="text" class="form-control" id="nilai_akhir" name="nilai_akhir" readonly>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="kompetensi" name="kompetensi" rows="4" placeholder="Capaian Kompetensi"></textarea>
                </div>
                <button type="button" class="btn btn-primary mx-2" data-toggle="modal" data-target="#confirmModal">Submit</button>
            </form>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr class="">
                  <th>No</th>
                  <th>Mata Pelajaran</th>
                  <th>Nilai Akhir</th>
                  <th>Kompetensi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($raport as $key => $dataRaport)
                <tr>
                    <td>{{ $raport->firstItem() + $key }}</td>
                    <td>{{ $dataRaport->nama_mapel }}</td>
                    <td>{{ number_format($dataRaport->rata_rata_nilai, 2) }}</td> <!-- Format nilai rata-rata -->
                    <td>{{ $dataRaport->kompetensi }}</td>
                    <td>
                        <a href="#" class="text-dark btn btn-warning px-2" type="button" data-bs-toggle="modal" data-bs-target="#edit-raport{{ $dataRaport->id }}">Edit raport</a>
                    </td>
                </tr>
                @include('guru.edit-raport')
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
document.getElementById('id_mapel').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var rataRata = selectedOption.getAttribute('data-ratarata');
    document.getElementById('nilai_akhir').value = rataRata ? rataRata : '';
});
</script>

@include('guru.validasi-modal-raport')
@endsection
