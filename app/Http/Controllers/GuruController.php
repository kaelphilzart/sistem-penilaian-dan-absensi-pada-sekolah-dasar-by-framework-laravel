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
use App\Exports\MapelTemplateExport;
use App\Imports\SkriningImport;
use App\Imports\KompetensiImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use ConsoleTVs\Charts\Facades\Charts;

class GuruController extends Controller
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
    
        return view('guru.dashboard', compact('jumlahSiswaAktif', 'jumlahGuruAktif', 'jumlahSiswa', 'jumlahGuru', 'labels', 'values', 'siswaValues'));
    }
    


    public function getMapelKelas($id_kelas)
    {
        $mapel = Mapel::where('id_kelas', $id_kelas)->get();
        return response()->json($mapel);
    }

// absen
    public function dataAbsen(Request $request)
    {
        $id_guru = auth()->user()->guru->id;

        // Mendapatkan kelas yang pertama kali ditemukan untuk guru
        $kelas = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
                    ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
                    ->where('kelas.nip_guru', $id_guru)
                    ->first();  // Hanya ambil kelas pertama

        $mapel = collect(); // Kosongkan data mapel saat pertama kali membuka halaman
        $data = collect(); // Kosongkan data siswa saat pertama kali membuka halaman
        $absensi = collect();
        $tanggal = null;

        if ($kelas) {
            // Ambil mapel berdasarkan id_kelas
            $mapel = Mapel::where('kategori', 'inti')->get();

            if ($request->has('tgl') && $request->has('id_mapel') && $request->has('semester')) {
                $tanggal = $request->tgl;
                $id_mapel = $request->id_mapel;
                $semester = $request->semester;

                // Mengambil data siswa berdasarkan id_kelas
                $data = Siswa::where('id_kelas', $kelas->id_kelas)->get();

                // Ambil data absensi berdasarkan tanggal, mapel, dan semester
                $absensi = Absen::whereDate('tgl', $tanggal)
                        ->where('id_mapel', $id_mapel)
                        ->where('semester', $semester)
                        ->whereIn('id_siswa', $data->pluck('id'))
                        ->get()->keyBy('id_siswa');
            }
        }

        return view('guru.data-absen', compact('data', 'kelas', 'mapel', 'absensi', 'tanggal'));
    }

public function searchAbsen(Request $request)
{
    return redirect()->route('absen', [
        'semester' => $request->semester, 
        'tgl' => $request->tgl,
        'id_mapel' => $request->id_mapel, // Tambahkan parameter id_mapel
    ]);
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
        return redirect()->route('absen', [
            'tgl' => $request->tgl,
            'id_mapel' => $request->id_mapel,
            'semester' => $request->semester, // Tambahkan parameter id_mapel
        ])->with('success', 'Absen berhasil dilakukan.');
    }

    public function updateAbsen(Request $request, $id){

        $data = Absen::find($id);
        $data->status = $request->status;
        $data->update();
        return redirect()->route('absen', [
            'tgl' => $request->tgl,
            'id_mapel' => $request->id_mapel,
            'semester' => $request->semester,  // Tambahkan parameter id_mapel
        ])->with('success', 'Absen berhasil diperbarui.');
    }

// siswa
    public function dataSiswa(Request $request)
    {
        $id_guru = auth()->user()->guru->id;

        $kelas = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
                    ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
                    ->where('kelas.nip_guru', $id_guru)
                    ->get();

        // Mendapatkan kelas yang pertama kali ditemukan untuk guru
        $kelasPertama = $kelas->first();

        // Mendapatkan ID kelas pertama
        $id_kelas = $kelasPertama ? $kelasPertama->id_kelas : null;

        // Mengambil data siswa berdasarkan id_kelas
        $data = $id_kelas ? Siswa::where('id_kelas', $id_kelas)->get() : collect();

        return view('guru.data-siswa', compact('data', 'kelasPertama'));
    }

