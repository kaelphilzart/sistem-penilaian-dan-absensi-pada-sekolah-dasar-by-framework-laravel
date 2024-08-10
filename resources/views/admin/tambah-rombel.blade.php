<div class="modal fade" id="tambah-rombel" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rombongan Belajar</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('tambah-rombel')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tahun_rombel" class="form-label">Rombongan Belajar</label>
                        <input type="text" class="form-control" id="tahun_rombel" name="tahun_rombel">
                        @error('tahun_rombel')
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
