<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    protected $fillable = ['NISN','email','nama_siswa','id_kelas', 'id_rombel' ,'tempat_lahir','tgl_lahir',
                          'jenis_kelamin','asal_sekolah','nama_ayah','pekerjaan_ayah',
                           'nama_ibu','pekerjaan_ibu','no_telp','alamat','status'];


    public function absensi()
    {
    return $this->hasMany(Absen::class, 'id_siswa', 'id');
    }

    
}


