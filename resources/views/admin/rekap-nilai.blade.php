@extends('template.template_admin')

@section('content')
<div class="container">
    <div class="card">
        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="d-flex justify-content-end py-2">
                <form action="{{ route('cari-rekapNilai') }}" method="GET" class="form-inline">
                    <label for="semester" class="me-2">Pilih semester</label>
                    <select class="form-control me-2" id="semester_dropdown" name="semester">
                        <option value="">Pilih Semester</option>
                        <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Ganjil</option>
                        <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Genap</option>
                    </select>
                    @error('semester')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="btn btn-primary">Done</button>
                </form>
            </div>
        </div>

        @if($semesterDipilih)
        <div class="table-responsive py-4">
            <div class="table-wrapper">
            <table class="table table-hover">
                    <thead class="sticky-header">
                        <tr>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Wali Kelas</th>
                            <th>Tahun Pelajaran</th>
                            <th>Rata Rata</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelasData as $key => $dataKelas)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dataKelas->nama_kelas }} - {{ $dataKelas->bagian }}</td>
                            <td>{{ $dataKelas->guru ? $dataKelas->guru->nama_lengkap : 'N/A' }}</td>
                            <td>{{ $dataKelas->tahunAjar->tahunAjar }}</td>
                            <td>{{ number_format($kelasNilai[$dataKelas->id] ?? 0, 2) }}</td>
                            <td>
                                <input type="hidden" name="semester" id="semester_hidden" value="{{ request('semester', 0) }}">
                                <a href="{{ route('data-nilai-admin', ['id_kelas' => $dataKelas->id, 'semester' => '0']) }}" class="text-dark btn btn-success px-4 data-nilai-link" data-id-kelas="{{ $dataKelas->id }}">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="alert alert-info my-4">
            Silakan memilih semester terlebih dahulu.
        </div>
        @endif
    </div>
</div>
<script>
    document.getElementById('semester_dropdown').addEventListener('change', function() {
        var semester = this.value || 0; // Default to 0 if no value selected
        document.getElementById('semester_hidden').value = semester;

        var links = document.querySelectorAll('.data-nilai-link');
        links.forEach(function(link) {
            var idKelas = link.getAttribute('data-id-kelas');
            var url = "{{ route('data-nilai-admin', ['id_kelas' => ':id_kelas', 'semester' => ':semester']) }}"
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
