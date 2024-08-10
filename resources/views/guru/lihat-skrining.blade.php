<div class="modal fade" id="lihat-skrining{{ $siswa->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white">Data Skrining</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <h3 class="text-dark" style="font-weight: bold">{{ strtoupper($siswa->nama_siswa) }}</h3>
                        <h5>Status Siswa: {{ $siswa->status }}</h5>
                    </div>
                    @php
                        $skrining = \App\Models\Skrining::where('id_kelas', $siswa->id_kelas)
                                                        ->where('id_siswa', $siswa->id)->first();
                    @endphp
                    @if ($skrining)
                        <div class="col-md-4 text-end text-dark">
                            <p>Tinggi Badan</p>
                            <p>Berat Badan</p>
                            <p>Pendengaran</p>
                            <p>Penglihatan</p>
                            <p>Gigi</p>
                        </div>
                        <div class="col-md-4 text-start">
                            <p>{{ $skrining->tinggi_badan }}</p>
                            <p>{{ $skrining->berat_badan }}</p>
                            <p>{{ $skrining->pendengaran }}</p>
                            <p>{{ $skrining->penglihatan }}</p>
                            <p>{{ $skrining->gigi }}</p>
                        </div>
                    @else
                        <div class="col-md-12 text-center">
                            <p>Belum Diisi Skriningnya</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
