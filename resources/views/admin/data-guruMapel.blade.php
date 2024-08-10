@extends('template.template_admin')

@section('content')
<div class="container ">
    <div class="card">

        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-6 ">
                  
                </div>
              @include('admin.tambah-GuruMapel')
                <div class="col-md-6">
                    <div class="text-end mx-2 text-right">
                        <a href="#" class="text-dark btn btn-success  mb-0  px-4 mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambah-guruMapel">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Mapel</th>
                        <th>Kode Mapel</th>
                        <th>Kelas yang diajar</th>
                    </tr>
                </thead>
                @foreach($data as $key => $dataKelas)
                <tbody>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dataKelas->nama_lengkap }}</td>
                        <td>{{ $dataKelas->mapel->nama_mapel }}</td>
                        <td>{{ $dataKelas->kode_mapel }}</td>
                        <td>
                        <form action="{{route('delete-guruMapel', $dataKelas->id)}}" method="post">
                                @csrf
                                <a href="#" class="btn btn-dark px-4" type="button" data-bs-toggle="modal" data-bs-target="#lihat-kelas{{ $dataKelas->id }}">Lihat</a>
                                <button class="btn btn-danger px-3" onClick="return confirm('Yakin Hapus?')">Hapus</button>
                            </form>
                    </td>
                    </tr>
                @include('admin.lihat-kelas')
                    @endforeach
                </tbody>
            </table>    
        </div>
    </div>
</div>
@endsection