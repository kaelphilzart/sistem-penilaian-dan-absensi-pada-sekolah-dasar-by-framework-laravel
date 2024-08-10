<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'Guru';
    protected $primaryKey = 'id';
    protected $fillable = ['nip','id_user', 'jenis_guru', 'kode_mapel', 'kelas', 'id_mapel','nama_lengkap','tempat_lahir', 'tgl_lahir', 'jenis_kelamin', 'no_tlp', 'alamat','golongan',
                            'jabatan','status'];

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'nip_guru'); // Sesuaikan dengan kolom kunci asing yang digunakan
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id_user');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'kode_mapel', 'kode');
    }

   

}

