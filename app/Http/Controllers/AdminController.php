<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use App\Models\Guru;
use App\Models\TahunAjar;
use App\Models\Siswa;
use App\Models\Mapel;
use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\Eskul;
use App\Models\Nilai;
use App\Models\Profile;
use App\Models\Kurikulum;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use ConsoleTVs\Charts\Facades\Charts;
use App\Mail\AkunWaliMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
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
    
        return view('admin.dashboard', compact('jumlahSiswaAktif', 'jumlahGuruAktif', 'jumlahSiswa', 'jumlahGuru', 'labels', 'values', 'siswaValues'));
    }
    
    

    public function dataUser(){
        $data = User::join('level', 'users.level', '=', 'level.id')
                    ->select('users.*', 'level.nama')
                    ->paginate(5);
        $data1 = Level::all();
        return view('admin.data-user', ['data' => $data, 'data1'=> $data1]);
    }

    public function createUser(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
        ];

        $attributes = request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'level' => 'required',
        ], $message);
        
        $attributes['password'] = bcrypt($attributes['password'] );

        $data = new User;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = Hash::make($request->password);
        $data->level = $request->level;
        $data->save($attributes);
        return redirect('/data-user')->with('success', 'User berhasil disimpan');;
    }

    
    public function updateUser(Request $request, $id){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
            'numeric' => 'attribute harus berupa angka',
        ];

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ], $message);

        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->level = $request->level;
        $data->update();
        return redirect('/data-user')->with('success', 'User berhasil diubah');;
    }

    public function deleteUser($id){
        $data = User::find($id);
        $data->delete();
        return redirect('/data-user')->with('success', 'User berhasil dihapus');;
    }

     
    public function cariUser(Request $request)
    {
        $kataKunci = $request->input('q');
        $hasilPencarian = User::when($kataKunci, function ($query) use ($kataKunci) {
            $query->where('name', 'LIKE', "%$kataKunci%")
            ->orWhere('email', 'LIKE', "%$kataKunci%");
        })->paginate(5);
        $data1 = Level::all();

        return view('admin.data-user', ['data' => $hasilPencarian, 'kataKunci' => $kataKunci, 'data1'=> $data1]);
    }

