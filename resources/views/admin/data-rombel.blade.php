@extends('template.template_admin')

@section('content')
<div class="container ">
    <div class="card">
        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-6">
                    <form action="{{route('rombel-cari')}}" method="GET">
                        <label>
                            <input type="search" name="q" class="form-control" placeholder="masukkan rombel">
                        </label>
                        <button type="submit" class="mx-2 btn btn-primary">
                            <i class="bx bx-search fs-4 lh-0"></i> Cari
                        </button>
                    </form>
                </div>
                @include('admin.tambah-rombel')
                <div class="col-md-6">
                    <div class="text-end mx-2 text-right">
                        <a href="#" class="text-dark btn btn-success mb-0 px-4 mx-2" type="button" data-bs-toggle="modal" data-bs-target="#tambah-rombel">+&nbsp; Tambah</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr class="">
                        <th>No</th>
                        <th>Tahun Rombel</th>
                        <th>Jumlah Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $dataRombel)
                    <tr>
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $dataRombel->tahun_rombel }}</td>
                        <td>{{ $dataRombel->siswa_count }}</td>
                        <td>
                            <form action="{{route('delete-rombel', $dataRombel->id)}}" method="post">
                                @csrf
                                <a href="{{ route('siswa-rombel', $dataRombel->id) }}" class="text-dark btn btn-info  px-4" >Siswa</a>
                                <a href="#" class="text-dark btn btn-warning px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-rombel{{$dataRombel->id}}">Edit</a>
                                <button class="btn btn-danger px-3" onClick="return confirm('Yakin Hapus Rombel?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @include('admin.edit-rombel', ['dataRombel' => $dataRombel])
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
