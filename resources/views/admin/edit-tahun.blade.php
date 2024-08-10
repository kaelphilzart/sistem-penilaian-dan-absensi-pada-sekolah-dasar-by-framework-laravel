<div class="modal fade" id="edit-tahun{{$dataTahun->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tahun Pelajaran</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('update-tahun', ['id' => $dataTahun->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="tahunAjar" class="form-label">Tahun Pelajaran</label>
                        <input type="text" class="form-control" id="tahunAjar" name="tahunAjar" value="{{$dataTahun->tahunAjar}}">
                        @error('tahunAjar')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                    </div>
                    <div class="mb-3 input-group">
                    <label for="semester" class="form-label">Semester</label>
                        <select class="dropdown-item" id="semester" name="semester" value="{{$dataTahun->semester}}">
                        <option value="ganjil">Ganjil</option>
                        <option value="genap">Genap</option>
                        </select>
                        @error('semester')
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