// Guru
    public function dataGuru(){
        // Ambil data guru dengan paginasi
        $data = Guru::get();

        // Ambil data pengguna dengan level 'guru' menggunakan relasi
        $data1 = User::where('level', '2')
        ->whereDoesntHave('guru')
        ->get();

        $mapel = Mapel::where('kategori','pilihan')->get();

        // Kirim data ke view 'admin.data-guru'
        return view('admin.data-guru', ['data' => $data, 'data1' => $data1, 'mapel' => $mapel]);
    }

    public function tambahGuru(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
        ];

        $attributes = request()->validate([
            'id_user' => 'required|unique:guru',
            'jenis_guru'=> 'required',
            'nama_lengkap'=> 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_tlp' => 'required|regex:/^[0-9]+$/|min:12|max:15',
            'alamat' => 'required',
            'golongan'=> 'required',
            'status'=> 'required',
            'jabatan'=> 'required',
        ], $message);
        
        $data = new Guru;
        $data->nip = $request->nip;
        $data->id_user = $request->id_user;
        $data->jenis_guru = $request->jenis_guru;
        $data->nama_lengkap = $request->nama_lengkap;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->no_tlp = $request->no_tlp;
        $data->alamat = $request->alamat;
        $data->golongan = $request->golongan;
        $data->jabatan = $request->jabatan;
        $data->status = $request->status;
        $data->save($attributes);
        return redirect('/data-guru')->with('success', 'Guru berhasil disimpan');
    }

    public function updateGuru(Request $request, $id){

        $data = Guru::find($id);
        $data->nip = $request->nip;
        $data->jenis_guru = $request->jenis_guru;
        $data->nama_lengkap = $request->nama_lengkap;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->no_tlp = $request->no_tlp;
        $data->alamat = $request->alamat;
        $data->golongan = $request->golongan;
        $data->jabatan = $request->jabatan;
        $data->save();
        return redirect('/data-guru')->with('success', 'Guru berhasil diubah');;
    }

    public function deleteGuru($id){
        $data = Guru::find($id);
        $data->delete();
        return redirect('/data-guru')->with('success', 'Guru berhasil dihapus');;
    }

    public function cariGuru(Request $request)
    {
        $kataKunci = $request->input('q');
        $hasilPencarian = Guru::when($kataKunci, function ($query) use ($kataKunci) {
            $query->where('nama_lengkap', 'LIKE', "%$kataKunci%")
            ->orWhere('nip', 'LIKE', "%$kataKunci%");
        })->paginate(5);
        $data1 = User::where('level', '2')
        ->whereDoesntHave('guru')
        ->get();


        return view('admin.data-guru', ['data' => $hasilPencarian, 'kataKunci' => $kataKunci, 'data1'=> $data1]);
    }

    public function waliKelas(Request $request)
    {
        $kelas = Kelas::join('tahun_ajar','kelas.id_tahunAjar','=','tahun_ajar.id')
                        ->select('kelas.*','tahun_ajar.tahunAjar','kelas.id as id_kelas')
                        ->get();
        $guru = Guru::where('jenis_guru','wali_kelas')->get();

        return view('admin.ganti-waliKelas', compact('kelas'));
    }

    public function gantiWaliKelas(Request $request)
    {
        $siswa_ids = explode(',', $request->input('siswa_ids', ''));
        $id_kelas_baru = $request->input('id_kelas_baru');
    
        if ($id_kelas_baru && !empty($siswa_ids)) {
            Siswa::whereIn('id', $siswa_ids)->update(['id_kelas' => $id_kelas_baru]);
            return redirect()->route('wali-kelas')->with('success', 'Siswa berhasil naik kelas');
        }
    
        return redirect()->route('wali-kelas')->with('error', 'Pilih kelas baru dan siswa terlebih dahulu.');
    }

    public function nonaktifkan(Request $request, $id){
        // Find the Guru model by ID
        $guru = Guru::find($id);
    
        if (!$guru) {
            return redirect('/data-guru')->with('error', 'Guru tidak ditemukan');
        }
        
        // Set the status to 'tidak aktif' and update
        $guru->status = 'tidak aktif';
        $guru->update();
        
        // Get the user ID associated with the Guru model
        $id_user = $guru->id_user;
        
        // Find the User model by the user ID
        $user = User::find($id_user);
        
        // Check if the User model exists before attempting to delete
        if ($user) {
            $user->delete();
        }
        
        // Redirect back to the data-guru page with a success message
        return redirect('/data-guru')->with('success', 'Guru berhasil dinonaktifkan');
    }
    
    public function dataGuruMapel()
    {
        // Mengambil data guru yang jenisnya 'guru_mapel' dan memiliki kode_mapel yang tidak 0
        $data = Guru::where('jenis_guru', 'guru_mapel')
                    ->where('kode_mapel', '!=', 'kosong')
                    ->get();
    
        // Mengambil daftar guru yang jenisnya 'guru_mapel' dan memiliki kode_mapel yang 0
        $daftarGuru = Guru::where('jenis_guru', 'guru_mapel')
                        ->where('kode_mapel', '=', 'kosong')
                        ->get();
    
        // Mengambil data mapel yang kategori 'pilihan'
        $mapel = Mapel::where('kategori', 'pilihan')->get();
    
        // Mengambil data kelas yang belum ada dalam kolom JSON 'kelas' pada tabel 'guru'
        return view('admin.data-guruMapel', [
            'data' => $data,
            'daftarGuru' => $daftarGuru,
            'mapel' => $mapel,
        ]);
    }
    

    public function getAvailableClasses($kode_mapel)
    {
        // Cari semua guru yang memiliki kode_mapel yang sesuai
        $gurus = Guru::where('kode_mapel', $kode_mapel)->get();
    
        if ($gurus->isEmpty()) {
            // Jika tidak ada guru dengan kode_mapel tersebut, ambil semua kelas
            $kelas = Kelas::with('tahunAjar')->get();
        } else {
            // Kumpulkan semua id_kelas dari JSON array semua guru
            $kelas_ids = $gurus->flatMap(function($guru) {
                return collect(json_decode($guru->kelas, true))->pluck('id_kelas');
            })->unique()->toArray();
    
            // Ambil semua kelas yang tidak ada dalam JSON array guru.kelas
            $kelas = Kelas::whereNotIn('id', $kelas_ids)->with('tahunAjar')->get();
        }
    
        return response()->json($kelas);
    }

        public function deleteGuruMapel(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->kode_mapel = 'kosong';
        $guru->kelas = null;
        $guru->save();

        return redirect()->back()->with('success', 'Data guru berhasil diperbarui.');
    }

    // public function coba($kode_mapel)
    // {
    //     // Cari guru yang memiliki kode_mapel yang sesuai
    //     $guru = Guru::where('kode_mapel', $kode_mapel)->first();
    
    //     if (!$guru) {
    //         // Jika tidak ada guru dengan kode_mapel tersebut, ambil semua kelas
    //         $kelas = Kelas::with('tahunAjar')->get();
    //     } else {
    //         // Jika ada guru dengan kode_mapel tersebut, ambil ID kelas dari JSON array guru.kelas
    //         $kelas_ids = collect(json_decode($guru->kelas, true))->pluck('id_kelas')->toArray();
    
    //         // Ambil semua kelas yang tidak ada dalam JSON array guru.kelas
    //         $kelas = Kelas::whereNotIn('id', $kelas_ids)->with('tahunAjar')->get();
    //     }
    
    //     // Debugging output
    //     dd($kelas);
    
    //     return response()->json($kelas);
    // }
    

    public function tambahGuruMapel(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:guru,id',
            'kode_mapel' => 'required|exists:mapel,kode',
            'kelas' => 'required|array',
            'kelas.*' => 'exists:kelas,id'
        ]);
    
        $guru = Guru::findOrFail($request->id);
        $guru->kode_mapel = $request->kode_mapel;
    
        // Convert array to JSON with key `id_kelas`
        $kelasArray = array_map(function($id) {
            return ['id_kelas' => $id];
        }, $request->kelas);
        $guru->kelas = json_encode($kelasArray);
    
        $guru->save();
    
        return redirect()->route('data-guruMapel')->with('success', 'Guru Mapel berhasil ditambahkan.');
    }
    

    
    

    // public function statusGuru(){
    //     // Ambil data guru dengan paginasi
    //     $data = Guru::where('status','aktif')->get();

    //     return view('admin.status-guru', ['data' => $data]);
    // }

