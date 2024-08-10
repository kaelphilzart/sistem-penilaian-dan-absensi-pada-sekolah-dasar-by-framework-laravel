<div class="modal fade" id="edit-skrining{{ $id_skrining }}" tabindex="-1" aria-labelledby="editSkriningLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSkriningLabel">Edit Skrining</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Edit Skrining -->
                <form action="{{ route('update-skrining', ['id' => $id_skrining]) }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$siswa->id}}" id="id_siswa" name="id_siswa" value="{{ $siswa->siswa_id }}">
                    <input type="hidden" value="{{$siswa->id_kelas}}" id="id_kelas" name="id_kelas" value="{{ $siswa->kelas_id }}">
                    <div class="mb-3">
                    <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
                    <input type="number" step="0.01" class="form-control" id="tinggi_badan" name="tinggi_badan" value="{{ $siswa->tinggi_badan }}" placeholder="Masukkan Nilai">
                    @error('tinggi_badan')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-3">
                    <label for="berat_badan" class="form-label">Berat Badan</label>
                    <input type="number" step="0.01" class="form-control" id="berat_badan" name="berat_badan" value="{{ $siswa->berat_badan }}" placeholder="Masukkan Nilai">
                    @error('berat_badan')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="pendengaran" class="form-label">Pendengaran</label>
                        <input type="text" class="form-control" id="pendengaran" name="pendengaran" value="{{ $siswa->pendengaran }}">
                        @error('pendengaran')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="penglihatan" class="form-label">Penglihatan</label>
                        <input type="text" class="form-control" id="penglihatan" name="penglihatan" value="{{ $siswa->penglihatan }}">
                        @error('penglihatan')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gigi" class="form-label">Gigi</label>
                        <input type="text" class="form-control" id="gigi" name="gigi" value="{{ $siswa->gigi }}">
                        @error('gigi')
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
