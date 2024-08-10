@extends('template.template_guru_mapel')

@section('content')
<div class="container pb-4 mb-4">
    <div class="card">
        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="py-2">Data Siswa</h2>
                    <h4 class="mb-3">Pilih Kelas dan Tahun Ajar</h4>
                </div>
                <div class="col-md-4">
                <form action="{{ route('cari-isi-nilai-guru-mapel') }}" method="GET" class="form-inline">
                        <div class="form-group py-2">
                        <label for="semester" class="form-label mx-2">Semester</label>
                            <select class="form-control px-4" id="semester_dropdown" name="semester">
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
            <div class="form-inline mb-2">
                    <label for="id_kelas" class="form-label mx-2">Kelas</label>
                    <select class="form-control" id="id_kelas" name="id_kelas">
                        <option value="">Pilih Kelas dan Tahun Ajar</option>
                        @foreach($kelas as $data1)
                            <option value="{{ $data1->id }}" {{ request('id_kelas') == $data1->id ? 'selected' : '' }}>
                                {{ $data1->nama_kelas }} ({{ $data1->bagian }}) | {{ $data1->tahunAjar }} 
                            </option>
                        @endforeach
                    </select>
                    @error('id_kelas')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="btn btn-primary mx-2">Cari</button>
                </form>
                @if(request('semester'))
                <form class="form-inline mx-4" action="{{ route('import-nilai-guru-mapel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_kelas" value="{{ request('id_kelas') }}">
                    <input type="hidden" name="semester" id="semester" value="{{ request('semester') }}">
                    <div class="form-group mx-2">
                        <input type="file" class="form-control-file" id="excel_file" name="excel_file" accept=".xls,.xlsx,.csv" style="border: solid black 1px;">
                        @error('excel_file')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Import Nilai</button>
                </form>
                <a href="#" id="download-template" class="text-dark btn btn-warning mx-4">Download Template</a>
                @endif
            </div>
            
        </div>
        <div class="table-responsive">
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
                                        <a href="{{ route('data-nilai', ['nisn' => $siswa->NISN, 'id_kelas' => $siswa->id_kelas, 'semester' => request('semester')]) }}" class="text-dark btn btn-success px-4 data-nilai-link">Lihat Nilai</a>
                                    </td>
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
</div>
<script>
    document.getElementById('download-template').addEventListener('click', function() {
    const idKelas = document.getElementById('id_kelas').value;
    if (idKelas) {
        const url = `{{ url('download-template-mapel') }}/${idKelas}`;
        window.location.href = url;
    } else {
        alert('Pilih kelas terlebih dahulu.');
    }
});
    document.getElementById('semester_dropdown').addEventListener('change', function() {
        var semester = this.value || 0; // Default to 0 if no value selected
        document.getElementById('semester_hidden').value = semester;

        var links = document.querySelectorAll('.data-nilai-link');
        links.forEach(function(link) {
            var nisn = link.getAttribute('data-nisn');
            var idKelas = link.getAttribute('data-id-kelas');
            var url = "{{ route('data-nilai', ['nisn' => ':nisn', 'id_kelas' => ':id_kelas', 'semester' => ':semester']) }}"
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