// Tahun Ajar
    public function dataTahun(){
       
        $data = TahunAjar::paginate(5);
        
        return view('admin.data-tahun', ['data' => $data]);
    }

    public function tambahTahun(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $attributes = request()->validate([
            'tahunAjar' => 'required',
        ], $message);
        
        $data = new TahunAjar;
        $data->tahunAjar = $request->tahunAjar;
        $data->save($attributes);
        return redirect('/data-tahun')->with('success', 'Tahun Ajar berhasil disimpan');
    }

    public function updateTahun(Request $request, $id){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $this->validate($request, [
            'tahunAjar' => 'required',
        ], $message);

        $data = TahunAjar::find($id);
        $data->tahunAjar = $request->tahunAjar;
        $data->update();
        return redirect('/data-tahun')->with('success', 'Tahun Ajar berhasil diubah');;
    }

    public function deleteTahun($id){
        $data = TahunAjar::find($id);
        $data->delete();
        return redirect('/data-tahun')->with('success', 'Tahun Ajar berhasil dihapus');;
    }


// Rombel
    public function dataRombel()
    {
        // Get rombels with students count
        $data = Rombel::withCount('siswa')->paginate(5);
        
        return view('admin.data-rombel', ['data' => $data]);
    }

public function cariRombel(Request $request)
{
    $kataKunci = $request->input('q');

    $hasilPencarian = Rombel::when($kataKunci, function ($query) use ($kataKunci) {
        $query->where('tahun_rombel', 'LIKE', "%$kataKunci%");
    })->withCount('siswa')->paginate(5);

    return view('admin.data-rombel', [
        'data' => $hasilPencarian,
        'kataKunci' => $kataKunci
    ]);
}


    public function siswaRombel($id)
    {
        // Mengambil data pesanan berdasarkan ID

        $dataRombel = Rombel::find($id);
                            
        $data = Siswa::where('id_rombel', $id)
                            ->paginate(5);
        
        // Mengambil detail pesanan berdasarkan ID pesanan
        return view('admin.siswa-rombel', compact('data','dataRombel'));
    }

    public function tambahRombel(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $attributes = request()->validate([
            'tahun_rombel' => 'required',
        ], $message);
        
        $data = new Rombel;
        $data->tahun_rombel = $request->tahun_rombel;
        $data->save($attributes);
        return redirect('/data-rombel')->with('success', 'Rombel berhasil disimpan');
    }

    public function updateRombel(Request $request, $id){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $this->validate($request, [
            'tahun_rombel' => 'required',
        ], $message);

        $data = Rombel::find($id);
        $data->tahun_rombel = $request->tahun_rombel;
        $data->update();
        return redirect('/data-rombel')->with('success', 'Rombel berhasil diubah');;
    }

    public function deleteRombel($id){
        $data = Rombel::find($id);
        $data->delete();
        return redirect('/data-rombel')->with('success', 'Rombel berhasil dihapus');;
    }
