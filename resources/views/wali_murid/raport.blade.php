@extends('template.template_waliMurid')

@section('content')
<div class="container pb-4 mb-4">
    <div class="card">
        <h5 class="card-header">{{ ucfirst(request()->route()->getName()) }}</h5>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3 mt-4">Pilih Kelas dan Tahun ajar</h4>
                </div>
            </div>
            <form id="raportForm" class="form-inline pb-4">
                <input type="hidden" id="nisn" name="nisn" value="{{ $anak->NISN }}">
                <label for="id_kelas" class="form-label mx-2">Kelas</label>
                <select class="form-control" id="id_kelas" name="id_kelas">
                    <option value="">Pilih Kelas dan tahun ajar</option>
                    @foreach($kelas as $data1)
                        <option value="{{ $data1->id }}" {{ request('id_kelas') == $data1->id ? 'selected' : '' }}>
                            {{ $data1->nama_kelas }} ({{ $data1->bagian }}) | {{ $data1->tahunAjar }}
                        </option>
                    @endforeach
                </select>
                @error('id_kelas')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
                <div class="form-group py-2 mx-4">
            <select class="form-control px-4" id="semester" name="semester">
                <option value="">Pilih Semester</option>
                <option value="1" {{ request('semester') == '1' ? 'selected' : '' }}>Ganjil</option>
                <option value="2" {{ request('semester') == '2' ? 'selected' : '' }}>Genap</option>
              </select>
              @error('semester')
              <p class="text-danger text-xs mt-2">{{ $message }}</p>
              @enderror
          </div>
                <button type="button" id="btnCari" class="btn btn-primary mx-2">Cari</button>
            </form>
        </div>
        <div id="raportContent" class="text-center">
            <iframe id="raportIframe" width="816.68px" height="1248.84px" style="border: none;"></iframe>
            <p id="errorMessage" class="text-danger mt-3" style="display: none;">Raport tidak ada atau salah kelas yang anda pilih.</p>
        </div>
    </div>
</div>

<script>
    document.getElementById('btnCari').addEventListener('click', function () {
        var nisn = document.getElementById('nisn').value;
        var id_kelas = document.getElementById('id_kelas').value;
        var semester = document.getElementById('semester').value;

        if (id_kelas) {
            var iframe = document.getElementById('raportIframe');
            var errorMessage = document.getElementById('errorMessage');

            iframe.onload = function() {
                if (iframe.contentDocument.body.innerText.includes('Raport tidak ada')) {
                    errorMessage.style.display = 'block';
                } else {
                    errorMessage.style.display = 'none';
                }
            };

            iframe.src = `/lihat-raport/${nisn}/${id_kelas}/${semester}`;
        } else {
            alert('Pilih kelas dan tahun ajar terlebih dahulu.');
        }
    });
</script>
@endsection
