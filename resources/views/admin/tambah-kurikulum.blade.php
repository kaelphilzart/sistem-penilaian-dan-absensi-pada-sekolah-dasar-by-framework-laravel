<div class="modal fade" id="tambah-kurikulum" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kurikulum</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('tambah-kurikulum')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_kurikulum" class="form-label">Kode Kurikulum</label>
                        <input type="text" class="form-control" id="kode_kurikulum" name="kode_kurikulum">
                        @error('kode_kurikulum')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_kurikulum" class="form-label">Nama Kurikulum</label>
                        <input type="text" class="form-control" id="nama_kurikulum" name="nama_kurikulum">
                        @error('nama_kurikulum')
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
