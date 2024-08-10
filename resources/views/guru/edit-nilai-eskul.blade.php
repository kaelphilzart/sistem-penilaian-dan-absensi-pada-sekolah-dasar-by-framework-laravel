<div class="modal fade" id="edit-nilai-eskul{{$dataNilaiEskul->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Nilai Estrakulikuler</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{  route('update-nilai-eskul', ['id' => $dataNilaiEskul->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$dataNilaiEskul->id_siswa}}" id="id_siswa" name="id_siswa">
                    <input type="hidden" value="{{ $dataNilaiEskul->id_kelas }}" id="id_kelas" name="id_kelas">
                    <div class="mb-3">
                        <label for="tahun_rombel" class="form-label">Estrakulikuler</label>
                        <input type="text" class="form-control" value="{{$dataNilaiEskul->nama_eskul}}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="predikat" class="form-label" >Predikat</label>
                        <input type="text" class="form-control" id="predikat" name="predikat" value="{{$dataNilaiEskul->predikat}}">
                        @error('predikat')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                    </div>
                    <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea class="form-control"  id="keterangan" name="keterangan" rows="4" placeholder="keterangan">{{$dataNilaiEskul->keterangan}}</textarea>
                            @error('keterangan')
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
