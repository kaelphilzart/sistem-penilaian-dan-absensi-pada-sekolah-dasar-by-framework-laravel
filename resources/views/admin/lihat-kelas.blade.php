<div class="modal fade" id="lihat-kelas{{$dataKelas->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white">{{ strtoupper($dataKelas->nama_lengkap) }}</h5>
            </div>
            <div class="modal-body">
                @php
                    $kelasArray = json_decode($dataKelas->kelas);
                @endphp

                @if(is_array($kelasArray) || is_object($kelasArray))
                    @foreach($kelasArray as $kelasObj)
                        @php
                            $kelas = App\Models\Kelas::find($kelasObj->id_kelas);
                        @endphp
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p>Kelas - tahun ajar</p>
                            </div>
                            <div class="col-md-6">
                                <p>: {{ $kelas ? $kelas->nama_kelas : 'Tidak ditemukan' }} ({{ $kelas ? $kelas->bagian : 'Tidak ditemukan' }} ) - {{ $kelas ? $kelas->tahunAjar->tahunAjar : 'Tidak ditemukan' }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Tidak ada kelas yang ditemukan.</p>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
