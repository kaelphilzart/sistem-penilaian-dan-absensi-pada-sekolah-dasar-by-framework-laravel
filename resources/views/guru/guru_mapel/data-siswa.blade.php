@extends('template.template_guru_mapel')

@section('content')
<div class="container pb-4 mb-4">
    <div class="card">
        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container mb-2">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="py-2">Data Siswa</h2>
                    <h4 class="mb-3">Pilih Kelas</h4>
                </div>
            </div>
            <form action="{{ route('cari-siswa-guru-mapel') }}" method="GET" class="form-inline">
                            <label for="id_kelas" class="form-label mx-2">Kelas</label>
                            <select class="form-control" id="id_kelas" name="id_kelas">
                                <option value="">Pilih Kelas</option>
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
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="3">Tidak ada data siswa untuk kelas yang dipilih.</td>
                        </tr>
                    </tbody>
                @endif
            </table>
        </div>
        </div>
    </div>
</div>
@endsection
