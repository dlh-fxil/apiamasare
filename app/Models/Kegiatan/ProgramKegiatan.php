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
        'realisasi_biaya',
        'target_biaya',
        'target_waktu_pelaksanaan',
        'target_jumlah_hasil',
        'realisasi_jumlah_hasil',
        'satuan',
        'target_waktu_pelaksanaan',
        'unit_id',
        'id_program',
        'id_kegiatan',
        'created_by',
        'selesai',
    ];
    protected $append = ['status'];
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


    public function getStatusAttribute()
    {

        $status = 0;
        if ($this->type == 'subKegiatan' && $this->selesai) {
            $status = 100;
        } elseif ($this->type == 'kegiatan') {
            $total = ProgramKegiatan::where('type', 'subKegiatan')->where('id_kegiatan', $this->id)->count();
            $selesai = ProgramKegiatan::where('type', 'subKegiatan')->where('id_kegiatan', $this->id)->where('selesai', 1)->count();
            if ($total > 0) {
                $status = round($selesai / $total * 100, 2);
            }
        } elseif ($this->type == 'program') {
            $total = ProgramKegiatan::where('type', 'subKegiatan')->where('id_program', $this->id)->count();
            $selesai = ProgramKegiatan::where('type', 'subKegiatan')->where('id_program', $this->id)->where('selesai', 1)->count();
            if ($total > 0) {
                $status = round($selesai / $total * 100, 2);
            }
        }
        return $status;
    }

    public function itemKegiatan()
    {
        return $this->hasMany(ItemKegiatan::class);
    }
}
