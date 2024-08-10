<div class="modal fade" id="tambah-mapel" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Mata Pelajaran</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('tambah-mapel')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Mapel</label>
                        <input type="text" class="form-control" id="kode" name="kode">
                        @error('kode')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3 input-group">
                    <label for="id_kurikulum" class="form-label">Kurikulum</label>
                        <select class="dropdown-item" id="id_kurikulum" name="id_kurikulum">
                        @foreach($data2 as $data2)
                        <option value="{{ $data2->id }}">{{ $data2->nama_kurikulum }} ({{ $data2->kode_kurikulum }})</option>
                        @endforeach
                        </select>
                        @error('id_kurikulum')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_mapel" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" id="nama_mapel" name="nama_mapel">
                        @error('nama_mapel')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nilai_kkm" class="form-label">Nilai KKM</label>
                        <input type="number" class="form-control" id="nilai_kkm" name="nilai_kkm" step="0.01" min="-100">
                        @error('nilai_kkm')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3 input-group">
                                    <label for="kategori" class="form-label">Kategori</label>
                                        <select class="dropdown-item" id="kategori" name="kategori">
                                        <option value="">pilih kategori</option>
                                        <option value="inti">Mapel inti</option>
                                        <option value="pilihan">Mapel Pilihan</option>
                                        </select>
                                        @error('kategori')
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
