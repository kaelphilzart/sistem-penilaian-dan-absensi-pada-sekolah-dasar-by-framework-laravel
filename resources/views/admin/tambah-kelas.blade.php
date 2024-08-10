<div class="modal fade" id="tambah-kelas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kelas</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('tambah-kelas')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="nama_kelas" name="nama_kelas">
                        @error('nama_kelas')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                        <label for="bagian" class="form-label">Bagian</label>
                        <input type="text" class="form-control" id="bagian" name="bagian">
                        @error('bagian')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3 input-group">
                    <label for="nip_guru" class="form-label">Nip Guru</label>
                        <select class="dropdown-item" id="nip_guru" name="nip_guru">
                        @foreach($data1 as $data1)
                        <option value="{{ $data1->id }}">{{ $data1->nama_lengkap }}</option>
                        @endforeach
                        </select>
                        @error('nip_guru')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3 input-group">
                    <label for="nip_guru" class="form-label">Tahun Pelajaran</label>
                        <select class="dropdown-item" id="id_tahunAjar" name="id_tahunAjar">
                        @foreach($data2 as $data2)
                        <option value="{{ $data2->id }}">Tahun pelajaran : {{ $data2->tahunAjar }}</option>
                        @endforeach
                        </select>
                        @error('id_tahunAjar')
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
