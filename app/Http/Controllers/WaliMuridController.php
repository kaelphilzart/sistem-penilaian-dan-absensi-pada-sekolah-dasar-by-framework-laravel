<?php

namespace App\Http\Controllers;

use App\Models\Profile;
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
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PDF; 
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class WaliMuridController extends Controller
{
    //
    public function dashboard(){
        return view('wali_murid.dashboard');
    }

    public function isiProfile(){
        return view('wali_murid.isi-profile');
    }

    public function profile(){
        // Mengambil ID user yang sedang login
        $id_user = auth()->user()->id;
    
       
        $siswa = Profile::join('users', 'profile.id_user', '=', 'users.id')
                            ->where('users.id', $id_user)
                            ->join('siswa','profile.nisn','=','siswa.NISN')
                            ->select('siswa.*')
                            ->first();
    
      
        if(!$siswa){
        
            return view('wali_murid.isi-profile');
        }
    
      
        return view('wali_murid.profile', compact('siswa'));
    }

    public function inputProfile(Request $request){
        //validasi form
        $message= [
            'required' =>':attribute tidak boleh kosong',
        ];

        $attributes = request()->validate([
           'nisn' => ['required', 'max:50', Rule::unique('profile', 'nisn')],
        ], $message);
        
        $id_user = auth()->user()->id;

        $data = new Profile;
        $data->id_user = $id_user;
        $data->nisn = $request->nisn;
        $data->save($attributes);
        return redirect('/dashboard_waliMurid')->with('success', 'karyawab berhasil disimpan');
    }

    public function raport()
    {
        // Mengambil ID user yang sedang login
        $id_user = auth()->user()->id;
    
        $nisn = Profile::where('id_user', $id_user)->value('nisn');
        
        // Mengambil kelas berdasarkan NISN pada tabel nilai dan hanya menampilkan satu kelas jika nilai.id_kelas sama
        $kelas = Kelas::join('nilai', 'kelas.id', '=', 'nilai.id_kelas')
                      ->join('tahun_ajar', 'kelas.id_tahunAjar', '=', 'tahun_ajar.id')
                      ->where('nilai.nisn', $nisn)
                      ->select('kelas.*', 'tahun_ajar.tahunAjar', 'kelas.id as id_kelas')
                      ->distinct()
                      ->get();
        
        $anak = Siswa::join('profile', 'siswa.NISN', '=', 'profile.nisn')
                     ->join('users', 'profile.id_user', '=', 'users.id')
                     ->where('users.id', $id_user)
                     ->select('siswa.*')
                     ->first();
        
        if (!$anak) {
            return view('wali_murid.isi-profile');
        }
        
        return view('wali_murid.raport', compact('kelas', 'anak'));
    }
    
    
    public function showRaport($nisn, $id_kelas, $semester)
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
    
    public function pengaturanAkun(){
        // Mengambil ID user yang sedang login
        $id_user = auth()->user()->id;
    
       
        $user = Profile::join('users', 'profile.id_user', '=', 'users.id')
                            ->where('users.id', $id_user)
                            ->select('users.*','profile.nisn')
                            ->first();
    
      
        return view('wali_murid.pengaturan-akun', compact('user'));
    }

    public function ubahUser(Request $request){
        $id_user = auth()->user()->id;

        $data = User::find($id_user);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = $request->password;
        $data->update();
        return redirect('/dashboard_waliMurid')->with('success', 'berhasil memperbarui akun');
    }
    
}
