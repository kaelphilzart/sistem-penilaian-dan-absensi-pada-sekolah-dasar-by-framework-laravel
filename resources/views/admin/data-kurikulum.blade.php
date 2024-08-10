@extends('template.template_admin')

@section('content')
<div class="container ">
    <div class="card">
        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-6">
                    <form action="{{route('kurikulum-cari')}}" method="GET">
                        <label>
                            <input type="search" name="q" class="form-control" placeholder="Search">
                        </label>
                        <button type="submit" class="mx-2 btn btn-primary">
                            <i class="bx bx-search fs-4 lh-0"></i> Cari
                        </button>
                    </form>
                </div>
                @include('admin.tambah-kurikulum')
                <div class="col-md-6">
                    <div class="text-end mx-2 text-right">
                        <a href="#" class="text-dark btn btn-success mb-0 px-4 mx-2" type="button" data-bs-toggle="modal" data-bs-target="#tambah-kurikulum">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr class="">
                        <th>No</th>
                        <th>Kode Kurikulum</th>
                        <th>Nama Kurikulum</th>
                        <th>Jumlah Mapel</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $dataKurikulum)
                    <tr>
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $dataKurikulum->kode_kurikulum }}</td>
                        <td>{{ $dataKurikulum->nama_kurikulum }}</td>
                        <td>{{ $dataKurikulum->mapel_count }}</td>
                        <td>
                            <form action="{{route('delete-kurikulum', $dataKurikulum->id)}}" method="post">
                                @csrf
                                <a href="{{ route('mapel-kurikulum', $dataKurikulum->id) }}" class="text-dark btn btn-info  px-4" >Mapel</a>
                                <a href="#" class="text-dark btn btn-warning px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-kurikulum{{$dataKurikulum->id}}">Edit</a>
                                <button class="btn btn-danger px-3" onClick="return confirm('Yakin Hapus Kurikulum?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @include('admin.edit-kurikulum', ['dataKurikulum' => $dataKurikulum])
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
