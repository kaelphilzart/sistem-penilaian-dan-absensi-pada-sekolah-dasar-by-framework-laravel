<div class="modal fade" id="edit-rombel{{$dataRombel->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Rombangan Belajar</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-rombel', ['id' => $dataRombel->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tahun_rombel" class="form-label">Tahun Pelajaran</label>
                        <input type="number" class="form-control" id="tahun_rombel" name="tahun_rombel" value="{{$dataRombel->tahun_rombel}}">
                        @error('tahun_rombel')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