// Kelas
    public function dataKelas(){
        
        $data = Kelas::select('kelas.*', 'guru.nama_lengkap AS wali_kelas', 'tahun_ajar.tahunAjar AS tahunPelajaran')
        ->leftJoin('guru', 'kelas.nip_guru', '=', 'guru.id')
        ->leftJoin('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
        ->paginate(5);

        $data1 = Guru::where('status','aktif')->get();

        $data2 = TahunAjar::all();
        
        return view('admin.data-kelas', [
            'data' => $data,
            'data1' => $data1,
            'data2' => $data2]);
    }

    public function cariKelas(Request $request)
    {
        $kataKunci = $request->input('q');
        
        // Lakukan pencarian kelas dengan menggabungkan tabel Kelas dengan Guru dan TahunAjar
        $hasilPencarian = Kelas::leftJoin('guru', 'kelas.nip_guru', '=', 'guru.id')
                                ->leftJoin('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
                                ->select('kelas.*', 'guru.nama_lengkap AS wali_kelas', 'tahun_ajar.tahunAjar AS tahunPelajaran', 'tahun_ajar.semester')
                                ->when($kataKunci, function ($query) use ($kataKunci) {
                                    $query->where('guru.nama_lengkap', 'LIKE', "%$kataKunci%");
                                })
                                ->paginate(5);
        
        // Ambil semua data guru
        $data1 = Guru::where('status','aktif')->get();
        
        // Ambil semua data tahun ajaran
        $data2 = TahunAjar::all();
        
        // Redirect dengan membawa data hasil pencarian, kata kunci, data guru, dan data tahun ajaran
        return view('admin.data-kelas', [
            'data' => $hasilPencarian,
            'kataKunci' => $kataKunci,
            'data1' => $data1,
            'data2' => $data2,
        ]);
    }
    
    
    public function tambahKelas(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
        ];

        $attributes = request()->validate([
            'nama_kelas' => 'required',
            'nip_guru' => 'required',
            'id_tahunAjar' => 'required',
            'bagian' => 'required',
        ], $message);
        
        $data = new Kelas;
        $data->nama_kelas = $request->nama_kelas;
        $data->bagian = $request->bagian;
        $data->nip_guru = $request->nip_guru;
        $data->id_tahunAjar = $request->id_tahunAjar;
        $data->save($attributes);
        return redirect('/data-kelas')->with('success', 'Kelas berhasil disimpan');
    }

    public function updateKelas(Request $request, $id){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
            'unique' => 'attribute sudah digunakan',
        ];

        $this->validate($request, [
            'nama_kelas' => 'required',
            'id_tahunAjar' => 'required',
            'bagian' => 'required',
            'nip_guru' => 'required',
        ], $message);

        $data = Kelas::find($id);
        $data->nama_kelas = $request->nama_kelas;
        $data->bagian = $request->bagian;
        $data->nip_guru = $request->nip_guru;
        $data->id_tahunAjar = $request->id_tahunAjar;
        $data->update();
        return redirect('/data-kelas')->with('success', 'Kelas berhasil diubah');;
    }

    public function deleteKelas($id){
        $data = Kelas::find($id);
        $data->delete();
        return redirect('/data-kelas')->with('success', 'Kelas berhasil dihapus');;
    }

    public function siswaKelas($id)
    {
        // Mengambil data pesanan berdasarkan ID

        $dataKelas = Kelas::find($id);
                            
        $data = Siswa::where('id_kelas', $id)
                            ->get();
        
        // Mengambil detail pesanan berdasarkan ID pesanan
        return view('admin.siswa-kelas', compact('data','dataKelas'));
    }


