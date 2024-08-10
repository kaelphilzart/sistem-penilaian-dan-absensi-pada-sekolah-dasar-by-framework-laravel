@extends('template.template_admin')

@section('content')
<div class="container ">
    <div class="card">

        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-6 ">
                    <form action="{{route('kelas-cari')}}" method="GET">
                            <label>
                            <input type="search" name="q"  class="form-control" placeholder="masukan wali kelas ">
                            </label>
                            <button type="submit" class="mx-2 btn btn-primary ">
                            <i class="bx bx-search fs-4 lh-0"></i> Cari</button>
                    </form>
                </div>
                @include('admin.tambah-kelas')
                <div class="col-md-6">
                    <div class="text-end mx-2 text-right">
                        <a href="#" class="text-dark btn btn-success  mb-0  px-4 mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambah-kelas">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kelas</th>
                        <th>Wali Kelas</th>
                        <th>Tahun Pelajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @foreach($data as $key => $dataKelas)
                <tbody>
                    <tr>
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $dataKelas->nama_kelas }} - {{ $dataKelas->bagian }}</td>
                        <td>{{ $dataKelas->wali_kelas }}</td>
                        <td>{{ $dataKelas->tahunPelajaran }}</td>
                        <td>
                            <form action="{{route('delete-kelas', $dataKelas->id)}}" method="post">@csrf
                                <a href="#" class="text-dark btn btn-warning  px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-kelas{{$dataKelas->id}}">Edit</a>
                                <button class="btn btn-danger px-3"
                                    onClick="return confirm('Yakin Hapus Kelas?')">Delete</button>
                                    <a href="{{ route('siswa-kelas', $dataKelas->id) }}" class="text-dark btn btn-info  px-4" >Siswa</a>
                            </form>
                        </td>
                    </tr>
                    @include('admin.edit-kelas')
                    @endforeach
                </tbody>
            </table>
            <div class="pagination py-2 px-2">
            <div class="d-flex justify-content-center align-items-center">
             
                {{ $data->links('pagination::bootstrap-4') }}
            </div>
        </div>
        </div>
    </div>
</div>
@endsection