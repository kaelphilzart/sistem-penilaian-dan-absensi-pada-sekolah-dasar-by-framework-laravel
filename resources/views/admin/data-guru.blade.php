@extends('template.template_admin')

@section('content')
<div class="container">
    <div class="card">
        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row mt-2 mb-2">
                <div class="col-md-6">
                    <form action="{{ route('guru-cari') }}" method="GET">
                        <label>
                            <input type="search" name="q" class="form-control" placeholder="Search">
                        </label>
                        <button type="submit" class="mx-2 btn btn-primary">
                            <i class="bx bx-search fs-4 lh-0"></i> Cari
                        </button>
                    </form>
                </div>
                @include('admin.tambah-guru')
                <div class="col-md-6">
                    <div class="text-end mx-2 text-right">
                        <a href="#" class="text-dark btn btn-success mb-0 px-4 mx-2" type="button" 
                            data-bs-toggle="modal" data-bs-target="#tambah-guru">+&nbsp; Tambah</a>
                    </div> 
                </div>
            </div>
        </div>
        <div class="table-responsive py-4">
            <div class="table-wrapper">
                <table class="table table-hover">
                    <thead class="sticky-header">
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 10%;">NIP</th>
                            <th style="width: 15%;">Nama</th>
                            <th style="width: 5%;">Jabatan</th>
                            <th style="width: 5%;">Jenis</th>
                            <th style="width: 20%;">Masa Kerja</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 30%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $dataGuru)
                        <tr>
                            <td style="width: 5%;">{{ $loop->iteration }}</td>
                            <td style="width: 10%;">{{ $dataGuru->nip }}</td>
                            <td style="width: 15%;">{{ $dataGuru->nama_lengkap }}</td>
                            <td style="width: 5%;">{{ $dataGuru->jabatan }}</td>
                            <td style="width: 5%;">{{ $dataGuru->jenis_guru }}</td>
                            <td style="width: 20%;">
                                @if($dataGuru->status == 'aktif')
                                {{ $dataGuru->created_at->format('Y-m-d') }} sampai sekarang
                                @else
                                {{ $dataGuru->created_at->format('Y-m-d') }} sampai {{ $dataGuru->updated_at->format('Y-m-d') }}
                                @endif
                            </td>
                            <td style="width: 10%;">{{ $dataGuru->status }}</td>
                            <td style="width: 30%;">
                                <form action="{{ route('delete-guru', $dataGuru->id) }}" method="post">
                                    @csrf
                                    <a href="#" class="text-dark btn btn-info px-2" type="button" data-bs-toggle="modal" data-bs-target="#detail-guru{{ $dataGuru->id }}">Detail</a>
                                    <a href="#" class="text-dark btn btn-warning px-4" type="button" data-bs-toggle="modal" data-bs-target="#edit-guru{{ $dataGuru->id }}">Edit</a>
                                    <button class="btn btn-danger px-3" onClick="return confirm('Yakin Hapus Guru?')">Delete</button>
                                </form>
                                <form action="{{ route('nonaktifkan', $dataGuru->id) }}" method="post" class="mt-2">
                                    @csrf
                                    <button class="btn btn-primary px-3 d-flex" onClick="return confirm('Yakin untuk menonaktifkan')">nonaktifkan</button>
                                </form>
                            </td>
                        </tr>
                        @include('admin.edit-guru')
                        @include('admin.detail-guru')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