// Siswa
    public function dataSiswa(Request $request)
    {
        // Ambil data pencarian dari request jika ada
        $kataKunci = $request->input('q');

        // Jika ada kata kunci pencarian, lakukan pencarian, jika tidak, ambil semua data
        $data = Siswa::join('kelas', 'siswa.id_kelas', '=', 'kelas.id')
            ->join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
            ->join('rombel', 'siswa.id_rombel', '=', 'rombel.id')
            ->select('siswa.*', 'kelas.nama_kelas', 'kelas.bagian', 'rombel.tahun_rombel', 'tahun_ajar.tahunAjar')
            ->when($kataKunci, function ($query) use ($kataKunci) {
                $query->where('NISN', 'LIKE', "%$kataKunci%")
                    ->orWhere('nama_siswa', 'LIKE', "%$kataKunci%");
            })->get();

        $data1 = Kelas::join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
            ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
            ->get();

        $data2 = Rombel::all();

        return view('admin.data-siswa', [
            'data' => $data,
            'kataKunci' => $kataKunci,
            'data1' => $data1,
            'data2' => $data2,
        ]);
    }

    public function cariSiswa(Request $request)
    {
        // Redirect ke dataSiswa dengan kata kunci pencarian sebagai query string
        return redirect()->route('data-siswa-admin', ['q' => $request->input('q')]);
    }

    public function tambahSiswa(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $attributes = request()->validate([
            'NISN' => [
                'required',
                'max:50',
                'regex:/^[0-9]+$/',
                Rule::unique('siswa', 'NISN')
            ],
           'email' => ['required', 'max:50', Rule::unique('siswa', 'email')],
            'nama_siswa' => 'required',
            'id_kelas' => 'required',
            'id_rombel' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'asal_sekolah' => 'required',
            'nama_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'nama_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'no_telp' => 'required|regex:/^[0-9]+$/|min:11|max:15',
            'alamat' => 'required',
        ], $message);
        
        $data = new Siswa;
        $data->NISN = $request->NISN;
        $data->email = $request->email;
        $data->nama_siswa = $request->nama_siswa;
        $data->id_kelas = $request->id_kelas;
        $data->id_rombel = $request->id_rombel;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->asal_sekolah = $request->asal_sekolah;
        $data->nama_ayah = $request->nama_ayah;
        $data->pekerjaan_ayah = $request->pekerjaan_ayah;
        $data->nama_ibu = $request->nama_ibu;
        $data->pekerjaan_ibu = $request->pekerjaan_ibu;
        $data->no_telp = $request->no_telp;
        $data->alamat = $request->alamat;
        $data->status = 'aktif';
        $data->save($attributes);
        return redirect('/data-siswa')->with('success', 'Siswa berhasil disimpan');
    }

    public function updateSiswa(Request $request, $id){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $this->validate($request, [
            'nama_siswa' => 'required',
            'id_kelas' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'asal_sekolah' => 'required',
            'nama_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'nama_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'no_telp' => 'required|regex:/^[0-9]+$/|min:12|max:15',
            'alamat' => 'required',
            'status' => 'required',
        ], $message);

        $data = Siswa::find($id);
        $data->NISN = $request->NISN;
        $data->email = $request->email;
        $data->nama_siswa = $request->nama_siswa;
        $data->id_kelas = $request->id_kelas;
        $data->tempat_lahir = $request->tempat_lahir;
        $data->tgl_lahir = $request->tgl_lahir;
        $data->jenis_kelamin = $request->jenis_kelamin;
        $data->asal_sekolah = $request->asal_sekolah;
        $data->nama_ayah = $request->nama_ayah;
        $data->pekerjaan_ayah = $request->pekerjaan_ayah;
        $data->nama_ibu = $request->nama_ibu;
        $data->pekerjaan_ibu = $request->pekerjaan_ibu;
        $data->no_telp = $request->no_telp;
        $data->alamat = $request->alamat;
        $data->status = $request->status;
        $data->update();
        return redirect('/data-siswa')->with('success', 'Siswa berhasil diubah');;
    }

    public function deleteSiswa($id){
        $data = Siswa::find($id);
        $data->delete();
        return redirect('/data-siswa')->with('success', 'Siswa berhasil dihapus');;
    }

    public function siswaNaik(Request $request)
    {
        $kelas = Kelas::join('tahun_ajar','kelas.id_tahunAjar','=','tahun_ajar.id')
                        ->select('kelas.*','tahun_ajar.tahunAjar','kelas.id as id_kelas')
                        ->get();
        $data = collect(); // Kosongkan data siswa saat pertama kali membuka halaman
        $id_kelas = $request->id_kelas;

        // Jika ada pencarian
        if ($request->has('id_kelas')) {
            $data = Siswa::where('id_kelas', $id_kelas)->get();
        }

        return view('admin.naik-kelas', compact('data', 'kelas'));
    }

    public function searchSiswaNaik(Request $request)
    {
        return redirect()->route('naik-kelas', [
            'id_kelas' => $request->id_kelas,
        ]);
    }

    public function naikKelas(Request $request)
    {
        $siswa_ids = explode(',', $request->input('siswa_ids', ''));
        $id_kelas_baru = $request->input('id_kelas_baru');
    
        if ($id_kelas_baru && !empty($siswa_ids)) {
            Siswa::whereIn('id', $siswa_ids)->update(['id_kelas' => $id_kelas_baru]);
            return redirect()->route('naik-kelas')->with('success', 'Siswa berhasil naik kelas');
        }
    
        return redirect()->route('naik-kelas')->with('error', 'Pilih kelas baru dan siswa terlebih dahulu.');
    }
    
    

