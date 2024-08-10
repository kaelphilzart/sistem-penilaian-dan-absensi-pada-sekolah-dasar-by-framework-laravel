@extends('template.template_admin')

@section('content')
<div class="container ">
    <div class="card">

        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-6 ">
                    <form action="{{route('siswa-cari')}}" method="GET">
                            <label>
                            <input type="search" name="q"  class="form-control" placeholder="NISN atau Nama">
                            </label>
                            <button type="submit" class="mx-2 btn btn-primary ">
                            <i class="bx bx-search fs-4 lh-0"></i> Cari</button>
                    </form>
                </div>
                @include('admin.tambah-siswa')
                <div class="col-md-6">
                    <div class="text-end mx-2 text-right">
                        <a href="#" class="text-dark btn btn-success  mb-0  px-4 mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambah-siswa">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive py-4">
        <div class="table-wrapper">
              <table class="table table-hover">
                <thead class="sticky-header">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @foreach($data as $key => $dataSiswa)
                <tbody>
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dataSiswa->NISN }}</td>
                        <td>{{ $dataSiswa->nama_siswa }}</td>
                        <td>{{ $dataSiswa->nama_kelas }} ({{ $dataSiswa->bagian }} )</td>
                        <td>{{ $dataSiswa->tahunAjar }}</td>
                        <td>{{ $dataSiswa->semester }}</td>
                        <td>
                            <form action="{{route('delete-siswa', $dataSiswa->id)}}" method="post">@csrf
                            <a href="#" class="text-dark btn btn-info  px-2" type="button" data-bs-toggle="modal" data-bs-target="#profile-siswa{{$dataSiswa->id}}">Profile</a>
                                <a href="#" class="text-dark btn btn-warning  px-2" type="button" data-bs-toggle="modal" data-bs-target="#edit-siswa{{$dataSiswa->id}}">Edit</a>
                                <button class="btn btn-danger px-3"
                                    onClick="return confirm('Yakin Hapus siswa?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @include('admin.edit-siswa')
                    @include('admin.profile-siswa')
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection