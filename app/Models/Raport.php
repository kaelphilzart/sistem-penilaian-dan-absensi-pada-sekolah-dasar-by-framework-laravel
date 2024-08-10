<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raport extends Model
{
    use HasFactory;
    protected $table = 'raport';
    protected $primaryKey = 'id';
    protected $fillable = ['nisn','id_kelas','semester','kode_mapel','kompetensi'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'kode_mapel','kode');
    }
    // public function nilai()
    // {
    //     return $this->belongsTo(Nilai::class, 'id_nilai');
    // }
}