// Mapel
    public function dataMapel(Request $request)
    {
        $kataKunci = $request->input('q');

        // Mengambil data mapel dengan join ke tabel kurikulum, kelas, dan tahun ajar
        $data = Mapel::join('kurikulum', 'mapel.id_kurikulum', '=', 'kurikulum.id')
                    ->select('mapel.*', 'kurikulum.kode_kurikulum')
                    ->when($kataKunci, function ($query) use ($kataKunci) {
                        $query->where('mapel.nama_mapel', 'LIKE', "%$kataKunci%")
                            ->orWhere('kurikulum.kode_kurikulum', 'LIKE', "%$kataKunci%");
                    })
                    ->get();

        // Mengambil semua data kurikulum
        $data2 = Kurikulum::all();

        // Mengembalikan view dengan data hasil pencarian, data kelas, dan data kurikulum
        return view('admin.data-mapel', [
            'data' => $data,
            'kataKunci' => $kataKunci,
            'data2' => $data2,
        ]);
    }

    public function cariMapel(Request $request)
    {
        // Redirect ke route data-mapel dengan parameter pencarian
        return redirect()->route('data-mapel', ['q' => $request->input('q')]);
    }


    public function tambahMapel(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $attributes = request()->validate([
            'id_kurikulum' => 'required',
            'nama_mapel' => 'required',
            'nilai_kkm' => 'required',
            'kategori' => 'required',
            'kode' => ['required', 'max:10', Rule::unique('mapel', 'kode')],
        ], $message);
        
        $data = new Mapel;
        $data->kode = $request->kode;
        $data->id_kurikulum = $request->id_kurikulum;
        $data->nama_mapel = $request->nama_mapel;
        $data->nilai_kkm = $request->nilai_kkm;
        $data->kategori = $request->kategori;
        $data->save($attributes);
        return redirect('/data-mapel')->with('success', 'Mapel berhasil disimpan');
    }

    public function updateMapel(Request $request, $id){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $this->validate($request, [
            'id_kurikulum' => 'required',
            'nama_mapel' => 'required',
            'nilai_kkm' => 'required',
            'kategori' => 'required',
        ], $message);

        $data = Mapel::find($id);
        $data->id_kurikulum = $request->id_kurikulum;
        $data->kode = $request->kode;
        $data->nama_mapel = $request->nama_mapel;
        $data->nilai_kkm = $request->nilai_kkm;
        $data->kategori = $request->kategori;
        $data->update();
        return redirect('/data-mapel')->with('success', 'Mapel berhasil diubah');;
    }

    public function deleteMapel($id){
        $data = Mapel::find($id);
        $data->delete();
        return redirect('/data-mapel')->with('success', 'Mapel berhasil dihapus');;
    }

// kurikulum
    public function dataKurikulum()
    {
        // Get rombels with students count
        $data = Kurikulum::withCount('mapel')->paginate(5);
        
        return view('admin.data-kurikulum', ['data' => $data]);
    }

    public function cariKurikulum(Request $request)
    {
        $kataKunci = $request->input('q');
        $hasilPencarian = Kurikulum::when($kataKunci, function ($query) use ($kataKunci) {
            $query->where('kode_kurikulum', 'LIKE', "%$kataKunci%")
            ->orWhere('nama_kurikulum', 'LIKE', "%$kataKunci%");
        })->paginate(5);


        return view('admin.data-kurikulum', ['data' => $hasilPencarian, 'kataKunci' => $kataKunci]);
    }

    public function mapelKurikulum($id)
    {
        // Mengambil data pesanan berdasarkan ID

        $dataKurikulum = Kurikulum::find($id);
                            
        $data = Mapel::where('id_kurikulum', $id)
                            ->paginate(5);
        
        // Mengambil detail pesanan berdasarkan ID pesanan
        return view('admin.mapel-kurikulum', compact('data','dataKurikulum'));
    }

    public function tambahKurikulum(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $attributes = request()->validate([
            'kode_kurikulum' => 'required',
            'nama_kurikulum' => 'required',
        ], $message);
        
        $data = new Kurikulum;
        $data->kode_kurikulum = $request->kode_kurikulum;
        $data->nama_kurikulum = $request->nama_kurikulum;
        $data->save($attributes);
        return redirect('/data-kurikulum')->with('success', 'Kurikulum berhasil disimpan');
    }

    public function updateKurikulum(Request $request, $id){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $this->validate($request, [
            'kode_kurikulum' => 'required',
            'nama_kurikulum' => 'required',
        ], $message);

        $data = Kurikulum::find($id);
        $data->kode_kurikulum = $request->kode_kurikulum;
        $data->nama_kurikulum = $request->nama_kurikulum;
        $data->update();
        return redirect('/data-kurikulum')->with('success', 'Kurikulum berhasil diubah');;
    }

    public function deleteKurikulum($id){
        $data = Kurikulum::find($id);
        $data->delete();
        return redirect('/data-kurikulum')->with('success', 'Kurikulum berhasil dihapus');;
    }

