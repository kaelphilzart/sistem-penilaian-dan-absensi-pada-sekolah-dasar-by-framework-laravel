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
            <form class="form-inline" action="{{ route('import-skrining') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_kelas" value="{{ $kelasPertama->id_kelas }}">
                <input type="hidden" name="semester" id="semester_hidden" value="{{ request('semester', 0) }}">
                <div class="form-group mx-2">
                    <input type="file" class="form-control-file" id="excel_file" name="excel_file" accept=".xls,.xlsx,.csv" style="border: solid black 1px;">
                    @error('excel_file')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Import Skrining</button>
            </form>
        </div>
        <div class="table-responsive">
        <div class="table-wrapper">
              <table class="table table-hover">
                <thead class="sticky-header">
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
                                    <a href="{{ route('data-skrining', ['nisn' => $siswa->NISN]) }}" class="text-dark btn btn-success px-4 data-nilai-link" >Lihat Skrining</a>
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
    });

    // Initialize links with default semester value
    var event = new Event('change');
    document.getElementById('semester_dropdown').dispatchEvent(event);
</script>
@endsection
