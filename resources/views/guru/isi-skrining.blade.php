<div class="modal fade" id="isi-skrining{{$siswa->id}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$siswa->nama_lengkap}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('isi-skrining')}}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$siswa->id}}" id="id_siswa" name="id_siswa">
                    <input type="hidden" value="{{$siswa->id_kelas}}" id="id_kelas" name="id_kelas">
                    <div class="mb-3">
                    <label for="tinggi_badan" class="form-label">Tinggi Badan</label>
                    <input type="number" step="0.01" class="form-control" id="tinggi_badan" name="tinggi_badan" placeholder="Masukkan Nilai">
                    @error('tinggi_badan')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-3">
                    <label for="berat_badan" class="form-label">Berat Badan</label>
                    <input type="number" step="0.01" class="form-control" id="berat_badan" name="berat_badan" placeholder="Masukkan Nilai">
                    @error('berat_badan')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="pendengaran" class="form-label">Pendengaran</label>
                        <input type="text" class="form-control" id="pendengaran" name="pendengaran">
                        @error('pendengaran')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="penglihatan" class="form-label">Penglihatan</label>
                        <input type="text" class="form-control" id="penglihatan" name="penglihatan">
                        @error('penglihatan')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                    @enderror
                    </div>
                    <div class="mb-3">
                        <label for="gigi" class="form-label">Gigi</label>
                        <input type="text" class="form-control" id="gigi" name="gigi">
                        @error('gigi')
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
