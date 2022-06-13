<?php

namespace App\Models\Kegiatan;

use App\Models\User;
use App\Models\Kepegawaian\Unit;
use App\Models\Kepegawaian\UraianTugas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemKegiatan extends Model
{
    use HasFactory;
    protected $casts = [
        'mulai' => 'datetime',
        'selesai' => 'datetime',
    ];
    protected $table = "item_kegiatan";
    protected $fillable =  [
        'judul',
        'tanggal',
        'tahun',
        'uraian',
        'program_kegiatan_id',
        'mulai',
        'selesai',
        'created_by',
        'unit_id'
    ];



    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function programKegiatan()
    {
        return $this->belongsTo(ProgramKegiatan::class);
    }

    public function uraianTugas()
    {
        return $this->morphedByMany(UraianTugas::class, 'kegiatanable');
    }

    public function users()
    {
        return $this->morphedByMany(User::class, 'kegiatanable');
    }

    public function units()
    {
        return $this->morphedByMany(Unit::class, 'kegiatanable');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function userHasUraianTugas()
    {
        return $this->morphedByMany(UserHasUraianTugas::class,'kegiatanable');
    }
  
}
