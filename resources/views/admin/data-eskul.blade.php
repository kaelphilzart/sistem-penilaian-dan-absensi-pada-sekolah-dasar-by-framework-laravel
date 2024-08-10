@extends('template.template_admin')

@section('content')
<div class="container ">
    <div class="card">

        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-6 ">
                    <form action="{{route('eskul-cari')}}" method="GET">
                            <label>
                            <input type="search" name="q"  class="form-control" placeholder="nama Estrakulikuler ">
                            </label>
                            <button type="submit" class="mx-2 btn btn-primary ">
                            <i class="bx bx-search fs-4 lh-0"></i> Cari</button>
                    </form>
                </div>
                @include('admin.tambah-eskul')
                <div class="col-md-6">
                    <div class="text-end mx-2 text-right">
                        <a href="#" class="text-dark btn btn-success  mb-0  px-4 mx-2" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambah-eskul">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Eskul</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                @foreach($data as $key => $dataEskul)
                <tbody>
                    <tr>
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $dataEskul->nama_eskul }}</td>
                        <td>{{ $dataEskul->status }}</td>
                        <td>
                            <form action="{{route('delete-eskul', $dataEskul->id)}}" method="post">@csrf
                                <a href="#" class="text-dark btn btn-warning  px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-eskul{{$dataEskul->id}}">Edit</a>
                                <button class="btn btn-danger px-3"
                                    onClick="return confirm('Yakin Hapus Eskul?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @include('admin.edit-eskul')
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