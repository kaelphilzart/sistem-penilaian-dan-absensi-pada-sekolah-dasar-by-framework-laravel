
@extends('template.template_admin')

@section('content')
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
      <div class="row p-2">
        <div class="col-md-6">
        <h5 class="py-2 ">Kurikulum : {{ ($dataKurikulum->nama_kurikulum) }}</h5>
        </div>
        <div class="col-md-6">
        <h5 class="py-2 text-end">Kode : {{ ($dataKurikulum->kode_kurikulum) }}</h5>
        </div>
        </div>
        <div class="card-body ">
            <div class="table-responsive">
          <table class="table table-hover">
            <thead>
            <tr class="">
                        <th>No</th>
                        <th>Mata Pelajaran</th>
                        <th>Nilai KKM</th>
                        <th>Kategori</th>           
                    </tr>
            </thead>
            @foreach($data as $key => $dataMapel)
            <tbody>
            <tr class="">
                        <td>{{ $data->firstItem() + $key }}</td>
                        <td>{{ $dataMapel->nama_mapel }}</td>
                        <td>{{ $dataMapel->nilai_kkm }}</td>
                        <td>{{ $dataMapel->kategori }}</td>
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