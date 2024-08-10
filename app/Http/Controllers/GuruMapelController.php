<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Guru;
use App\Models\TahunAjar;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Absen;
use App\Models\Rombel;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\EskulSiswa;
use App\Models\Eskul;
use App\Models\Raport;
use App\Models\Skrining;
use Illuminate\Support\Facades\DB;
use PDF; 
use Excel;
use App\Imports\NilaiSiswaImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use ConsoleTVs\Charts\Facades\Charts;
use App\Exports\MapelTemplateExportMapel;

class GuruMapelController extends Controller
{
    //
    public function dashboard()
    {
        $jumlahSiswaAktif = Siswa::where('status', 'aktif')->count();
        $jumlahGuruAktif = Guru::where('status', 'aktif')->count();
        $jumlahSiswa = Siswa::where('status', 'tidak aktif')->count();
        $jumlahGuru = Guru::where('status', 'tidak aktif')->count();
    
        // Mengambil nilai rata-rata per tahun
        $nilaiPerTahun = Nilai::selectRaw('YEAR(created_at) as tahun, 
                            AVG((tugas_1 + tugas_2 + uts + tugas_3 + tugas_4 + uas) / 6) as rata_rata')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();
    
        // Mengambil jumlah siswa masuk per tahun
        $siswaMasukPertahun = Siswa::selectRaw('YEAR(created_at) as tahun, COUNT(*) as jumlah')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();
    
        // Menyiapkan array untuk tahun
        $tahunArray = $nilaiPerTahun->pluck('tahun')->toArray();
    
        // Mengisi array dengan tahun dari siswa masuk
        foreach ($siswaMasukPertahun as $siswa) {
            if (!in_array($siswa->tahun, $tahunArray)) {
                $tahunArray[] = $siswa->tahun;
            }
        }
    
        // Urutkan array tahun
        sort($tahunArray);
    
        // Menyiapkan data untuk ditampilkan di chart
        $labels = array_map('strval', $tahunArray);
        $values = [];
        $siswaValues = [];
    
        foreach ($tahunArray as $tahun) {
            $nilaiTahun = $nilaiPerTahun->firstWhere('tahun', $tahun);
            $values[] = $nilaiTahun ? $nilaiTahun->rata_rata : 0;
    
            $siswaTahun = $siswaMasukPertahun->firstWhere('tahun', $tahun);
            $siswaValues[] = $siswaTahun ? $siswaTahun->jumlah : 0;
        }
    
        return view('guru.guru_mapel.dashboard', compact('jumlahSiswaAktif', 'jumlahGuruAktif', 'jumlahSiswa', 'jumlahGuru', 'labels', 'values', 'siswaValues'));
    }

//menu siswa
    public function dataSiswa(Request $request)
    {
        $guru = auth()->user()->guru;
        $kelas_ids = collect(json_decode($guru->kelas, true))->pluck('id_kelas');

        // Ambil data kelas berdasarkan id yang ada di guru.kelas
        $kelas = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
            ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
            ->whereIn('kelas.id', $kelas_ids)
            ->get();

        $data = collect(); // Kosongkan data siswa saat pertama kali membuka halaman
        $id_kelas = $request->id_kelas;

        // Jika ada pencarian
        if ($request->has('id_kelas')) {
            $data = Siswa::where('id_kelas', $id_kelas)->get();
        }

        return view('guru.guru_mapel.data-siswa', compact('data', 'kelas'));
    }

    public function searchSiswa(Request $request)
    {
        return redirect()->route('data-siswa-guru-mapel', [
            'id_kelas' => $request->id_kelas,
        ]);
    }

//menu absen
    public function dataAbsen(Request $request)
    {
        $guru = auth()->user()->guru;
        $kelas_ids = collect(json_decode($guru->kelas, true))->pluck('id_kelas');

        // Ambil data kelas berdasarkan id yang ada di guru.kelas
        $kelas = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
            ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
            ->whereIn('kelas.id', $kelas_ids)
            ->get();

        $mapel = Mapel::all();
        $data = collect();
        $absensi = collect();
        $tanggal = null;

        $id_kelas = $request->id_kelas;
        $kode_mapel = auth()->user()->guru->kode_mapel;
        $id_mapel = Mapel::where('kode', $kode_mapel)->value('id');

        // Check if search parameters are present
        if ($request->has(['id_kelas', 'tgl', 'semester']) && $id_mapel) {
            $data = Siswa::where('id_kelas', $request->id_kelas)->get();
            $tanggal = $request->tgl;
            $semester = $request->semester;

            // Fetch absensi data based on the search parameters
            $absensi = Absen::whereDate('tgl', $tanggal)
                ->where('id_mapel', $id_mapel)
                ->where('semester', $semester)
                ->whereIn('id_siswa', $data->pluck('id'))
                ->get()->keyBy('id_siswa');
        }

        return view('guru.guru_mapel.data-absen', compact('data', 'kelas', 'mapel', 'absensi', 'tanggal', 'id_kelas', 'id_mapel'));
    }

public function searchAbsen(Request $request)
{
    $kode_mapel = auth()->user()->guru->kode_mapel;
    $id_mapel = Mapel::where('kode', $kode_mapel)->value('id');

    return redirect()->route('absen-guru-mapel', [
        'semester' => $request->semester,
        'id_kelas' => $request->id_kelas,
        'tgl' => $request->tgl,
        'id_mapel' => $id_mapel,
    ]);
}


    public function getMapelKelas($id_kelas)
    {
        $user = Auth::user(); // Mendapatkan model User yang sedang login
        $kode_mapel = $user->guru->kode_mapel; // Mengakses kode_mapel melalui relasi guru
        $mapel = Mapel::where('id_kelas', $id_kelas)
                        ->where('kategori', 'pilihan')
                        ->where('kode', $kode_mapel)
                        ->get();
        return response()->json($mapel);
    }

    public function inputAbsen(Request $request){
    
        
        $userId = Auth::id();
        
        // Mengambil id_guru dari relasi Guru dengan User
        $guruId = Guru::where('id_user', $userId)->value('id');

        $data = new Absen;
        $data->id_siswa = $request->id_siswa;
        $data->id_pengabsen = $guruId;
        $data->id_mapel = $request->id_mapel;
        $data->semester = $request->semester;
        $data->tgl = $request->tgl;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('absen-guru-mapel', [
            'id_kelas' => $request->id_kelas,
            'tgl' => $request->tgl,
            'semester' => $request->semester,
            'id_mapel' => $request->id_mapel, // Tambahkan parameter id_mapel
        ])->with('success', 'Absen berhasil dilakukan.');
    }

    public function updateAbsen(Request $request, $id){

        $data = Absen::find($id);
        $data->status = $request->status;
        $data->update();
        return redirect()->route('absen-guru-mapel', [
            'id_kelas' => $request->id_kelas,
            'tgl' => $request->tgl,
            'id_mapel' => $request->id_mapel,
            'semester' => $request->semester, // Tambahkan parameter id_mapel
        ])->with('success', 'Absen berhasil diperbarui.');
    }

//isi nilai
    public function isiNilai(Request $request)
    {
        $guru = auth()->user()->guru;
        $kelas_ids = collect(json_decode($guru->kelas, true))->pluck('id_kelas');

        // Ambil data kelas berdasarkan id yang ada di guru.kelas
        $kelas = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
            ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
            ->whereIn('kelas.id', $kelas_ids)
            ->get();

        $data = collect(); // Kosongkan data siswa saat pertama kali membuka halaman
        $id_kelas = $request->id_kelas;
        $semester = $request->semester;

        // Jika ada pencarian
        if ($request->has('id_kelas')) {
            $data = Siswa::where('id_kelas', $id_kelas)->get();
        }

        return view('guru.guru_mapel.isi-nilai', compact('data', 'kelas'));
    }

    public function searchIsiNilai(Request $request)
    {
        return redirect()->route('isi-nilai-guru-mapel', [
            'id_kelas' => $request->id_kelas,
            'semester' => $request->semester,
        ]);
    }


    public function importNilai(Request $request)
    {
        $kode_mapel = auth()->user()->guru->kode_mapel;
    
        // Check if the combination of id_kelas, semester, and kode_mapel already exists in the Nilai table
        $existingRecords = Nilai::where('id_kelas', $request->id_kelas)
                                ->where('semester', $request->semester)
                                ->where('kode_mapel', $kode_mapel)
                                ->exists();
        
        if ($existingRecords) {
            // Delete existing records for the given id_kelas, semester, and kode_mapel
            Nilai::where('id_kelas', $request->id_kelas)
                 ->where('semester', $request->semester)
                 ->where('kode_mapel', $kode_mapel)
                 ->delete();
        }
        
        // Proceed with the import
        $import = new NilaiSiswaImport($request->id_kelas, $request->semester, $kode_mapel);
        Excel::import($import, $request->file('excel_file'));
    
        return redirect()->back()->with('success', 'Data nilai berhasil diimpor.');
    }
    

    public function dataNilai($nisn, $id_kelas, $semester)
    {
        $kelas = Kelas::find($id_kelas);
        $siswa = Siswa::where('NISN', $nisn)->first();
    
        $nilai = Nilai::where('nilai.nisn', $nisn)
                        ->where('nilai.id_kelas', $id_kelas)
                        ->where('nilai.semester', $semester)
                        ->join('mapel', 'nilai.kode_mapel', '=', 'mapel.kode')
                        ->select('nilai.*', 'mapel.nama_mapel')
                        ->get();

         foreach ($nilai as $dataNilai) {
        $dataNilai->rata_rata = (
            $dataNilai->tugas_1 +
            $dataNilai->tugas_2 +
            $dataNilai->tugas_3 +
            $dataNilai->tugas_4 +
            $dataNilai->uts +
            $dataNilai->uas
        ) / 6;
    }
    
        return view('guru.guru_mapel.data-nilai', compact('kelas', 'nilai', 'siswa', 'semester'));
    }

    public function downloadTemplate($id_kelas)
    {
        $kodeMapel = auth()->user()->guru->kode_mapel;

        $siswa = Siswa::where('id_kelas', $id_kelas)->get(); // Ambil data siswa berdasarkan ID user
        $mapel = Mapel::where('kode', $kodeMapel )->get();
        
        return Excel::download(new MapelTemplateExportMapel($siswa, $mapel), 'template_nilai.xlsx');
    }
}
