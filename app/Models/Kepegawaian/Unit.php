<?php

namespace App\Models\Kepegawaian;

// use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "unit";
    public $timestamps = false;
    protected $fillable = ['nama', 'singkatan', 'jenis', 'uraian_tugas_fungsi', 'file_path'];
    // protected $appends = ['can', 'imageUrl'];

    public function subUnit()
    {
        return $this->hasMany(SubUnit::class);
    }
}
