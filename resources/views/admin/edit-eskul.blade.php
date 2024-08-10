<div class="modal fade" id="edit-eskul{{$dataEskul->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Esktrakulikuler</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-estrakulikuler', ['id' => $dataEskul->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_eskul" class="form-label">Nama Eskul</label>
                        <input type="text" class="form-control" id="nama_eskul" name="nama_eskul" value="{{$dataEskul->nama_eskul}}">
                        @error('nama_eskul')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3">
                    <select class="form-control" id="status" name="status">
                        <option value="wajib">Wajib</option>
                        <option value="tidak wajib">Tidak Wajib</option>
                    </select>
                        @error('status')
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
