<div class="modal fade" id="tambah-guru" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Guru</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('tambah-guru')}}" method="POST">
                    @csrf
                    <!-- NIP Input -->
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP </label>
                        <input type="number" class="form-control" min="0" id="nip" name="nip">
                    </div>
                    
                    <!-- Email Input -->
                    <div class="mb-3 input-group">
                        <label for="id_user" class="form-label">Email</label>
                        <select class="dropdown-item" id="id_user" name="id_user">
                            @foreach($data1 as $data)
                                <option value="{{ $data->id }}">{{ $data->email }}</option>
                            @endforeach
                        </select>
                        @error('id_user')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Jenis Guru Input -->
                    <div class="mb-3 input-group">
                        <label for="jenis_guru" class="form-label">Jenis Guru</label>
                        <select class="dropdown-item" id="jenis_guru" name="jenis_guru" onchange="toggleMapelInput()">
                            <option value="wali_kelas">Wali Kelas</option>
                            <option value="guru_mapel">Guru Mapel</option>
                        </select>
                        @error('jenis_guru')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                        @error('nama_lengkap')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Tempat Lahir Input -->
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                        @error('tempat_lahir')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Tanggal Lahir Input -->
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                        @error('tgl_lahir')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Jenis Kelamin Input -->
                    <div class="mb-3 input-group">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="dropdown-item" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="pria">Pria</option>
                            <option value="wanita">Wanita</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- No HP Input -->
                    <div class="mb-3">
                        <label for="no_tlp" class="form-label">No Hp</label>
                        <input type="text" class="form-control" id="no_tlp" name="no_tlp" pattern="\d*" title="Masukkan hanya angka.">
                        @error('no_tlp')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Alamat Input -->
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                        @error('alamat')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Golongan Input -->
                    <div class="mb-3 input-group">
                        <label for="golongan" class="form-label">Golongan</label>
                        <select class="dropdown-item" id="golongan" name="golongan">
                            <option value="golongan 1">Golongan 1</option>
                            <option value="golongan 2">Golongan 2</option>
                            <option value="golongan 3">Golongan 3</option>
                            <option value="golongan 4">Golongan 4</option>
                            <option value="golongan 5">Golongan 5</option>
                        </select>
                        @error('golongan')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Status Input -->
                    <div class="mb-3 input-group">
                        <label for="status" class="form-label">Status</label>
                        <select class="dropdown-item" id="status" name="status">
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                        </select>
                        @error('status')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Jabatan Input -->
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="guru">
                        @error('jabatan')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
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


