<div class="modal fade" id="tambah-guruMapel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white">Tambah Guru Mapel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('tambah-guruMapel') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id" class="form-label">Calon Guru</label>
                        <select class="form-select" id="id" name="id">
                            @foreach($daftarGuru as $data2)
                                <option value="{{ $data2->id }}">{{ $data2->nama_lengkap }}</option>
                            @endforeach
                        </select>
                        @error('id')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kode_mapel" class="form-label">Mata Pelajaran</label>
                        <select class="form-select" id="kode_mapel" name="kode_mapel">
                            @foreach($mapel as $data2)
                                <option value="{{ $data2->kode }}">{{ $data2->nama_mapel }}</option>
                            @endforeach
                        </select>
                        @error('kode_mapel')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <div class="p-3 border" id="kelas-container" style="max-height: 200px; overflow-y: auto;">
                            <!-- Kelas akan diisi melalui AJAX -->
                        </div>
                        @error('kelas')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('kode_mapel').addEventListener('change', function() {
    let kodeMapel = this.value;
    if (kodeMapel) {
        fetch(`/get-available-classes/${kodeMapel}`)
            .then(response => response.json())
            .then(data => {
                let kelasContainer = document.getElementById('kelas-container');
                kelasContainer.innerHTML = '';
                data.forEach(kelas => {
                    let div = document.createElement('div');
                    div.className = 'form-check mx-2 ml-2';
                    let input = document.createElement('input');
                    input.className = 'form-check-input';
                    input.type = 'checkbox';
                    input.id = `kelas${kelas.id}`;
                    input.name = 'kelas[]';
                    input.value = kelas.id;
                    let label = document.createElement('label');
                    label.className = 'form-check-label';
                    label.htmlFor = `kelas${kelas.id}`;
                    label.textContent = `${kelas.nama_kelas} (${kelas.bagian}) - ${kelas.tahun_ajar.tahunAjar}`;
                    div.appendChild(input);
                    div.appendChild(label);
                    kelasContainer.appendChild(div);
                });
            })
            .catch(error => console.error('Error:', error));
    }
});
</script>
