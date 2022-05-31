<?php

namespace App\Models\Kegiatan;

use App\Models\User;
use App\Models\Kepegawaian\Unit;
use App\Models\Kegiatan\ItemKegiatan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramKegiatan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "program_kegiatan";
    protected $fillable =  [
        'type',
        'kode_urusan',
        'kode_bidang_urusan',
        'kode_program',
        'kode_kegiatan',
        'kode_sub_kegiatan',
        'nomenklatur',
        'kinerja',
        'indikator',
        'tahun_anggaran',
        'biaya',
        'target_waktu_pelaksanaan',
        'target_jumlah_hasil',
        'satuan',
        'target_waktu_pelaksanaan',
        'progress',
        'unit_id',
        'id_program',
        'id_kegiatan',
        'created_by',
        'selesai',
    ];
    public function program()
    {
        return $this->belongsTo(ProgramKegiatan::class, 'id_program');
    }
    public function kegiatan()
    {
        return $this->belongsTo(ProgramKegiatan::class, 'id_kegiatan');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function units()
    {
        return $this->morphedByMany(Unit::class, 'kegiatanable');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    // public function itemKegiatan()
    // {
    //     return $this->belongsTo(ItemKegiatan::class);
    // }
}
