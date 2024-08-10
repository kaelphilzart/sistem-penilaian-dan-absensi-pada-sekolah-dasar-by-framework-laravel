<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\WaliMuridController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GuruMapelController;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::get('/coba/{kode_mapel}', [AdminController::class, 'coba']);
Route::get('login', [SessionController::class, 'login'])-> name('login');
Route::get('register', [SessionController::class, 'register'])-> name('register');
Route::post('buat-akun', [SessionController::class, 'createUser'])-> name('buat-akun');
Route::post('login-akun', [SessionController::class, 'login_akun'])->name('login-akun');
Route::middleware(['auth'])->group(function () {
    // Rute untuk pengguna dengan tingkat 'admin'

    Route::get('coba', [AdminController::class, 'coba'])-> name('coba');

    Route::middleware(['admin'])->group(function () {

        Route::get('dashboard_admin', [AdminController::class, 'dashboard'])-> name('dashboard_admin');
        Route::get('logout-admin', [SessionController::class, 'destroyAdmin'])->name('logout-admin');
        Route::get('data-user', [AdminController::class, 'dataUser'])-> name('data-user');
        Route::post('create-user', [AdminController::class, 'createUser'])-> name('create-user');
        Route::post('/user/update/{id}', [AdminController::class, 'updateUser']) -> name('update-user');
        Route::post('/user/delete/{id}', [AdminController::class, 'deleteUser']) -> name('delete-user');
        Route::get('/user/cari', [AdminController::class, 'cariUser'])->name('user-cari');

// Guru
        Route::get('data-guru', [AdminController::class, 'dataGuru'])-> name('data-guru');
        Route::post('tambah-guru', [AdminController::class, 'tambahGuru'])-> name('tambah-guru');
        Route::post('/guru/update/{id}', [AdminController::class, 'updateGuru']) -> name('update-guru');
        Route::post('/guru/delete/{id}', [AdminController::class, 'deleteGuru']) -> name('delete-guru');
        Route::get('/guru/cari', [AdminController::class, 'cariGuru'])->name('guru-cari');

        Route::get('wali-kelas', [AdminController::class, 'waliKelas'])->name('wali-kelas');
        Route::post('ganti-waliKelas', [AdminController::class, 'gantiWaliKelas'])-> name('ganti-waliKelas');

        Route::get('status-guru', [AdminController::class, 'statusGuru'])->name('status-guru');
        Route::post('/nonaktifkan/{id}', [AdminController::class, 'nonaktifkan']) -> name('nonaktifkan');

        Route::get('data-guruMapel', [AdminController::class, 'dataGuruMapel'])-> name('data-guruMapel');
        Route::post('/tambah-guruMapel', [AdminController::class, 'tambahGuruMapel'])->name('tambah-guruMapel');

        Route::get('/get-available-classes/{kode_mapel}', [AdminController::class, 'getAvailableClasses']);
        Route::post('/delete-guruMapel/{id}', [AdminController::class, 'deleteGuruMapel'])->name('delete-guruMapel');


// Tahun Ajaran
        Route::get('data-tahun', [AdminController::class, 'dataTahun'])-> name('data-tahun');
        Route::post('tambah-tahun', [AdminController::class, 'tambahTahun'])-> name('tambah-tahun');
        Route::post('/tahun/update/{id}', [AdminController::class, 'updateTahun']) -> name('update-tahun');
        Route::post('/tahun/delete/{id}', [AdminController::class, 'deleteTahun']) -> name('delete-tahun');

// Kelas
        Route::get('data-kelas', [AdminController::class, 'dataKelas'])-> name('data-kelas');
        Route::post('tambah-kelas', [AdminController::class, 'tambahKelas'])-> name('tambah-kelas');
        Route::post('/kelas/update/{id}', [AdminController::class, 'updateKelas']) -> name('update-kelas');
        Route::post('/kelas/delete/{id}', [AdminController::class, 'deleteKelas']) -> name('delete-kelas');
        Route::get('/siswa/kelas/{id}', [AdminController::class, 'siswaKelas']) -> name('siswa-kelas');
        Route::get('/kelas/cari', [AdminController::class, 'cariKelas'])->name('kelas-cari');

// Siswa
        Route::get('data-siswa-admin', [AdminController::class, 'dataSiswa'])-> name('data-siswa-admin');
        Route::post('tambah-siswa', [AdminController::class, 'tambahSiswa'])-> name('tambah-siswa');
        Route::post('/siswa/update/{id}', [AdminController::class, 'updateSiswa']) -> name('update-siswa');
        Route::post('/siswa/delete/{id}', [AdminController::class, 'deleteSiswa']) -> name('delete-siswa');
        Route::get('/siswa/cari', [AdminController::class, 'cariSiswa'])->name('siswa-cari');

        Route::get('naik-kelas', [AdminController::class, 'siswaNaik'])->name('naik-kelas');
        Route::get('cari-naik-kelas', [AdminController::class, 'searchSiswaNaik'])->name('cari-naik-kelas');
        Route::post('siswa-naik-kelas', [AdminController::class, 'naikKelas'])-> name('siswa-naik-kelas');

// Rombel
        Route::get('data-rombel', [AdminController::class, 'dataRombel'])-> name('data-rombel');
        Route::post('tambah-rombel', [AdminController::class, 'tambahRombel'])-> name('tambah-rombel');
        Route::post('/rombel/update/{id}', [AdminController::class, 'updateRombel']) -> name('update-rombel');
        Route::post('/rombel/delete/{id}', [AdminController::class, 'deleteRombel']) -> name('delete-rombel');
        Route::get('/siswa/rombel/{id}', [AdminController::class, 'siswaRombel']) -> name('siswa-rombel');
        Route::get('/rombel/cari', [AdminController::class, 'cariRombel'])->name('rombel-cari');

// mapel
        Route::get('data-mapel', [AdminController::class, 'dataMapel'])-> name('data-mapel');
        Route::post('tambah-mapel', [AdminController::class, 'tambahMapel'])-> name('tambah-mapel');
        Route::post('/mapel/update/{id}', [AdminController::class, 'updateMapel']) -> name('update-mapel');
        Route::post('/mapel/delete/{id}', [AdminController::class, 'deleteMapel']) -> name('delete-mapel');
        Route::get('/mapel/cari', [AdminController::class, 'cariMapel'])->name('mapel-cari');

// Kurikulum
        Route::get('data-kurikulum', [AdminController::class, 'dataKurikulum'])-> name('data-kurikulum');
        Route::post('tambah-kurikulum', [AdminController::class, 'tambahKurikulum'])-> name('tambah-kurikulum');
        Route::post('/kurikulum/update/{id}', [AdminController::class, 'updateKurikulum']) -> name('update-kurikulum');
        Route::post('/kurikulum/delete/{id}', [AdminController::class, 'deleteKurikulum']) -> name('delete-kurikulum');
        Route::get('/mapel/kurikulum/{id}', [AdminController::class, 'mapelKurikulum']) -> name('mapel-kurikulum');
        Route::get('/kurikulum/cari', [AdminController::class, 'cariKurikulum'])->name('kurikulum-cari');


// eskul
        Route::get('data-eskul-admin', [AdminController::class, 'dataEskul'])-> name('data-eskul-admin');
        Route::post('tambah-eskul', [AdminController::class, 'tambahEskul'])-> name('tambah-eskul');
        Route::post('/estrakulikuler/update/{id}', [AdminController::class, 'updateEskul']) -> name('update-estrakulikuler');
        Route::post('/eskul/delete/{id}', [AdminController::class, 'deleteEskul']) -> name('delete-eskul');
        Route::get('/eskul/cari', [AdminController::class, 'cariEskul'])->name('eskul-cari');
        
//buat akun wali murid
        Route::get('akun-waliMurid', [AdminController::class, 'akunWaliMurid'])-> name('akun-waliMurid');
        Route::post('buat-akun-wali', [AdminController::class, 'buatAkunWali'])-> name('buat-akun-wali');
        Route::get('rekap-nilai-admin', [AdminController::class, 'rekapNilai'])-> name('rekap-nilai-admin');
        Route::get('/cari-rekapNilai', [AdminController::class, 'cariRekapNilai'])->name('cari-rekapNilai');
        Route::get('/data/nilai/{id_kelas}/{semester}', [AdminController::class, 'dataNilai']) -> name('data-nilai-admin');
  
    });

    Route::middleware(['guru'])->group(function () {

                Route::middleware(['checkGuru:wali_kelas'])->group(function () {
                        Route::get('dashboard_guru_waliKelas', [GuruController::class, 'dashboard'])-> name('dashboard_guru_waliKelas');
                        Route::get('logout-guru', [SessionController::class, 'destroyGuru'])->name('logout-guru');
                
                        Route::get('absen', [GuruController::class, 'dataAbsen'])->name('absen');
                        Route::get('/cari-absen', [GuruController::class, 'searchAbsen'])->name('cari-absen');
                        Route::post('input-absen', [GuruController::class, 'inputAbsen'])-> name('input-absen');
                        Route::post('/absen/update/{id}', [GuruController::class, 'updateAbsen']) -> name('update-absen');
                
                        Route::get('/get-mapel/{id_kelas}', [GuruController::class, 'getMapelKelas']);
                
                        Route::get('data-siswa', [GuruController::class, 'dataSiswa'])->name('data-siswa');
                        Route::get('/cari-siswa', [GuruController::class, 'searchSiswa'])->name('cari-siswa');
                
                // nilai
                        Route::get('isi-nilai', [GuruController::class, 'isiNilai'])->name('isi-nilai');
                        Route::get('/cari-isi-nilai', [GuruController::class, 'searchIsiNilai'])->name('cari-isi-nilai');
                        Route::get('/data/nilaiWali/{nisn}/{id_kelas}/{semester}', [GuruController::class, 'dataNilai']) -> name('data-nilai-wali');
                        Route::post('input-nilai', [GuruController::class, 'inputNilai'])-> name('input-nilai');
                        Route::post('/nilai/update/{id}', [GuruController::class, 'updateNilai']) -> name('update-nilai');
                        Route::get('/cari-data-nilai', [GuruController::class, 'searchDataNilai'])->name('cari-data-nilai');
                        Route::post('import-nilai', [GuruController::class, 'importNilai'])-> name('import-nilai');
                
                // eskul
                        Route::get('isi-eskul', [GuruController::class, 'isiEskul'])->name('isi-eskul');
                        Route::get('/cari-isi-eskul', [GuruController::class, 'searchIsiEskul'])->name('cari-isi-eskul');
                        Route::get('/data/eskul/{nisn}/{id_kelas}/{semester}', [GuruController::class, 'dataEskul']) -> name('data-eskul');
                        Route::post('input-eskul', [GuruController::class, 'inputEskul'])-> name('input-eskul');
                        Route::post('/eskul/update/{id}', [GuruController::class, 'updateNilaiEskul']) -> name('update-nilai-eskul');
                
                //rekap nilai
                        Route::get('rekap-nilai', [GuruController::class, 'rekapNilaiSiswa'])->name('rekap-nilai');
                        Route::get('/cari-rekap-nilai', [GuruController::class, 'searchRekapNilaiSiswa'])->name('cari-rekap-nilai');
                        Route::get('/lihat/rekap/{id_siswa}/{id_kelas}', [GuruController::class, 'lihatRekap']) -> name('lihat-rekap');
                
                // skrining
                        Route::get('skrining', [GuruController::class, 'skriningSiswa'])->name('skrining');
                        Route::get('/cari-skrining-siswa', [GuruController::class, 'searchSkriningSiswa'])->name('cari-skrining-siswa');
                        Route::post('isi-skrining', [GuruController::class, 'isiSkrining'])-> name('isi-skrining');
                        Route::post('/skrining/update/{id}', [GuruController::class, 'updateSkrining']) -> name('update-skrining');
                        Route::get('/data/skrining/{nisn}', [GuruController::class, 'dataSkrining']) -> name('data-skrining');
                        Route::post('import-skrining', [GuruController::class, 'importSkrining'])-> name('import-skrining');
                
                // raport
                        Route::get('raport-siswa', [GuruController::class, 'raportSiswa'])->name('raport-siswa');
                        Route::get('/cari-raport-siswa', [GuruController::class, 'searchRaportSiswa'])->name('cari-raport-siswa');
                        Route::get('/lihat/kompetensi/{id_siswa}/{id_kelas}', [GuruController::class, 'lihatRaport']) -> name('lihat-kompetensi');
                        Route::post('input-raport', [GuruController::class, 'inputRaport'])-> name('input-raport');
                        Route::post('/raport/update/{id}', [GuruController::class, 'updateRaport']) -> name('update-raport');
                        Route::post('import-kompetensi', [GuruController::class, 'importKompetensi'])-> name('import-kompetensi');
                        Route::get('/siswa/kompetensi/{nisn}/{id_kelas}/{semester}', [GuruController::class, 'dataRaport']) -> name('siswa-kompetensi');
                
                //cetak raport
                        Route::get('cetak-raport', [GuruController::class, 'cetakRaport'])->name('cetak-raport');
                        Route::get('/cari-cetak-raport', [GuruController::class, 'searchCetakRaport'])->name('cari-cetak-raport');
                        Route::get('/lihat/cetak-raport/{nisn}/{id_kelas}/{semester}', [GuruController::class, 'lihatCetakRaport']) -> name('lihat-cetak-raport');
                
                        Route::get('/review-raport/{nisn}/{id_kelas}/{semester}', [GuruController::class, 'reviewRaport'])->name('review-raport');
                        Route::get('/download-raport/{nisn}/{id_kelas}/{semester}', [GuruController::class, 'downloadRaport'])->name('download-raport');

                        Route::get('/download-template', [GuruController::class, 'downloadTemplate'])->name('download-template');
                            
            });
        
                Route::middleware(['checkGuru:guru_mapel'])->group(function () {
                        Route::get('dashboard_guru_mapel', [GuruMapelController::class, 'dashboard'])-> name('dashboard_guru_mapel');
                        Route::get('data-siswa-guru-mapel', [GuruMapelController::class, 'dataSiswa'])->name('data-siswa-guru-mapel');
                        Route::get('/cari-siswa-guru-mapel', [GuruMapelController::class, 'searchSiswa'])->name('cari-siswa-guru-mapel');

                        Route::get('absen-guru-mapel', [GuruMapelController::class, 'dataAbsen'])->name('absen-guru-mapel');
                        Route::get('/cari-absen-guru-mapel', [GuruMapelController::class, 'searchAbsen'])->name('cari-absen-guru-mapel');
                        Route::post('input-absen-guru-mapel', [GuruMapelController::class, 'inputAbsen'])-> name('input-absen-guru-mapel');
                        Route::post('/absen-guru-mapel/update/{id}', [GuruMapelController::class, 'updateAbsen']) -> name('update-absen-guru-mapel');
                        Route::get('/get-mapel/{id_kelas}', [GuruMapelController::class, 'getMapelKelas']);

                        Route::get('isi-nilai-guru-mapel', [GuruMapelController::class, 'isiNilai'])->name('isi-nilai-guru-mapel');
                        Route::get('/cari-isi-nilai-guru-mapel', [GuruMapelController::class, 'searchIsiNilai'])->name('cari-isi-nilai-guru-mapel');
                        Route::post('import-nilai-guru-mapel', [GuruMapelController::class, 'importNilai'])-> name('import-nilai-guru-mapel');
                        Route::get('/data/nilai/{nisn}/{id_kelas}/{semester}', [GuruMapelController::class, 'dataNilai']) -> name('data-nilai');

                        Route::get('/download-template-mapel/{id_kelas}', [GuruMapelController::class, 'downloadTemplate'])->name('download-template-mapel');

            });
    
     
      
    });

    Route::middleware(['waliMurid'])->group(function () {
    
        Route::get('dashboard_waliMurid', [WaliMuridController::class, 'dashboard'])-> name('dashboard_waliMurid');
        Route::get('logout-waliMurid', [SessionController::class, 'destroyWaliMurid'])->name('logout-waliMurid');

        Route::get('isi-profile', [WaliMuridController::class, 'isiProfile'])->name('isi-profile');
        Route::get('profile', [WaliMuridController::class, 'profile'])->name('profile');
        Route::post('input-profile', [WaliMuridController::class, 'inputProfile']) -> name('input-profile');

        Route::get('raport', [WaliMuridController::class, 'raport'])->name('raport');
        Route::get('/lihat-raport/{nisn}/{id_kelas}/{semester}', [WaliMuridController::class, 'showRaport'])->name('lihat-raport');
        
        Route::get('pengaturan-akun', [WaliMuridController::class, 'pengaturanAkun'])->name('pengaturan-akun');
        Route::post('ubah-user', [WaliMuridController::class, 'ubahUser']) -> name('ubah-user');

      
      
    });
    
});