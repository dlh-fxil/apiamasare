<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Kepegawaian\Unit;
use App\Models\Kepegawaian\Jabatan;
use App\Models\Kepegawaian\Pangkat;
use App\Models\Kepegawaian\SubUnit;
use App\Models\Kepegawaian\ItemKegiatan;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email_verified_at',
        'email',
        'eselon',
        'jabatan_id',
        'jenis_pegawai',
        'name',
        'nip',
        'no_hp',
        'no_wa',
        'pangkat_id',
        'password',
        'sub_unit_id',
        'unit_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAllPermissionsAttribute()
    {
        // return $this->getAllPermissions()->mapWithKeys(function ($pr) {
        //     return [$pr['name'] => true];
        // });
        return $this->getAllPermissions()->pluck('name');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(250);
        // $this->addMediaConversion('medium')
        //     ->width(800);
        // ->height(800);
        // ->sharpen(10);
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('google')
            ->singleFile();
    }


    public function pangkat()
    {
        return $this->belongsTo(Pangkat::class);
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function subUnit()
    {
        return $this->belongsTo(SubUnit::class);
    }

    public function kegiatan()
    {
        return $this->morphToMany(ItemKegiatan::class, 'kegiatanable');
    }
}
