<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eskul extends Model
{
    use HasFactory;
    protected $table = 'eskul';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_eskul', 'status'];
}