//eskul
    public function dataEskul()
    {
        // Get rombels with students count
        $data = Eskul::paginate(5);
        
        return view('admin.data-eskul', ['data' => $data]);
    }

    public function cariEskul(Request $request)
    {
        $kataKunci = $request->input('q');
        $hasilPencarian = Eskul::when($kataKunci, function ($query) use ($kataKunci) {
            $query->where('nama_eskul', 'LIKE', "%$kataKunci%");
        })->paginate(5);

        return view('admin.data-eskul', ['data' => $hasilPencarian, 'kataKunci' => $kataKunci]);
    }

    public function tambahEskul(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $attributes = request()->validate([
            'nama_eskul' => 'required',
            'status' => 'required',
        ], $message);
        
        $data = new Eskul;
        $data->nama_eskul = $request->nama_eskul;
        $data->status = $request->status;
        $data->save($attributes);
        return redirect('/data-eskul-admin')->with('success', 'Eskul berhasil disimpan');
    }

    public function updateEskul(Request $request, $id){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $this->validate($request, [
            'nama_eskul' => 'required',
            'status' => 'required',
        ], $message);

        $data = Eskul::find($id);
        $data->nama_eskul = $request->nama_eskul;
        $data->status = $request->status;
        $data->update();
        return redirect('/data-eskul-admin')->with('success', 'Eskul berhasil diubah');;
    }

    public function deleteEskul($id){
        $data = Eskul::find($id);
        $data->delete();
        return redirect('/data-eskul-admin')->with('success', 'Eskul berhasil dihapus');;
    }

// wali murid akun
    public function akunWaliMurid()
    {
        // Get students who do not have a profile
        $data = Siswa::leftJoin('profile', 'siswa.NISN', '=', 'profile.nisn')
                    ->whereNull('profile.nisn')
                    ->select('siswa.*')
                    ->get();
        
        return view('admin.akun-waliMurid', ['data' => $data]);
    }

    public function buatAkunWali(Request $request)
    {
        $NISNs = explode(',', $request->NISN);
        $emails = explode(',', $request->email);
    
        foreach ($NISNs as $index => $NISN) {
            $email = $emails[$index];
    
            request()->validate([
                'email' => ['required', 'email', 'max:50', Rule::unique('users', 'email')],
            ]);
    
            $password = Str::random(8);
    
            $data1 = new User;
            $data1->name = $NISN;
            $data1->email = $email;
            $data1->password = bcrypt($password);
            $data1->level = "3";
            $data1->save();
    
            $data = new Profile;
            $data->id_user = $data1->id;
            $data->nisn = $NISN;
            $data->save();
    
            // Kirim email ke wali murid
            Mail::to($email)->send(new AkunWaliMail($NISN, $email, $password));
        }
    
        return redirect('/akun-waliMurid')->with('success', 'Akun berhasil dibuat dan email telah dikirim.');
    } 