// isi-eskul
    public function isiEskul(Request $request)
    {
        $id_guru = auth()->user()->guru->id;

        $kelas = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
                    ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
                    ->where('kelas.nip_guru', $id_guru)
                    ->get();

         $kelasPertama = $kelas->first();

        // Mendapatkan ID kelas pertama
        $id_kelas = $kelasPertama ? $kelasPertama->id_kelas : null;

        // Mengambil data siswa berdasarkan id_kelas
        $data = $id_kelas ? Siswa::where('id_kelas', $id_kelas)->get() : collect();

        return view('guru.isi-eskul', compact('data', 'kelasPertama'));
    }

    // public function searchIsiEskul(Request $request)
    // {
    //     return redirect()->route('isi-eskul', [
    //         'id_kelas' => $request->id_kelas,
    //     ]);
    // }

    public function dataEskul($nisn, $id_kelas, $semester)
    {
        // Mengambil data pesanan berdasarkan ID

        $kelas = Kelas::find($id_kelas);
        $siswa = Siswa::where('NISN', $nisn)->first();

        $eskul = Eskul::all();
                            
        $nilaiEskul = EskulSiswa::where('nisn', $nisn)
                        ->where('id_kelas', $id_kelas)
                        ->where('semester', $semester)
                        ->join('eskul','eskul_siswa.id_eskul','=','eskul.id')
                        ->select('eskul_siswa.*','eskul.nama_eskul')    
                        ->paginate(5);
        
        // Mengambil detail pesanan berdasarkan ID pesanan
        return view('guru.data-eskul-siswa', compact('kelas','eskul','nilaiEskul','siswa','semester','nisn','id_kelas'));
    }

    public function inputEskul(Request $request){
        // Validasi form
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka',
        ];
    
        $attributes = $request->validate([
            'nisn' => 'required',
            'id_kelas' => 'required',
            'semester' => 'required',
            'id_eskul' => 'required',
            'predikat' => 'required',
            'keterangan' => 'required',
        ], $message);
    
        // Pengecekan apakah data sudah ada
        $existingData = EskulSiswa::where('nisn', $request->nisn)
                            ->where('id_kelas', $request->id_kelas)
                            ->where('id_eskul', $request->id_eskul)
                            ->where('semester', $request->semester)
                            ->first();
    
        if ($existingData) {
            // Jika data sudah ada, tampilkan pesan toast dan kembali ke halaman sebelumnya
            return redirect()->back()->with('error', 'Masukan predikat gagal karena anda sudah menginputkan untuk eskul ini');
        }
    
        // Jika data belum ada, simpan data baru
        $data = new EskulSiswa;
        $data->nisn = $request->nisn;
        $data->id_kelas = $request->id_kelas;
        $data->semester = $request->semester;
        $data->id_eskul = $request->id_eskul;
        $data->predikat = $request->predikat;
        $data->keterangan = $request->keterangan;
        $data->save();
    
        return redirect()->route('data-eskul', [
            'nisn' => $request->nisn,
            'id_kelas' => $request->id_kelas,
            'semester' => $request->semester
        ])->with('success', 'Predikat berhasil ditambahkan.');
    }
    

    public function updateNilaiEskul(Request $request, $id)
    {
        // Validasi form
        $message = [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka',
        ];
    
        $attributes = $request->validate([
            'predikat' => 'required',
            'keterangan' => 'required',
        ], $message);
    
        // Ambil data yang ada berdasarkan id
        $data = EskulSiswa::findOrFail($id);
        $data->predikat = $request->predikat;
        $data->keterangan = $request->keterangan;
        $data->save(); // Simpan perubahan
    
        return redirect()->route('data-eskul', [
            'nisn' => $data->nisn,
            'id_kelas' => $data->id_kelas,
            'semester' => $data->semester
        ])->with('success', 'Predikat Eskul berhasil diperbarui.');
    }
    

