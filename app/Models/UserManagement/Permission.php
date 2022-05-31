<?php

namespace App\Models\UserManagement;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermissionModel;

class Permission extends SpatiePermissionModel
{
    use  SoftDeletes;
    protected $fillable = ['name', 'description', 'group', 'guard_name'];
    protected $guarded = [];
    protected $hidden = ['pivot'];
    // protected $appends = ['can'];
}