// rekap nilai
public function rekapNilai(Request $request)
{
    // Ambil semua kelas
    $kelasData = Kelas::all();

    // Siapkan array untuk menyimpan rata-rata nilai per kelas
    $kelasNilai = [];
    $semester = $request->semester;

    if ($request->has('semester') && !empty($semester)) {
        foreach ($kelasData as $kelas) {
            // Ambil nilai untuk setiap kelas
            $nilai = Nilai::where('nilai.semester', $semester)
                ->where('nilai.id_kelas', $kelas->id)
                ->join('mapel', 'nilai.kode_mapel', '=', 'mapel.kode')
                ->select('nilai.*', 'mapel.nama_mapel')
                ->get();

            // Hitung rata-rata nilai per kelas
            $totalNilai = 0;
            $jumlahNilai = 0;

            foreach ($nilai as $dataNilai) {
                $rataRata = (
                    $dataNilai->tugas_1 +
                    $dataNilai->tugas_2 +
                    $dataNilai->tugas_3 +
                    $dataNilai->tugas_4 +
                    $dataNilai->uts +
                    $dataNilai->uas
                ) / 6;

                $totalNilai += $rataRata;
                $jumlahNilai++;
            }

            // Jika tidak ada nilai, hindari pembagian dengan nol
            $kelasNilai[$kelas->id] = $jumlahNilai > 0 ? $totalNilai / $jumlahNilai : 0;
        }
    }

    // Kirimkan data ke view
    return view('admin.rekap-nilai', ['kelasData' => $kelasData, 'kelasNilai' => $kelasNilai, 'semesterDipilih' => $request->has('semester') && !empty($semester)]);
}

public function cariRekapNilai(Request $request)
{
    return redirect()->route('rekap-nilai-admin', [
        'semester' => $request->semester,
    ]);
}


public function dataNilai($id_kelas, $semester)
{
    // Mengambil semua mata pelajaran
    $allMapel = Mapel::pluck('nama_mapel', 'kode');

    // Mengambil data nilai dengan join ke tabel mapel dan siswa
    $nilai = Nilai::where('nilai.id_kelas', $id_kelas)
                    ->where('nilai.semester', $semester)
                    ->join('mapel', 'nilai.kode_mapel', '=', 'mapel.kode')
                    ->join('siswa', 'nilai.nisn', '=', 'siswa.NISN')
                    ->select('nilai.*', 'mapel.nama_mapel', 'siswa.NISN', 'siswa.nama_siswa',
                        DB::raw('
                            LEFT(
                                ROUND(
                                    (
                                        COALESCE(nilai.tugas_1, 0) +
                                        COALESCE(nilai.tugas_2, 0) +
                                        COALESCE(nilai.tugas_3, 0) +
                                        COALESCE(nilai.tugas_4, 0) +
                                        COALESCE(nilai.uts, 0) +
                                        COALESCE(nilai.uas, 0)
                                    ) / 
                                    NULLIF(
                                        (
                                            CASE WHEN nilai.tugas_1 IS NOT NULL THEN 1 ELSE 0 END +
                                            CASE WHEN nilai.tugas_2 IS NOT NULL THEN 1 ELSE 0 END +
                                            CASE WHEN nilai.tugas_3 IS NOT NULL THEN 1 ELSE 0 END +
                                            CASE WHEN nilai.tugas_4 IS NOT NULL THEN 1 ELSE 0 END +
                                            CASE WHEN nilai.uts IS NOT NULL THEN 1 ELSE 0 END +
                                            CASE WHEN nilai.uas IS NOT NULL THEN 1 ELSE 0 END
                                        ), 0
                                    ) * 10, 0
                                ), 2
                            ) as rata_rata')
                    )
                    ->get();

    // Mengelompokkan nilai berdasarkan siswa dan menghitung rata-rata keseluruhan
    $nilaiPerSiswa = $nilai->groupBy('nisn')->map(function ($groupedNilai) use ($allMapel) {
        $rataRataMapel = $allMapel->mapWithKeys(function ($mapel, $kode_mapel) use ($groupedNilai) {
            $nilaiMapel = $groupedNilai->where('kode_mapel', $kode_mapel)->first();
            return [$mapel => $nilaiMapel ? (int)round((
                $nilaiMapel->tugas_1 +
                $nilaiMapel->tugas_2 +
                $nilaiMapel->tugas_3 +
                $nilaiMapel->tugas_4 +
                $nilaiMapel->uts +
                $nilaiMapel->uas
            ) / 6) : 0];
        });

        $rataRataKeseluruhan = (int)round($rataRataMapel->avg());

        return [
            'nama_siswa' => $groupedNilai->first()->nama_siswa,
            'nilai_mapel' => $rataRataMapel,
            'rata_rata_keseluruhan' => $rataRataKeseluruhan
        ];
    });

    // Menghitung rata-rata antar mapel
    $rataRataPerMapel = $nilai->groupBy('kode_mapel')->map(function ($groupedNilai) {
        return (int)round($groupedNilai->avg('rata_rata'));
    });

    return view('admin.data-nilai', compact('nilaiPerSiswa', 'allMapel', 'rataRataPerMapel'));
}





}
