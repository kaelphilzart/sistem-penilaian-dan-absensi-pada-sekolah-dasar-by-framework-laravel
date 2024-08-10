@extends('template.template_admin')

@section('content')
<div class="container pb-4 mb-4">
  <div class="card">
    <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
    <div class="container mb-2">
      <div class="d-flex justify-content-center align-items-center my-4">
        <div class="mx-2">
          <form action="{{ route('cari-naik-kelas') }}" method="GET" class="form-inline">
            <label for="id_kelas" class="form-label mx-2">Pilih Kelas lama</label>
            <select class="form-control" id="id_kelas" name="id_kelas">
              <option value="">Pilih Kelas</option>
              @foreach($kelas as $data1)
              <option value="{{ $data1->id }}" {{ request('id_kelas')==$data1->id ? 'selected' : '' }}>
                {{ $data1->nama_kelas }} ({{ $data1->bagian }}) | {{ $data1->tahunAjar }}
              </option>
              @endforeach
            </select>
            @error('id_kelas')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
            <button type="submit" class="btn btn-primary mx-2">Cari</button>
          </form>
        </div>
        <div class="mx-2">
          <i class="fas fa-arrow-right fa-2x"></i>
        </div>
        <div class="mx-2">
          <form id="naikKelasForm" action="{{ route('siswa-naik-kelas') }}" method="POST" class="form-inline">
            @csrf
            <label for="id_kelas_baru" class="form-label mx-2">Pilih Kelas Baru</label>
            <select class="form-control" id="id_kelas_baru" name="id_kelas_baru">
              <option value="">Pilih Kelas</option>
              @foreach($kelas as $data1)
              <option value="{{ $data1->id }}" {{ old('id_kelas_baru')==$data1->id ? 'selected' : '' }}>
                {{ $data1->nama_kelas }} ({{ $data1->bagian }}) | {{ $data1->tahunAjar }}
              </option>
              @endforeach
            </select>
            @error('id_kelas_baru')
            <p class="text-danger text-xs mt-2">{{ $message }}</p>
            @enderror
            <input type="hidden" name="siswa_ids" id="siswa_ids">
            <button type="submit" class="btn btn-success mx-2">Naik Kelas</button>
          </form>
        </div>
      </div>
    </div>

    <h2 class="py-2 text-center">Data Siswa</h2>
  </div>
  <div class="table-responsive">
    <div class="table-wrapper">
      <table class="table table-hover">
        <thead class="sticky-header">
          <tr>
            <th><input type="checkbox" id="selectAll"></th>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Jenis Kelamin</th>
          </tr>
        </thead>
        @if($data->isNotEmpty())
        <tbody>
          @foreach($data as $key => $siswa)
          <tr>
            <td><input type="checkbox" class="selectItem" data-id="{{ $siswa->id }}"></td>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $siswa->nama_siswa }}</td>
            <td>{{ $siswa->jenis_kelamin }}</td>
          </tr>
          @endforeach
        </tbody>
        @else
        <tbody>
          <tr>
            <td colspan="4">Tidak ada data siswa untuk kelas yang dipilih.</td>
          </tr>
        </tbody>
        @endif
      </table>
    </div>
  </div>
</div>

<script>
document.getElementById('selectAll').addEventListener('change', function(e) {
    const checkboxes = document.querySelectorAll('.selectItem');
    checkboxes.forEach(checkbox => checkbox.checked = e.target.checked);
});

document.getElementById('naikKelasForm').addEventListener('submit', function(e) {
    const selectedIds = [];
    const checkboxes = document.querySelectorAll('.selectItem:checked');
    checkboxes.forEach(checkbox => {
        selectedIds.push(checkbox.getAttribute('data-id'));
    });
    document.getElementById('siswa_ids').value = selectedIds.join(',');
});
</script>
@endsection
