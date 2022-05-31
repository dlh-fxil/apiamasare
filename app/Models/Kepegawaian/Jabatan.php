<?php

namespace App\Models\Kepegawaian;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "jabatan";
    public $timestamps = false;
    protected $fillable = ['jenis', 'nama', 'kelas', 'singkatan'];

    public function uraianTugas()
    {
        return $this->hasMany(UraianTugas::class);
    }
}
