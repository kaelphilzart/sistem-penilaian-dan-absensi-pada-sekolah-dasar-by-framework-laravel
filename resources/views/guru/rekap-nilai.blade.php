@extends('template.template_guru')

@section('content')
<div class="container pb-4 mb-4">
    <div class="card">
        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="py-2">Data Siswa</h2>
                    <h4 class="mb-3">Pilih Kelas dan Tahun ajar</h4>
                </div>
            </div>
            <form action="{{ route('cari-rekap-nilai') }}" method="GET" class="form-inline">
                            <label for="id_kelas" class="form-label mx-2">Kelas</label>
                            <select class="form-control" id="id_kelas" name="id_kelas">
                                <option value="">Pilih Kelas dan tahun ajar</option>
                                @foreach($kelas as $data1)
                                    <option value="{{ $data1->id }}" {{ request('id_kelas') == $data1->id ? 'selected' : '' }}>
                                        {{ $data1->nama_kelas }} ({{ $data1->bagian }}) | {{ $data1->tahunAjar }} | {{ $data1->semester }}
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
                                <td>{{ $data->firstItem() + $key }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>{{ $siswa->jenis_kelamin }}</td>
                                <td>
                                <a href="{{ route('lihat-rekap', ['id_siswa' => $siswa->id, 'id_kelas' => $siswa->id_kelas]) }}" class="text-dark btn btn-success  px-4" >Lihat Rekap</a>
                                </td>
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
            @if($data->count() > 0)
                <div class="d-flex justify-content-center py-2">
                {{ $data->appends(['id_kelas' => request('id_kelas')])->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
