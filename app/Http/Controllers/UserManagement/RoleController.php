<?php

namespace App\Http\Controllers\UserManagement;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\UserManagement\Role;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Requests\UserManagement\RoleRequest;
use App\Http\Resources\UserManagement\RoleResource;
use App\Http\Resources\UserManagement\RoleCollection;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return RoleCollection
     */
    public function index()
    {
        $role = QueryBuilder::for(Role::class)->with('permissions')
            ->defaultSorts([
                'id',
            ])
            ->allowedSorts(['name', 'id', 'description', 'level'])
            ->allowedFilters(['name', 'description', 'level'])
            ->get();
        return new RoleCollection($role);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RoleResource
     */
    public function store(RoleRequest $request)
    {
        $validate = $request->safe()->except(['permission_names']);
        $permissions = $request->safe()->only(['permission_names']);
        DB::beginTransaction();
        try {
            $role = Role::create($validate);
            if ($permissions) {
                $role->givePermissionTo($permissions);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal Simpan:Internal Server Error'], 500);
        } finally {
            DB::commit();
        }
        return (new RoleResource($role))->setMessage('Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return RoleResource
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Role $role
     * @return RoleResource
     */
    public function update(RoleRequest $request, Role $role)
    {
        $validate = $request->safe()->except(['permission_names']);
        $permissions = $request->safe()->only(['permission_names']);
        try {
            $role->syncPermissions($permissions);
            $role->update($validate);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        } finally {
            DB::commit();
        }
        return (new RoleResource($role))->setMessage('Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
            $role->revokePermissionTo($role->permissions->pluck('name')->toArray());
            $role->delete();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
        } finally {
            DB::commit();
        }
        return response()->json([
            'success' => true,
            'message' => 'Deleted!',
            'meta' => null,
            'errors' => null
        ], 200);
    }

    // public function restore(Role $role)
    // {
    //     try {
    //        role->restore();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //    return (new RoleResource($role))->setMessage('Restored!');
    // }


    // public function forceDelete(Role $role)
    // {
    //     try {
    //        role->forceDelete();
    //     } catch (\Throwable $th) {
    //          return response()->json(['message' => 'Gagal Update:Internal Server Error'], 500);
    //     }
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Permanent Deleted!',
    //         'meta' => null,
    //         'errors' => null
    //     ], 200);
    // }

}
