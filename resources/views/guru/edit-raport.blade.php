<div class="modal fade" id="edit-raport{{$dataRaport->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Capaian Kompetensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{  route('update-raport', ['id' => $dataRaport->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$dataRaport->id_siswa}}" id="id_siswa" name="id_siswa">
                    <input type="hidden" value="{{ $dataRaport->mapel->id_kelas }}" id="id_kelas" name="id_kelas">
                    <div class="mb-3">
                        <label for="tahun_rombel" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" value="{{$dataRaport->nama_mapel}}" disabled>
                    </div>
                    <div class="mb-3">
                    <textarea class="form-control" id="kompetensi" name="kompetensi" rows="4" placeholder="Capaian Kompetensi">{{$dataRaport->kompetensi}}</textarea>
                    @error('kompetensi')
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
