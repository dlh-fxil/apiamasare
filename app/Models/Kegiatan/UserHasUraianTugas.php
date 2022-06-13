<?php

namespace App\Models\Kegiatan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kepegawaian\UraianTugas;
class UserHasUraianTugas extends Model
{
    use HasFactory;
    protected $table = "user_has_uraian_tugas";
    protected $touches = ['kegiatan'];
    protected $fillable =  [
        'user_id',
        'uraian_tugas_id',
    ];
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uraianTugas()
    {
        return $this->belongsTo(UraianTugas::class);
    }
    public function kegiatan()
    {
        return $this->morphToMany(ItemKegiatan::class, 'kegiatanable');
    }


}
