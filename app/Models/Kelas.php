<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_kelas','bagian','id_guru','id_tahunAjar'];

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'id_tahunAjar', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'nip_guru', 'id');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'id_kelas'); // Sesuaikan dengan kolom kunci asing yang digunakan
    }

    public function mapel()
    {
        return $this->hasOne(Mapel::class, 'id_kelas'); // Sesuaikan dengan kolom kunci asing yang digunakan
    }

    public function skrining()
    {
        return $this->hasOne(Skrining::class, 'id_kelas'); // Sesuaikan dengan kolom kunci asing yang digunakan
    }
}
