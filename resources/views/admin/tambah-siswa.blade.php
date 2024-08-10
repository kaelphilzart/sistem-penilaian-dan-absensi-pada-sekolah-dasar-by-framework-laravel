<div class="modal fade" id="tambah-siswa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white">Profil Peserta</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('tambah-siswa')}}" method="POST">
                    @csrf
                    <div class="row">
                    <div class="col-md-6">
                            <div class="mb-3">
                                <label for="NISN" class="form-label">NISN</label>
                                <input type="text" class="form-control" id="NISN" name="NISN" pattern="\d*" title="Masukkan hanya angka.">
                                @error('NISN')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 input-group">
                    <label for="id_kelas" class="form-label">Kelas</label>
                        <select class="dropdown-item" id="id_kelas" name="id_kelas">
                        @foreach($data1 as $data1)
                        <option value="{{ $data1->id_kelas }}">{{ $data1->nama_kelas }} ({{ $data1->bagian }}) | {{ $data1->tahunAjar }} | {{ $data1->semester }}</option>
                        @endforeach
                        </select>
                        @error('id_kelas')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="form-group">
                                <label for="date">Tanggal Lahir:</label>
                                <div class="input-group date" id="tgl_lahir">
                                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" >
                                </div>
                                @error('tgl_lahir')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                    <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                                    <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah">
                                    @error('asal_sekolah')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                                </div>
                                <div class="mb-3 ">
                                    <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                    <input type="text" class="form-control" id="nama_ayah" name="nama_ayah">
                                    @error('nama_ayah')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                                </div>
                              
                                <div class="mb-3">
                                    <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu">
                                    @error('nama_ibu')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                                </div>
                               
                                <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                            <textarea class="form-control"  id="alamat" name="alamat" rows="4"></textarea>
                                            @error('alamat')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                    </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                            <label for="nama_siswa" class="form-label">Nama Siswa</label>
                            <input type="text" class="form-control" id="nama_siswa" name="nama_siswa">
                            @error('nama_siswa')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                        </div>
                        <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                @error('email')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                            @error('tempat_lahir')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                        </div>
                        <div class="mb-3 input-group">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="dropdown-item" id="jenis_kelamin" name="jenis_kelamin">
                                    <option value="laki - laki">Laki - laki</option>
                                    <option value="perempuan">Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah">
                                    @error('pekerjaan_ayah')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu">
                                    @error('pekerjaan_ibu')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                                </div>
                                <div class="mb-3">
                                <label for="no_telp" class="form-label">No Hp</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp" pattern="\d*" title="Masukkan hanya angka.">
                                @error('no_telp')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 input-group">
                                    <label for="id_rombel" class="form-label">Rombongan Belajar</label>
                                        <select class="dropdown-item" id="id_rombel" name="id_rombel">
                                        @foreach($data2 as $data2)
                                        <option value="{{ $data2->id }}">{{ $data2->tahun_rombel }}</option>
                                        @endforeach
                                        </select>
                                        @error('id_rombel')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                                    </div>

                        </div>
                           
                    </div>
                    
                    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
