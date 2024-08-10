<div class="modal fade" id="detail-guru{{$dataGuru->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white">{{ strtoupper($dataGuru->nama_lengkap) }}</h5>
            </div>
            <div class="modal-body">
                <div class="container">
              <div class="row">
                <div class="col-md-4 col-sm-4">
                <p>Nip</p>
                <p>Tempat Lahir</p>
                <p>Tanggal Lahir</p>
                <p>Jenis Kelamin</p>
                <p>No Hp</p>
                <p>Alamat</p>
                <p>Golongan</p>
                <p>Jabatan</p>
                <p>Status</p>
                <p>Masa Kerja</p>
                </div>
                <div class="col-md-4 ">
                <p>{{$dataGuru->nip}}</p>
                <p>{{$dataGuru->tempat_lahir}}</p>
                <p>{{$dataGuru->tgl_lahir}}</p>
                <p>{{$dataGuru->jenis_kelamin}}</p>
                <p>{{$dataGuru->no_tlp}}</p>
                <p>{{$dataGuru->alamat}}</p>
                <p>{{$dataGuru->golongan}}</p>
                <p>{{$dataGuru->jabatan}}</p>
                <p>{{$dataGuru->status}}</p>
                <p>
                    @if($dataGuru->status == 'aktif')
                    {{ $dataGuru->created_at->format('Y-m-d') }} sampai saat ini
                    @else
                    {{ $dataGuru->created_at->format('Y-m-d') }} sampai {{ $dataGuru->updated_at->format('Y-m-d') }}
                    @endif
                </p>
                </div>
                <div class="col-md-4">
                <p>Jenis Guru : {{$dataGuru->jenis_guru}}</p>
                @if($dataGuru->jenis_guru == 'guru_mapel')
                <p>Mapel : {{$dataGuru->kode_mapel}}</p>
                @else
                <p>Mapel : Tidak Ada</p>
                @endif
                </div>
              </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
