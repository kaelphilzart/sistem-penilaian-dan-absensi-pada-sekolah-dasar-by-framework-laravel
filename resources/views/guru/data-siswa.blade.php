@extends('template.template_guru')

@section('content')
<div class="container pb-4 mb-4">
    <div class="card">
        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="py-2">Data Siswa</h3>
                </div>
                <div class="col-md-6 text-end">
                    <div class="form-inline py-2">
                        <h4>Kelas: {{ $kelasPertama->nama_kelas ?? 'Tidak ada kelas yang ditemukan' }} {{ $kelasPertama->bagian}}
                        <span class="mx-2"> Tahun Ajar: {{ $kelasPertama->tahunAjar ?? 'Tidak ada tahun ajar yang ditemukan' }}</span></h4>
                    </div>
                </div>
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
