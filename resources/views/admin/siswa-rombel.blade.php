
@extends('template.template_admin')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
      
        <h5 class="text-center py-2 bg-dark text-white">Tahun Rombongan Belajar : {{ ($dataRombel->tahun_rombel) }}</h5>
       
        <div class="card-body ">
            <div class="table-responsive">
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Jenis Kelamin</th>           
                    </tr>
            </thead>
            @foreach($data as $key => $dataSiswa)
            <tbody>
            <tr class="">
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $dataSiswa->NISN }}</td>
                        <td>{{ $dataSiswa->nama_siswa }}</td>
                        <td>{{ $dataSiswa->jenis_kelamin }}</td>
                           </tr>
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
  </div>
</section>



@endsection