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
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
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
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>{{ $siswa->jenis_kelamin }}</td>
                                <td>
                                    <a href="{{ route('data-eskul', ['nisn' => $siswa->NISN, 'id_kelas' => $siswa->id_kelas, 'semester' => request('semester', 0)]) }}" class="text-dark btn btn-success px-4 data-nilai-link" data-nisn="{{ $siswa->NISN }}" data-id-kelas="{{ $siswa->id_kelas }}">Isi Predikat</a>
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

<script>
    document.getElementById('semester_dropdown').addEventListener('change', function() {
        var semester = this.value || 0; // Default to 0 if no value selected

        var links = document.querySelectorAll('.data-nilai-link');
        links.forEach(function(link) {
            var nisn = link.getAttribute('data-nisn');
            var idKelas = link.getAttribute('data-id-kelas');
            var url = "{{ route('data-eskul', ['nisn' => ':nisn', 'id_kelas' => ':id_kelas', 'semester' => ':semester']) }}"
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
