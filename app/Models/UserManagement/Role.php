<?php

namespace App\Models\UserManagement;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRoleModel;

class Role extends SpatieRoleModel
{
    use  SoftDeletes;
    protected $fillable = ['name', 'guard_name', 'description', 'level'];
    protected $guarded = ['id'];
    // protected $hidden = ['pivot'];
    // protected $appends = ['can'];
}
