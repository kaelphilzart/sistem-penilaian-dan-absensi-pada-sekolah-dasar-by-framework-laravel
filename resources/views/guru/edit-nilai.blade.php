<div class="modal fade" id="edit-nilai{{$dataNilai->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Nilai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{  route('update-nilai', ['id' => $dataNilai->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$dataNilai->id_siswa}}" id="id_siswa" name="id_siswa">
                    <input type="hidden" value="{{ $dataNilai->mapel->id_kelas }}" id="id_kelas" name="id_kelas">
                    <div class="mb-3">
                        <label for="tahun_rombel" class="form-label">Mata Pelajaran</label>
                        <input type="text" class="form-control" value="{{$dataNilai->nama_mapel}}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_rombel" class="form-label">Jenis Tugas</label>
                        <input type="text" class="form-control" value="{{$dataNilai->nama_tugas}}" disabled>
                    </div>
                    <div class="mb-3">
                    <label for="isi_nilai" class="form-label">Nilai</label>
                    <input type="number" step="0.01" class="form-control" id="isi_nilai" name="isi_nilai" placeholder="Masukkan Nilai" value="{{$dataNilai->isi_nilai}}" >
                    @error('isi_nilai')
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
