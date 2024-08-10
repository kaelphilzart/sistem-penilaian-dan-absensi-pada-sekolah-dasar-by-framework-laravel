<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skrining extends Model
{
    use HasFactory;
    protected $table = 'skrining';
    protected $primaryKey = 'id';
    protected $fillable = ['nisn','id_kelas', 'semester','tinggi_badan','berat_badan','pendengaran','penglihatan','gigi'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
}
