<?php

namespace App\Models\Kepegawaian;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pangkat extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;
    protected $table = "pangkat";
    protected $fillable = ['nama_pangkat', 'golongan', 'ruang'];
}
