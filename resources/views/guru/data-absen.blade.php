@extends('template.template_guru')

@section('content')
<div class="container mt-4 pb-4 mb-4">
  <div class="card">
    <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h2 class="py-2">Data Absensi</h2>
          <h4 class="mb-3">Pilih Tanggal dan Mata Pelajaran</h4>
        </div>
        <div class="col-md-5 text-end">
          <div class="form-inline py-2">
            <h4>Kelas: {{ $kelas->nama_kelas ?? 'Tidak ada kelas yang ditemukan' }} {{ $kelas->bagian}}
              <span class="mx-2"> Tahun Ajar: {{ $kelas->tahunAjar ?? 'Tidak ada tahun ajar yang ditemukan' }}</span>
            </h4>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group py-2">
            <form action="{{ route('cari-absen') }}" method="GET">
            <select class="form-control px-4" id="semester" name="semester">
                <option value="">Pilih Semester</option>
                <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Ganjil</option>
                <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Genap</option>
              </select>
              @error('semester')
              <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
          </div>
        </div>
      </div>
      <div class="form-inline">
        <div class="form-group">
          <label for="tgl" class="px-2">Pilih Tanggal</label>
          <div class="input-group date px-2">
            <input type="date" class="form-control" id="tgl" name="tgl" value="{{ request('tgl') }}">
            @error('tgl')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <label for="id_mapel" class="form-label px-2">Mata Pelajaran</label>
          <select class="form-control px-4" id="id_mapel" name="id_mapel">
            <option value="">Pilih Mapel</option>
            @foreach($mapel as $data1)
            <option value="{{ $data1->id }}" {{ request('id_mapel')==$data1->id ? 'selected' : '' }}>
              {{ $data1->nama_mapel }}
            </option>
            @endforeach
          </select>
          @error('id_mapel')
          <p class="text-danger text-xs mt-2">{{ $message }}</p>
          @enderror
        </div>
        <div class="px-2">
          <button type="submit" class="btn btn-primary">Done</button>
        </div>
        </form>
      </div>
    </div>
    <div class="table-responsive py-4">
    <div class="table-wrapper">
              <table class="table table-hover">
                <thead class="sticky-header">
          <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Absensi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        @if($data->isNotEmpty())
        <tbody>
          @foreach($data as $key => $siswa)
          @php
          $existingAbsensi = $absensi->get($siswa->id);
          @endphp
          <tr>
            <td>{{ $loop->iteration}}</td>
            <td>{{ $siswa->nama_siswa }}</td>

            <td>
              @if($existingAbsensi)
              <span class="mx-2">{{ ucfirst($existingAbsensi->status) }}</span>
              @else
              <form action="{{ route('input-absen') }}" method="POST" class="d-flex align-items-center">
                @csrf
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" value="hadir" checked>
                  <label class="form-check-label">Hadir</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" value="alfa">
                  <label class="form-check-label">Alfa</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="status" value="izin">
                  <label class="form-check-label">Izin</label>
                </div>
                <input type="hidden" name="tgl" value="{{ $tanggal }}">
                <input type="hidden" name="id_kelas" value="{{ $siswa->id_kelas }}">
                <input type="hidden" name="id_siswa" value="{{ $siswa->id }}">
                <input type="hidden" name="id_mapel" value="{{ request('id_mapel') }}">
                <input type="hidden" name="semester" value="{{ request('semester') }}">
                <button type="submit" class="btn btn-danger px-3">Absen</button>
              </form>
              @endif
            </td>
            <td>
              @include('guru.edit-absen')
              @if(isset($existingAbsensi))
              <a href="#" class="text-dark btn btn-warning px-4" type="button" data-bs-toggle="modal"
                data-bs-target="#edit-absen{{ $existingAbsensi->id }}">Edit</a>
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>
        @else
        <tbody>
          <tr>
            <td colspan="4">Tidak ada data siswa untuk hari dan mapel yang dipilih.</td>
          </tr>
        </tbody>
        @endif
      </table>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('tgl').setAttribute('min', today);
  });
</script>

@endsection