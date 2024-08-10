<div class="modal fade" id="profile-siswa{{$dataSiswa->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white">Profil Siswa</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- <div class="col-md-4">
                        <img src="{{ $dataSiswa->foto }}" class="img-fluid rounded-circle mx-auto d-block" alt="Foto Profil">
                    </div> -->
                    <div class="col-md-4"> <h3 class="text-dark " style="font-weight: bold">{{ strtoupper($dataSiswa->nama_siswa) }}</h3>
                    <h5>Status : <span>{{$dataSiswa->status}}</span></h5>
                </div>
                        
                    <div class="col-md-4 text-end text-dark">
                    <p>NISN</p>
                    <p>Kelas</p>
                    <p>Rombongan Belajar</p>
                    <p>Tempat Lahir</p>
                    <p>Tanggal Lahir</p>
                    <p>Jenis Kelamin</p>
                    <p>Asal Sekolah</p>
                    <p>Nama Ayah</p>
                    <p>Pekerjaan Ayah</p>
                    <p>Nama Ibu</p>
                    <p>Pekerjaan Ibu</p>
                    <p>No Hp</p>
                    <p>Alamat</p>
                    <p>Tahun Masuk</p>

                    </div>
                    <div class="col-md-4 text-start">
                    <p>{{ $dataSiswa->NISN }}</p>
                    <p>{{ $dataSiswa->nama_kelas }}</p>
                    <p>{{ $dataSiswa->tahun_rombel }}</p>
                    <p>{{ $dataSiswa->tempat_lahir }}</p>
                    <p >{{ $dataSiswa->tgl_lahir }}</p>
                    <p>{{ $dataSiswa->jenis_kelamin }}</p>
                    <p>{{ $dataSiswa->asal_sekolah }}</p>
                    <p>{{ $dataSiswa->nama_ayah }}</p>
                    <p>{{ $dataSiswa->pekerjaan_ayah }}</p>
                    <p>{{ $dataSiswa->nama_ibu }}</p>
                    <p>{{ $dataSiswa->pekerjaan_ibu }}</p>
                    <p>{{ $dataSiswa->no_telp }}</p>
                    <p>{{ $dataSiswa->alamat }}</p>
                    <p>{{ $dataSiswa->created_at->format('d-m-Y') }}</p>

                    </div>
                    
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
