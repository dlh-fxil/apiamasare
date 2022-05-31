<?php

namespace App\Models\Kepegawaian;

use App\Models\Kegiatan\ItemKegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UraianTugas extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "uraian_tugas";
    protected $fillable = [
        'jabatan_id',
        'jenis_tugas',
        'uraian_tugas',
        'indikator',
        'angka_kredit',
        'keterangan',
        'created_by',
    ];
    public function jabatan()
    {
        return $this->belongsToMany(Jabatan::class);
    }
    public function kegiatan()
    {
        return $this->morphToMany(ItemKegiatan::class, 'kegiatanable');
    }
}
