@extends('template.template_guru')

@section('content')
<div class="container pb-4 mb-4">
    <div class="card">
        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h2 class="py-2">Data Siswa</h2>
                </div>
                <div class="col-md-5 text-end">
                    <div class="form-inline py-2">
                        <h4>Kelas: {{ $kelasPertama->nama_kelas ?? 'Tidak ada kelas yang ditemukan' }} {{ $kelasPertama->bagian ?? 'Tidak ada kelas yang ditemukan' }}
                        <span class="mx-2"> Tahun Ajar: {{ $kelasPertama->tahunAjar ?? 'Tidak ada tahun ajar yang ditemukan' }}</span></h4>
                    </div>
                </div>
                <div class="col-md-3 py-2">
                    <select class="form-control" id="semester_dropdown">
                        <option value="0" {{ request('semester') == '0' ? 'selected' : '' }}>Pilih Semester</option>
                        <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Ganjil</option>
                        <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Genap</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                <form class="form-inline" action="{{ route('import-nilai') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_kelas" value="{{ $kelasPertama->id_kelas }}">
                <input type="hidden" name="semester" id="semester_hidden" value="{{ request('semester', 0) }}">
                <div class="form-group mx-2">
                    <input type="file" class="form-control-file" id="excel_file" name="excel_file" accept=".xls,.xlsx,.csv" style="border: solid black 1px;">
                    @error('excel_file')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Import Nilai</button>
            </form>
                </div>
                <div class="col-md-6 text-center">
                <a href="{{ route('download-template') }}" class="text-dark btn btn-warning px-4">Download Template</a>
                
                </div>
            </div>
           
        </div>
        <div class="table-responsive py-4">
        <div class="table-wrapper">
              <table class="table table-hover">
                <thead class="sticky-header">
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @if($data->isNotEmpty())
                    <tbody>
                        @foreach($data as $key => $siswa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $siswa->NISN }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>{{ $siswa->jenis_kelamin }}</td>
                                <td>
                                    <a href="{{ route('data-nilai-wali', ['nisn' => $siswa->NISN, 'id_kelas' => $siswa->id_kelas, 'semester' => '0']) }}" class="text-dark btn btn-success px-4 data-nilai-link" data-nisn="{{ $siswa->NISN }}" data-id-kelas="{{ $siswa->id_kelas }}">Lihat Rekap</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="4">Tidak ada siswa.</td>
                        </tr>
                    </tbody>
                @endif
            </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('semester_dropdown').addEventListener('change', function() {
        var semester = this.value || 0; // Default to 0 if no value selected
        document.getElementById('semester_hidden').value = semester;

        var links = document.querySelectorAll('.data-nilai-link');
        links.forEach(function(link) {
            var nisn = link.getAttribute('data-nisn');
            var idKelas = link.getAttribute('data-id-kelas');
            var url = "{{ route('data-nilai-wali', ['nisn' => ':nisn', 'id_kelas' => ':id_kelas', 'semester' => ':semester']) }}"
                        .replace(':nisn', nisn)
                        .replace(':id_kelas', idKelas)
                        .replace(':semester', semester);
            link.href = url;
        });
    });

    // Initialize links with default semester value
    var event = new Event('change');
    document.getElementById('semester_dropdown').dispatchEvent(event);
</script>
@endsection
