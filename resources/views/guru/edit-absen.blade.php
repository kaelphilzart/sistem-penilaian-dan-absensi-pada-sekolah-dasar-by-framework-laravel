@foreach($data as $siswa)
    @if(isset($absensi[$siswa->id]))
    <div class="modal fade" id="edit-absen{{ $absensi[$siswa->id]->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title text-white">Absen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form action="{{ route('update-absen', ['id' => $absensi[$siswa->id]->id]) }}" method="POST" >
                        @csrf
                        <h3>Status</h3>
                        <div class="d-flex align-items-center mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status" value="hadir" {{ $absensi[$siswa->id]->status == 'hadir' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Hadir</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status" value="alfa" {{ $absensi[$siswa->id]->status == 'alfa' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Alfa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="status" value="izin" {{ $absensi[$siswa->id]->status == 'izin' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Izin</label>
                        </div>
                        </div>
                        <input type="hidden" name="tgl" value="{{ $tanggal }}">
                        <input type="hidden" name="id_kelas" value="{{ $siswa->id_kelas }}">
                        <input type="hidden" name="id_mapel" value="{{ request('id_mapel') }}">
                        <input type="hidden" name="semester" value="{{ request('semester') }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
