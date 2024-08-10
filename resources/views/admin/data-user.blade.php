@extends('template.template_admin')

@section('content')
<div class="container shadow-md">
<div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                    <h4 class="card-title">{{ ucfirst(request()->route()->getName()) }}</h4>
                    </div>
                    <div class="col-md-6">
                    <div class="text-end mx-2 text-right">
                    @include('admin.tambah-user')
                        <a href="#" class="text-dark btn btn-success" type="button"
                            data-bs-toggle="modal" data-bs-target="#tambahUser">+&nbsp; Tambah</a>
                    </div>
                    </div>
                    <div class="col-md-6 ">
                    <p class="card-description">
                    Sistem Informasi <code>.raport</code>
                  </p>
                    </div>
                    <div class="col-md-6 text-right pt-2">
                    <form action="{{route('user-cari')}}" method="GET">
                            <label>
                            <input type="search" name="q"  class="form-control" placeholder="Search ">
                            </label>
                            <button type="submit" class="mx-2  btn btn-warning ">
                            <i class="bx bx-search fs-4 lh-0  mx-3 text-center"></i> Cari</button>
                    </form>
                    </div>
                  </div>
                  <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Level</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      @foreach($data as $key => $dataUser)
                      <tbody>
                        <tr>
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $dataUser->name }}</td>
                        <td>{{ $dataUser->email }}</td>
                        <td>{{ $dataUser->nama }}</td>
                        <td>
                            <form action="{{route('delete-user', $dataUser->id)}}" method="post">@csrf
                                <a href="#" class="text-dark btn btn-success  px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-user{{$dataUser->id}}">Edit</a>
                                <button class="btn btn-danger px-3"
                                    onClick="return confirm('Yakin Hapus User?')">Delete</button>
                            </form>
                        </td>
                        </tr>
                        @include('admin.edit-user')
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
              </div>
@endsection