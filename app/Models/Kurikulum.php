<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    protected $table = 'kurikulum';
    protected $primaryKey = 'id';
    protected $fillable = ['kode_kurikulum','nama_kurikulum'];

    public function mapel()
    {
        return $this->hasMany(Mapel::class, 'id_kurikulum', 'id');
    }
}
