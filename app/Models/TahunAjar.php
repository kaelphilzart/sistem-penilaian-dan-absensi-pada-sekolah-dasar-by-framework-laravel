<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjar extends Model
{
    use HasFactory;
    protected $table = 'tahun_ajar';
    protected $primaryKey = 'id';
    protected $fillable = ['tahunAjar','semester'];

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'id_tahunAjar'); // Sesuaikan dengan kolom kunci asing yang digunakan
    }
}
