<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EskulSiswa extends Model
{
    use HasFactory;
    protected $table = 'eskul_siswa';
    protected $primaryKey = 'id';
    protected $fillable = ['nisn', 'id_kelas','semester', 'id_eskul','predikat','keterangan'];
}
