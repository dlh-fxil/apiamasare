<?php

namespace App\Models\Kepegawaian;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubUnit extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "sub_unit";

    public $timestamps = false;
    protected $fillable = ['nama', 'singkatan', 'unit_id', 'jenis'];


    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