// isi-nilai
    public function isiNilai(Request $request)
    {
        $id_guru = auth()->user()->guru->id;

        // Mendapatkan semua kelas yang diajar oleh guru yang sedang login
        $kelas = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
                    ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
                    ->where('kelas.nip_guru', $id_guru)
                    ->get();

        // Mendapatkan ID kelas pertama (untuk default view)
        $kelasPertama = $kelas->first();
        $id_kelas = $kelasPertama ? $kelasPertama->id_kelas : null;

        // Mengambil mata pelajaran berdasarkan id_kelas pertama
        $mapel = $id_kelas ? Mapel::where('kategori', 'inti')->get() : collect();

        // Mengambil data siswa berdasarkan id_kelas pertama
        $data = $id_kelas ? Siswa::where('id_kelas', $id_kelas)->get() : collect();

        return view('guru.isi-nilai', compact('data', 'kelasPertama', 'mapel', 'kelas'));
    }


    public function searchIsiNilai(Request $request)
    {
        return redirect()->route('isi-nilai', [
            'id_kelas' => $request->id_kelas,
        ]);
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
    
        return view('guru.data-nilai', compact('kelas', 'nilai', 'siswa', 'semester'));
    }
    
    public function searchDataNilai(Request $request)
    {
        return redirect()->route('data-nilai', [
            'id_siswa' => $request->id_siswa,
            'id_kelas' => $request->id_kelas,
            'semester' => $request->semester,
        ]);
    }

    public function inputNilai(Request $request){
        // Validasi form
        $message= [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka',
        ];
    
        $attributes = $request->validate([
            'id_siswa' => 'required',
            'id_mapel' => 'required',
            'nama_tugas' => 'required',
            'isi_nilai' => 'required|numeric',
        ], $message);
    
        // Pengecekan apakah data sudah ada
        $existingData = Nilai::where('id_siswa', $request->id_siswa)
                            ->where('id_mapel', $request->id_mapel)
                            ->where('nama_tugas', $request->nama_tugas)
                            ->first();
    
        if ($existingData) {
            // Jika data sudah ada, tampilkan pesan toast dan kembali ke halaman sebelumnya
            return redirect()->back()->with('error', 'Masukan nilai gagal karena anda sudah menginputkan untuk tugas ini');
        }
    
        // Jika data belum ada, simpan data baru
        $data = new Nilai;
        $data->id_siswa = $request->id_siswa;
        $data->id_mapel = $request->id_mapel;
        $data->nama_tugas = $request->nama_tugas;
        $data->isi_nilai = $request->isi_nilai;
        $data->save();
    
        return redirect()->route('data-nilai', [
            'id_siswa' => $request->id_siswa,
            'id_kelas' => $request->id_kelas
        ])->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function updateNilai(Request $request, $id)
    {
        // Validasi form
        $message= [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka',
        ];
    
        $attributes = $request->validate([
            'isi_nilai' => 'required|numeric',
        ], $message);
    
        // Ambil data yang ada berdasarkan id
        $data = Nilai::findOrFail($id);
        $data->isi_nilai = $request->isi_nilai;
        $data->save(); // Simpan perubahan
    
        return redirect()->route('data-nilai', [
            'id_siswa' => $request->id_siswa,
            'id_kelas' => $request->id_kelas
        ])->with('success', 'Nilai berhasil diperbarui.');
    }

    public function importNilai(Request $request)
    {
        $kode_mapel = auth()->user()->guru->kode_mapel;
    
        // Check if the combination of id_kelas, semester, and kode_mapel already exists in the Nilai table
        $existingRecords = Nilai::where('id_kelas', $request->id_kelas)
                                ->where('semester', $request->semester)
                                ->exists();
    
        if ($existingRecords) {
            // Join with the mapel table to check the category
            $recordsToDelete = Nilai::join('mapel', 'nilai.kode_mapel', '=', 'mapel.kode')
                ->where('nilai.id_kelas', $request->id_kelas)
                ->where('nilai.semester', $request->semester)
                ->where('mapel.kategori', 'inti')
                ->select('nilai.*')
                ->get();
    
            // Delete only the records that have kategori "inti"
            foreach ($recordsToDelete as $record) {
                $record->delete();
            }
        }
    
        // Proceed with the import
        $import = new NilaiSiswaImport($request->id_kelas, $request->semester, $kode_mapel);
        Excel::import($import, $request->file('excel_file'));
    
        return redirect()->back()->with('success', 'Data nilai berhasil diimpor.');
    }
    
    
    
    
    
// rekap-nilai
    public function rekapNilaiSiswa(Request $request)
    {
        $kelas = Kelas::join('tahun_ajar','kelas.id_tahunAjar','=','tahun_ajar.id')
                        ->select('kelas.*', 'tahun_ajar.tahunAjar','tahun_ajar.semester')
                        ->get();
        $data = collect(); // Kosongkan data siswa saat pertama kali membuka halaman
        $id_kelas = $request->id_kelas;

        // Jika ada pencarian
        if ($request->has('id_kelas')) {
            $data = Siswa::where('id_kelas', $id_kelas)->paginate(5);
        }

        return view('guru.rekap-nilai', compact('data', 'kelas'));
    }

    public function searchRekapNilaiSiswa(Request $request)
    {
        return redirect()->route('rekap-nilai', [
            'id_kelas' => $request->id_kelas,
        ]);
    }

    public function lihatRekap($id_siswa, $id_kelas)
    {
        // Mengambil data pesanan berdasarkan ID
        $kelas = Kelas::find($id_kelas);
        $siswa = Siswa::find($id_siswa);
    
        // Mengambil semua mapel untuk kelas tertentu
        $mapel = Mapel::where('id_kelas', $id_kelas)->get();
    
        // Mengambil semua jenis tugas yang ada
        $jenisTugas = Nilai::where('id_siswa', $id_siswa)
                            ->join('mapel', 'nilai.id_mapel', '=', 'mapel.id')
                            ->where('mapel.id_kelas', $id_kelas)
                            ->select('nilai.nama_tugas')
                            ->distinct()
                            ->get()
                            ->pluck('nama_tugas')
                            ->toArray();
    
        // Mengambil data nilai dan mengelompokkan berdasarkan mapel dan jenis tugas
        $rekap = Nilai::where('id_siswa', $id_siswa)
                        ->join('siswa', 'nilai.id_siswa', '=', 'siswa.id')
                        ->join('mapel', 'nilai.id_mapel', '=', 'mapel.id')
                        ->select('nilai.*', 'siswa.nama_siswa', 'mapel.nama_mapel')
                        ->get()
                        ->groupBy('nama_mapel');
    
        // Hitung rata-rata per mata pelajaran
        $rataRata = $rekap->mapWithKeys(function ($nilaiMapel, $mapel) {
            $totalNilai = $nilaiMapel->sum('isi_nilai');
            $jumlahNilai = $nilaiMapel->count();
            $rata2 = $jumlahNilai ? $totalNilai / $jumlahNilai : 0;
            return [$mapel => $rata2];
        });
    
        return view('guru.lihat-rekap', compact('kelas', 'mapel', 'rekap', 'siswa', 'jenisTugas', 'rataRata'));
    }
    
//skrining

    public function importSkrining(Request $request)
    {
        $import = new SkriningImport($request->id_kelas, $request->semester);
        Excel::import($import, $request->file('excel_file'));

        return redirect()->back()->with('success', 'Skrining berhasil diimpor.');
    }

    public function skriningSiswa(Request $request)
    {
        $id_guru = auth()->user()->guru->id;

        $kelas = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
                    ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
                    ->where('kelas.nip_guru', $id_guru)
                    ->get();

        $kelasPertama = $kelas->first();

        // Mendapatkan ID kelas pertama
        $id_kelas = $kelasPertama ? $kelasPertama->id_kelas : null;

        // Mengambil data siswa berdasarkan id_kelas
        $data = $id_kelas ? Siswa::where('id_kelas', $id_kelas)->get() : collect();

        return view('guru.skrining', compact('data', 'kelasPertama'));
    }

    public function searchSkriningSiswa(Request $request)
    {
        return redirect()->route('skrining', [
            'id_kelas' => $request->id_kelas,
        ]);
    }

    public function dataSkrining($nisn)
    {
        // Mengambil data pesanan berdasarkan ID

        $siswa = Siswa::where('NISN', $nisn)->first();
                            
        $skrining = Skrining::where('nisn', $nisn)
                        ->get();
        
        // Mengambil detail pesanan berdasarkan ID pesanan
        return view('guru.data-skrining', compact('siswa','skrining'));
    }

    public function isiSkrining(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $attributes = request()->validate([
            'id_siswa' => 'required',
            'id_kelas' => 'required',
            'tinggi_badan' => 'required',
            'berat_badan' => 'required',
            'pendengaran' => 'required',
            'penglihatan' => 'required',
            'gigi' => 'required',
        ], $message);
        
        $data = new Skrining;
        $data->id_siswa = $request->id_siswa;
        $data->id_kelas = $request->id_kelas;
        $data->tinggi_badan = $request->tinggi_badan;
        $data->berat_badan = $request->berat_badan;
        $data->pendengaran = $request->pendengaran;
        $data->penglihatan = $request->penglihatan;
        $data->gigi = $request->gigi;
        $data->save($attributes);
        return redirect()->route('skrining', [
            'id_kelas' => $request->id_kelas,
        ])->with('success', 'Skrining berhasil ditambahkan.');
    }

    public function updateSkrining(Request $request, $id)
    {
        // Validasi form
        $message= [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka',
        ];
    
        $attributes = $request->validate([
            'tinggi_badan' => 'required',
            'berat_badan' => 'required',
            'pendengaran' => 'required',
            'penglihatan' => 'required',
            'gigi' => 'required',
        ], $message);

        // Ambil data yang ada berdasarkan id
        $data = Skrining::find($id);
        $data->tinggi_badan = $request->tinggi_badan;
        $data->berat_badan = $request->berat_badan;
        $data->pendengaran = $request->pendengaran;
        $data->penglihatan = $request->penglihatan;
        $data->gigi = $request->gigi;
        $data->save(); // Simpan perubahan
    
        return redirect()->route('skrining', [
            'id_kelas' => $request->id_kelas,
        ])->with('success', 'Skrining berhasil diperbarui.');
    }

// raport

    public function importKompetensi(Request $request)
    {
        $import = new KompetensiImport($request->id_kelas, $request->semester);
        Excel::import($import, $request->file('excel_file'));

        return redirect()->back()->with('success', 'Kompetensi berhasil diimpor.');
    }

    public function raportSiswa(Request $request)
    {
        $id_guru = auth()->user()->guru->id;

        $kelas = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
                    ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
                    ->where('kelas.nip_guru', $id_guru)
                    ->get();

        $kelasPertama = $kelas->first();

        // Mendapatkan ID kelas pertama
        $id_kelas = $kelasPertama ? $kelasPertama->id_kelas : null;

        // Mengambil data siswa berdasarkan id_kelas
        $data = $id_kelas ? Siswa::where('id_kelas', $id_kelas)->get() : collect();

        return view('guru.raport', compact('data', 'kelasPertama'));
    }

    public function searchRaportSiswa(Request $request)
    {
        return redirect()->route('raport-siswa', [
            'id_kelas' => $request->id_kelas,
        ]);
    }

    public function dataRaport($nisn, $id_kelas, $semester)
    {
        // Mengambil data pesanan berdasarkan ID
        $kelas = Kelas::find($id_kelas);
        $siswa = Siswa::where('NISN', $nisn)->first();
                            
        $kompetensi = Raport::where('nisn', $nisn)
                            ->where('id_kelas', $id_kelas)
                            ->where('semester', $semester)
                             ->get();
        
        // Mengambil detail pesanan berdasarkan ID pesanan
        return view('guru.data-kompetensi', compact('siswa','kompetensi','kelas','semester'));
    }

        public function lihatRaport($id_siswa, $id_kelas)
    {
        // Mengambil data kelas dan siswa berdasarkan ID
        $kelas = Kelas::find($id_kelas);
        $siswa = Siswa::find($id_siswa);
        
        // Mengelompokkan nilai berdasarkan mapel dan menghitung rata-rata nilai per mapel
        $nilaiRataRata = Nilai::where('id_siswa', $id_siswa)
            ->join('mapel', 'nilai.id_mapel', '=', 'mapel.id')
            ->select('nilai.id_mapel', \DB::raw('AVG(nilai.isi_nilai) as rata_rata_nilai'), 'mapel.nama_mapel')
            ->groupBy('nilai.id_mapel', 'mapel.nama_mapel')
            ->get();

        // Mengubah hasil rata-rata nilai menjadi array dengan key id_mapel
        $nilaiRataRataMap = $nilaiRataRata->keyBy('id_mapel');

        // Query untuk mengambil data raport
        $raport = Raport::where('raport.id_siswa', $id_siswa)
            ->join('mapel', 'raport.id_mapel', '=', 'mapel.id')
            ->select('raport.*', 'mapel.nama_mapel')
            ->paginate(5);

        // Menggabungkan hasil rata-rata nilai ke dalam data raport
        foreach ($raport as $dataRaport) {
            $idMapel = $dataRaport->id_mapel;
            $dataRaport->rata_rata_nilai = isset($nilaiRataRataMap[$idMapel]) ? $nilaiRataRataMap[$idMapel]->rata_rata_nilai : null;
        }

        return view('guru.lihat-raport', compact('kelas', 'siswa', 'raport', 'nilaiRataRata', 'id_siswa', 'id_kelas'));
    }

    
    public function inputRaport(Request $request){
        // Validasi form
        $message= [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka',
        ];
    
        $attributes = $request->validate([
            'id_siswa' => 'required',
            'id_mapel' => 'required',
            'kompetensi' => 'required',
        ], $message);
    
        // Pengecekan apakah data sudah ada
        $existingData = Raport::where('id_siswa', $request->id_siswa)
                            ->where('id_mapel', $request->id_mapel)
                            ->first();
    
        if ($existingData) {
            // Jika data sudah ada, tampilkan pesan toast dan kembali ke halaman sebelumnya
            return redirect()->back()->with('error', 'Mata Pelajaran ini sudah ada kompetensi, silakn untuk merubahnya');
        }
    
        // Jika data belum ada, simpan data baru
        $data = new Raport;
        $data->id_siswa = $request->id_siswa;
        $data->id_mapel = $request->id_mapel;
        $data->kompetensi = $request->kompetensi;
        $data->save();
    
        return redirect()->route('lihat-raport', [
            'id_siswa' => $request->id_siswa,
            'id_kelas' => $request->id_kelas
        ])->with('success', 'Kompetensi berhasil ditambahkan.');
    }

    
    public function updateRaport(Request $request, $id)
    {
        // Validasi form
        $message= [
            'required' => ':attribute tidak boleh kosong',
            'numeric' => ':attribute harus berupa angka',
        ];
    
        $attributes = $request->validate([
            'kompetensi' => 'required',
        ], $message);
    
        // Ambil data yang ada berdasarkan id
        $data = Raport::findOrFail($id);
        $data->kompetensi = $request->kompetensi;
        $data->save(); // Simpan perubahan
    
        return redirect()->route('lihat-raport', [
            'id_siswa' => $request->id_siswa,
            'id_kelas' => $request->id_kelas
        ])->with('success', 'Komeptensi berhasil diperbarui.');
    }  

    public function searchCetakRaport(Request $request)
    {
        return redirect()->route('cetak-raport', [
            'id_kelas' => $request->id_kelas,
        ]);
    }

    public function cetakPdfRaport($id)
    {
        $dataDetail = searchSkriningSiswa::find($id);
        $pdf = PDF::loadView('admin.cetak-detail', compact('dataDetail'));
        
        return $pdf->stream('detail-' . $dataDetail->nama_pcs . '.pdf');
    }



    public function cetakRaport(Request $request)
    {
        $id_guru = auth()->user()->guru->id;

        $kelas = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
                    ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
                    ->where('kelas.nip_guru', $id_guru)
                    ->get();

         $kelasPertama = $kelas->first();

        // Mendapatkan ID kelas pertama
        $id_kelas = $kelasPertama ? $kelasPertama->id_kelas : null;

        // Mengambil data siswa berdasarkan id_kelas
        $data = $id_kelas ? Siswa::where('id_kelas', $id_kelas)->get() : collect();


        return view('guru.cetak-raport', compact('data', 'kelasPertama'));
    }

    public function lihatCetakRaport($nisn, $id_kelas, $semester)
    {
        // Mengambil data kelas dan siswa
        $kelas = Kelas::find($id_kelas);
        $siswa = Siswa::where('NISN',$nisn)->first();
    
        // Mengambil semua mapel untuk kelas tertentu
        $mapel = Mapel::all();
    
        // Ambil semua nilai berdasarkan nisn, id_kelas, dan semester
        $nilaiMapel = DB::table('mapel')
            ->leftJoin('nilai', function($join) use ($nisn, $id_kelas, $semester) {
                $join->on('mapel.kode', '=', 'nilai.kode_mapel')
                    ->where('nilai.nisn', $nisn)
                    ->where('nilai.id_kelas', $id_kelas)
                    ->where('nilai.semester', $semester);
            })
            ->select('mapel.nama_mapel', 'nilai.*', DB::raw('
                (COALESCE(nilai.tugas_1, 0) + COALESCE(nilai.tugas_2, 0) + COALESCE(nilai.uts, 0) + COALESCE(nilai.tugas_3, 0) + COALESCE(nilai.tugas_4, 0) + COALESCE(nilai.uas, 0)) / 
                NULLIF(
                    (CASE WHEN nilai.tugas_1 IS NOT NULL THEN 1 ELSE 0 END +
                    CASE WHEN nilai.tugas_2 IS NOT NULL THEN 1 ELSE 0 END +
                    CASE WHEN nilai.uts IS NOT NULL THEN 1 ELSE 0 END +
                    CASE WHEN nilai.tugas_3 IS NOT NULL THEN 1 ELSE 0 END +
                    CASE WHEN nilai.tugas_4 IS NOT NULL THEN 1 ELSE 0 END +
                    CASE WHEN nilai.uas IS NOT NULL THEN 1 ELSE 0 END), 0) as rata_rata
            '))
            ->get();
    
        return view('guru.lihat-cetak-raport', compact('kelas', 'mapel', 'nilaiMapel', 'siswa','semester'));
    }
    

    public function reviewRaport($nisn, $id_kelas, $semester)
    {
        // Ambil data siswa
        
        $siswa = Siswa::where('siswa.NISN', $nisn)
                        ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')
                        ->join('guru', 'kelas.nip_guru','=','guru.id')
                        ->select('siswa.*', 'kelas.nama_kelas', 'kelas.bagian', 
                                'guru.nama_lengkap','guru.nip')
                        ->first();
    
        // Ambil data kelas
        $kelas = Kelas::where('id', $id_kelas)->first();
    
        // Ambil semua nilai dan kompetensi berdasarkan mata pelajaran
        $mapelTahunAjaran = Mapel::pluck('id');
        $nilaiMapel = DB::table('mapel')
        ->leftJoin('nilai', function($join) use ($nisn, $id_kelas, $semester) {
            $join->on('mapel.kode', '=', 'nilai.kode_mapel')
                ->where('nilai.nisn', $nisn)
                ->where('nilai.id_kelas', $id_kelas)
                ->where('nilai.semester', $semester);
        })
        ->select('mapel.nama_mapel', 'nilai.*', DB::raw('
            LEFT(
                ROUND(
                    (
                        COALESCE(nilai.tugas_1, 0) +
                        COALESCE(nilai.tugas_2, 0) +
                        COALESCE(nilai.uts, 0) +
                        COALESCE(nilai.tugas_3, 0) +
                        COALESCE(nilai.tugas_4, 0) +
                        COALESCE(nilai.uas, 0)
                    ) / 
                    NULLIF(
                        (
                            CASE WHEN nilai.tugas_1 IS NOT NULL THEN 1 ELSE 0 END +
                            CASE WHEN nilai.tugas_2 IS NOT NULL THEN 1 ELSE 0 END +
                            CASE WHEN nilai.uts IS NOT NULL THEN 1 ELSE 0 END +
                            CASE WHEN nilai.tugas_3 IS NOT NULL THEN 1 ELSE 0 END +
                            CASE WHEN nilai.tugas_4 IS NOT NULL THEN 1 ELSE 0 END +
                            CASE WHEN nilai.uas IS NOT NULL THEN 1 ELSE 0 END
                        ), 0
                    ) * 10, 0
                ), 2
            ) as rata_rata
        '))
        ->get();
        $eskul = EskulSiswa::where('eskul_siswa.nisn',$nisn)
                            ->where('eskul_siswa.id_kelas',$id_kelas)   
                            ->where('eskul_siswa.semester',$semester)   
                            ->join('eskul','eskul_siswa.id_eskul','=','eskul.id')
                            ->select('eskul_siswa.*','eskul.nama_eskul')
                            ->get();
    
        $id_siswa = Siswa::where('siswa.NISN', $nisn)->select('id')->first()->id;

        $absen = Absen::where('absen.id_siswa', $id_siswa)
            ->join('mapel', 'absen.id_mapel', '=', 'mapel.id')
            ->join('siswa','absen.id_siswa','=','siswa.id')
            ->where('siswa.id_kelas', $id_kelas)
            ->where('absen.semester', $semester)
            ->whereIn('absen.status', ['izin', 'sakit'])
            ->select('absen.status', DB::raw('count(*) as total'))
            ->groupBy('absen.status')
            ->pluck('total', 'status');
    
        // Buat array default dengan nilai 0 untuk status izin dan sakit
        $defaultStatuses = [
            'izin' => 0,
            'sakit' => 0,
        ];
    
        // Gabungkan hasil query dengan array default
        $absenData = array_merge($defaultStatuses, $absen->toArray());
    
        $skrining = Skrining::where('skrining.NISN',$nisn)
                            ->where('skrining.id_kelas',$id_kelas)
                            ->where('skrining.semester',$semester)
                            ->get(); 
    
        return view('guru.tampilan-raport', compact('siswa', 'kelas', 'nilaiMapel', 'eskul','absenData','skrining','semester'));
    }
    

    public function downloadRaport($nisn, $id_kelas, $semester)
    {
        $siswa = Siswa::where('siswa.NISN', $nisn)
        ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')
        ->join('guru', 'kelas.nip_guru','=','guru.id')
        ->select('siswa.*', 'kelas.nama_kelas', 'kelas.bagian', 
                'guru.nama_lengkap','guru.nip')
        ->first();

            // Ambil data kelas
            $kelas = Kelas::where('id', $id_kelas)->first();

            // Ambil semua nilai dan kompetensi berdasarkan mata pelajaran
            $mapelTahunAjaran = Mapel::pluck('id');
            $nilaiMapel = DB::table('mapel')
            ->leftJoin('nilai', function($join) use ($nisn, $id_kelas, $semester) {
            $join->on('mapel.kode', '=', 'nilai.kode_mapel')
            ->where('nilai.nisn', $nisn)
            ->where('nilai.id_kelas', $id_kelas)
            ->where('nilai.semester', $semester);
            })
            ->select('mapel.nama_mapel', 'nilai.*', DB::raw('
            LEFT(
            ROUND(
                (
                    COALESCE(nilai.tugas_1, 0) +
                    COALESCE(nilai.tugas_2, 0) +
                    COALESCE(nilai.uts, 0) +
                    COALESCE(nilai.tugas_3, 0) +
                    COALESCE(nilai.tugas_4, 0) +
                    COALESCE(nilai.uas, 0)
                ) / 
                NULLIF(
                    (
                        CASE WHEN nilai.tugas_1 IS NOT NULL THEN 1 ELSE 0 END +
                        CASE WHEN nilai.tugas_2 IS NOT NULL THEN 1 ELSE 0 END +
                        CASE WHEN nilai.uts IS NOT NULL THEN 1 ELSE 0 END +
                        CASE WHEN nilai.tugas_3 IS NOT NULL THEN 1 ELSE 0 END +
                        CASE WHEN nilai.tugas_4 IS NOT NULL THEN 1 ELSE 0 END +
                        CASE WHEN nilai.uas IS NOT NULL THEN 1 ELSE 0 END
                    ), 0
                ) * 10, 0
            ), 2
            ) as rata_rata
            '))
            ->get();
            $eskul = EskulSiswa::where('eskul_siswa.nisn',$nisn)
                        ->where('eskul_siswa.id_kelas',$id_kelas)   
                        ->where('eskul_siswa.semester',$semester)   
                        ->join('eskul','eskul_siswa.id_eskul','=','eskul.id')
                        ->select('eskul_siswa.*','eskul.nama_eskul')
                        ->get();

            $id_siswa = Siswa::where('siswa.NISN', $nisn)->select('id')->first()->id;

            $absen = Absen::where('absen.id_siswa', $id_siswa)
            ->join('mapel', 'absen.id_mapel', '=', 'mapel.id')
            ->join('siswa','absen.id_siswa','=','siswa.id')
            ->where('siswa.id_kelas', $id_kelas)
            ->where('absen.semester', $semester)
            ->whereIn('absen.status', ['izin', 'sakit'])
            ->select('absen.status', DB::raw('count(*) as total'))
            ->groupBy('absen.status')
            ->pluck('total', 'status');

            // Buat array default dengan nilai 0 untuk status izin dan sakit
            $defaultStatuses = [
            'izin' => 0,
            'sakit' => 0,
            ];

            // Gabungkan hasil query dengan array default
            $absenData = array_merge($defaultStatuses, $absen->toArray());

            $skrining = Skrining::where('skrining.NISN',$nisn)
                        ->where('skrining.id_kelas',$id_kelas)
                        ->where('skrining.semester',$semester)
                        ->get();  

        // Gabungkan hasil query dengan array default
        // Load view 'guru.tampilan-raport' dengan data yang diberikan
        $pdf = PDF::loadView('guru.tampilan-raport', compact('siswa', 'kelas', 'nilaiMapel', 'eskul','absenData','skrining','semester'))
                ->setPaper('legal', 'portrait'); 
        // Set ukuran kertas ke F4 (legal size)
        // 'legal' untuk ukuran F4, 'portrait' untuk orientasi potret

        // Buat nama file untuk diunduh
        $filename = 'RAPORT_' . $siswa->nama_siswa . '_' . $kelas->nama_kelas . '('.$kelas->bagian.')_'.$kelas->tahunAjar->tahunAjar.'_'.$semester.'.pdf';

        // Unduh file PDF
        return $pdf->download($filename);
    }

    //     public function downloadRaport($id_siswa, $id_kelas)
//     {
//         // Ambil data dari database
//         $siswa = Siswa::where('siswa.id', $id_siswa)
//                     ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id')
//                     ->join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
//                     ->select('siswa.*', 'kelas.nama_kelas', 'kelas.bagian', 'tahun_ajar.tahunAjar', 'tahun_ajar.semester')
//                     ->first();

//     // Ambil data kelas
//     $kelas = Kelas::where('id', $id_kelas)->first();

//     // Ambil semua nilai dan kompetensi berdasarkan mata pelajaran
//     $rekap = Nilai::where('id_siswa', $id_siswa)
//                     ->join('mapel', 'nilai.id_mapel', '=', 'mapel.id')
//                     ->where('mapel.id_kelas', $id_kelas)
//                     ->select('nilai.*', 'mapel.nama_mapel')
//                     ->get()
//                     ->groupBy('nama_mapel');

//     // Join tabel raport dengan tabel mapel
//     $raport = Raport::where('raport.id_siswa', $id_siswa)
//                     ->join('mapel', 'raport.id_mapel', '=', 'mapel.id')
//                     ->where('mapel.id_kelas', $id_kelas)
//                     ->select('raport.*', 'mapel.nama_mapel')
//                     ->get()
//                     ->groupBy('nama_mapel');

//     // Hitung rata-rata per mata pelajaran
//     $rataRata = $rekap->mapWithKeys(function ($nilaiMapel, $mapel) use ($raport) {
//         $totalNilai = $nilaiMapel->sum('isi_nilai');
//         $jumlahNilai = $nilaiMapel->count();
//         $rata2 = $jumlahNilai ? $totalNilai / $jumlahNilai : 0;

//         // Ambil kompetensi dari raport
//         $kompetensi = $raport->has($mapel) ? $raport[$mapel]->pluck('kompetensi')->implode(', ') : '';

//         return [
//             $mapel => [
//                 'rata_rata' => $rata2,
//                 'kompetensi' => $kompetensi,
//             ]
//         ];
//     });

//     $eskul = EskulSiswa::where('eskul_siswa.id_siswa', $id_siswa)
//                         ->where('eskul_siswa.id_kelas', $id_kelas)   
//                         ->join('eskul', 'eskul_siswa.id_eskul', '=', 'eskul.id')
//                         ->select('eskul_siswa.*', 'eskul.nama_eskul')
//                         ->get();

//     $absen = Absen::where('absen.id_siswa', $id_siswa)
//         ->join('mapel', 'absen.id_mapel', '=', 'mapel.id')
//         ->where('mapel.id_kelas', $id_kelas)
//         ->whereIn('absen.status', ['izin', 'sakit'])
//         ->select('absen.status', DB::raw('count(*) as total'))
//         ->groupBy('absen.status')
//         ->get()
//         ->keyBy('status');

//     // Buat array default dengan nilai 0 untuk status izin dan sakit
//     $defaultStatuses = [
//         'izin' => 0,
//         'sakit' => 0,
//     ];

//     $absenData = array_merge($defaultStatuses, $absen->toArray());

//     $skrining = Skrining::where('skrining.id_siswa',$id_siswa)
//     ->where('skrining.id_kelas',$id_kelas)
//     ->get(); 

//     // Gabungkan hasil query dengan array default
//     // Load view 'guru.tampilan-raport' dengan data yang diberikan
//     $pdf = PDF::loadView('guru.tampilan-raport',compact('siswa', 'kelas', 'rekap', 'rataRata','eskul','absenData','skrining'))
//     ->setPaper('legal', 'portrait'); 
//     // Set ukuran kertas ke F4 (legal size)
//     // 'legal' untuk ukuran F4, 'portrait' untuk orientasi potret

//     // Tampilkan PDF di browser tanpa mengunduh
//     return $pdf->stream('RAPORT ' . $siswa->nama_siswa . '_' . $kelas->nama_kelas . '('.$kelas->bagian.
//                                 ')_'.$siswa->tahunAjar.'_'.$siswa->semester.'.pdf');
// }



     public function downloadTemplate()
    {
        $userId = auth()->user()->guru->id;
        $kelas = Kelas::where('nip_guru', $userId)->value('id');

        $siswa = Siswa::where('id_kelas', $kelas)->get(); // Ambil data siswa berdasarkan ID user
        $mapel = Mapel::where('kategori','inti')->get();
        
        return Excel::download(new MapelTemplateExport($siswa, $mapel), 'template_nilai.xlsx');
    }
}
