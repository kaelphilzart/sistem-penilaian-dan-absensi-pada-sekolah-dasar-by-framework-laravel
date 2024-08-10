<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;
    protected $table = 'rombel';
    protected $primaryKey = 'id';
    protected $fillable = ['tahun_rombel'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_rombel', 'id');
    }
    
}
