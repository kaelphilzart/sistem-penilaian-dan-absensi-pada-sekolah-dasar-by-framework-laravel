@extends('template.template_waliMurid')

@section('content')
<div class="container mt-2">
    <h3 class="text-center mb-4">IDENTITAS SISWA</h3>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="container">
                    <h4 class="card-header mt-4 text-center"><b>{{ strtoupper($siswa->nama_siswa) }}</b></h4>
                    <p class="card-title text-center mt-2"><b>{{ $siswa->NISN }}</b></p>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <p><strong>Jenis Kelamin</strong></p>
                                <p><strong>Tempat, tanggal lahir</strong></p>
                                <p><strong>No Hp</strong></p>
                                <p><strong>Alamat</strong></p>
                                <p><strong>Nama Ayah</strong></p>
                                <p><strong>Pekerjaan Ayah</strong></p>
                                <p><strong>Nama Ibu</strong></p>
                                <p><strong>Pekerjaan Ibu</strong></p>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <p>: {{ $siswa->jenis_kelamin }}</p>
                                <p>: {{ $siswa->tempat_lahir }}, {{$siswa->tgl_lahir}}</p>
                                <p>: {{ $siswa->no_telp }}</p>
                                <p>: {{ $siswa->alamat }}</p>
                                <p>: {{ $siswa->nama_ayah }}</p>
                                <p>: {{ $siswa->pekerjaan_ayah }}</p>
                                <p>: {{ $siswa->nama_ibu }}</p>
                                <p>: {{ $siswa->pekerjaan_ibu }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
