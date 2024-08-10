<div class="modal fade" id="edit-guru{{$dataGuru->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Guru</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-guru', ['id' => $dataGuru->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kry" class="form-label">NIP </label>
                        <input type="number" class="form-control" value="{{ $dataGuru->nip }}" min="0" id="nip" name="nip">
                    </div>

                    <!-- Jenis Guru Input -->
                    <div class="mb-3">
                        <label for="jenis_guru" class="form-label">Jenis Guru</label>
                        <select class="form-select" id="jenis_guru" name="jenis_guru" onchange="toggleMapelInput()">
                            <option value="wali_kelas" {{ $dataGuru->jenis_guru == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                            <option value="guru_mapel" {{ $dataGuru->jenis_guru == 'guru_mapel' ? 'selected' : '' }}>Guru Mapel</option>
                        </select>
                        @error('jenis_guru')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $dataGuru->nama_lengkap }}">
                        @error('nama_lengkap')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $dataGuru->tempat_lahir }}">
                        @error('tempat_lahir')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ $dataGuru->tgl_lahir }}">
                        @error('tgl_lahir')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="pria" {{ $dataGuru->jenis_kelamin == 'pria' ? 'selected' : '' }}>Pria</option>
                            <option value="wanita" {{ $dataGuru->jenis_kelamin == 'wanita' ? 'selected' : '' }}>Wanita</option>
                        </select>
                        @error('jenis_kelamin')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="no_tlp" class="form-label">No Telepon</label>
                        <input type="number" class="form-control" id="no_tlp" name="no_tlp" value="{{ $dataGuru->no_tlp }}" min="0">
                        @error('no_tlp')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $dataGuru->alamat }}">
                        @error('alamat')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="golongan" class="form-label">Golongan</label>
                        <select class="form-select" id="golongan" name="golongan">
                            <option value="golongan 1" {{ $dataGuru->golongan == 'golongan 1' ? 'selected' : '' }}>golongan 1</option>
                            <option value="golongan 2" {{ $dataGuru->golongan == 'golongan 2' ? 'selected' : '' }}>golongan 2</option>
                            <option value="golongan 3" {{ $dataGuru->golongan == 'golongan 3' ? 'selected' : '' }}>golongan 3</option>
                            <option value="golongan 4" {{ $dataGuru->golongan == 'golongan 4' ? 'selected' : '' }}>golongan 4</option>
                            <option value="golongan 5" {{ $dataGuru->golongan == 'golongan 5' ? 'selected' : '' }}>golongan 5</option>
                        </select>
                        @error('golongan')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $dataGuru->jabatan }}">
                        @error('jabatan')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- tambahkan input lainnya sesuai kebutuhan -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

