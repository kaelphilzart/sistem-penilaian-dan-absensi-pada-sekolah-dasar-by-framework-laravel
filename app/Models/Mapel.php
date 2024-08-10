<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;
    protected $table = 'mapel';
    protected $primaryKey = 'id';
    protected $fillable = ['id_kelas','nama_mapel','nilai_kkm','kategori'];
    
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
    
    public function guru()
    {
        return $this->hasOne(Guru::class, 'kode_mapel'); // Sesuaikan dengan kolom kunci asing yang digunakan
    }

    public function raport()
    {
        return $this->hasOne(Raport::class, 'kodes'); // Sesuaikan dengan kolom kunci asing yang digunakan
    }
}
